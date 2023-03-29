<?php defined('SYSPATH') or die('No direct script access.');

class Request_Request {
    // какик поля выводить при запросе
    const SELECT_FIELDS_ALL = 1; // все поля
    const SELECT_FIELDS_EXCLUSION_TEXT = 2; // все поля, кроме тектовых (типы DB_FieldType::FIELD_TYPE_ARRAY, DB_FieldType::FIELD_TYPE_TEXT, DB_FieldType::FIELD_TYPE_JSON)

    /**
     * Проверяем есть ли объект Request_...
     * @param $dbObject
     * @return bool|string
     */
    protected static function getRequest($dbObject)
    {
        $dbObject = substr($dbObject, 3);
        $path = APPPATH . 'classes' . DIRECTORY_SEPARATOR . 'Request' . DIRECTORY_SEPARATOR
            . str_replace('_', '/', $dbObject). '.php';
        if(file_exists($path)){
            return 'Request_' . $dbObject;
        }

        return false;
    }

    /**
     * Добавляем базовую группировку
     * @param $groupByName
     * @param array $fields
     * @param $tableName
     * @param Model_Driver_DBBasicSQL $sql
     * @param null $sortBy
     * @return bool
     */
    protected static function _addGroupByBasic($groupByName, array $fields, $tableName, Model_Driver_DBBasicSQL $sql,
                                               $sortBy = NULL)
    {
        $groupFields = explode('.', $groupByName);

        // группировка в текущей таблице
        if(count($groupFields) == 1) {
            if(!key_exists($groupByName, $fields)){
                foreach ($fields as $field => $data){
                    switch ($data['type']){
                        case DB_FieldType::FIELD_TYPE_INTEGER:
                        case DB_FieldType::FIELD_TYPE_BOOLEAN:
                        case DB_FieldType::FIELD_TYPE_STRING:
                            break;
                        case DB_FieldType::FIELD_TYPE_DATE_TIME:
                        case DB_FieldType::FIELD_TYPE_DATE:
                            if($groupByName == $field.'_date' || $groupByName == $field.'_day'){
                                $sql->getRootSelect()->addFunctionField($tableName, $field, 'DATE', $groupByName);
                                $sql->getRootGroupBy()->addFunctionField($tableName, $field, 'DATE');
                                if (($sortBy !== NULL) && (key_exists($groupByName, $sortBy))) {
                                    $sql->getrootSort()->addField('', $groupByName, !($sortBy[$groupByName] === 'desc'), false);
                                }

                                return true;
                            }
                            break;
                        case DB_FieldType::FIELD_TYPE_TIME:
                        case DB_FieldType::FIELD_TYPE_FLOAT:
                            break;
                    }
                }

                return true;
            }

            $sql->getRootGroupBy()->addField($tableName, $groupByName);
            $sql->getRootSelect()->addField($tableName, $groupByName);
            if ($sortBy !== NULL && key_exists($groupByName, $sortBy)) {
                $sql->getrootSort()->addField($tableName, $groupByName, !($sortBy[$groupByName] == 'desc'));
            }

            return true;
        }

        $name = $groupFields[0];
        if (!key_exists($name, $fields)) {
            return true;
        }

        $table = Arr::path($fields[$name], 'table', '');
        if (empty($table)) {
            return true;
        }

        if(count($groupFields) > 2) {
            $tableJoin = self::_addJoinTable($sql, $tableName, $groupFields[0], $table::TABLE_NAME);

            unset($groupFields[0]);
            return self::_addGroupByBasic(implode('.', $groupFields), $table::FIELDS, $tableJoin, $sql, $sortBy);
        }

        // группировка в присоединенных таблицах
        if(count($groupFields) == 2) {
            $field = $groupFields[1];
            if (!key_exists($field, $table::FIELDS)) {
                // TODO: В будущем сделать группировки по фукнциям типа DATE
                return true;
            }

            self::_addGroupTableSQL($name, $field, $tableName, $table::TABLE_NAME, $sql, $sortBy);

            return true;
        }

        return true;
    }

    /**
     * Добавляем базовую сортировку
     * @param string $sortByName
     * @param boolean $isASC
     * @param array $fields
     * @param string $tableName
     * @param Model_Driver_DBBasicSQL $sql
     * @return bool
     */
    protected static function _addSortByBasic($sortByName, $isASC, array $fields, $tableName, Model_Driver_DBBasicSQL $sql)
    {
        $sortFields = preg_split("/[\/\.]+/", $sortByName);
        if(count($sortFields) == 1) {
            foreach ($sql->getRootSelect()->getFields() as $field){
                if($field['new'] == $sortByName){
                    $sql->getrootSort()->addField('', $sortByName, $isASC, false);
                    return true;
                }
            }

            if(!key_exists($sortByName, $fields)){
                foreach ($fields as $fieldName => $fieldType){
                    // сортируем по весу вхождения поиска обрасывающие окончания
                    if($fieldName.'_lexicon' == $sortByName && $fieldType['type'] == DB_FieldType::FIELD_TYPE_STRING){
                        $value = Request_RequestParams::getParamStr($fieldName.'_lexicon');
                        if(!empty($value)){
                            $sql->getrootSort()->addField(
                                '',
                                'ts_rank(setweight(to_tsvector('.$fieldName.'), \'A\'), plainto_tsquery(\'russian\', \'' . htmlspecialchars($value, ENT_QUOTES) . '\'))',
                                $isASC
                            );
                        }
                        return true;
                    }
                }

                // TODO: В будущем сделать сотрировки по функциям типа DATE
                return true;
            }

            $sql->getrootSort()->addField($tableName, $sortByName, $isASC);
            return true;
        }

        if(count($sortFields) == 2) {
            $name = $sortFields[0];
            if (!key_exists($name, $fields)) {
                return true;
            }

            $table = Arr::path($fields[$name], 'table', '');
            if (empty($table)) {
                return true;
            }

            $field = $sortFields[1];
            if (!key_exists($field, $table::FIELDS)) {
                // TODO: В будущем сделать сотрировки по фукнциям типа DATE
                return true;
            }

            self::_addSortByTableSQL($name, $field, $tableName, $table::TABLE_NAME, $isASC, $sql);

            return true;
        }

        return true;
    }

    /**
     * Добавляем базовые соединения таблиц
     * @param $elementName
     * @param array $elementFields
     * @param array $fields
     * @param $tableName
     * @param Model_Driver_DBBasicSQL $sql
     * @return bool
     */
    protected static function _addFromSQLBasic($elementName, array $elementFields, array $fields, $tableName,
                                               Model_Driver_DBBasicSQL $sql){
        if (empty($elementFields) || empty($fields)){
            return true;
        }

        // если есть запрос на вложенный элемент
        $n = strpos($elementName, '.');
        if($n > 0){
            $field = substr($elementName, 0, $n);
            if (!key_exists($field, $fields)){
                return true;
            }

            $table = Arr::path($fields[$field], 'table', '');
            if (empty($table)){
                return true;
            }

            $fields = $table::FIELDS;
            $tableName = self::_addJoinTable($sql, $tableName, $field, $table::TABLE_NAME);
            return self::_addFromSQLBasic(substr($elementName, $n + 1), $elementFields, $fields, $tableName, $sql);
        }

        if(!key_exists($elementName, $fields)){
            return true;
        }

        $table = Arr::path($fields[$elementName], 'table', '');
        if (empty($table)){
            return true;
        }

        static::_addElementTableSQL($tableName, $elementName, $table::TABLE_NAME, $elementFields, $sql, -1, 0);

        return true;
    }

    /**
     * Добавляем значение в SELECT SQL базовые запросы
     * @param $fieldWhere
     * @param $fieldValue
     * @param array $fields
     * @param $tableName
     * @param Model_Driver_DBBasicSQL $sql
     * @param array $groupBy
     * @return bool
     */
    private static function _addWhereFieldBasic($fieldWhere, $fieldValue, array $fields, $tableName, Model_Driver_DBBasicSQL $sql,
                                                array &$groupBy){
        if($fieldValue === null){
            return null;
        }

        foreach ($fields as $fieldName => $fieldType){
            if(!is_array($fieldValue)) {
                switch ($fieldType['type']) {
                    case DB_FieldType::FIELD_TYPE_INTEGER:
                        $value = $fieldValue;
                        if($value === ''){
                            continue 2;
                        }
                        break;
                    case DB_FieldType::FIELD_TYPE_BOOLEAN:
                        $value = Request_RequestParams::valParamBoolean($fieldValue);
                        break;
                    case DB_FieldType::FIELD_TYPE_STRING:
                        $value = Request_RequestParams::valParamStr($fieldValue);
                        break;
                    case DB_FieldType::FIELD_TYPE_DATE_TIME:
                        $value = Request_RequestParams::valParamDateTime($fieldValue);
                        break;
                    case DB_FieldType::FIELD_TYPE_DATE:
                        $value = Request_RequestParams::valParamDate($fieldValue);
                        break;
                    case DB_FieldType::FIELD_TYPE_TIME:
                        $value = Request_RequestParams::valParamTime($fieldValue);
                        break;
                    case DB_FieldType::FIELD_TYPE_FLOAT:
                        $value = Request_RequestParams::valParamFloat($fieldValue);
                        break;
                    default:
                        $value = Request_RequestParams::valParamStr($fieldValue);
                }
            }else{
                $value = $fieldValue;
            }

            switch ($fieldType['type']) {
                case DB_FieldType::FIELD_TYPE_INTEGER:
                    $func = 'setWhereValueInt';
                    break;
                case DB_FieldType::FIELD_TYPE_BOOLEAN:
                    $func = 'setWhereValueBool';
                    break;
                case DB_FieldType::FIELD_TYPE_STRING:
                    $func = 'setWhereValueStr';
                    break;
                default:
                    $func = 'setWhereValue';
            }

            if($fieldName == $fieldWhere){
                if($fieldType['type'] == DB_FieldType::FIELD_TYPE_STRING){
                    $compare = Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE;
                }else{
                    $compare = Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY;
                }

                Request_RequestUtils::$func(
                    $fieldName, $value, $sql->getRootWhere(),
                    $compare, $tableName
                );

                return true;
            }
            if($fieldName.'_not' == $fieldWhere || 'not_'.$fieldName == $fieldWhere){
                if ($value !== null) {
                    Request_RequestUtils::$func(
                        $fieldName, $value, $sql->getRootWhere(),
                        Model_Driver_DBBasicWhere::COMPARE_TYPE_NOT_EQUALLY, $tableName
                    );
                    return true;
                }
                return null;
            }
            if($fieldName.'_equally' == $fieldWhere || $fieldName.'_full' == $fieldWhere){
                if ($value !== null) {
                    Request_RequestUtils::$func(
                        $fieldName, $value, $sql->getRootWhere(),
                        Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY, $tableName
                    );
                }
                return true;
            }
            if('empty_'.$fieldName == $fieldWhere || $fieldName.'_empty' == $fieldWhere){
                $value = Request_RequestParams::valParamBoolean($fieldValue);
                if($value === true || $value === false){
                    $fields = $sql->getRootWhere()->addOR($fieldWhere);
                    $fields->addFieldIsNULL($fieldName, $tableName);

                    if($fieldType['type'] == DB_FieldType::FIELD_TYPE_INTEGER
                        || $fieldType['type'] == DB_FieldType::FIELD_TYPE_FLOAT){
                        $fields->addField($fieldName, $tableName, 0);
                    }elseif($fieldType['type'] == DB_FieldType::FIELD_TYPE_STRING){
                        $fields->addField($fieldName, $tableName, '');
                        $fields->addField($fieldName, $tableName, '0');
                    }
                    if($value === false){
                        $fields->isNot = true;
                    }
                }
                return true;
            }

            // одно из списка значений
            if($fieldName.'_in' == $fieldWhere || $fieldName.'_in_not' == $fieldWhere){
                if($fieldValue !== null){
                    if(!array($fieldValue)){
                        $fieldValue = preg_split("/[\,]+/", $fieldValue . ',');
                    }

                    if(empty($fieldValue)){
                        return null;
                    }

                    $fields = $sql->getRootWhere()->addOR($fieldWhere);
                    if($fieldType['type'] == DB_FieldType::FIELD_TYPE_STRING){
                        foreach ($fieldValue as $v) {
                            $fields->addField(
                                $fieldName, $tableName, ','.$v.',', '',
                                Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE
                            );
                        }
                    }else{
                        Request_RequestUtils::$func(
                            $fieldName, $fieldValue, $fields,
                            Model_Driver_DBBasicWhere::COMPARE_TYPE_IN, $tableName
                        );
                    }

                    if($fieldName.'_in_not' == $fieldWhere){
                        $fields->isNot = true;
                    }
                }
                return true;
            }
            // разбиваем по подстроки и ищем каждую строку отдельно через LIKE
            if($fieldName.'_list' == $fieldWhere || $fieldName.'_not_list' == $fieldWhere){
                if (!empty($fieldValue)){
                    if(!array($fieldValue)){
                        $fieldValue = preg_split("/[\s]+/", $fieldValue. ' ');
                    }

                    if(is_array($fieldValue)) {
                        if ($fieldType['type'] == DB_FieldType::FIELD_TYPE_STRING) {
                            $compare = Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE;
                        } else {
                            $compare = Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY;
                        }

                        $sqlChild = $sql->getRootWhere()->addField($fieldWhere);
                        foreach ($fieldValue as $child) {
                            $child = trim($child);
                            if (!empty($child)) {
                                $sqlChild->addField($fieldName, $tableName, $child, '', $compare);
                            }
                        }

                        if ($fieldName . '_not_list' == $fieldWhere) {
                            $sqlChild->isNot = true;
                        }
                    }
                    return true;
                }
                return null;
            }

            if($fieldName.'_from' == $fieldWhere || $fieldName.'_more' == $fieldWhere){
                if ($value !== null) {
                    Request_RequestUtils::$func(
                        $fieldName, $value, $sql->getRootWhere(),
                        Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE, $tableName
                    );
                }
                return true;
            }
            if($fieldName.'_from_equally' == $fieldWhere || $fieldName.'_more_equally' == $fieldWhere){
                if ($value !== null) {
                    Request_RequestUtils::$func(
                        $fieldName, $value, $sql->getRootWhere(),
                        Model_Driver_DBBasicWhere::COMPARE_TYPE_MORE_EQUALLY, $tableName
                    );
                }
                return true;
            }
            if($fieldName.'_to' == $fieldWhere || $fieldName.'_to_equally' == $fieldWhere || $fieldName.'_less_equally' == $fieldWhere){
                if ($value !== null) {
                    Request_RequestUtils::$func(
                        $fieldName, $value, $sql->getRootWhere(),
                        Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS_EQUALLY, $tableName
                    );
                }
                return true;
            }
            if($fieldName.'_not_equally' == $fieldWhere || $fieldName.'_less' == $fieldWhere){
                if ($value !== null) {
                    Request_RequestUtils::$func(
                        $fieldName, $value, $sql->getRootWhere(),
                        Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS, $tableName
                    );
                }
                return true;
            }
            if('min_'.$fieldName == $fieldWhere || $fieldName.'_min' == $fieldWhere){
                if (Request_RequestParams::valParamBoolean($fieldValue) === TRUE) {
                    $sql->getRootSelect()->addFunctionField($tableName, $fieldName, 'MIN', 'min_'.$fieldName);
                    if(empty($groupBy)){
                        $groupBy[] = '*';
                    }
                }
                return true;
            }
            if('max_'.$fieldName == $fieldWhere || $fieldName.'_max' == $fieldWhere){
                if (Request_RequestParams::valParamBoolean($fieldValue) === TRUE) {
                    $sql->getRootSelect()->addFunctionField($tableName, $fieldName, 'MAX', 'max_'.$fieldName);
                    if(empty($groupBy)){
                        $groupBy[] = '*';
                    }
                }
                return true;
            }

            if('sum_'.$fieldName == $fieldWhere){
                if (Request_RequestParams::valParamBoolean($fieldValue) === TRUE) {
                    $sql->getRootSelect()->addFunctionField($tableName, $fieldName, 'SUM', $fieldName);
                    if(empty($groupBy)){
                        $groupBy[] = '*';
                    }
                    return true;
                }
                return null;
            }

            // специфически в зависимости от типа
            switch ($fieldType['type']){
                case DB_FieldType::FIELD_TYPE_STRING:
                    if($fieldName.'_lexicon' == $fieldWhere){
                        if (!empty($value)){
                            $sql->getRootWhere()->addField(
                                $fieldName, $tableName, $value, '',
                                Model_Driver_DBBasicWhere::COMPARE_TYPE_LEXICON, array('weight' => 'A')
                            );
                            return true;
                        }
                        return null;
                    }
                    break;
                case DB_FieldType::FIELD_TYPE_DATE_TIME:
                case DB_FieldType::FIELD_TYPE_DATE:
                    if($fieldName.'_to_day' == $fieldWhere || $fieldName.'_to_equally_day' == $fieldWhere || $fieldName.'_less_equally_day' == $fieldWhere){
                        $date = Request_RequestParams::valParamDate($fieldValue);
                        if ($date != null) {
                            $sql->getRootWhere()->addField(
                                $fieldName, $tableName,
                                Helpers_DateTime::plusDays($date, 1), '',
                                Model_Driver_DBBasicWhere::COMPARE_TYPE_LESS
                            );
                            return true;
                        }
                        return null;
                    }
                    if($fieldName.'_date' == $fieldWhere){
                        if (Request_RequestParams::valParamBoolean($fieldValue) === TRUE) {
                            $sql->getRootSelect()->addFunctionField(
                                $tableName, $fieldName, 'DATE', $fieldWhere
                            );
                            return true;
                        }
                        return null;
                    }
                    if($fieldName.'_day_count' == $fieldWhere){
                        if (Request_RequestParams::valParamBoolean($fieldValue) === TRUE) {
                            $sql->getRootSelect()->addFunctionField(
                                $tableName, 'DATE('.$fieldName.')', 'COUNT', $fieldWhere
                            );
                            return true;
                        }
                        return null;
                    }
                    if($fieldName.'#year' == $fieldWhere || $fieldName.'_year' == $fieldWhere){
                        Request_RequestUtils::setWhereValueInt(
                            'date_part(\'year\', ' . $fieldName . ')', $fieldValue, $sql->getRootWhere(),
                            Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY, $tableName
                        );
                        return true;
                    }
                    if($fieldName.'_month' == $fieldWhere){
                        Request_RequestUtils::setWhereValueInt(
                            'date_part(\'month\', ' . $fieldName . ')', $fieldValue, $sql->getRootWhere(),
                            Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY, $tableName
                        );
                        return true;
                    }
                    break;
                case DB_FieldType::FIELD_TYPE_INTEGER:
                    if($fieldName.'_modulo' == $fieldWhere){
                        $value = Request_RequestParams::valParamArray($fieldValue);
                        if($value !== null){
                            $sql->getRootWhere()->addField(
                                '(' . $tableName.'.'.$fieldName . ' % ' . intval(Arr::path($value, 'divisor', 1)) . ')',
                                '', intval(Arr::path($value, 'result', 1))
                            );
                        }
                        return true;
                    }
                    break;
            }

            // поиск по двум полям одновременно
            if(!empty($fieldValue) && strpos($fieldWhere, '_') !== false) {
                foreach ($fields as $fieldName2 => $fieldType2) {
                    if ($fieldWhere == $fieldName . '_' . $fieldName2) {
                        $or = $sql->getRootWhere()->addOR($fieldName . '_' . $fieldName2);


                        switch ($fieldType['type']) {
                            case DB_FieldType::FIELD_TYPE_INTEGER:
                            case DB_FieldType::FIELD_TYPE_BOOLEAN:
                            case DB_FieldType::FIELD_TYPE_DATE_TIME:
                            case DB_FieldType::FIELD_TYPE_DATE:
                            case DB_FieldType::FIELD_TYPE_TIME:
                            case DB_FieldType::FIELD_TYPE_FLOAT:
                                $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY;
                                break;
                            case DB_FieldType::FIELD_TYPE_STRING:
                                $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE;
                                break;
                        }
                        $or->addField($fieldName, '', $fieldValue, '', $compareType);

                        switch ($fieldType2['type']) {
                            case DB_FieldType::FIELD_TYPE_INTEGER:
                            case DB_FieldType::FIELD_TYPE_BOOLEAN:
                            case DB_FieldType::FIELD_TYPE_DATE_TIME:
                            case DB_FieldType::FIELD_TYPE_DATE:
                            case DB_FieldType::FIELD_TYPE_TIME:
                            case DB_FieldType::FIELD_TYPE_FLOAT:
                                $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY;
                                break;
                            case DB_FieldType::FIELD_TYPE_STRING:
                                $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE;
                                break;
                        }
                        $or->addField($fieldName2, '', $fieldValue, '', $compareType);
                    }
                }
            }
        }

        return null;
    }

    /**
     * Добавляем значение в SELECT SQL с проверкой на вложенность базовые запросы
     * @param array $params
     * @param $fieldWhere
     * @param $fieldValue
     * @param array $fields
     * @param $tableName
     * @param Model_Driver_DBBasicSQL $sql
     * @param SitePageData $sitePageData
     * @param $isNotReadRequest
     * @param array $groupBy
     * @param string $prefix
     * @return bool
     */
    protected static function _addWhereBasic(array $params, $fieldWhere, $fieldValue, array $fields, $tableName, Model_Driver_DBBasicSQL $sql,
                                             SitePageData $sitePageData, $isNotReadRequest, array &$groupBy, $prefix = ''){
        $listField = preg_split("/[\/\.]+/", $fieldWhere);
        if(count($listField) > 1){
            $field1 = $listField[0];
            if(!key_exists($field1, $fields)){
                return null;
            }

            $table = Arr::path($fields[$field1], 'table', '');
            if(empty($table)){
                return null;
            }

            $tableJoin = self::_addJoinTable($sql, $tableName, $listField[0], $table::TABLE_NAME);

            // Сделать проверку на вложенность больше 1 уровня
            if(count($listField) > 2){
                unset($listField[0]);
                $result = self::_addWhereBasic(
                    $params, implode('.', $listField), $fieldValue, $table::FIELDS, $tableJoin, $sql, $sitePageData,
                    $isNotReadRequest, $groupBy, $prefix.$field1.'.'
                );
            }else{
                $result = self::_addWhereFieldBasic(
                    $listField[1], $fieldValue, $table::FIELDS, $tableJoin, $sql, $groupBy
                );
            }

            return $result;
        }

        $result = self::_addWhereFieldBasic(
            $fieldWhere, $fieldValue, $fields, $tableName, $sql, $groupBy
        );
        if($result){
            return true;
        }

        // Поиск ИЛИ между двуми полями. Поля должны быть одного типа
        foreach ($fields as $fieldName1 => $fieldType1){
            foreach ($fields as $fieldName2 => $fieldType2){
                if($fieldType2['type'] != DB_FieldType::FIELD_TYPE_STRING){
                    continue;
                }
                if($fieldName1.'_'.$fieldName2 == $fieldWhere){
                    if($fieldType1['type'] != $fieldType2['type']){
                        return null;
                    }

                    switch ($fieldType1['type']) {
                        case DB_FieldType::FIELD_TYPE_INTEGER:
                            $value = Request_RequestParams::valParamInt($fieldValue);
                            break;
                        case DB_FieldType::FIELD_TYPE_BOOLEAN:
                            $value = Request_RequestParams::valParamBoolean($fieldValue);
                            if($value === null){
                                break 2;
                            }
                            $value = Func::boolToInt($value);
                            break;
                        case DB_FieldType::FIELD_TYPE_STRING:
                            $value = Request_RequestParams::valParamStr($fieldValue);
                            break;
                        case DB_FieldType::FIELD_TYPE_DATE_TIME:
                            $value = Request_RequestParams::valParamDateTime($fieldValue);
                            break;
                        case DB_FieldType::FIELD_TYPE_DATE:
                            $value = Request_RequestParams::valParamDate($fieldValue);
                            break;
                        case DB_FieldType::FIELD_TYPE_TIME:
                            $value = Request_RequestParams::valParamTime($fieldValue);
                            break;
                        case DB_FieldType::FIELD_TYPE_FLOAT:
                            $value = Request_RequestParams::valParamFloat($fieldValue);
                            break;
                        default:
                            $value = Request_RequestParams::valParamStr($value);
                    }

                    if($value === null){
                        break;
                    }

                    switch ($fieldType1['type']){
                        case DB_FieldType::FIELD_TYPE_INTEGER:
                            if($value < 0) {
                                break 2;
                            }
                            break;
                        case DB_FieldType::FIELD_TYPE_STRING:
                            if(empty($tmp)) {
                                break 2;
                            }
                            break;
                    }

                    $fields = $sql->getRootWhere()->addOR($fieldWhere);
                    $fields->addFieldLike($fieldName1, $tableName, $value);
                    $fields->addFieldLike($fieldName2, $tableName, $value);
                    return true;
                }
            }
        }
        return null;
    }

    /**
     * Добавляем сотрировку полей связанных таблиц
     * @param $field1
     * @param $field2
     * @param $tableName1
     * @param $tableName2
     * @param $isASC
     * @param Model_Driver_DBBasicSQL $sql
     */
    protected static function _addSortByTableSQL($field1, $field2, $tableName1, $tableName2, $isASC, Model_Driver_DBBasicSQL $sql)
    {
        $tableJoin = $sql->getRootFrom()->addTable($tableName1, $field1, $tableName2);
        $sql->getrootSort()->addField($tableJoin, $field2, $isASC);
    }

    /**
     * Добавляем группировку полей связанных таблиц
     * @param $field1
     * @param $field2
     * @param $tableName1
     * @param $tableName2
     * @param Model_Driver_DBBasicSQL $sql
     * @param null $sortBy
     * @param bool $isJoin
     */
    protected static function _addGroupTableSQL($field1, $field2, $tableName1, $tableName2, Model_Driver_DBBasicSQL $sql,
                                                $sortBy = NULL, $isJoin = TRUE)
    {
        if($isJoin) {
            $tableJoin = self::_addJoinTable($sql, $tableName1, $field1, $tableName2);
        }else{
            $tableJoin = $tableName1;
        }
        $sql->getRootGroupBy()->addField($tableJoin, $field2);
        $sql->getRootSelect()->addField($tableJoin, $field2, $field1.'___'.$field2);


        if ($isJoin && ($sortBy !== NULL) && (key_exists($field1.'.'.$field2, $sortBy))) {
            $sql->getrootSort()->addField($tableJoin, $field2, !($sortBy[$field1.'.'.$field2] === 'desc'));
        }
    }

    /**
     * Добавляем связь таблиц и возвращение полей
     * @param $tableName1
     * @param $fieldName1
     * @param $tableName2
     * @param array $fields
     * @param Model_Driver_DBBasicSQL $sql
     * @param int $shopID
     * @param int $shopMainID
     * @param string $fieldName2
     * @param string $prefixField
     * @param bool $isDouble
     * @param int $json
     * @param string $sqlOn
     * @return string
     */
    protected static function _addElementTableSQL($tableName1, $fieldName1, $tableName2, array $fields,
                                                  Model_Driver_DBBasicSQL $sql, $shopID = -1, $shopMainID = -1,
                                                  $fieldName2 = 'id', $prefixField = '', $isDouble = FALSE,
                                                  $json = Model_Driver_DBBasicFrom::JOIN_LEFT, $sqlOn = ''){

        $table2 = $tableName2.'__'.$fieldName1;
        if($isDouble && $sql->getRootFrom()->isFindTable($tableName2, $fieldName1)){
            $table2 = $table2 . '_' . random_int(1, 999999);
        }

        $s = '';
        if(!empty($sqlOn)){
            $s = $sqlOn . ' AND ';
        }

        $s .= $tableName1 . '.language_id=' . $table2 . '.language_id';
        if (($shopID != $shopMainID) && ($shopMainID > 0)) {
            if (($shopID > 0) && ($shopMainID > 0)) {
                $s = $s . ' AND ' . $table2 . '.shop_id IN (' . $shopID . ',' . $shopMainID . ')';
            } elseif (($shopID > 0)) {
                $s = $s . ' AND ' . $table2 . '.shop_id = ' . $shopID;
            }
        }elseif (($shopID > 0)) {
            $s = $s . ' AND ' . $table2 . '.shop_id = ' . $shopID;
        }

        $sql->getRootFrom()->addTable(
            $tableName1, $fieldName1, $tableName2, $fieldName2,
            $json,
            $s, false, $table2
        );

        $rootSelect = $sql->getRootSelect();
        if(empty($prefixField)){
            $prefixField = $fieldName1;
        }
        foreach ($fields as $field){
            $rootSelect->addField($table2, $field, $prefixField.'___'.$field);
        }

        return $table2;
    }

    /**
     * Добавляем связь таблиц
     * @param Model_Driver_DBBasicSQL $sql
     * @param $tableName1
     * @param $fieldName1
     * @param $tableName2
     * @param string $fieldName2
     * @param int $shopID
     * @param int $shopMainID
     * @param string $sqlText
     * @return string
     */
    protected static function _addJoinTable(Model_Driver_DBBasicSQL $sql, $tableName1, $fieldName1, $tableName2,
                                            $fieldName2 = 'id', $shopID = -1, $shopMainID = -1, $sqlText = ''){

        $table2 = $tableName2.'__'.$fieldName1;
        $s = $tableName1 . '.language_id=' . $table2 . '.language_id';
        if (($shopID != $shopMainID) && ($shopMainID > 0)) {
            if (($shopID > 0) && ($shopMainID > 0)) {
                $s = $s . ' AND ' . $table2 . '.shop_id IN (' . $shopID . ',' . $shopMainID . ')';
            } elseif (($shopID > 0)) {
                $s = $s . ' AND ' . $table2 . '.shop_id = ' . $shopID . ')';
            }
        }

        if(!empty($sqlText)){
            $s .= ' AND ' . $sqlText;
        }

        return $sql->getRootFrom()->addTable(
            $tableName1, $fieldName1, $tableName2, $fieldName2, Model_Driver_DBBasicFrom::JOIN_LEFT, $s
        );
    }

    /**
     * Получаем список параметров для списка
     * @return array
     */
    public static function getParamsList(){
        return array('limit_page', 'limit', 'page');
    }

    /**
     * Получаем список параметров для одного объекта
     * @return array
     */
    public static function getParamsOne(){
        return array('is_error_404', 'id');
    }

    /**
     * Добавляем группировка
     * @param $dbObject
     * @param $groupByName
     * @param Model_Driver_DBBasicSQL $sql
     * @param null $sortBy
     * @return bool
     */
    protected static function _addGroupBy($dbObject, $groupByName, Model_Driver_DBBasicSQL $sql, $sortBy = NULL)
    {
        return self::_addGroupByBasic($groupByName, $dbObject::FIELDS, $dbObject::TABLE_NAME, $sql, $sortBy);
    }

    /**
     * Добавляем группировки
     * @param $dbObject
     * @param array $groupBy
     * @param Model_Driver_DBBasicSQL $sql
     * @param null $sortBy
     */
    protected static function _addGroupsBy($dbObject, array $groupBy, Model_Driver_DBBasicSQL $sql, $sortBy = NULL)
    {
        foreach ($groupBy as $groupByName){
            static::_addGroupBy($dbObject, $groupByName, $sql, $sortBy);
        }
    }

    /**
     * Добавляем сортировку
     * @param $dbObject
     * @param $sortByName
     * @param $isASC
     * @param Model_Driver_DBBasicSQL $sql
     * @return bool
     */
    protected static function _addSortBy($dbObject, $sortByName, $isASC, Model_Driver_DBBasicSQL $sql)
    {
        return self::_addSortByBasic($sortByName, $isASC, $dbObject::FIELDS, $dbObject::TABLE_NAME, $sql);
    }

    /**
     * Добавляем сортировки
     * @param $dbObject
     * @param array $sortBy
     * @param Model_Driver_DBBasicSQL $sql
     */
    protected static function _addSortsBy($dbObject, array $sortBy, Model_Driver_DBBasicSQL $sql)
    {
        foreach ($sortBy as $name => $value){
            static::_addSortBy($dbObject, $name, !(strtolower($value) == 'desc'), $sql);
        }
    }

    /**
     * Добавляем базовые запросы SELECT SQL
     * @param $dbObject
     * @param $fieldWhere
     * @param $fieldValue
     * @param array $params
     * @param Model_Driver_DBBasicSQL $sql
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $isNotReadRequest
     * @param array $groupBy
     * @param array $elements
     * @return bool
     */
    protected static function _addWhere($dbObject, $fieldWhere, $fieldValue, array $params, Model_Driver_DBBasicSQL $sql,
                                        SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                        $isNotReadRequest, array &$groupBy, array &$elements){

        // ищем по неточному совпадению по каждому слову (например: "при пок" должен найти "привет доча. Пока.")
        if($fieldWhere == 'names_articles') {
            $tmp = Request_RequestParams::valParamStr($fieldValue);
            if (!empty($tmp)) {
                $field = $sql->getRootWhere()->addField('name_article', '', '');
                $field->relationsType = Model_Driver_DBBasicWhere::RELATIONS_TYPE_OR;
                $field->addField('name', '', $tmp, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE_SUBSTRING);
                $field->addField('article', '', $tmp, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE_SUBSTRING);
                return true;
            }
            return null;
        }

        if($fieldWhere == 'name_article_text_lexicon') {
            $tmp = Request_RequestParams::valParamStr($fieldValue);
            if (!empty($tmp)){
                if (empty($tableName)) {
                    $sql->getRootWhere()->addField(
                        'name || \' \' || article || \' \' || text', '',
                        $tmp, '',
                        Model_Driver_DBBasicWhere::COMPARE_TYPE_LEXICON
                    )->isFuncField1 = TRUE;
                }else{
                    $sql->getRootWhere()->addField(
                        $tableName.'.name || \' \' || '.$tableName.'.article || \' \' || '.$tableName.'.text', '',
                        $tmp, '',
                        Model_Driver_DBBasicWhere::COMPARE_TYPE_LEXICON
                    )->isFuncField1 = TRUE;
                }
                return true;
            }
            return null;
        }

        return static::_addWhereBasic(
            $params, $fieldWhere, $fieldValue, $dbObject::FIELDS, $dbObject::TABLE_NAME, $sql, $sitePageData, $isNotReadRequest,
            $groupBy
        );
    }

    /**
     * Добавляем запросы SELECT SQL
     * @param $dbObject
     * @param array $params
     * @param Model_Driver_DBBasicSQL $sql
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $isNotReadRequest
     * @param array $groupBy
     * @param array $elements
     * @return bool
     */
    private static function _addWheres($dbObject, array $params, Model_Driver_DBBasicSQL $sql, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver, $isNotReadRequest, array &$groupBy, array &$elements){
        foreach ($params as $fieldName => $fieldValue){
            if($fieldName == Request_RequestParams::IS_NOT_READ_REQUEST_NAME
                || $fieldName == 'limit' || $fieldName == 'limit_page'
                || $fieldName == 'sort_by' || $fieldName == 'group_by'){
                continue;
            }

            if($fieldName == 'type'){
                $fieldName = 'shop_table_catalog_id';
            }

            $isGet = false;

            if(is_array($fieldValue)){
                // нельзя считывать
                if(key_exists('is_public', $fieldValue) && Request_RequestParams::isBoolean($fieldValue['is_public']) === false){
                    continue;
                }

                // берем данные из другого поля
                if(key_exists('field', $fieldValue) && !empty($fieldValue['field'])){
                    if(!$isNotReadRequest) {
                        if(key_exists($fieldValue['field'], $_POST)){
                            $fieldValue = $_POST[$fieldValue['field']];
                        }elseif(key_exists($fieldValue['field'], $_GET)){
                            $fieldValue = $_GET[$fieldValue['field']];
                        }
                    }elseif(key_exists($fieldValue['field'], $params)){
                        $fieldValue = $params[$fieldValue['field']];
                    }
                }

                if(is_array($fieldValue) && key_exists('value', $fieldValue)){
                    $fieldValue = $fieldValue['value'];
                }
            }elseif(!$isNotReadRequest){
                // если приоритет из URL запроса
                if(key_exists($fieldName, $_POST)){
                    $fieldValue = $_POST[$fieldName];
                    $isGet = true;
                }elseif(key_exists($fieldName, $_GET)){
                    $fieldValue = $_GET[$fieldName];
                    $isGet = true;
                }
            }

            $result = static::_addWhere(
                $dbObject, str_replace('/', '.', $fieldName), $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements
            );
            if($result && $isGet){
                $sitePageData->urlParams[$fieldName] = $fieldValue;
            }

            if($result === false){
                return false;
            }
        }

        if(!$isNotReadRequest){
            $list = array_merge($_POST, $_GET);

            foreach ($list as $fieldName => $fieldValue){
                if($fieldName == Request_RequestParams::IS_NOT_READ_REQUEST_NAME
                    || $fieldName == 'limit' || $fieldName == 'limit_page'
                    || $fieldName == 'sort_by' || $fieldName == 'group_by'){
                    continue;
                }

                if($fieldName == 'type'){
                    $fieldName = 'shop_table_catalog_id';
                }

                // если из параметров уже был считан, то пропускаем
                if(key_exists($fieldName, $params)){
                    continue;
                }

                $result = static::_addWhere(
                    $dbObject, str_replace('/', '.', $fieldName), $fieldValue, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements
                );

                if($result){
                    $sitePageData->urlParams[$fieldName] = $fieldValue;
                }

                if($result === false){
                    return false;
                }
            }

        }

        $tableName = $dbObject::TABLE_NAME;

        if (Request_RequestParams::getParamBoolean('is_delete_public_ignore', $params, $isNotReadRequest, $sitePageData) !== TRUE
            && Request_RequestParams::getParamBoolean('is_public_ignore', $params, $isNotReadRequest, $sitePageData) !== TRUE) {
            $isNotPublic = Request_RequestParams::getParamBoolean('is_not_public', $params, $isNotReadRequest, $sitePageData);
            if ($isNotPublic === TRUE) {
                $sql->getRootWhere()->addField('is_public', $tableName, 0);
            } else {
                $isPublic = Request_RequestParams::getParamBoolean('is_public', $params, $isNotReadRequest, $sitePageData);
                if ($isPublic === FALSE) {
                    $sql->getRootWhere()->addField('is_public', $tableName, 0);
                } elseif(($isPublic === TRUE) || (Request_RequestParams::getParamBoolean('is_delete', $params, $isNotReadRequest, $sitePageData) !== TRUE)) {
                    $sql->getRootWhere()->addField('is_public', $tableName, 1);
                }
            }
        }

        if (Request_RequestParams::getParamBoolean('is_delete_ignore', $params, $isNotReadRequest, $sitePageData) !== TRUE
            && Request_RequestParams::getParamBoolean('is_delete_public_ignore', $params, $isNotReadRequest, $sitePageData) !== TRUE){
            $sql->getRootWhere()->addField(
                'is_delete', $tableName,
                Func::boolToInt(Request_RequestParams::getParamBoolean('is_delete', $params, $isNotReadRequest, $sitePageData))
            );
        }

        if (Request_RequestParams::getParamBoolean('count_id', $params, $isNotReadRequest, $sitePageData) === TRUE) {
            $sql->getRootSelect()->addFunctionField($tableName, '*', 'COUNT', 'count');
            if(empty($groupBy)){
                $groupBy[] = '*';
            }
        }

        return true;
    }

    /**
     * Добавляем соединения таблиц
     * @param $dbObject
     * @param $elementName
     * @param array $elementFields
     * @param Model_Driver_DBBasicSQL $sql
     * @return bool
     */
    protected static function _addFromSQL($dbObject, $elementName, array $elementFields, Model_Driver_DBBasicSQL $sql, array $params){
        return self::_addFromSQLBasic($elementName, $elementFields, $dbObject::FIELDS, $dbObject::TABLE_NAME, $sql);
    }

    /**
     * Добавление связи дополнительных таблиц
     * @param $dbObject
     * @param array $elements
     * @param Model_Driver_DBBasicSQL $sql
     * @param array $params
     * @param int | array $selectFields
     * @return bool
     */
    protected static function _addFromsSQL($dbObject, array $elements, Model_Driver_DBBasicSQL $sql, array $params,
                                           $selectFields = self::SELECT_FIELDS_ALL){
        $result = FALSE;
        if (count($sql->getRootGroupBy()->getFields()) == 0) {
            if($selectFields == self::SELECT_FIELDS_EXCLUSION_TEXT) {
                foreach ($dbObject::FIELDS as $name => $field){
                    $type = $field['type'];
                    if($type == DB_FieldType::FIELD_TYPE_ARRAY
                        || $type == DB_FieldType::FIELD_TYPE_TEXT
                        || $type == DB_FieldType::FIELD_TYPE_JSON){
                        continue;
                    }

                    $sql->getRootSelect()->addField($dbObject::TABLE_NAME, $name);
                }
            }elseif(is_array($selectFields)) {
                foreach ($selectFields as $name){
                    $sql->getRootSelect()->addField($dbObject::TABLE_NAME, $name);
                }
            }else{
                $sql->getRootSelect()->addField($dbObject::TABLE_NAME, '*');

            }
        }

        foreach ($elements as $elementName => $elementFields){
            if (!is_array($elementFields) || empty($elementFields)){
                continue;
            }

            $result = static::_addFromSQL($dbObject, $elementName, $elementFields, $sql, $params) || $result;
        }

        return $result;
    }

    /**
     * Фильтр по полю options
     * @param array $options
     * @param array $resultSQL
     */
    private static function _whereOptions(array $options, array &$resultSQL){
        foreach ($resultSQL['result'] as $keyList => $record) {
            if (empty($record['options'])) {
                unset($resultSQL['result'][$keyList]);
                continue;
            }

            $isAdd = TRUE;
            $recordOptions = json_decode($record['options'], TRUE);
            foreach ($options as $key => $value) {
                if (empty($value)) {
                    continue;
                }

                if (!key_exists($key, $recordOptions)) {
                    $isAdd = FALSE;
                    break;
                } else {
                    $s = $recordOptions[$key];
                    $isNumeric = is_numeric($s);

                    if (!(($isNumeric && ($s == $value))
                        || ((!$isNumeric) && (mb_strpos($s, $value) !== FALSE)))
                    ) {
                        $isAdd = FALSE;
                        break;
                    }
                }
            }
            if(!$isAdd){
                unset($resultSQL['result'][$keyList]);
            }
        }

        $resultSQL['count'] = count($resultSQL['result']);
    }


    /**
     * Добавляем выборку в SQL
     * @param $dbObject
     * @param $shopID
     * @param Model_Driver_DBBasicSQL $sql
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $isNotReadRequest
     * @param array $params
     * @param $limit
     * @param $isLoadAllFields
     * @param null $elements
     * @param int | array $selectFields
     * @return bool|null
     */
    private static function _addSQL($dbObject, $shopID, Model_Driver_DBBasicSQL $sql, SitePageData $sitePageData,
                                    Model_Driver_DBBasicDriver $driver, $isNotReadRequest, array $params,
                                    $limit, &$isLoadAllFields, $elements = NULL, $selectFields = self::SELECT_FIELDS_ALL){
        $sql->setTableName($dbObject::TABLE_NAME);
        $sql->limit = $limit;

        $groupBy = Request_RequestParams::getParamArray('group_by', $params, NULL, $isNotReadRequest, $sitePageData);
        $sortBy = Request_RequestParams::getParamArray('sort_by', $params, NULL, $isNotReadRequest, $sitePageData);

        $isLoadAllFields = $isLoadAllFields || !Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE || ($groupBy !== NULL);

        if(! $isLoadAllFields) {
            $sql->getRootSelect()->addField('', 'id');
            if(is_array($shopID)){
                $sql->getRootSelect()->addField('', 'shop_id');
            }
        }

        if(!is_array($elements)){
            $elements = array();
        }
        if(!is_array($groupBy)){
            $groupBy = array();
        }

        // добавляем выборку
        if(! static::_addWheres($dbObject, $params, $sql, $sitePageData, $driver, $isNotReadRequest, $groupBy, $elements)){
            return null;
        }

        // группировака
        if(!empty($groupBy)){
            self::_addGroupsBy($dbObject, $groupBy, $sql, $sortBy);
        }

        // сортировка
        if(empty($groupBy) && empty($sortBy)){
            if(key_exists('created_at', $dbObject::FIELDS)){
                $sortBy = array('created_at' => 'desc');
            }else{
                $sortBy = array('id' => 'desc');
            }
        }
        if(!empty($sortBy) && is_array($sortBy)){
            self::_addSortsBy($dbObject, $sortBy, $sql);
        }

        // добавление связи вспомогательными элементами
        $isLoadElements = FALSE;
        if ($isLoadAllFields && !empty($elements)){
            $isLoadElements = static::_addFromsSQL($dbObject, $elements, $sql, $params, $selectFields);
        }

        return $isLoadElements;
    }

    /**
     * Запускаем выборку
     * @param $dbObject
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @param bool $isTree
     * @param int | array $selectFields
     * @return MyArray
     */
    private static function _runSQLShop($dbObject, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                        array $params = array(), $limit = 0, $isLoadAllFields = FALSE, $elements = NULL,
                                        $isTree = FALSE, $selectFields = self::SELECT_FIELDS_ALL){
        // не считывать параметры переданные в GET и POST запросах
        $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);

        $sql = GlobalData::newModelDriverDBSQL();

        $isLoadElements = self::_addSQL(
            $dbObject, $shopID, $sql, $sitePageData, $driver, $isNotReadRequest, $params, $limit, $isLoadAllFields,
            $elements, $selectFields
        );
        if($isLoadElements === null){
            return new MyArray();
        }

        if(!key_exists('shop_id', $dbObject::FIELDS)){
            $shopID = -1;
        }

        // фильтруем по полю options
        $options = Request_RequestParams::getParamArray('options', $params, NULL, $isNotReadRequest, $sitePageData);

        $page = Request_RequestParams::getParamInt('page', $params, $isNotReadRequest, $sitePageData);
        $sql->page = $page;

        $limitPage = Request_RequestParams::getParamInt('limit_page', $params, $isNotReadRequest, $sitePageData);
        $isShift = !empty($options) || $limitPage < 1;
        if(!$isShift) {
            $sql->limitPage = $limitPage;
        }

        $resultSQL = $driver->getSelect($sql, $isLoadAllFields, $sitePageData->dataLanguageID, $shopID);

        // фильтруем по полю options
        if(!empty($options)){
            self::_whereOptions($options, $resultSQL);
        }

        // возвращаем результат
        if ($isTree) {
            return Request_RequestUtils::ArrayInMyArrayTree($resultSQL, $isLoadAllFields, $isLoadElements);
        }else{
            $sql->limitPage = $limitPage;
            return Request_RequestUtils::ArrayInMyArrayList(
                $sitePageData, $resultSQL, $limit, $limitPage, $page, $isLoadAllFields, $isLoadElements, $isShift
            );
        }
    }

    /**
     * Запускаем выборку
     * @param $dbObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    private static function _runSQL($dbObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                    array $params = array(), $limit = 0, $isLoadAllFields = FALSE, $elements = NULL,
                                    $selectFields = self::SELECT_FIELDS_ALL){
        // не считывать параметры переданные в GET и POST запросах
        $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);

        $sql = GlobalData::newModelDriverDBSQL();

        $isLoadElements = self::_addSQL(
            $dbObject, 0, $sql, $sitePageData, $driver, $isNotReadRequest, $params, $limit, $isLoadAllFields,
            $elements, $selectFields
        );
        if($isLoadElements === null){
            return new MyArray();
        }

        // фильтруем по полю options
        $options = Request_RequestParams::getParamArray('options', $params, NULL, $isNotReadRequest, $sitePageData);

        $page = Request_RequestParams::getParamInt('page', $params, $isNotReadRequest, $sitePageData);
        $sql->page = $page;

        $limitPage = Request_RequestParams::getParamInt('limit_page', $params, $isNotReadRequest, $sitePageData);
        $isShift = !empty($options) || $limitPage < 1;
        if(!$isShift) {
            $sql->limitPage = $limitPage;
        }

        $resultSQL = $driver->getSelect($sql, $isLoadAllFields, $sitePageData->dataLanguageID);

        // фильтруем по полю options
        if(!empty($options)){
            self::_whereOptions($options, $resultSQL);
        }

        // возвращаем результат
        $sql->limitPage = $limitPage;
        return Request_RequestUtils::ArrayInMyArrayList(
            $sitePageData, $resultSQL, $limit, $limitPage, $page, $isLoadAllFields, $isLoadElements, $isShift
        );
    }

    /**
     * Запускаем выборку филиалов
     * @param $dbObject
     * @param array $shopIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @param bool $isTree
     * @param int | array $selectFields
     * @return MyArray
     */
    private static function _runSQLBranch($dbObject, array $shopIDs, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          array $params = array(), $limit = 0, $isLoadAllFields = FALSE,
                                          $elements = NULL, $isTree = FALSE, $selectFields = self::SELECT_FIELDS_ALL){
        // не считывать параметры переданные в GET и POST запросах
        $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);

        $sql = GlobalData::newModelDriverDBSQL();

        $isLoadElements = self::_addSQL(
            $dbObject, $shopIDs, $sql, $sitePageData, $driver, $isNotReadRequest, $params, $limit, $isLoadAllFields,
            $elements, $selectFields
        );
        if($isLoadElements === null){
            return new MyArray();
        }

        if(!empty($shopIDs)){
            $sql->getRootWhere()->addField(
                'shop_id', $dbObject::TABLE_NAME, $shopIDs, '',
                Model_Driver_DBBasicWhere::COMPARE_TYPE_IN
            );
        }

        // фильтруем по полю options
        $options = Request_RequestParams::getParamArray('options', $params, NULL, $isNotReadRequest, $sitePageData);

        $page = Request_RequestParams::getParamInt('page', $params, $isNotReadRequest, $sitePageData);
        $sql->page = $page;

        $limitPage = Request_RequestParams::getParamInt('limit_page', $params, $isNotReadRequest, $sitePageData);
        $isShift = !empty($options) || $limitPage < 1;
        if(!$isShift) {
            $sql->limitPage = $limitPage;
        }

        $resultSQL = $driver->getSelect($sql, TRUE, $sitePageData->dataLanguageID);

        // фильтруем по полю options
        if(!empty($options)){
            self::_whereOptions($options, $resultSQL);
        }

        // возвращаем результат
        if ($isTree) {
            return Request_RequestUtils::ArrayInMyArrayTree($resultSQL, $isLoadAllFields, $isLoadElements);
        }else{
            $sql->limitPage = $limitPage;
            return Request_RequestUtils::ArrayInMyArrayList(
                $sitePageData, $resultSQL, $limit, $limitPage, $page, $isLoadAllFields, $isLoadElements, $isShift
            );
        }
    }

    /**
     * Получение всех значений таблицы
     * @param $dbObject
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isLoadAllFields
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    protected static function _findAll($dbObject, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                       $isLoadAllFields = FALSE, $elements = NULL, $selectFields = self::SELECT_FIELDS_ALL)
    {
        return self::_runSQLShop(
            $dbObject, $shopID, $sitePageData, $driver, Request_RequestParams::setParams(), 0, $isLoadAllFields,
            $elements, false, $selectFields
        );
    }

    /**
     * Получение всех значений таблицы
     * @param string $dbObject
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isLoadAllFields
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    public static function findAll($dbObject, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                   $isLoadAllFields = FALSE, $elements = NULL, $selectFields = self::SELECT_FIELDS_ALL)
    {
        /** @var Request_Request $request */
        $request = static::getRequest($dbObject);
        if($request !== false){
            return $request::_findAll($dbObject, $shopID, $sitePageData, $driver, $isLoadAllFields, $elements, $selectFields);
        }

        return self::_findAll($dbObject, $shopID, $sitePageData, $driver, $isLoadAllFields, $elements, $selectFields);
    }

    /**
     * Получение значений таблицы по филиалам
     * @param string $dbObject
     * @param array $shopIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    protected static function _findBranch($dbObject, array $shopIDs, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          array $params = array(), $limit = 0, $isLoadAllFields = FALSE, $elements = NULL,
                                          $selectFields = self::SELECT_FIELDS_ALL)
    {
        return self::_runSQLBranch(
            $dbObject, $shopIDs, $sitePageData, $driver, $params, $limit, $isLoadAllFields, $elements, false,
            $selectFields
        );
    }

    /**
     * Получение значений таблицы по филиалам
     * @param string $dbObject
     * @param array $shopIDs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    public static function findBranch($dbObject, array $shopIDs, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                      array $params = array(), $limit = 0, $isLoadAllFields = FALSE, $elements = NULL,
                                      $selectFields = self::SELECT_FIELDS_ALL)
    {
        /** @var Request_Request $request */
        $request = static::getRequest($dbObject);
        if($request !== false){
            return $request::_findBranch($dbObject, $shopIDs, $sitePageData, $driver, $params, $limit, $isLoadAllFields, $elements, $selectFields);
        }

        return self::_findBranch($dbObject, $shopIDs, $sitePageData, $driver, $params, $limit, $isLoadAllFields, $elements, $selectFields);
    }

    /**
     * Поиск данных в заданной заведении
     * @param string $dbObject
     * @param int $id
     * @param int $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    protected static function _findOneByID($dbObject, $id, $shopID, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver, $elements = NULL,
                                           $selectFields = self::SELECT_FIELDS_ALL){
        $params = Request_RequestParams::setParams(
            array(
                'id' => $id,
                'is_public_ignore' => true,
                'is_delete_ignore' => true,
            )
        );

        $result = self::_runSQLShop(
            $dbObject, $shopID, $sitePageData, $driver, $params, 1, true, $elements, false,
            $selectFields
        );

        if(count($result->childs) > 0){
            return $result->childs[0];
        }

        return null;
    }

    /**
     * Поиск данных в заданной заведении
     * @param string $dbObject
     * @param int $id
     * @param int $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    public static function findOneByID($dbObject, $id, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                       $elements = NULL, $selectFields = self::SELECT_FIELDS_ALL){
        /** @var Request_Request $request */
        $request = static::getRequest($dbObject);
        if($request !== false){
            return $request::_findOneByID($dbObject, $id, $shopID, $sitePageData, $driver, $elements, $selectFields);
        }

        return self::_findOneByID($dbObject, $id, $shopID, $sitePageData, $driver, $elements, $selectFields);
    }

    /**
     * Поиск данных в заданной заведении
     * @param string $dbObject
     * @param int $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param int | array $selectFields
     * @return null|MyArray
     */
    protected static function _findOne($dbObject, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                       array $params = array(), $elements = NULL, $selectFields = self::SELECT_FIELDS_ALL){
        $result = self::_runSQLShop(
            $dbObject, $shopID, $sitePageData, $driver, $params, 1, true, $elements, false,
            $selectFields
        );


        if(count($result->childs) > 0){
            return $result->childs[0];
        }

        return null;
    }

    /**
     * Поиск данных в заданной заведении
     * @param string $dbObject
     * @param int $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param int | array $selectFields
     * @return null|MyArray
     */
    public static function findOne($dbObject, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                   array $params = array(), $elements = NULL, $selectFields = self::SELECT_FIELDS_ALL){
        /** @var Request_Request $request */
        $request = static::getRequest($dbObject);
        if($request !== false){
            return $request::_findOne($dbObject, $shopID, $sitePageData, $driver, $params, $elements, $selectFields);
        }

        return self::_findOne($dbObject, $shopID, $sitePageData, $driver, $params, $elements, $selectFields);
    }

    /**
     * Поиск данных в заданной заведении
     * @param string $dbObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    protected static function _findOneNotShop($dbObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                              array $params = array(), $elements = NULL, $selectFields = self::SELECT_FIELDS_ALL){
        $result = self::_runSQL(
            $dbObject, $sitePageData, $driver, $params, 1, true, $elements, $selectFields
        );


        if(count($result->childs) > 0){
            return $result->childs[0];
        }

        return null;
    }

    /**
     * Поиск данных в заданной заведении
     * @param string $dbObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    public static function findOneNotShop($dbObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          array $params = array(), $elements = NULL, $selectFields = self::SELECT_FIELDS_ALL){
        /** @var Request_Request $request */
        $request = static::getRequest($dbObject);
        if($request !== false){
            return $request::_findOneNotShop($dbObject, $sitePageData, $driver, $params, $elements, $selectFields);
        }

        return self::_findOneNotShop($dbObject, $sitePageData, $driver, $params, $elements, $selectFields);
    }

    /**
     * Поиск данных в заданной заведении
     * @param string $dbObject
     * @param int $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    protected static function _find($dbObject, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                    array $params = array(), $limit = 0, $isLoadAllFields = FALSE, $elements = NULL,
                                    $selectFields = self::SELECT_FIELDS_ALL){
        return self::_runSQLShop(
            $dbObject, $shopID, $sitePageData, $driver, $params, $limit, $isLoadAllFields, $elements,
            Request_RequestParams::getParamBoolean('is_tree', $params), $selectFields
        );
    }

    /**
     * Поиск данных в заданной заведении
     * @param string $dbObject
     * @param int $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    public static function find($dbObject, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                array $params = array(), $limit = 0, $isLoadAllFields = FALSE, $elements = NULL,
                                $selectFields = self::SELECT_FIELDS_ALL){
        /** @var Request_Request $request */
        $request = static::getRequest($dbObject);
        if($request !== false){
            return $request::_find($dbObject, $shopID, $sitePageData, $driver, $params, $limit, $isLoadAllFields, $elements, $selectFields);
        }

        return self::_find($dbObject, $shopID, $sitePageData, $driver, $params, $limit, $isLoadAllFields, $elements, $selectFields);
    }

    /**
     * Поиск данных в заданной заведении
     * @param string $dbObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    protected static function _findNotShop($dbObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                           array $params = array(), $limit = 0, $isLoadAllFields = FALSE, $elements = NULL,
                                           $selectFields = self::SELECT_FIELDS_ALL){
        return self::_runSQL($dbObject, $sitePageData, $driver, $params, $limit, $isLoadAllFields, $elements, $selectFields);
    }

    /**
     * Поиск данных в заданной заведении
     * @param string $dbObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @return MyArray
     */
    public static function findNotShop($dbObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                       array $params = array(), $limit = 0, $isLoadAllFields = FALSE, $elements = NULL,
                                       $selectFields = self::SELECT_FIELDS_ALL){
        /** @var Request_Request $request */
        $request = static::getRequest($dbObject);
        if($request !== false){
            return $request::_findNotShop($dbObject, $sitePageData, $driver, $params, $limit, $isLoadAllFields, $elements, $selectFields);
        }

        return self::_findNotShop($dbObject, $sitePageData, $driver, $params, $limit, $isLoadAllFields, $elements, $selectFields);
    }

    /**
     * Получение всех значений таблицы
     * @param string $dbObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isLoadAllFields
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    protected static function _findAllNotShop($dbObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                              $isLoadAllFields = FALSE, $elements = NULL, $selectFields = self::SELECT_FIELDS_ALL)
    {
        return self::_runSQL(
            $dbObject, $sitePageData, $driver, Request_RequestParams::setParams(), 0, $isLoadAllFields, $elements,
            $selectFields
        );
    }


    /**
     * Получаем записи по полю
     * @param $dbObject
     * @param $field
     * @param $value
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    public static function findByField($dbObject, $field, $value, $shopID, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver, $limit = 0, $isLoadAllFields = FALSE,
                                       $elements = NULL, $selectFields = self::SELECT_FIELDS_ALL){
        if (empty($value)){
            return new MyArray();
        }

        $params= Request_RequestParams::setParams(
            array(
                $field => $value,
            )
        );
        return self::find($dbObject, $shopID, $sitePageData, $driver, $params, $limit, $isLoadAllFields, $elements, $selectFields);
    }


    /**
     * Получение всех значений таблицы
     * @param string $dbObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isLoadAllFields
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray
     */
    public static function findAllNotShop($dbObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          $isLoadAllFields = FALSE, $elements = NULL, $selectFields = self::SELECT_FIELDS_ALL)
    {
        /** @var Request_Request $request */
        $request = static::getRequest($dbObject);
        if($request !== false){
            return $request::_findAllNotShop($dbObject, $sitePageData, $driver, $isLoadAllFields, $elements, $selectFields);
        }

        return self::_findAllNotShop($dbObject, $sitePageData, $driver, $isLoadAllFields, $elements, $selectFields);
    }

    /**
     * Поиск записи по полю и значению
     * @param $dbObject
     * @param $fieldName
     * @param $fieldValue
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $elements
     * @param int | array $selectFields
     * @return MyArray|null
     */
    public static function findOneByField($dbObject, $fieldName, $fieldValue, $shopID, SitePageData $sitePageData,
                                          Model_Driver_DBBasicDriver $driver, $elements = NULL,
                                          $selectFields = self::SELECT_FIELDS_ALL){
        if(empty($fieldName)){
            return null;
        }

        $params = Request_RequestParams::setParams(
            array(
                $fieldName => $fieldValue,
            )
        );
        return self::_findOne($dbObject, $shopID, $sitePageData, $driver, $params, $elements, $selectFields);
    }

    /**
     * Получаем Model по полю и значению
     * @param $dbObject
     * @param $fieldName
     * @param $fieldValue
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool|Model_Basic_LanguageObject
     */
    public static function findOneByFieldModel($dbObject, $fieldName, $fieldValue, $shopID, SitePageData $sitePageData,
                                               Model_Driver_DBBasicDriver $driver){
        $object = self::findOneByField($dbObject, $fieldName, $fieldValue, $shopID, $sitePageData, $driver);

        if($object === null){
            return FALSE;
        }else{
            /** @var Model_Basic_DBValue $model */
            $model = DB_Basic::createModel($dbObject, $driver);
            $model->setDBDriver($driver);
            $object->setModel($model);
            return $model;
        }
    }

    /**
     * Поиск записи по названию
     * @param $dbObject
     * @param $name
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int |array $selectFields
     * @return MyArray|null
     */
    public static function findOneByName($dbObject, $name, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                         $selectFields = self::SELECT_FIELDS_ALL){
        if(empty($name)){
            return null;
        }

        return self::findOneByField($dbObject, 'name_full', $name, $shopID, $sitePageData, $driver, null, $selectFields);
    }

    /**
     * Поиск записи по полю, если не найдено то создаем запись и возвращаем ID записи
     * @param $dbObject
     * @param $field
     * @param $value
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function findIDByFieldAndCreate($dbObject, $field, $value, $shopID, SitePageData $sitePageData,
                                                  Model_Driver_DBBasicDriver $driver){
        if(empty($field) || empty($value)){
            return 0;
        }

        $result = self::findOneByField($dbObject, $field . '_full', $value, $shopID, $sitePageData, $driver);
        if($result != null){
            return $result->id;
        }

        $model = DB_Basic::createModel($dbObject, $driver);
        $model->setValue($field, $value);

        return Helpers_DB::saveDBObject($model, $sitePageData, $shopID);
    }

    /**
     * Поиск записи по названию
     * @param $dbObject
     * @param $name
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | array $selectFields
     * @return null | MyArray
     */
    public static function findOneByNameNotShop($dbObject, $name, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                $selectFields = self::SELECT_FIELDS_ALL){
        if(empty($name)){
            return null;
        }

        $params = Request_RequestParams::setParams(
            array(
                'name_full' => $name,
            )
        );
        return self::_findOneNotShop($dbObject, $sitePageData, $driver, $params, null, $selectFields);
    }

    /**
     * Получаем ID записи по полю
     * @param $dbObject
     * @param $field
     * @param $value
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function findIDByField($dbObject, $field, $value, $shopID, SitePageData $sitePageData,
                                         Model_Driver_DBBasicDriver $driver){
        if (empty($value)){
            return 0;
        }

        $params= Request_RequestParams::setParams(
            array(
                $field => $value,
            )
        );
        if($shopID > 0){
            $result = self::_findOne($dbObject, $shopID, $sitePageData, $driver, $params, null, ['id']);
        }else{
            $result = self::_findOneNotShop($dbObject, $sitePageData, $driver, $params, null, ['id']);
        }

        if ($result == null){
            return 0;
        }

        return $result->id;
    }

    /**
     * Получаем ID записи по списку параметров
     * @param $dbObject
     * @param $shopID
     * @param array $params
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int
     */
    public static function findID($dbObject, $shopID, array $params, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        if($shopID > 0){
            $result = self::findOne($dbObject, $shopID, $sitePageData, $driver, $params, null, ['id']);
        }else{
            $result = self::findOneNotShop($dbObject, $sitePageData, $driver, $params, null, ['id']);
        }

        if ($result == null){
            return 0;
        }

        return $result->id;
    }

    /**
     * Получаем Model по списку параметров
     * @param $dbObject
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @return bool|Model_Basic_LanguageObject
     */
    public static function findOneModel($dbObject, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                        array $params, $elements = NULL){
        $object = self::findOne($dbObject, $shopID, $sitePageData, $driver, $params, $elements);

        if($object === null){
            return FALSE;
        }else{
            /** @var Model_Basic_DBValue $model */
            $model = DB_Basic::createModel($dbObject, $driver);
            $model->setDBDriver($driver);
            $object->setModel($model);

            $model->dbGetElements($sitePageData->shopMainID, $elements);
            return $model;
        }
    }

    /**
     * Получаем Model по списку параметров
     * @param $dbObject
     * @param $id
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool|Model_Basic_LanguageObject
     */
    public static function findOneModelByID($dbObject, $id, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        return self::findOneModel(
            $dbObject, $shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(['id' => $id, 'is_delete_ignore' => true, 'is_public_ignore' => true])
        );
    }

    /**
     * Поиск данных по ID и возвращает значение заданного поля
     * @param $dbObject
     * @param $id
     * @param $field
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $elements
     * @return MyArray
     */
    public static function findOneByIDResultField($dbObject, $id, $field, $shopID, SitePageData $sitePageData,
                                                  Model_Driver_DBBasicDriver $driver, $elements = NULL){
        $result = self::findOneByID($dbObject, $id, $shopID, $sitePageData, $driver, $elements, [$field]);
        if ($result === null){
            return null;
        }

        return Arr::path($result->values, $field, null);
    }

    /**
     * Поиск по заданым параметрам и возвращается массив определенных полей
     * @param array $fields
     * @param $dbObject
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param int $limit
     * @param bool $isLoadAllFields
     * @param null $elements
     * @return array
     */
    public static function findResultFields(array $fields, $dbObject, $shopID, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver, array $params = array(), $limit = 0,
                                            $isLoadAllFields = FALSE, $elements = NULL){
        $result = self::find($dbObject, $shopID, $sitePageData, $driver, $params, $limit, $isLoadAllFields, $elements, $fields);
        return $result->getChildsFields($fields);
    }
}
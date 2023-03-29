<?php defined('SYSPATH') or die('No direct script access.');

class Request_RequestUtils {

    /**
     * Считывание данных с запроса и записывания в SQL запрос WHERE
     * @param SitePageData $sitePageData
     * @param $nameRead
     * @param $nameWhere
     * @param Model_Driver_DBBasicWhere $where
     * @param array $params
     * @param null $isNotReadRequest
     * @param string $tableName
     */
    public static function setWhereFieldArray(SitePageData $sitePageData, $nameRead, $nameWhere,
                                              Model_Driver_DBBasicWhere $where, array $params,
                                              $isNotReadRequest = NULL,
                                              $tableName = '')
    {
        // не считывать параметры переданные в GET и POST запросах
        if($isNotReadRequest === NULL) {
            $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);
        }

        if (!is_array($nameRead)) {
            $nameRead = array($nameRead);
        }

        $tmp = NULL;
        foreach ($nameRead as $value) {
            $tmp = Request_RequestParams::getParamArray($value, $params, $isNotReadRequest, $sitePageData);
            if ($tmp !== NULL) {
                break;
            }
        }

        if (($tmp !== NULL)) {
            $where->addField($nameWhere, $tableName, $tmp, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_IN);
        }
    }

    /**
     * Считывание данных с запроса и записывания в SQL запрос WHERE
     * @param SitePageData $sitePageData
     * @param $nameRead
     * @param $nameWhere
     * @param Model_Driver_DBBasicWhere $where
     * @param array $params
     * @param null $isNotReadRequest
     * @param int $compareType
     * @param string $tableName
     */
    public static function setWhereFieldFloat(SitePageData $sitePageData, $nameRead, $nameWhere,
                                            Model_Driver_DBBasicWhere $where, array $params,
                                            $isNotReadRequest = NULL,
                                            $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY,
                                            $tableName = '')
    {
        // не считывать параметры переданные в GET и POST запросах
        if($isNotReadRequest === NULL) {
            $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);
        }

        if (!is_array($nameRead)) {
            $nameRead = array($nameRead);
        }

        $tmp = NULL;
        foreach ($nameRead as $value) {
            $tmp = Request_RequestParams::getParamFloat($value, $params, $isNotReadRequest, $sitePageData);
            if ($tmp !== NULL) {
                break;
            }
        }

        if (($tmp !== NULL)) {
            $where->addField($nameWhere, $tableName, $tmp, '', $compareType);
        }
    }

    public static function setWhereValue($nameWhere, $value,
                                         Model_Driver_DBBasicWhere $where,
                                         $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY,
                                         $tableName = '')
    {
        if(is_array($value)){
            $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_IN;
        }

        if ($value !== NULL && $value !== '') {
            $where->addField($nameWhere, $tableName, $value, '', $compareType);
        }

        return $value;
    }

    /**
     * Считывание данных с запроса и записывания в SQL запрос WHERE
     * @param SitePageData $sitePageData
     * @param $nameRead
     * @param $nameWhere
     * @param Model_Driver_DBBasicWhere $where
     * @param array $params
     * @param null $isNotReadRequest
     * @param int $compareType
     * @param string $tableName
     * @return false|int|mixed|null|string
     */
    public static function setWhereFieldDateTime(SitePageData $sitePageData, $nameRead, $nameWhere,
                                                 Model_Driver_DBBasicWhere $where, array $params,
                                                 $isNotReadRequest = NULL,
                                                 $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY,
                                                 $tableName = '')
    {
        // не считывать параметры переданные в GET и POST запросах
        if($isNotReadRequest === NULL) {
            $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);
        }

        if (!is_array($nameRead)) {
            $nameRead = array($nameRead);
        }

        $tmp = NULL;
        foreach ($nameRead as $value) {
            $tmp = Request_RequestParams::getParamDateTime($value, $params, $isNotReadRequest, $sitePageData);
            if ($tmp !== NULL) {
                break;
            }
        }

        return self::setWhereValue($nameWhere, $tmp, $where, $compareType, $tableName);
    }

    /**
     * Считывание данных с запроса и записывания в SQL запрос WHERE
     * @param SitePageData $sitePageData
     * @param $nameRead
     * @param $nameWhere
     * @param Model_Driver_DBBasicWhere $where
     * @param array $params
     * @param null $isNotReadRequest
     * @param int $compareType
     * @param string $tableName
     * @return false|int|mixed|null|string
     */
    public static function setWhereFieldDate(SitePageData $sitePageData, $nameRead, $nameWhere,
                                             Model_Driver_DBBasicWhere $where, array $params,
                                             $isNotReadRequest = NULL,
                                             $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY,
                                             $tableName = '')
    {
        // не считывать параметры переданные в GET и POST запросах
        if($isNotReadRequest === NULL) {
            $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);
        }

        if (!is_array($nameRead)) {
            $nameRead = array($nameRead);
        }

        $tmp = NULL;
        foreach ($nameRead as $value) {
            $tmp = Request_RequestParams::getParamDate($value, $params, $isNotReadRequest, $sitePageData);
            if ($tmp !== NULL) {
                break;
            }
        }

        return self::setWhereValue($nameWhere, $tmp, $where, $compareType, $tableName);
    }

    /**
     * Считывание данных с запроса и записывания в SQL запрос WHERE
     * @param SitePageData $sitePageData
     * @param $nameRead
     * @param $nameWhere
     * @param Model_Driver_DBBasicWhere $where
     * @param array $params
     * @param null $isNotReadRequest
     * @param int $compareType
     * @param string $tableName
     * @return false|int|mixed|null|string
     */
    public static function setWhereFieldTime(SitePageData $sitePageData, $nameRead, $nameWhere,
                                             Model_Driver_DBBasicWhere $where, array $params,
                                             $isNotReadRequest = NULL,
                                             $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY,
                                             $tableName = '')
    {
        // не считывать параметры переданные в GET и POST запросах
        if($isNotReadRequest === NULL) {
            $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);
        }

        if (!is_array($nameRead)) {
            $nameRead = array($nameRead);
        }

        $tmp = NULL;
        foreach ($nameRead as $value) {
            $tmp = Request_RequestParams::getParamTime($value, $params, $isNotReadRequest, $sitePageData);
            if ($tmp !== NULL) {
                break;
            }
        }

        return self::setWhereValue($nameWhere, $tmp, $where, $compareType, $tableName);
    }

    public static function setWhereValueBool($nameWhere, $value,
                                             Model_Driver_DBBasicWhere $where,
                                             $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY,
                                             $tableName = '')
    {
        if ($value !== NULL) {
            if($value === TRUE) {
                $where->addField($nameWhere, $tableName, 1, '', $compareType);
            }else{
                $where->addField($nameWhere, $tableName, 0, '', $compareType);
            }
        }

        return $value;
    }

    /**
     * Считывание данных с запроса и записывания в SQL запрос WHERE
     * @param SitePageData $sitePageData
     * @param $nameRead
     * @param $nameWhere
     * @param Model_Driver_DBBasicWhere $where
     * @param array $params
     * @param null $isNotReadRequest
     * @param int $compareType
     * @param string $tableName
     * @return mixed
     */
    public static function setWhereFieldBool(SitePageData $sitePageData, $nameRead, $nameWhere,
                                            Model_Driver_DBBasicWhere $where, array $params,
                                             $isNotReadRequest = NULL,
                                            $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY,
                                            $tableName = '')
    {
        // не считывать параметры переданные в GET и POST запросах
        if($isNotReadRequest === NULL) {
            $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);
        }

        if (!is_array($nameRead)) {
            $nameRead = array($nameRead);
        }

        $tmp = NULL;
        foreach ($nameRead as $value) {
            $tmp = Request_RequestParams::getParamBoolean($value, $params, $isNotReadRequest, $sitePageData);
            if ($tmp !== NULL) {
                break;
            }
        }

        return self::setWhereValueBool($nameWhere, $tmp, $where, $compareType, $tableName);
    }

    public static function setWhereValueStr($nameWhere, $value,
                                            Model_Driver_DBBasicWhere $where,
                                            $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE,
                                            $tableName = '', $notEmpty = TRUE)
    {
        if(is_array($value)){
            $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_IN;
        }

        if ($value !== NULL && ($notEmpty === FALSE || !empty($value))) {
            $where->addField($nameWhere, $tableName, $value, '', $compareType);
        }


        return $value;
    }

    /**
     * Считывание данных с запроса и записывания в SQL запрос WHERE
     * @param SitePageData $sitePageData
     * @param $nameRead
     * @param $nameWhere
     * @param Model_Driver_DBBasicWhere $where
     * @param array $params
     * @param null $isNotReadRequest
     * @param int $compareType
     * @param string $tableName
     * @param bool $notEmpty
     * @return mixed
     */
    public static function setWhereFieldStr(SitePageData $sitePageData, $nameRead, $nameWhere,
                                            Model_Driver_DBBasicWhere $where, array $params,
                                            $isNotReadRequest = NULL,
                                            $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_LIKE,
                                            $tableName = '', $notEmpty = TRUE)
    {
        // не считывать параметры переданные в GET и POST запросах
        if($isNotReadRequest === NULL) {
            $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);
        }

        if (!is_array($nameRead)) {
            $nameRead = array($nameRead);
        }

        $tmp = NULL;
        foreach ($nameRead as $value) {
            $tmp = Request_RequestParams::getParam($value, $params, NULL, $isNotReadRequest, $sitePageData);
            if ($tmp !== NULL) {
                if (is_array($tmp)){
                    $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_IN;
                }
                break;
            }
        }

        return self::setWhereValueStr($nameWhere, $tmp, $where, $compareType, $tableName, $notEmpty);
    }

    public static function setWhereValueInt($nameWhere, $value,
                                            Model_Driver_DBBasicWhere $where,
                                            $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY,
                                            $tableName = '', $more = -1)
    {
        $compareTypeOriginal = $compareType;
        if ($value === null) {
            return null;
        }

        if(is_array($value)){
            $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_IN;

            $tmp2 = array();
            foreach($value as $i){
                if (($i == '0' || intval($i)) && ($i > $more)) {
                    $tmp2[] = $i;
                }
            }

            if(!empty($tmp2)){
                $value = $tmp2;
            }
        }else{
            if (strpos($value, ',') > -1) {
                $value = explode(',', $value);

                for ($i = 0; $i < count($value); $i++) {
                    $value[$i] = trim($value[$i]) * 1;
                    if (($more === NULL) || ($value[$i] <= $more)) {
                        unset($value[$i]);
                    }
                }
                $value = array_values($value);

                if(!empty($value)){
                    $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_IN;
                }
            } else {
                $value = intval($value);
            }
        }

        if ($value !== NULL && $value !== ''  && (!is_array($value) || !empty($value))
            && ($more === NULL || is_array($value) || $value > $more * 1)) {
            $fieldWhere = $where->addField($nameWhere, $tableName, $value, '', $compareType);
            if(($compareType == Model_Driver_DBBasicWhere::COMPARE_TYPE_IN)
                && ($compareTypeOriginal == Model_Driver_DBBasicWhere::COMPARE_TYPE_NOT_EQUALLY)){
                $fieldWhere->isNot = TRUE;
            }

            return $value;
        }

        return NULL;
    }

    /**
     * Считывание данных с запроса и записывания в SQL запрос WHERE
     * @param SitePageData $sitePageData
     * @param $nameRead
     * @param $nameWhere
     * @param Model_Driver_DBBasicWhere $where
     * @param array $params
     * @param null $isNotReadRequest
     * @param int $compareType
     * @param string $tableName
     * @param int $more
     * @return array|int|mixed|null
     */
    public static function setWhereFieldInt(SitePageData $sitePageData, $nameRead, $nameWhere,
                                            Model_Driver_DBBasicWhere $where, array $params,
                                            $isNotReadRequest = NULL,
                                            $compareType = Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY,
                                            $tableName = '', $more = -1)
    {
        // не считывать параметры переданные в GET и POST запросах
        if($isNotReadRequest === NULL) {
            $isNotReadRequest = Request_RequestParams::getIsNotReadRequest($params);
        }

        if (!is_array($nameRead)) {
            $nameRead = array($nameRead);
        }

        $value = NULL;
        foreach ($nameRead as $value) {
            $value = Request_RequestParams::getParam($value, $params, NULL, $isNotReadRequest, $sitePageData);
            if($value != null && $value != '' ){
                break;
            }
        }

        return self::setWhereValueInt($nameWhere, $value, $where, $compareType, $tableName, $more);
    }

    /**
     * Считываем список ID по заданному лимиту и возвращае массив MyArray
     * @param array $resultSQL
     * @param bool $isAllFields
     * @param bool $isLoadElements
     * @param string $fieldName
     * @return MyArray
     */
    public static function ArrayInMyArrayTree(array $resultSQL, $isAllFields = FALSE, $isLoadElements = FALSE, $fieldName = 'root_id') {
        $data = $resultSQL['result'];

        $result = new MyArray();
        for($i = 0; $i < 10; $i++) {
            foreach ($data as $key => $value) {
                $child = $result->addChild($value['id'], $value[$fieldName]);
                if ($child !== NULL) {
                    $child->values = $value;
                    if ($isAllFields){
                        foreach ($child->values as $fieldName => $fieldValue){
                            $n = strpos($fieldName, '___');
                            if ($n !== FALSE){
                                $child->values[Model_Basic_BasicObject::FIELD_ELEMENTS][substr($fieldName, 0, $n)][substr($fieldName, $n + 3)] = $fieldValue;
                                unset($child->values[$fieldName]);
                            }
                        }

                        if($isAllFields === TRUE) {
                            $child->isFindDB = TRUE;
                        }
                        $child->isLoadElements = $isLoadElements;
                    }

                    unset($data[$key]);
                }
            }

            if(count($data) == 0){
                break;
            }
        }

        return $result;
    }

    /**
     * Сохраняем значение в список
     * @param SitePageData $sitePageData
     * @param array $resultSQL
     * @param $limit
     * @param $limitPage
     * @param $page
     * @param bool $isAllFields
     * @param bool $isLoadElements
     * @param bool $isShift
     * @return MyArray
     */
    public static function ArrayInMyArrayList(SitePageData $sitePageData, array $resultSQL, $limit, $limitPage, $page,
                                              $isAllFields = FALSE, $isLoadElements = FALSE, $isShift = true) {
        $result = new MyArray();

        if($page < 1){
            $page = 1;
        }

        $sitePageData->urlParams['page'] = $page;
        $sitePageData->page = $page;

        // количество записей
        $sitePageData->countRecord = $resultSQL['count'];

        // лимит по количетву записей
        if($limitPage < 1) {
            $limitPage = $sitePageData->countRecord;
        }
        $sitePageData->limit = intval($limit);
        $sitePageData->limitPage = $limitPage;

        // проверяем, чтобы количество записей было большое нуля
        if($sitePageData->countRecord == 0){
            $sitePageData->pages = 0;

            return $result;
        }

        // количество страниц результата поиска
        $sitePageData->pages = floor($sitePageData->countRecord / $limitPage);
        if ($sitePageData->countRecord % $limitPage > 0){
            $sitePageData->pages++;
        }

        if($isShift) {
            $shift = ($sitePageData->page - 1) * $limitPage;
            $count = $sitePageData->countRecord - $shift;
        }else{
            $shift = 0;
            $count = count($resultSQL['result']);
        }

        if($limitPage > $count){
            $limitPage = $count;
        }

        $data = $resultSQL['result'];
        for ($i = 0; $i < $limitPage; $i++) {
            $values = $data[$i + $shift];
            if(is_array($values)) {
                if (key_exists('id', $values)) {
                    $id = $values['id'];
                } else {
                    $id = 0;
                }
                $tmp = $result->addChild($id);
                $tmp->values = $data[$i + $shift];

                if ($isLoadElements){
                    foreach ($tmp->values as $fieldName => $fieldValue){
                        $n = strpos($fieldName, '___');
                        if ($n !== FALSE){
                            $tmp->values[Model_Basic_BasicObject::FIELD_ELEMENTS][substr($fieldName, 0, $n)][substr($fieldName, $n + 3)] = $fieldValue;
                            unset($tmp->values[$fieldName]);
                        }
                    }
                }
            }else{
                $tmp = $result->addChild($data[$i + $shift]);
            }

            if($isAllFields === TRUE) {
                $tmp->isFindDB = TRUE;
            }
            $tmp->isLoadElements = $isLoadElements;
        }

        return $result;
    }
}
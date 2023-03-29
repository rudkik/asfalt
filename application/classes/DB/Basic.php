<?php defined('SYSPATH') or die('No direct script access.');

class DB_Basic {

    const NAME = 'DB_Basic';

    /**
     * По Table ID получаем DB_
     * @param $tableID
     * @return string
     */
    public static function getDBByTableID($tableID)
    {
        return 'DB_Ab1_Shop_Analysis_Type';
    }

    /**
     * Задаем данные в модель по типу
     * @param Model_Basic_BasicObject $model
     * @param $name
     * @param $value
     * @param int $type
     */
    public static function setValueModel(Model_Basic_BasicObject $model, $name, $value, $type = DB_FieldType::FIELD_TYPE_STRING)
    {
        switch ($type){
            case DB_FieldType::FIELD_TYPE_INTEGER:
                $model->setValueInt($name, $value);
                break;
            case DB_FieldType::FIELD_TYPE_BOOLEAN:
                $model->setValueBool($name, $value);
                break;
            case DB_FieldType::FIELD_TYPE_DATE_TIME:
                $model->setValueDateTime($name, $value);
                break;
            case DB_FieldType::FIELD_TYPE_DATE:
                $model->setValueDate($name, $value);
                break;
            case DB_FieldType::FIELD_TYPE_TIME:
                $model->setValueTime($name, $value);
                break;
            case DB_FieldType::FIELD_TYPE_FLOAT:
                $model->setValueFloat($name, $value);
                break;
            case DB_FieldType::FIELD_TYPE_JSON:
            case DB_FieldType::FIELD_TYPE_FILES:
                $model->setValueArray($name, $value);
                break;
            case DB_FieldType::FIELD_TYPE_ARRAY:
                $model->setValueArray($name, $value, false, true);
                break;
            default:
                $model->setValue($name, $value);
        }
    }

    /**
     * получаем название проекта по DB_
     * @param $dbObject
     * @return string
     */
    public static function getProjectName($dbObject){
        if (empty($dbObject)){
            return '';
        }

        $projectName = explode('_',$dbObject);
        if (count($projectName) < 1){
            return '';
        }

        switch ($projectName[1]) {
            case 'Ab1':
            case 'AutoPart':
            case 'Magazine':
                return $projectName[1];
        }
        return '';
    }

    /**
     * Получаем имя Controller_ по DB_
     * @param $dbObject
     * @param $projectName
     * @param $interfaceName
     * @return string
     */
    public static function getControllerName($dbObject, $projectName, $interfaceName = null)
    {
        $prefix = 'Controller_' . $projectName;
        if (!empty($interfaceName)){
            $prefix .= '_' . $interfaceName;
        }

        $projectName = self::getProjectName($dbObject);
        if (!empty($projectName)){
            $dbObject = str_replace('DB_' . $projectName . '_','', $dbObject);
        }else{
            $dbObject = str_replace('DB_','', $dbObject);
        }

        return $prefix . '_' . str_replace('_','', $dbObject);
    }

    /**
     * Получаем массив полей DB_
     * @param $dbObject
     * @param string $default
     * @return array
     */
    public static function getFieldsDB($dbObject, $default = '')
    {
        $result = array();
        foreach ($dbObject::FIELDS as $name => $value){
            $result[$name] = $default;
        }

        return $result;
    }

    /**
     * Получаем имя View_ по DB_
     * @param $dbObject
     * @param string $default
     * @return string
     */
    public static function getViewName($dbObject, $default = 'View_View')
    {
        $dbObject = substr($dbObject, 3);
        $path = APPPATH . 'classes' . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR
            . str_replace('_', '/', $dbObject). '.php';
        if(file_exists($path)){
            return 'View_' . $dbObject;
        }

        return $default;
    }

    /**
     * Получаем имя Model_ по DB_
     * @param $dbObject
     * @return string
     */
    public static function getModelName($dbObject)
    {
        return 'Model' . substr($dbObject, 2);
    }

    /**
     * Получаем имя Api_ по DB_
     * @param $dbObject
     * @return string
     */
    public static function getApiName($dbObject)
    {
        return 'Api' . substr($dbObject, 2);
    }

    /**
     * Создание модели по объекту базы данных
     * @param string $dbObject
     * @param Model_Driver_DBBasicDriver $driver
     * @return Model_Basic_LanguageObject
     */
    public static function createModel($dbObject, Model_Driver_DBBasicDriver $driver = null)
    {
        $model = self::getModelName($dbObject);
        $model = new $model();
        if(!empty($driver)){
            $model->setDBDriver($driver);
        }

        return $model;
    }

    /**
     * По пути DB получаем имя DB
     * @param $path
     * @return array|string
     */
    public static function getDBObjectByPath($path)
    {
        $filePath = Helpers_Path::getPathFile(APPPATH, ['classes']);
        $path = Func::mb_str_replace($filePath, '', $path);
        $path = Func::mb_str_replace(DIRECTORY_SEPARATOR, '_', $path);
        $path = Func::mb_str_replace('.php', '', $path);

        return $path;
    }

    /**
     * Из DB_ объектов  преобразование в путь views
     * @param $dbObject
     * @return string
     */
    public static function getViewPath($dbObject)
    {
        if(strpos($dbObject, '_') === false){
            return '';
        }

        $arr = explode('_', $dbObject);
        if ($arr[1] == 'Ab1' || $arr[1] == 'Smg' || $arr[1] == 'AutoPart' || $arr[1] == 'Magazine') {
            $n = 2;
        } else {
            $n = 1;
        }

        $view = '';
        if ($arr[$n] == 'Shop') {
            $view .= '_shop/';
            $n++;
        }

        for ($i = $n; $i < count($arr); $i++) {
            $s = $arr[$i];
            $directory = '';
            for ($j = 0; $j < mb_strlen($s); $j++) {
                $char = mb_substr($s, $j, 1);
                if ($j > 0 && ctype_upper($char)) {
                    $directory .= '-';
                }
                $directory .= $char;
            }
            $view .= $directory . '/';
        }

        return mb_strtolower($view);
    }

    /**
     * Записываем данные полученные из формы HTML в модель
     * @param $dbObject
     * @param Model_Basic_BasicObject $model
     * @param array $notSaveFields
     */
    public static function saveRequestParamsInModel($dbObject, Model_Basic_BasicObject $model, array $notSaveFields = array())
    {
        $list = array();
        foreach ($notSaveFields as $child){
            $list[$child] = true;
        }
        $notSaveFields = $list;
        $notSaveFields['id'] = true;
        $notSaveFields['global_id'] = true;
        $notSaveFields['is_delete'] = true;
        $notSaveFields['language_id'] = true;
        $notSaveFields['image_path'] = true;

        foreach ($dbObject::FIELDS as $name => $field){
            if(Arr::path($field, 'is_not_automatic_save', false)
                || key_exists($name, $notSaveFields) !== false){
                continue;
            }

            switch ($field['type']){
                case DB_FieldType::FIELD_TYPE_STRING:
                    Request_RequestParams::setParamStr($name, $model);
                    break;
                case DB_FieldType::FIELD_TYPE_INTEGER:
                    Request_RequestParams::setParamInt($name, $model);
                    break;
                case DB_FieldType::FIELD_TYPE_BOOLEAN:
                    Request_RequestParams::setParamBoolean($name, $model);
                    break;
                case DB_FieldType::FIELD_TYPE_DATE_TIME:
                    Request_RequestParams::setParamDateTime($name, $model);
                    break;
                case DB_FieldType::FIELD_TYPE_DATE:
                    Request_RequestParams::setParamDate($name, $model);
                    break;
                case DB_FieldType::FIELD_TYPE_TIME:
                    Request_RequestParams::setParamTime($name, $model);
                    break;
                case DB_FieldType::FIELD_TYPE_FLOAT:
                    Request_RequestParams::setParamFloat($name, $model);
                    break;
                case DB_FieldType::FIELD_TYPE_JSON:
                    $arr = Request_RequestParams::getParamArray($name);
                    if($arr !== null){
                        $model->addValueArray($name, $arr);
                    }
                    break;
                case DB_FieldType::FIELD_TYPE_ARRAY:
                    $arr = Request_RequestParams::getParamArray($name);
                    if($arr !== null){
                        $model->setValueArray($name, $arr, false, true);
                    }
                    break;
            }
        }
    }

    /**
     * Сохраняем файлы и картинки в модель
     * @param $dbObject
     * @param Model_Basic_BasicObject $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function saveRequestParamsFilesInModel($dbObject, Model_Basic_BasicObject $model,
                                                         SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $name = 'files';
        if(!key_exists($name, $dbObject::FIELDS)){
            return false;
        }

        $field = $dbObject::FIELDS[$name];

        // загружаем фотографии
        $file = new Model_File($sitePageData);

        if(Arr::path($field, 'is_not_automatic_save', false)
            || $field['type'] != DB_FieldType::FIELD_TYPE_FILES){
            return false;
        }

        $file->saveFiles(Request_RequestParams::getParamArray($name), $model, $sitePageData, $driver);

        return true;
    }

    /**
     * Задаем нумерацию записей как в 1С исходя из настроек DB_Ab1_Shop_Sequence, если он не задан
     * @param Model_Basic_BasicObject $model
     * @param $fieldName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     */
    public static function setNumber1CIfEmpty(Model_Basic_BasicObject $model, $fieldName, SitePageData $sitePageData,
                                              Model_Driver_DBBasicDriver $driver, $shopID = 0){
        if(Func::_empty($model->getValue($fieldName))){
            $model->setValue($fieldName, DB_Basic::getNumber1C($model, $sitePageData, $driver, $shopID));
        }
    }


    /**
     * Получаем нумерацию записей как в 1С исходя из настроек DB_Ab1_Shop_Sequence
     * @param Model_Basic_BasicObject $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     * @return int|string
     * @throws HTTP_Exception_500
     */
    public static function getNumber1C(Model_Basic_BasicObject $model, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver, $shopID = 0)
    {
        if($shopID == 0){
            $shopID = $model->shopID;
        }

        /** @var Model_Ab1_Shop_Sequence $modelSequence */
        $modelSequence = Request_Request::findOneByFieldModel(
            'DB_Ab1_Shop_Sequence', 'table_id', $model::TABLE_ID, $shopID, $sitePageData, $driver
        );
        if($modelSequence === false){
            return '';
        }

        $sequence = $modelSequence->getSequence();
        if(empty($sequence)){
            throw new HTTP_Exception_500('Sequence name not found.');
        }

        $symbol = $modelSequence->getSymbol();

        // зависимость от филиала
        if($modelSequence->getIsBranch()){
            $sequence .= '_s' . $shopID;
        }

        // зависимость от кассового аппарата
        if($modelSequence->getIsCashbox()){
            $model->setShopTableRubricID($sitePageData->operation->getShopTableRubricID());

            /** @var Model_Ab1_Shop_Cashbox $cashbox */
            $cashbox = $sitePageData->operation->getElement('shop_cashbox_id', true, $sitePageData->shopMainID);
            if (empty($cashbox)) {
                throw new HTTP_Exception_500('Cashbox no found');
            }
            $model->setShopCashboxID($cashbox->id);

            $sequence .= '_o' . $model->getShopTableRubricID();
            $symbol = $cashbox->getSymbol();
        }

        // зависимость от вида продукции (продукт/материал)
        if($modelSequence->getIsProduct()){
            $sequence .= '_t' . $model->getValueInt('product_type_id');
        }

        $length = $modelSequence->getLength();

        $number = $driver->nextSequence($sequence);
        if($length < strlen($number)){
            $length = strlen($number);
        }

        $number = $symbol . Func::addBeginSymbol($number, '0', $length);

        return $number;
    }

    /**
     * Задаем нумерацию записей как в 1С
     * @param $dbObject
     * @param Model_Basic_BasicObject $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function setNumber1CInModel($dbObject, Model_Basic_BasicObject $model,
                                              SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $fieldNumber = '';
        $fieldValue = null;
        foreach ($dbObject::FIELDS as $name => $field){
            if(key_exists('sequence', $field) !== false
                || (key_exists('is_sequence', $field) !== false && $field['is_sequence'])){
                $fieldNumber = $name;
                $fieldValue = Arr::path($field, 'sequence');
                break;
            }
        }

        if(empty($fieldNumber)){
            return false;
        }

        if(!Func::_empty($model->getValue($fieldNumber))){
            return true;
        }

        // is_sequence = true определяем счетчик исходя из настроек DB_Ab1_Shop_Sequence
        if(!is_array($fieldValue)){
            $model->setValue(
                $fieldNumber,
                self::getNumber1C($model, $sitePageData, $driver, $sitePageData->shopID)
            );

            return true;
        }

        $sequence = Arr::path($fieldValue, 'name');
        if(empty($sequence)){
            throw new HTTP_Exception_500('Sequence name not found.');
        }

        $symbol = Arr::path($fieldValue, 'symbol', '');

        if(Arr::path($fieldValue, 'is_shop', false)){
            $sequence .= '_s' . $sitePageData->shopID;
        }

        if(Arr::path($fieldValue, 'is_cashbox', false)){
            $model->setShopTableRubricID($sitePageData->operation->getShopTableRubricID());

            /** @var Model_Ab1_Shop_Cashbox $cashbox */
            $cashbox = $sitePageData->operation->getElement('shop_cashbox_id', true, $sitePageData->shopMainID);
            if (empty($cashbox)) {
                throw new HTTP_Exception_500('Cashbox no found');
            }
            $model->setShopCashboxID($cashbox->id);

            $sequence .= '_o' . $model->getShopTableRubricID();
            $symbol = $cashbox->getSymbol();
        }

        $length = intval(Arr::path($fieldValue, 'length', 0));

        $number = $driver->nextSequence($sequence);
        if($length < strlen($number)){
            $length = strlen($number);
        }

        $number = $symbol . Func::addBeginSymbol($number, '0', $length - strlen($number));
        $model->setValue($fieldNumber, $number);

        return true;
    }

    /**
     * Сохраяем список связанных записей с основной записью (например: список товаров заказа)
     * @param $dbObject
     * @param $dbObjectItem
     * @param $fieldIDMain
     * @param Model_Basic_BasicObject $modelMain
     * @param array $items - список связанных записей
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function saveItems($dbObject, $dbObjectItem, $fieldIDMain,
                                     Model_Basic_BasicObject $modelMain, $items,
                                     SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $mainID = $modelMain->id;
        $model = self::createModel($dbObjectItem, $driver);

        $itemIDs = Request_Request::find(
            $dbObjectItem, $modelMain->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    $fieldIDMain => $mainID,
                )
            ),
            0, TRUE
        );

        // находим общие поля и итоговые поля
        $commonFields = array();
        $totalFields = array();
        foreach ($dbObject::FIELDS as $name => $field) {
            if (Arr::path($field, 'is_common_items', false)
                && key_exists($name, $dbObjectItem::FIELDS)) {
                $commonFields[$name] = $field;
            }
            if (Arr::path($field, 'is_total_items', false)
                && key_exists($name, $dbObjectItem::FIELDS)) {
                $totalFields[$name] = array(
                    'field' => $name,
                    'quantity' => 0,
                );
            }

            $totalItem = Arr::path($field, 'total_item', false);
            if (is_array($totalItem)
                && Arr::path($totalItem, 'db_name') == $dbObjectItem
                && key_exists(Arr::path($totalItem, 'field', $name), $dbObjectItem::FIELDS)) {
                $totalFields[$name] = array(
                    'field' => Arr::path($totalItem, 'field', $name),
                    'quantity' => 0,
                );
            }
        }

        if($items == null || !is_array($items)){
            foreach ($itemIDs->childs as $child) {
                $child->setModel($model);

                // переносим общие поля
                foreach ($commonFields as $name => $field) {
                    $model->setValue($name, $modelMain->getValue($name));
                }

                // считаем итоговые поля
                foreach ($totalFields as $name => $total) {
                    $totalFields[$name]['quantity']  += $model->getValueFloat($total['field']);
                }

                Helpers_DB::saveDBObject($model, $sitePageData, $modelMain->shopID);
            }
        }else {
            foreach ($items as $key => $child) {
                if (empty($child) || !is_array($child)) {
                    continue;
                }

                $itemIDs->childShiftSetModel($model, $key, $modelMain->shopID);

                // переносим общие поля
                foreach ($commonFields as $name => $field) {
                    $model->setValue($name, $modelMain->getValue($name));
                }

                // считываем переданные значения
                foreach ($dbObjectItem::FIELDS as $name => $field) {
                    if (!key_exists($name, $child)) {
                        continue;
                    }

                    $value = $child[$name];
                    switch ($field['type']) {
                        case DB_FieldType::FIELD_TYPE_STRING:
                            $model->setValue($name, $value);
                            break;
                        case DB_FieldType::FIELD_TYPE_INTEGER:
                            $model->setValueInt($name, Request_RequestParams::valParamInt($value));
                            break;
                        case DB_FieldType::FIELD_TYPE_BOOLEAN:
                            $model->setValueBool($name, $value);
                            break;
                        case DB_FieldType::FIELD_TYPE_DATE_TIME:
                            $model->setValueDateTime($name, $value);
                            break;
                        case DB_FieldType::FIELD_TYPE_DATE:
                            $model->setValueDate($name, $value);
                            break;
                        case DB_FieldType::FIELD_TYPE_TIME:
                            $model->setValueTime($name, $value);
                            break;
                        case DB_FieldType::FIELD_TYPE_FLOAT:
                            $model->setValueFloat($name, Request_RequestParams::valParamFloat($value));
                            break;
                        case DB_FieldType::FIELD_TYPE_JSON:
                            if (is_array($value)) {
                                $model->addValueArray($name, $value);
                            }
                            break;
                    }
                }

                // считаем итоговые поля
                foreach ($totalFields as $name => $total) {
                    $totalFields[$name]['quantity'] += $model->getValueFloat($total['field']);
                }

                $model->setValueInt($fieldIDMain, $modelMain->id);
                Helpers_DB::saveDBObject($model, $sitePageData, $modelMain->shopID);
            }

            // удаляем лишние
            $driver->deleteObjectIDs(
                $itemIDs->getChildArrayID(), $sitePageData->userID, $dbObjectItem::TABLE_NAME,
                array(), $modelMain->shopID
            );

            // записываем итоговые поля
            foreach ($totalFields as $name => $total) {
                switch ($dbObject::FIELDS[$name]['type']) {
                    case DB_FieldType::FIELD_TYPE_INTEGER:
                        $modelMain->setValueInt($name, $total['quantity']);
                        break;
                    case DB_FieldType::FIELD_TYPE_FLOAT:
                        $modelMain->setValueFloat($name, $total['quantity']);
                        break;
                }
            }
        }

        return $totalFields;
    }

    /**
     * Сохраяем списки связанных записей с основной записью (например: список товаров заказа, список скидок)
     * @param $dbObject
     * @param Model_Basic_BasicObject $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function saveListItems($dbObject, Model_Basic_BasicObject $model,
                                         SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $result = false;
        foreach ($dbObject::ITEMS as $name => $field) {
            $items = Request_RequestParams::getParamArray($name);
            self::saveItems(
                $dbObject, $field['table'], $field['field_id'], $model, $items, $sitePageData, $driver
            );
            $result = true;
        }
        return $result;
    }

    /**
     * По название класса проверяем есть ли такой файл
     * @param string $className
     * @param string $basicCatalog
     * @return bool|string
     */
    protected static function fileClassExists($className, $basicCatalog = APPPATH . 'classes' . DIRECTORY_SEPARATOR)
    {
        $path = mb_substr(Helpers_Path::getPathFile($basicCatalog, explode('_', $className)), 0, -1) . '.php';
        return file_exists($path);
    }

    /**
     * Сохранение записи полученной из HTML-формы
     * @param $dbObject
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save($dbObject, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = self::createModel($dbObject, $driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $shopID)) {
                throw new HTTP_Exception_500('Object "' . $dbObject . '" id "' . $id . '" shop_id "' . $shopID . '" not found.');
            }
        }

        // считываем данные полученные из формы в модель
        self::saveRequestParamsInModel($dbObject, $model);

        $result = array();
        if ($model->validationFields($result)) {
            $isSave = true;

            // Задаем нумерацию записей как в 1С
            self::setNumber1CInModel($dbObject, $model, $sitePageData, $driver, $sitePageData);

            if($model->id < 1){
                Helpers_DB::saveDBObject($model, $sitePageData);
                $isSave = false;
            }

            // Сохраняем файлы и картинки
            $isSave = self::saveRequestParamsFilesInModel($dbObject, $model, $sitePageData, $driver) || $isSave;


            // Сохраяем списки связанных записей
            $isSave = self::saveListItems($dbObject, $model, $sitePageData, $driver) || $isSave;

            self::saveFiles($model, $sitePageData, $driver);

            if($isSave){
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            $result['values'] = $model->getValues();
        }

        $apiName = self::getApiName($dbObject);

        if(self::fileClassExists($apiName) && method_exists($apiName,'saveModel')){
            $apiName::saveModel($model, $sitePageData, $driver);
        }

        return array(
            'id' => $model->id,
            'result' => $result,
            'model' => $model,
        );
    }

    /**
     * Удаление/востановление записи
     * @param $dbObject
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete($dbObject, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');
        if($id < 0){
            return FALSE;
        }
        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = self::createModel($dbObject, $driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $shopID)) {
            throw new HTTP_Exception_500('Object "' . $dbObject . '" not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        // Удаление/востановление связанные записи 1коМногим
        foreach ($dbObject::ITEMS as $name => $field) {
            if($isUnDel){
                $params = Request_RequestParams::setParams(
                    array(
                        $field['field_id'] => $id,
                        'is_delete' => 1,
                        'is_public' => FALSE,
                    )
                );
                $ids = Request_Request::find($field['table'], $shopID, $sitePageData, $driver, $params);
                $driver->unDeleteObjectIDs(
                    $ids->getChildArrayID(), $sitePageData->userID, $field['table']::TABLE_NAME,
                    array('is_public' => 1), $shopID
                );
            }else{
                $params = Request_RequestParams::setParams(
                    array(
                        $field['field_id'] => $id,
                        'is_delete' => 0,
                        'is_public_ignore' => TRUE,
                    )
                );
                $ids = Request_Request::find($field['table'], $shopID, $sitePageData, $driver, $params);
                $driver->deleteObjectIDs(
                    $ids->getChildArrayID(), $sitePageData->userID, $field['table']::TABLE_NAME,
                    array('is_public' => 0), $shopID
                );
            }
        }

        if($isUnDel){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else{
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return TRUE;
    }

    /**
     * Сохраняем картинки и файлы в модель из $_FILES в image_path и options
     * @param Model_Shop_Basic_Options $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveFiles(Model_Shop_Basic_Options $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $file = new Model_File($sitePageData);
        $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

        $options = $model->getOptionsArray();
        $files = Helpers_Image::getChildrenFILES('options');
        foreach ($files as $key => $child) {
            if(is_array($child['tmp_name'])){
                foreach ($child['tmp_name'] as $index => $path){
                    $data = array(
                        'tmp_name' => $path,
                        'name' => $child['name'][$index],
                        'type' => $child['type'][$index],
                        'error' => $child['error'][$index],
                        'size' => $child['size'][$index],
                    );
                    $options[$key][] = array(
                        'file' => $file->saveDownloadFilePath($data, $model->id, $model::TABLE_ID, $sitePageData),
                        'name' => $data['name'],
                        'size' => $data['size'],
                    );
                }
            }else{
                $options[$key][] = array(
                    'file' => $file->saveDownloadFilePath($child, $model->id, $model::TABLE_ID, $sitePageData),
                    'name' => $child['name'],
                    'size' => $child['size'],
                );
            }
        }
        $model->addOptionsArray($options);
    }

    /**
     * Сохраняем считанные данные из Excel-файла, проверяем необходимость на добавление по полю integrations
     * @param $dbObject
     * @param array $data
     * @param array $editFields
     * @param array $rootData
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isArticleID
     * @return array|bool
     */
    public static function saveOfExcelObjects($dbObject, array $data, array $editFields, array $rootData,
                                              SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                              $isArticleID = false){

        $list = [];
        foreach ($data as $child){
            if(!key_exists('integration', $child)){
                continue;
            }

            $integration = trim($child['integration']);
            if(empty($integration)){
                continue;
            }

            unset($child['integration']);
            $list[$integration] = $child;
        }

        $addValueList = function ($fieldType, $name, $value, Model_Basic_DBObject $model){
            switch ($fieldType) {
                case DB_FieldType::FIELD_TYPE_STRING:
                    $model->setValue($name, $value);
                    break;
                case DB_FieldType::FIELD_TYPE_INTEGER:
                    $value = str_replace(' ', '',
                        str_replace('>', '',
                            str_replace('<', '', $value)
                        )
                    );
                    $model->setValueInt($name, $value);
                    break;
                case DB_FieldType::FIELD_TYPE_BOOLEAN:
                    $model->setValueBool($name, $value);
                    break;
                case DB_FieldType::FIELD_TYPE_DATE_TIME:
                    $model->setValueDateTime($name, $value);
                    break;
                case DB_FieldType::FIELD_TYPE_DATE:
                    $model->setValueDate($name, $value);
                    break;
                case DB_FieldType::FIELD_TYPE_TIME:
                    $model->setValueTime($name, $value);
                    break;
                case DB_FieldType::FIELD_TYPE_FLOAT:
                    $value = str_replace(' ', '',
                        str_replace('>', '',
                            str_replace('<', '', $value)
                        )
                    );

                    $model->setValueFloat($name, $value);
                    break;
                case DB_FieldType::FIELD_TYPE_JSON:
                    if (is_array($value)) {
                        $model->addValueArray($name, $value);
                    }
                    break;
                case DB_FieldType::FIELD_TYPE_ARRAY:
                    if (is_array($value)) {
                        $model->setValueArray($name, $value, false, true);
                    }
                    break;
            }
        };

        $ids = Request_Request::find(
            $dbObject, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array_merge(
                    $rootData,
                    array(
                        'is_public_ignore' => true,
                    )
                )
            ),
            0, true
        );

        /** @var Model_AutoPart_Shop_Product $model */
        $model = DB_Basic::createModel($dbObject, $driver);

        // изменяем те записи, которые есть в базе данных
        $oldCount = 0;
        $process = [];
        foreach ($ids->childs as $child){
            $child->setModel($model);

            $key = '';
            foreach ($model->getIntegrationsArray() as $integration){
                if(key_exists($integration, $list)){
                    $key = $integration;
                    break;
                }
            }
            $model->setIsPublic(!empty($key));
            if($model->getIsPublic()){
                $dataChild = $list[$key];

                // заполняем данные, которые не были заполненны в прошлый раз
                foreach ($dataChild as $field => $value){
                    $field = explode('.', $field);
                    if(!key_exists($field[0], $dbObject::FIELDS)){
                        continue;
                    }

                    if(Func::_empty($model->getValue($field[0]))){
                        if(count($field) > 1){
                            $value = Request_Request::findIDByFieldAndCreate(
                                $dbObject::FIELDS[$field[0]]['table'], trim($field[1]), $value, $sitePageData->shopID,
                                $sitePageData, $driver
                            );
                        }

                        $addValueList($dbObject::FIELDS[$field[0]]['type'], $field[0], $value, $model);
                    }
                }

                // заполняем данные, которые обязательно нужно обновить
                foreach ($editFields as $field){
                    if(!key_exists($field, $dataChild)){
                        continue;
                    }

                    $value = trim($dataChild[$field]);

                    $field = explode('.', $field);
                    if(!key_exists($field[0], $dbObject::FIELDS)){
                        continue;
                    }
                    if(count($field) > 1){
                        $value = Request_Request::findIDByFieldAndCreate(
                            $dbObject::FIELDS[$field[0]]['table'], $field[1], $value, $sitePageData->shopID,
                            $sitePageData, $driver
                        );
                    }

                    $addValueList($dbObject::FIELDS[$field[0]]['type'], $field[0], $value, $model);
                }

                // сохраняем, что запись уже обработана, нужно для того, что одно значение Интеграции может быть у нескольких товаров
                // при дублировании такое происходит
                $process[$key] = true;

                $oldCount++;
            }
            $model->setIsInStock($model->getIsPublic());

            if($isArticleID && Func::_empty($model->getValue('article'))){
                $model->setValue('article', 'I'.$model->id);
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);
        }

        // добавляем новые записи в базу данных
        foreach ($list as $integration => $dataChild){
            if(key_exists($integration, $process)){
                continue;
            }

            $model->clear();

            foreach ($dataChild as $field => $value){
                $value = trim($value);

                $field = explode('.', $field);
                if(!key_exists($field[0], $dbObject::FIELDS)){
                    continue;
                }

                if(count($field) > 1){
                    $value = Request_Request::findIDByFieldAndCreate(
                        $dbObject::FIELDS[$field[0]]['table'], $field[1], $value, $sitePageData->shopID,
                        $sitePageData, $driver
                    );
                }

                $addValueList($dbObject::FIELDS[$field[0]]['type'], $field[0], $value, $model);
            }

            $model->setValues($rootData);
            $model->addIntegration($integration);
            $model->setIsInStock(true);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);

            if($isArticleID && Func::_empty($model->getValue('article'))){
                $model->setValue('article', 'I'.$model->id);
                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
            }
        }

        return [
            'old' => $oldCount,
            'new' => count($list),
        ];
    }
}
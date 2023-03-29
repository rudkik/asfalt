<?php

/**
 * Class Integration_Ab1_1C_Service
 */
class Integration_Ab1_1C_Service
{
    const SERVICE_NAME = 'ab1_1c';

    private $userName = '';
    private $password = '';
    private $url = '';
    private $dbObjects = [];

    /**
     * Integration_Ab1_1C_Service constructor.
     * @param string $userName
     * @param string $password
     * @param null $url
     * @param array $dbObjects
     */
    public function __construct($userName = '', $password = '', $url = null, array $dbObjects = [])
    {
        if(empty($proxyAuthorization) || empty($password) || empty($wsdl) || empty($dbObjects)){
            $config = include Helpers_Path::getPathFile(APPPATH, ['config', 'integration'], self::SERVICE_NAME . '.php');

            if(empty($userName)){
                $userName = $config['user_name'];
            }
            if(empty($password)){
                $password = $config['password'];
            }
            if(empty($url)){
                $url = $config['url'];
            }
            if(empty($dbObjects)){
                $dbObjects = $config['db_objects'];
            }
        }

        if (!$url) {
            $url = 'http://192.168.111.30:1980/acba/hs/asvaload/v1/data';
        }

        $this->userName = $userName;
        $this->password = $password;
        $this->url = $url;
        $this->dbObjects = $dbObjects;
    }

    /**
     * Отправляем данные в 1с
     * @param $dbObject
     * @param Model_Basic_LanguageObject $model
     * @return bool|mixed
     * @throws HTTP_Exception_500
     */
    public function update1C($dbObject, Model_Basic_LanguageObject $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $nameObject = Arr::path($dbObject::INTEGRATIONS, self::SERVICE_NAME);
        if(empty($nameObject)){
            return false;
            throw new HTTP_Exception_500('Integration name in DB object empty.');
        }

        $isDelete1C = false;
        // Проверяем нужно ли выгружать в 1С
        if(key_exists('is_save_1c', $nameObject)
            && key_exists('class', $nameObject['is_save_1c'])
            && key_exists('function', $nameObject['is_save_1c'])) {
            $class = $nameObject['is_save_1c']['class'];
            $function = $nameObject['is_save_1c']['function'];

            if(!$class::$function($model, $sitePageData, $driver)){
                $isDelete1C = true;
            }
        }

        // проверяем нужно ли синхронизировать
        foreach (Arr::path($nameObject,'params', []) as $key => $value){
            if($model->getValue($key) != $value){
                $isDelete1C = true;
            }
        }

        $data = [
            'type' => $nameObject['type'],
        ];

        if($model->getIsDelete() || $isDelete1C){
            $data['mode'] = 'del';
        }else{
            $data['mode'] = 'new';
        }

        $setDBObjectData = function (array &$result, $nameObject, array $fields, Model_Basic_LanguageObject $model,
                                     SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
            if(key_exists('guid', $nameObject)) {
                $result[$nameObject['guid']['1c']] = strval($model->getValue($nameObject['guid']['system']));
            }
            if(key_exists('guid_1c', $nameObject)) {
                $result[$nameObject['guid_1c']['1c']] = strval($model->getValue($nameObject['guid_1c']['system']));
            }

            // значения по умолчанию
            if(key_exists('default', $nameObject)){
                foreach ($nameObject['default'] as $name => $value){
                    Arr::set_path($result, $name, strval($value));
                }
            }

            foreach ($fields as $fieldName => $field){
                if(!key_exists('integrations', $field) || !key_exists(self::SERVICE_NAME, $field['integrations'])){
                    continue;
                }

                $name = $field['integrations'][self::SERVICE_NAME];
                if(key_exists('table', $field) && !empty($field['table'])){
                    $names = $name;
                    foreach ($names as $s1 => $s2){
                        if(Arr::path($result, $s1, null) === null) {
                            Arr::set_path($result, $s1, '');
                        }
                    }

                    $id = $model->getValueInt($fieldName);
                    if ($id > 0) {
                        $modelRoot = Request_Request::findOneModelByID($field['table'], $id, 0, $sitePageData, $driver);
                        if ($modelRoot != false) {
                            foreach ($names as $childField => $childNameList) {
                                if(!is_array($childNameList)){
                                    $childNameList = [$childNameList];
                                }

                                foreach ($childNameList as $childName){
                                    $valueModel = null;

                                    $childNames = explode('.', $childName);
                                    if(count($childNames) == 1){
                                        $valueModel = strval($modelRoot->getValue($childName));
                                    }else {
                                        $table = $field['table'];
                                        $childNameFirst = array_pop($childNames);

                                        $modelChild = $modelRoot;
                                        foreach ($childNames as $childNameOne) {
                                            if ($childNameOne == 'shop_operation_id' && !key_exists('shop_operation_id', $table::FIELDS)) {
                                                $childID = $modelChild->getValueInt('id');
                                                if ($childID < 1) {
                                                    break;
                                                }

                                                $modelChild = Request_Request::findOneModel(
                                                    'DB_Shop_Operation', 0, $sitePageData, $driver,
                                                    Request_RequestParams::setParams(
                                                        [
                                                            'user_id' => $childID,
                                                            'is_public_ignore' => true,
                                                            'is_delete_ignore' => true,
                                                        ]
                                                    )
                                                );
                                                $table = 'DB_Shop_Operation';
                                            }else{
                                                if(empty($table) || !key_exists($childNameOne, $table::FIELDS) || !key_exists('table', $table::FIELDS[$childNameOne])){
                                                    $modelChild = false;
                                                    break;
                                                }

                                                $childID = $modelChild->getValueInt($childNameOne);
                                                if ($childID < 1) {
                                                    $modelChild = false;
                                                    break;
                                                }

                                                $table = $table::FIELDS[$childNameOne]['table'];
                                                $modelChild = Request_Request::findOneModelByID($table, $childID, 0, $sitePageData, $driver);
                                            }

                                            if ($modelChild == false) {
                                                break;
                                            }
                                        }

                                        if ($modelChild != false) {
                                            $valueModel = strval($modelChild->getValue($childNameFirst));
                                        }
                                    }

                                    if(!empty($valueModel)){
                                        Arr::set_path($result, $childField, $valueModel);
                                    }
                                }
                            }
                        }
                    }
                }else{
                    $names = $name;
                    if(!is_array($names)){
                        $names = [$names];
                    }

                    foreach ($names as $name) {
                        if($name == 'date'){
                            Arr::set_path($result, $name, strval($model->getValueDate($fieldName)));
                        }else {
                            Arr::set_path($result, $name, strval($model->getValue($fieldName)));
                        }
                    }
                }
            }
        };

        $setDBObjectData($data, $nameObject, $dbObject::FIELDS, $model, $sitePageData, $driver);

        if(key_exists('children', $nameObject)) {
            foreach ($nameObject['children'] as $fieldName => $tables) {
                $data[$fieldName] = [];
                foreach ($tables as $field) {
                    // функция в ручную обработать
                    if(key_exists('class', $field) && key_exists('function', $field)) {
                        $class = $field['class'];
                        $function = $field['function'];

                        $data[$fieldName] = $class::$function($model, $sitePageData, $driver);

                        continue;
                    }

                    $modelChild = DB_Basic::createModel($field['table'], $driver);

                    $params = Arr::path($field, 'params', []);
                    $params[$field['field_2']] = $model->getValue($field['field_1']);

                    $ids = Request_Request::find(
                        $field['table'], 0, $sitePageData, $driver, Request_RequestParams::setParams($params),
                        0, true
                    );


                    foreach ($ids->childs as $child) {
                        $child->setModel($modelChild);

                        $one = [];
                        $nameObjectChild = Arr::path($field['table']::INTEGRATIONS, self::SERVICE_NAME);
                        $setDBObjectData($one, $nameObjectChild, $field['table']::FIELDS, $modelChild, $sitePageData, $driver);

                        $data[$fieldName][] = $one;
                    }
                }
            }
        }

        $result = $this->sendData($data);

        // сохраняем guid_1c
        $guid = Arr::path($result, '0.guid_1c');
        if(!empty($guid)){
            /** @var DB_Ab1_Shop_Client $model */
            $model->setGUID1C($guid);

            $model->setDBDriver($driver);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }
    }

    /**
     * Отправка данных
     * @param array $data
     */
    public function sendData(array $data){
        $cs = curl_init();

        echo '<pre>';
        print_r($data);
        $data = json_encode([$data]);
        echo $data;

        $opt = array(
            CURLOPT_URL => $this->url,
            CURLOPT_COOKIE => '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_REFERER => null,
            CURLOPT_USERAGENT => "1C+Enterprise/8.3",
            CURLOPT_TIMEOUT => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_POST => 1,
            CURLOPT_USERPWD => $this->userName . ":" . $this->password,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data),
            ],
            CURLOPT_POSTFIELDS => $data,
        );

        curl_setopt_array($cs, $opt);
        $result = curl_exec($cs);
        curl_close($cs);
        echo $result;//die;

        return json_decode($result, true);
    }

    /**
     * Возвращаем результат
     * @param $message
     * @param bool $isError
     * @throws HTTP_Exception_Service1C
     */
    private function sendRequestError($message, $isError = false){
        $result = [
            'message' => $message,
            'error' => $isError,
        ];

        throw new HTTP_Exception_Service1C($result, 500);
    }

    /**
     * Проверка наличие параметров
     * @param array $data
     * @param array $parameters
     */
    private function checkParameter(array $data, array $parameters)
    {
        foreach ($parameters as $parameter) {
            if (!key_exists($parameter, $data)) {
                $this->sendRequestError('Параметр "' . $parameter . '"не найден.', true);
            }
        }
    }

    /**
     * Обновляем данные заданного объекта
     * @param array $data
     * @param $dbObject
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    private function updateObject(array $data, $dbObject, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $fieldGUID = $dbObject::INTEGRATIONS[self::SERVICE_NAME]['guid']['1c'];
        $fieldGUID1C = $dbObject::INTEGRATIONS[self::SERVICE_NAME]['guid_1c']['1c'];

        if(empty($data[$fieldGUID]) && empty($data[$fieldGUID1C])){
            $this->sendRequestError('Параметры "guid" и "guid_1c" не заданы.', true);
        }

        $model = false;
        if(!empty($data[$fieldGUID1C])){
            $model = Request_Request::findOneModel(
                $dbObject, 0, $sitePageData, $driver,
                Request_RequestParams::setParams(['is_delete_ignore' => true, 'is_public_ignore' => true, $dbObject::INTEGRATIONS[self::SERVICE_NAME]['guid_1c']['system'].'_full' => $data[$fieldGUID1C]])
            );
        }

        if($model == false && !empty($data[$fieldGUID])){
            $model = Request_Request::findOneModel(
                $dbObject, 0, $sitePageData, $driver,
                Request_RequestParams::setParams(['is_delete_ignore' => true, 'is_public_ignore' => true, $dbObject::INTEGRATIONS[self::SERVICE_NAME]['guid']['system'].'_full' => $data[$fieldGUID]])
            );
        }

        // если нужно удалить
        if($data['mode'] == 'del'){
            if($model == false){
                $this->sendRequestError('Объект не найден.', true);

                return [
                    'type' => $data['type'],
                    'mode' => 'del',
                    'guid' => '',
                    'guid_1c' => '',
                ];
            }

            $model->dbDelete($sitePageData->userID);

            return [
                'type' => $data['type'],
                'mode' => 'del',
                'guid' => $model->getValue($dbObject::INTEGRATIONS[self::SERVICE_NAME]['guid']['system']),
                'guid_1c' => $model->getValue($dbObject::INTEGRATIONS[self::SERVICE_NAME]['guid_1c']['system']),
            ];

        }

        if($model == false){
            $model = DB_Basic::createModel($dbObject, $driver);
        }

        if(!empty($data[$fieldGUID1C])) {
            $model->setValue($dbObject::INTEGRATIONS[self::SERVICE_NAME]['guid_1c']['system'], $data[$fieldGUID1C]);
        }

        foreach ($dbObject::FIELDS as $fieldName => $fieldOptions){
            if(!key_exists('integrations', $fieldOptions) || !key_exists(self::SERVICE_NAME, $fieldOptions['integrations'])){
                continue;
            }

            $names = $fieldOptions['integrations'][self::SERVICE_NAME];
            if(!is_array($names)){
                $names = [$names];
            }

            if(key_exists('table', $fieldOptions)){
                foreach ($names as $field1C => $fieldChild){
                    if(strpos($fieldChild, '.') === false){
                        if (!key_exists($field1C, $data) || is_array($data[$field1C])) {
                            $this->sendRequestError('Параметр "' . $field1C . '" не найден.', true);
                        }

                        $modelChild = Request_Request::findOneModel(
                            $fieldOptions['table'], 0, $sitePageData, $driver,
                            Request_RequestParams::setParams(['is_delete_ignore' => true, 'is_public_ignore' => true, $fieldChild . '_full' => $data[$field1C]])
                        );

                        if($modelChild == false){
                            $this->sendRequestError('Объект "' . $field1C . '" со значением "' . $data[$field1C] . '" не найден.', true);
                        }
                    }
                }
            }else {
                $value = '';
                $isValue = false;
                foreach ($names as $name) {
                    if (key_exists($name, $data) && !is_array($data[$name])) {
                        $value = $data[$name];
                        $isValue = true;
                    }
                }

                if (!$isValue) {
                    $this->sendRequestError('Параметр "' . implode(', ', $names) . '" не найден.', true);
                }

                DB_Basic::setValueModel($model, $fieldName, $value, $fieldOptions['type']);
            }
        }

        $model->setIsDelete(false);

        Helpers_DB::saveDBObject($model, $sitePageData, $shopID);

        return [
            'type' => $data['type'],
            'mode' => 'new',
            'guid' => $model->getValue($dbObject::INTEGRATIONS[self::SERVICE_NAME]['guid']['system']),
            'guid_1c' => $model->getValue($dbObject::INTEGRATIONS[self::SERVICE_NAME]['guid_1c']['system']),
        ];
    }

    /**
     * Обновление одного объекта
     * @param array $data
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    private function updateOneAb1(array $data, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $this->checkParameter($data, ['type', 'ver', 'code', 'guid', 'guid_1c']);

        if(!key_exists('ver', $data)){
            $this->sendRequestError('Данные не в формате JSON.', true);
        }

        $shopID = 20678;
        if(key_exists('division', $data)){
            $shop = Request_Request::findOneByField(
                DB_Ab1_Shop::NAME, 'old_id_full', $data['division'], 0,
                $sitePageData, $driver
            );

            if($shop == null){
                $this->sendRequestError('Подраздение "' . $data['division'] . '" не найдено.', true);
            }

            $shopID = $shop->id;
        }

        if(!key_exists($data['type'], $this->dbObjects)){
            $this->sendRequestError('Тип объекта "' . $data['type'] . '" не найден.', true);
        }

        return $this->updateObject($data, $this->dbObjects[$data['type']], $shopID, $sitePageData, $driver);
    }

    /**
     * Обновляем данные из 1С
     * @param $data
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_Service1C
     */
    public function updateAb1($data, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if(empty($data)){
            $this->sendRequestError('Данные пустые.', true);
        }

        $list = json_decode($data, true);
        if(empty($list)){
            $this->sendRequestError('Данные не в формате JSON.', true);
        }

        $result = [];
        foreach ($list as $child){
            if(!is_array($child)){
                $this->sendRequestError('Данные не в формате JSON.', true);
            }

            try {
                $result[] = $this->updateOneAb1($child, $sitePageData, $driver);
            }catch (Exception $e){
                $this->sendRequestError('Программная ошибка "' . $e->getMessage() . '".', true);
            }
        }

        $result = [
            'message' => 'ok',
            'error' => false,
            'data' => $result,
        ];

        throw new HTTP_Exception_Service1C($result, 200);
    }
}
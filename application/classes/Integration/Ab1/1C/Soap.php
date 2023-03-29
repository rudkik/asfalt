<?php

/**
 * Class Integration_Ab1_1C_Soap
 */
class Integration_Ab1_1C_Soap extends \SoapClient
{
    const SERVICE_NAME = 'ab1-1c-soap';

    /**
     * Integration_Ab1_1C_Service constructor.
     * @param string $login
     * @param string $password
     * @param null $wsdl
     */
    public function __construct($login = '', $password = '', $wsdl = null)
    {
        if(empty($login) || empty($password) || empty($wsdl)){
            $config = include Helpers_Path::getPathFile(APPPATH, ['config', 'integration'], self::SERVICE_NAME . '.php');

            if(empty($login)){
                $login = $config['login'];
            }
            if(empty($password)){
                $password = $config['password'];
            }
            if(empty($wsdl)){
                $wsdl = $config['wsdl'];
            }
        }

        $options = array(
            'login' => $login,
            'password' => $password,
            'Header' => null,
            'features' => 1,
        );

        if (!$wsdl) {
            $wsdl = 'http://192.168.111.30:1980/Asfaltabeton/ws/ASVAExchange.1cws?wsdl';
        }

        parent::__construct($wsdl, $options);
    }

    /**
     * Отправляем данные в 1с
     * @param $dbObject
     * @param Model_Basic_LanguageObject $model
     * @return bool|mixed
     * @throws HTTP_Exception_500
     */
    public function update1C($dbObject, Model_Basic_LanguageObject $model)
    {
        $nameObject = Arr::path($dbObject::INTEGRATIONS, self::SERVICE_NAME);
        if(empty($nameObject)){
            return false;
            throw new HTTP_Exception_500('Integration name in DB object empty.');
        }

        $action = new stdClass();

        $object = new stdClass();
        $action->$nameObject = $object;

        foreach ($dbObject::FIELDS as $fieldName => $field){
            if(!key_exists('integrations', $field) || !key_exists(self::SERVICE_NAME, $field['integrations'])){
                continue;
            }

            $name = $field['integrations'][self::SERVICE_NAME];
            $object->$name = $model->getValue($fieldName);
        }
    }

    private function getMessage($message, $isError = false){
        return [
            'message' => $message,
            'error' => $isError,
        ];
    }

    /**
     * Сохраняем данные из 1С
     * @param $data
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public function updateAb1($data, $shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if(empty($data)){
            return $this->getMessage('Data empty.', true);
        }

        $xml = simplexml_load_string($data);
        $xml = Helpers_XML::xmlToArray($xml);

        $config = include Helpers_Path::getPathFile(APPPATH, ['config'], '1C.php');

        foreach ($xml as $objectName => $object){
            if(!key_exists('Code1C', $object)){
                return $this->getMessage('Code1C not found.', true);
            }

            if(!key_exists($objectName, $config['db_objects'])){
                return $this->getMessage('Config DB object not found.', true);
            }
            $dbObject = $config['db_objects'][$objectName];

            $model = Request_Request::findOneModel(
                $dbObject, $shopID, $sitePageData, $driver,
                Request_RequestParams::setParams([$dbObject::INTEGRATIONS[self::SERVICE_NAME]['find_field'] . '_full' => $object['Code1C']])
            );
            if($model === false) {
                $model = DB_Basic::createModel($dbObject, $driver);
            }

            foreach ($dbObject::FIELDS as $fieldName => $field){
                if(!key_exists('integrations', $field) || !key_exists(self::SERVICE_NAME, $field['integrations'])){
                    continue;
                }

                $name = $field['integrations'][self::SERVICE_NAME];

                if(key_exists($name, $object)){
                    $model->setValue($fieldName, $object[$name]['value']);
                }
            }

            if($model instanceof Model_Ab1_Shop_Client){
                $model->setNames($model->getName1C());
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $shopID);
        }

        return $this->getMessage('OK', false);
    }
}
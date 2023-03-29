<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Consumable  {

    /**
     * удаление товара
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');
        if($id < 0){
            return FALSE;
        }

        $model = new Model_Magazine_Shop_Consumable();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Consumable not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return TRUE;
    }

    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Magazine_Shop_Consumable();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Consumable not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("number", $model);
        Request_RequestParams::setParamDateTime("from_at", $model);
        Request_RequestParams::setParamDateTime("to_at", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamFloat('amount', $model);
        Request_RequestParams::setParamStr("extradite", $model);
        Request_RequestParams::setParamStr("base", $model);
        Request_RequestParams::setParamStr("pko_number", $model);
        Request_RequestParams::setParamDate("pko_date", $model);
        Request_RequestParams::setParamDate("created_at", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if(Func::_empty($model->getNumber())){
                $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'sp_number_consumable_'.$sitePageData->shopID.'\') as id;')->as_array(NULL, 'id')[0];
                $n = '0000000'.$n;
                $n = 'Т'.substr($n, strlen($n) - 8);
                $model->setNumber($n);
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Сохраняем расходники в виде XML
     * @param $from
     * @param $to
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveXML($from, $to, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список оплат
        $shopConsumableIDs = Request_Request::find('DB_Magazine_Shop_Consumable', $sitePageData->shopID, $sitePageData, $driver,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'created_at_from' => $from, 'created_at_to' => $to),
            0, TRUE);

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($shopConsumableIDs->childs as $shopConsumableID){
            $data .= '<consumable>'
                .'<NumDoc>'.$shopConsumableID->values['number'].'</NumDoc>'
                .'<date>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($shopConsumableID->values['created_at'])).'</date>'
                .'<amount>'.$shopConsumableID->values['amount'].'</amount>'
                .'<extradite>'.$shopConsumableID->values['extradite'].'</extradite>'
                .'<base>'.$shopConsumableID->values['base'].'</base>';

            $data .= '</consumable>';
        }
        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="consumable.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }
}

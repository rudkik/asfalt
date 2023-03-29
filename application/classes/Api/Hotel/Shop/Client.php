<?php defined('SYSPATH') or die('No direct script access.');

class Api_Hotel_Shop_Client  {
    /**
     * Пересчет баланса клиента
     * @param $shopClientID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveBalance
     * @return mixed
     */
    public static function recountClientBalance($shopClientID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
        $isSaveBalance = FALSE)
    {
        // сумма заказов
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'sum_amount' => TRUE,
            )
        );
        $shopBillIDs = Request_Request::find('DB_Hotel_Shop_Bill', $sitePageData->shopID, $sitePageData, $driver, $params);

        // сумма возврат
        $shopRefundDs = Request_Request::find('DB_Hotel_Shop_Refund', $sitePageData->shopID, $sitePageData, $driver, $params);

        // сумма оплат
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'is_paid' => TRUE,
                'sum_amount' => TRUE,
            )
        );
        $shopPaymentIDs = Request_Request::find('DB_Hotel_Shop_Payment', $sitePageData->shopID, $sitePageData, $driver, $params);

        $balance = $shopPaymentIDs->childs[0]->values['amount']
            - $shopBillIDs->childs[0]->values['amount']
            - $shopRefundDs->childs[0]->values['amount'];

        if($isSaveBalance){
            $model = new Model_Hotel_Shop_Client();
            $model->setDBDriver($driver);
            if(Helpers_DB::getDBObject($model, $shopClientID, $sitePageData)){
                $model->setAmount($balance);
                Helpers_DB::saveDBObject($model, $sitePageData);
            }
        }

        return $balance;
    }

    /**
     * Пересчет баланса всех клиентов
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function recountClientsBalance(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopClientIDs = Request_Request::find('DB_Hotel_Shop_Client', $sitePageData->shopID, $sitePageData, $driver,
            array(), 0, TRUE);

        $model = new Model_Hotel_Shop_Client();
        $model->setDBDriver($driver);
        foreach ($shopClientIDs->childs as $child){
            $model->clear();
            $model->__setArray(array('values' => $child->values));
            $model->setAmount(self::recountClientBalance($model->id, $sitePageData, $driver));
            $model->setBlockAmount(0);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }
    }


    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Client();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Client not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("bank_id", $model);

        Request_RequestParams::setParamStr('phone', $model);
        Request_RequestParams::setParamStr('email', $model);
        Request_RequestParams::setParamStr('bin', $model);
        Request_RequestParams::setParamStr('bik', $model);
        Request_RequestParams::setParamStr('bank', $model);
        Request_RequestParams::setParamStr('account', $model);
        Request_RequestParams::setParamStr('address', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Добавление клиента
     * @param array $data
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isCheckPhone
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function saveOfArray(array $data, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                       $isCheckPhone = FALSE)
    {
        $model = new Model_Hotel_Shop_Client();
        $model->setDBDriver($driver);

        $id = intval(Arr::path($data, 'id', 0));
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Client not found.');
            }
        }elseif (($isCheckPhone) && (key_exists('phone', $data))){
            $phone = $data['phone'];
            if (!empty($phone)) {
                $params = Request_RequestParams::setParams(array('phone_full' => $phone));
                $ids = Request_Request::find('DB_Hotel_Shop_Client', $sitePageData->shopID, $sitePageData, $driver,
                    $params, 1, TRUE);
                if(count($ids->childs) > 0){
                    return array(
                        'id' => $ids->childs[0]->id,
                        'result' => $ids->childs[0]->values,
                        'user_name' => Arr::path($data, 'name', $ids->childs[0]->values['name']),
                    );
                }
            }
        }

        if (key_exists('is_public', $data)) {
            $model->setIsPublic($data['is_public']);
        }
        if (key_exists('text', $data)) {
            $model->setText($data['text']);
        }
        if (key_exists('name', $data)) {
            $model->setName($data['name']);
        }
        if (key_exists('first_name', $data)) {
            if (key_exists('last_name', $data)) {
                $model->setName($data['first_name'].' '.$data['last_name']);
            }else{
                $model->setName($data['first_name']);
            }
        }
        if (key_exists('old_id', $data)) {
            $model->setOldID($data['old_id']);
        }

        if (key_exists('phone', $data)) {
            $model->setPhone($data['phone']);
        }

        if (key_exists('email', $data)) {
            $model->setEmail($data['email']);
        }

        if (key_exists('options', $data)) {
            $options = $data['options'];
            if (is_array($options)) {
                $model->addOptionsArray($options);
            }
        }

        if(Func::_empty($model->getName())){
            return array(
                'id' => 0,
                'result' => array(),
                'user_name' => '',
            );
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
            'user_name' => Arr::path($data, 'name', ''),
        );
    }

    /**
     * Сохраняем список клиентов в XML
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveXML(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список оплат
        $shopClientIDs = Request_Request::find('DB_Hotel_Shop_Client', $sitePageData->shopID, $sitePageData, $driver,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE, array('shop_room_type_id' => array('old_id')));

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($shopClientIDs->childs as $shopClientID){
            $data .= '<client>'
                .'<id>'.$shopClientID->values['id'].'</id>'
                .'<id_1c>'.$shopClientID->values['old_id'].'</id_1c>'
                .'<name>'.htmlspecialchars($shopClientID->values['name'], ENT_XML1).'</name>'
                .'<bin>'.$shopClientID->values['bin'].'</bin>'
                .'<bik>'.$shopClientID->values['bik'].'</bik>'
                .'<address>'.$shopClientID->values['address'].'</address>'
                .'<account>'.$shopClientID->values['account'].'</account>'
                .'<bank>'.$shopClientID->values['bank'].'</bank>';
            $data .= '</client>';
        }
        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="clients.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }
}

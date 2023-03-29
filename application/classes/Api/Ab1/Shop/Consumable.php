<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Consumable  {
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

        $model = new Model_Ab1_Shop_Consumable();
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
        $model = new Model_Ab1_Shop_Consumable();
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
        Request_RequestParams::setParamDateTime("created_at", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            // счетчик как в 1с
            DB_Basic::setNumber1CIfEmpty($model, 'number', $sitePageData, $driver, $sitePageData->shopID);

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
     * @return string
     */
    public static function saveXML($from, $to, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список расходников
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $from,
                'created_at_to' => $to
            )
        );
        $shopConsumableIDs = Request_Request::findBranch('DB_Ab1_Shop_Consumable',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_cashbox_id' => array('name', 'old_id'),
                'shop_id' => array('name', 'old_id'),
            )
        );

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($shopConsumableIDs->childs as $shopConsumableID){
            $data .= '<consumable>'
                .'<type>0</type>'
                .'<NumDoc>'.$shopConsumableID->values['number'].'</NumDoc>'
                .'<date>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($shopConsumableID->values['created_at'])).'</date>'
                .'<amount>'.$shopConsumableID->values['amount'].'</amount>'
                .'<extradite>'.$shopConsumableID->values['extradite'].'</extradite>'
                .'<base>'.htmlspecialchars($shopConsumableID->values['base'], ENT_XML1).'</base>'
                .'<branch>'.$shopConsumableID->getElementValue('shop_id', 'old_id').'</branch>'
                .'<branch_name>'.htmlspecialchars($shopConsumableID->getElementValue('shop_id', 'name'), ENT_XML1).'</branch_name>'
                .'<cashbox>'.htmlspecialchars($shopConsumableID->getElementValue('shop_cashbox_id', 'old_id'), ENT_XML1).'</cashbox>'
                .'<cashbox_name>'.htmlspecialchars($shopConsumableID->getElementValue('shop_cashbox_id'), ENT_XML1).'</cashbox_name>';

            $data .= '</consumable>';
        }

        // получаем список возврат оплат
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $from,
                'created_at_to' => $to
            )
        );

        $shopPaymentReturnIDs = Request_Request::findBranch('DB_Ab1_Shop_Payment_Return',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array(
                'shop_client_id' => array('name', 'old_id', 'bin', 'address', 'account', 'bik'),
                'shop_cashbox_id' => array('name', 'old_id'),
                'shop_id' => array('name', 'old_id'),
            )
        );

        foreach($shopPaymentReturnIDs->childs as $shopPaymentReturnID){
            $data .= '<consumable>'
                .'<type>1</type>'
                .'<NumDoc>'.$shopPaymentReturnID->values['number'].'</NumDoc>'
                .'<date>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($shopPaymentReturnID->values['created_at'])).'</date>'
                .'<amount>'.$shopPaymentReturnID->values['amount'].'</amount>'

                .'<branch>'.$shopPaymentReturnID->getElementValue('shop_id', 'old_id').'</branch>'
                .'<branch_name>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_id', 'name'), ENT_XML1).'</branch_name>'

                .'<IdKlient>'.$shopPaymentReturnID->getElementValue('shop_client_id', 'old_id').'</IdKlient>'
                .'<Company>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_client_id', 'name'), ENT_XML1).'</Company>'
                .'<BIN>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_client_id', 'bin'), ENT_XML1).'</BIN>'
                .'<address>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_client_id', 'address'), ENT_XML1).'</address>'
                .'<account>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_client_id', 'account'), ENT_XML1).'</account>'
                .'<bank>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_client_id', 'bik'), ENT_XML1).'</bank>'

                .'<cashbox>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_cashbox_id', 'old_id'), ENT_XML1).'</cashbox>'
                .'<cashbox_name>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_cashbox_id'), ENT_XML1).'</cashbox_name>';

            $data .='<TypePay>1</TypePay>'
                .'<amount_pko>'. round($shopPaymentReturnID->values['amount'], 0) . '</amount_pko>'
                .'<sumNDS>'.round($shopPaymentReturnID->values['amount'] / 112 * 12, 2).'</sumNDS>';

            $params = Request_RequestParams::setParams(
                array(
                    'shop_payment_return_id' => $shopPaymentReturnID->id
                )
            );
            $shopPaymentReturnItemIDs = Request_Request::find('DB_Ab1_Shop_Payment_Return_Item',
                $shopPaymentReturnID->values['shop_id'], $sitePageData, $driver, $params, 0, TRUE,
                array(
                    'shop_product_id' => array('product_type_id', 'old_id'),
                )
            );

            $data .= '<Goods>';
            foreach($shopPaymentReturnItemIDs->childs as $shopPaymentReturnItemID){
                $data .= '<GoodString>'
                    .'<Code>'.htmlspecialchars($shopPaymentReturnItemID->getElementValue('shop_product_id', 'old_id'), ENT_XML1).'</Code>'
                    .'<Type>'.htmlspecialchars($shopPaymentReturnItemID->getElementValue('shop_product_id', 'product_type_id'), ENT_XML1).'</Type>'
                    .'<quantity>'.$shopPaymentReturnItemID->values['quantity'].'</quantity>'
                    .'<price>'.$shopPaymentReturnItemID->values['price'].'</price>'
                    .'<sum>'.$shopPaymentReturnItemID->values['amount'].'</sum>'
                    .'<sumBN>'.($shopPaymentReturnItemID->values['amount'] - round($shopPaymentReturnItemID->values['amount'] / 112 * 12, 2)) .'</sumBN>'
                    .'<sumNDS>'.round($shopPaymentReturnItemID->values['amount'] / 112 * 12, 2).'</sumNDS>'
                    .'</GoodString>';
            }
            $data .= '</Goods>';

            $data .=
            '<extradite>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_client_id', 'name'), ENT_XML1).'</extradite>'
            .'<base>'.htmlspecialchars('Возврат денежных средств клиенту', ENT_XML1).'</base>';

            $data .= '</consumable>';
        }

        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="consum.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }
}

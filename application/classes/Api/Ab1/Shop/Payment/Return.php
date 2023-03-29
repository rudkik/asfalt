<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Payment_Return  {

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

        $model = new Model_Ab1_Shop_Payment_Return();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Payment return not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        // баланс прихода денег
        Api_Ab1_Shop_Client::calcBalanceCash($model->getShopClientID(), $sitePageData, $driver);

        Api_Ab1_Shop_Client_Balance_Day::deleteBlockPaymentReturnClientBalanceDay(
            $model->getShopClientID(), $model->id, $sitePageData, $driver
        );

        return TRUE;
    }

    /**
     * Печать возвратного фискального чека
     * @param float $paidAmount
     * @param int $shopPaymentReturnID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
    public static function printReturnFiscalCheck(float $paidAmount, int $shopPaymentReturnID,
                                                  SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {

        $fiscalCheck = new Drivers_CashRegister_Aura3_FiscalCheck();

        // список продукции реализации
        Api_Ab1_Shop_Payment_Return_Item::getGoodListFiscalCheck(
            $shopPaymentReturnID, $fiscalCheck->getGoodsList(), $sitePageData, $driver
        );

        // печать чека
        return Drivers_CashRegister_RemoteComputerAura3::printReturnFiscalCheck(
            'payment_return_'.$shopPaymentReturnID, $paidAmount, $fiscalCheck, $sitePageData
        );
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
        $model = new Model_Ab1_Shop_Payment_Return();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Payment return not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        $shopClientID = $model->getShopClientID();
        Request_RequestParams::setParamInt('shop_client_id', $model);
        Request_RequestParams::setParamStr('number', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        $fiscalResult = null;
        if ($model->validationFields($result)) {
            $isEditClientOrAmount = $model->getShopClientID() != $model->getOriginalValue('shop_client_id')
                || $model->getAmount() != $model->getOriginalValue('amount');

            // счетчик как в 1с
            DB_Basic::setNumber1CIfEmpty($model, 'number', $sitePageData, $driver, $sitePageData->shopID);

            if ($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // сохраняем товары счета
            $shopPaymentReturnItems = Request_RequestParams::getParamArray('shop_payment_return_items');
            if($shopPaymentReturnItems !== NULL) {
                $model->setAmount(
                    Api_Ab1_Shop_Payment_Return_Item::save(
                        $model->id, $shopPaymentReturnItems, $model->getShopClientID(), $sitePageData, $driver
                    )
                );
            }
            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            if (!Helpers_DB::getDBObject($model, $model->id, $sitePageData)) {
                throw new HTTP_Exception_500('Payment return not found.');
            }

            // печать фискального чека
            if(!$model->getIsFiscalCheck()){
                $fiscalResult = self::printReturnFiscalCheck($model->getAmount(), $model->id, $sitePageData, $driver);
                if(array($fiscalResult)){
                    $model->setFiscalCheck(Arr::path($fiscalResult, 'number', ''));

                    if (!$model->getIsFiscalCheck()) {
                        $fiscalResult['status'] = false;
                    }
                }
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            if(! $model->getIsDelete()) {
                // баланс прихода денег
                Api_Ab1_Shop_Client::calcBalanceCash($shopClientID, $sitePageData, $driver);
                if ($shopClientID != $model->getShopClientID()) {
                    Api_Ab1_Shop_Client::calcBalanceCash($model->getShopClientID(), $sitePageData, $driver);
                }

                // списываем сумму возрата c баланса по фиксированной цене
                if($isEditClientOrAmount) {
                    Api_Ab1_Shop_Client_Balance_Day::blockPaymentReturnClientBalanceDay(
                        $model->getShopClientID(), $model->id, $model->getAmount(), $sitePageData, $driver
                    );
                }
            }
        }

        return array(
            'id' => $model->id,
            'result' => $result,
            'fiscal_result' => $fiscalResult,
        );
    }

    /**
     * Сохраняем машины + оплату в виде XML
     * @param $from
     * @param $to
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
    public static function saveXML($from, $to, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список оплат
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
                'shop_client_id.organization_type_id' => array('old_id'),
            )
        );

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($shopPaymentReturnIDs->childs as $shopPaymentReturnID){
            $data .= '<Invoice>'
                .'<NumDoc>'.$shopPaymentReturnID->values['number'].'</NumDoc>'
                .'<date>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($shopPaymentReturnID->values['created_at'])).'</date>'
                .'<branch>'.$shopPaymentReturnID->getElementValue('shop_id', 'old_id').'</branch>'
                .'<branch_name>'.$shopPaymentReturnID->getElementValue('shop_id', 'name').'</branch_name>'
                . '<IdKlient>'.$shopPaymentReturnID->getElementValue('shop_client_id', 'old_id').'</IdKlient>'
                .'<Company>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_client_id', 'name'), ENT_XML1).'</Company>'
                .'<BIN>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_client_id', 'bin'), ENT_XML1).'</BIN>'
                .'<address>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_client_id', 'address'), ENT_XML1).'</address>'
                .'<account>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_client_id', 'account'), ENT_XML1).'</account>'
                .'<organization_type>'.htmlspecialchars($shopPaymentReturnID->getElementValue('organization_type_id', 'old_id'), ENT_XML1).'</organization_type>'
                .'<bank>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_client_id', 'bik'), ENT_XML1).'</bank>'
                .'<cashbox>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_cashbox_id', 'old_id'), ENT_XML1).'</cashbox>'
                .'<cashbox_name>'.htmlspecialchars($shopPaymentReturnID->getElementValue('shop_cashbox_id'), ENT_XML1).'</cashbox_name>';

            $data .='<TypePay>1</TypePay>';
            $data .='<amount>'.$shopPaymentReturnID->values['amount'].'</amount>'
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

            $data .= '</Invoice>';
        }
        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="invoice.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }


        return $data;
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Revise  {
    /**
     * удаление реализации
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
        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = new Model_Magazine_Shop_Revise();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Revise not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_revise_id' => $id,
                    'is_delete' => 1,
                    'is_public' => FALSE,
                )
            );
            $ids = Request_Request::find('DB_Magazine_Shop_Revise_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params
            );
            $driver->unDeleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Magazine_Shop_Revise_Item::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID
            );

            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_revise_id' => $id,
                    'is_delete' => 0,
                    'is_public' => TRUE,
                )
            );
            $ids = Request_Request::find('DB_Magazine_Shop_Revise_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params
            );
            $driver->deleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Magazine_Shop_Revise_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID
            );

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
        $model = new Model_Magazine_Shop_Revise();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Revise not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {
            // номер для 1С для списания
            if(empty($model->getOldID())){
                $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'sp_number_revise_' . $sitePageData->shopID . '\') as id;')->as_array(NULL, 'id')[0];
                $n = '00000000'.$n;
                $n = 'Т'.substr($n, strlen($n) - 8);
                $model->setOldID($n);
            }

            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            // сохраняем товары
            $shopReviseItems = Request_RequestParams::getParamArray('shop_revise_items');
            if($shopReviseItems !== NULL) {
                $arr = Api_Magazine_Shop_Revise_Item::save(
                    $model, $shopReviseItems, $sitePageData, $driver
                );
                $model->setQuantityActual($arr['quantity_actual']);
                $model->setQuantity($arr['quantity']);
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
     * Сохраняем машины + оплату в виде XML
     * @param $from
     * @param $to
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveXML($from, $to, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список машина
        $reviseIDs = Api_Magazine_Shop_Revise::getExitShopRevise(
            $from, $to, $sitePageData, $driver,
            array(
                'shop_supplier_id' => array('name', 'bik', 'bin', 'address', 'account', 'bank', 'old_id'),
                'shop_product_id' => array('old_id'),
                'shop_delivery_id' => array('old_id'),
                'shop_client_attorney_id' => array('number', 'from_at', 'client_name', 'old_id'),
                'shop_client_contract_id' => array('from_at', 'number'),
            )
        );

        $data = '<?xml version="1.0" encoding="UTF-8"?><data>';
        foreach($reviseIDs->childs as $revise){
            if (floatval($revise->values['quantity']) < 0.001){
                continue;
            }

            $data .= '<realization>'
                .'<NumDoc>'.$revise->values['number'].'</NumDoc>'
                .'<DateDoc>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($revise->values['created_at'])).'</DateDoc>'
                .'<IdKlient>'.$revise->getElementValue('shop_supplier_id', 'old_id').'</IdKlient>'
                .'<Company>'.htmlspecialchars($revise->getElementValue('shop_supplier_id'), ENT_XML1).'</Company>'
                .'<BIN>'.htmlspecialchars($revise->getElementValue('shop_supplier_id', 'bin'), ENT_XML1).'</BIN>'
                .'<BIK>'.htmlspecialchars($revise->getElementValue('shop_supplier_id', 'bik'), ENT_XML1).'</BIK>'
                .'<address>'.htmlspecialchars($revise->getElementValue('shop_supplier_id', 'address'), ENT_XML1).'</address>'
                .'<account>'.htmlspecialchars($revise->getElementValue('shop_supplier_id', 'account'), ENT_XML1).'</account>'
                .'<bank>'.htmlspecialchars($revise->getElementValue('shop_supplier_id', 'bank'), ENT_XML1).'</bank>'
                . '<revise_number>'.$revise->values['name'].'</revise_number>';

            if($revise->values['shop_payment_id'] < 1) {
                if ($revise->values['shop_client_attorney_id'] > 0) {
                    $data .= '<attorney>' . $revise->getElementValue('shop_client_attorney_id', 'old_id') . '</attorney>'
                        . '<attorneyNum>' . $revise->getElementValue('shop_client_attorney_id', 'number') . '</attorneyNum>'
                        . '<attorneyDate>' . Helpers_DateTime::getDateFormatRus($revise->getElementValue('shop_client_attorney_id', 'from_at')) . '</attorneyDate>'
                        . '<attorneyName>' . $revise->getElementValue('shop_client_attorney_id', 'client_name') . '</attorneyName>'
                        . '<cash>0</cash>';
                }else{
                    $data .= '<cash>1</cash>';
                }
            }else{
                $data .= '<cash>1</cash>';
            }

            if ($revise->values['shop_client_contract_id'] > 0) {
                $data .= '<contractNum>' . $revise->getElementValue('shop_client_contract_id', 'number') . '</contractNum>'
                    . '<contractDate>' . Helpers_DateTime::getDateFormatRus($revise->getElementValue('shop_client_contract_id', 'from_at')) . '</contractDate>'
                    . '<contractID>' . $revise->values['shop_client_contract_id'] . '</contractID>';
            }

            // доставка
            if($revise->values['shop_delivery_id'] > 0){
                $data .= '<is_delivery>1</is_delivery>'
                    . '<delivery>'.$revise->getElementValue('shop_delivery_id', 'old_id').'</delivery>'
                    . '<delivery_amount>'.$revise->values['delivery_amount'].'</delivery_amount>'
                    . '<delivery_km>'.$revise->values['delivery_km'].'</delivery_km>'
                    . '<waybill>'.$revise->values['id'].'</waybill>'
                    . '<number>'.$revise->values['name'].'</number>';

                // считаем для Жанны не правильное значение
                $deliveryPrice = Api_Magazine_Shop_Delivery::getPrice(
                    $revise->values['delivery_amount'], $revise->values['delivery_km'], $revise->values['delivery_quantity'],
                    $revise->values['shop_delivery_id'], $revise->values['is_charity'], $sitePageData, $driver, TRUE
                );
                $data .= '<delivery_count>'.$deliveryPrice['value'].'</delivery_count>';
            }else{
                $data .= '<is_delivery>0</is_delivery>';
            }

            $data .= '<GoodString>'
                .'<Code>'.$revise->getElementValue('shop_product_id', 'old_id').'</Code>'
                .'<quantity>'.$revise->values['quantity'].'</quantity>'
                .'<price>'.$revise->values['price'].'</price>'
                .'<sum>'.$revise->values['amount'].'</sum>'
                .'</GoodString>';

            $data .= '</realization>';
        }

        $pieceIDs = Api_Magazine_Shop_Piece::getExitShopPieces(
            $from, $to, $sitePageData, $driver,
            array(
                'shop_supplier_id' => array('name', 'bik', 'bin', 'address', 'account', 'bank', 'old_id'),
                'shop_delivery_id' => array('old_id'),
                'shop_client_attorney_id' => array('number', 'from_at', 'client_name', 'old_id'),
                'shop_client_contract_id' => array('from_at', 'number'),
            )
        );

        if (count($pieceIDs->childs) > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_piece_id' => $pieceIDs->getChildArrayID(),
                    'quantity_from' => 0,
                )
            );
            $pieceItemIDs = Request_Request::find('DB_Magazine_Shop_Piece_Item',
                $sitePageData->shopID, $sitePageData, $driver,
                $params, 0, TRUE,
                array(
                    'shop_product_id' => array('old_id')
                )
            );

            $pieceIDs->runIndex();
        }else{
            $pieceItemIDs = new MyArray();
        }

        foreach($pieceItemIDs->childs as $pieceItem){
            $piece = $pieceIDs->childs[$pieceItem->values['shop_piece_id']];

            if (floatval($pieceItem->values['quantity']) < 0.001){
                continue;
            }

            $data .= '<realization>'
                .'<NumDoc>'.$piece->values['number'].'</NumDoc>'
                .'<DateDoc>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($piece->values['created_at'])).'</DateDoc>'
                .'<IdKlient>'.$piece->getElementValue('shop_supplier_id', 'old_id').'</IdKlient>'
                .'<Company>'.htmlspecialchars($piece->getElementValue('shop_supplier_id'), ENT_XML1).'</Company>'
                .'<BIN>'.htmlspecialchars($piece->getElementValue('shop_supplier_id', 'bin'), ENT_XML1).'</BIN>'
                .'<BIK>'.htmlspecialchars($piece->getElementValue('shop_supplier_id', 'bik'), ENT_XML1).'</BIK>'
                .'<address>'.htmlspecialchars($piece->getElementValue('shop_supplier_id', 'address'), ENT_XML1).'</address>'
                .'<account>'.htmlspecialchars($piece->getElementValue('shop_supplier_id', 'account'), ENT_XML1).'</account>'
                .'<bank>'.htmlspecialchars($piece->getElementValue('shop_supplier_id', 'bank'), ENT_XML1).'</bank>'
                . '<revise_number>'.$piece->values['name'].'</revise_number>';

            if($piece->values['shop_payment_id'] < 1) {
                if ($piece->values['shop_client_attorney_id'] > 0) {
                    $data .= '<attorney>' . $piece->getElementValue('shop_client_attorney_id', 'old_id') . '</attorney>'
                        . '<attorneyNum>' . $piece->getElementValue('shop_client_attorney_id', 'number') . '</attorneyNum>'
                        . '<attorneyDate>' . Helpers_DateTime::getDateFormatRus($piece->getElementValue('shop_client_attorney_id', 'from_at')) . '</attorneyDate>'
                        . '<attorneyName>' . $piece->getElementValue('shop_client_attorney_id', 'client_name') . '</attorneyName>'
                        . '<cash>0</cash>';
                }else{
                    $data .= '<cash>1</cash>';
                }
            }else{
                $data .= '<cash>1</cash>';
            }

            if ($piece->values['shop_client_contract_id'] > 0) {
                $data .= '<contractNum>' . $piece->getElementValue('shop_client_contract_id', 'number') . '</contractNum>'
                    . '<contractDate>' . Helpers_DateTime::getDateFormatRus($piece->getElementValue('shop_client_contract_id', 'from_at')) . '</contractDate>'
                    . '<contractID>' . $revise->values['shop_client_contract_id'] . '</contractID>';
            }

            // доставка
            if($piece->values['shop_delivery_id'] > 0){
                $data .= '<is_delivery>1</is_delivery>'
                    . '<delivery>'.$piece->getElementValue('shop_delivery_id', 'old_id').'</delivery>'
                    . '<delivery_amount>'.$piece->values['delivery_amount'].'</delivery_amount>'
                    . '<delivery_km>'.$piece->values['delivery_km'].'</delivery_km>'
                    . '<waybill>'.$piece->values['id'].'</waybill>'
                    . '<number>'.$piece->values['name'].'</number>';

                // считаем для Жанны не правильное значение
                $deliveryPrice = Api_Magazine_Shop_Delivery::getPrice(
                    $piece->values['delivery_amount'], $piece->values['delivery_km'], $piece->values['delivery_quantity'],
                    $piece->values['shop_delivery_id'], $piece->values['is_charity'], $sitePageData, $driver, TRUE
                );
                $data .= '<delivery_count>'.$deliveryPrice['value'].'</delivery_count>';

                $piece->values['shop_delivery_id'] = 0;
            }else{
                $data .= '<is_delivery>0</is_delivery>';
            }

            $data .= '<GoodString>'
                .'<Code>'.$pieceItem->getElementValue('shop_product_id', 'old_id').'</Code>'
                .'<quantity>'.$pieceItem->values['quantity'].'</quantity>'
                .'<price>'.$pieceItem->values['price'].'</price>'
                .'<sum>'.$pieceItem->values['amount'].'</sum>'
                .'</GoodString>';

            $data .= '</realization>';
        }

        $data .= '</data>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="realization.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }
}

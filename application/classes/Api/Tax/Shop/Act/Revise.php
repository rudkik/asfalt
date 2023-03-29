<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Act_Revise  {
    /**
     * Получаем текущие документы актов сверки
     * @param Model_Tax_Shop_Act_Revise $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return MyArray
     */
    public static function getItems(Model_Tax_Shop_Act_Revise $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $debit = 0;
        $credit = 0;
        $items = new MyArray();

        $params = array(
            Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
            'id' => array('value' => $model->getShopInvoiceCommercialIDsArray()),
        );

        // счета-фактуры реализации
        if (!Func::_empty($model->getShopInvoiceCommercialIDsArray())) {
            $shopInvoiceCommercialIDs = Request_Tax_Shop_Invoice_Commercial::findShopInvoiceCommercialIDs(
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE);

            foreach ($shopInvoiceCommercialIDs->childs as $child) {
                $item = $items->addChild($child->id);

                $item->values = array(
                    'id' => $child->id,
                    'name' => 'Реализация ТМЗ и услуг №' . $child->values['number'] . ' от ' . Helpers_DateTime::getDateFormatRus($child->values['date'])
                        . "\r\n" . 'Счет-фактура выданный №' . $child->values['number'] . ' от ' . Helpers_DateTime::getDateFormatRus($child->values['date']),
                    'date' => $child->values['date'],
                    'debit' => $child->values['amount'],
                    'credit' => 0,
                    'table_id' => Model_Tax_Shop_Invoice_Commercial::TABLE_ID,
                );
            }
            $debit += $child->values['amount'];
        }

        // счета-фактуры поступления
        if (!Func::_empty($model->getShopMyInvoiceIDsArray())) {
            $params['id']['value'] = $model->getShopMyInvoiceIDsArray();
            $shopMyInvoiceIDs = Request_Tax_Shop_My_Invoice::findShopMyInvoiceIDs(
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE);

            foreach ($shopMyInvoiceIDs->childs as $child) {
                $item = $items->addChild($child->id);

                $item->values = array(
                    'id' => $child->id,
                    'name' => 'Счет-фактура поступивший №' . $child->values['number'] . ' от ' . Helpers_DateTime::getDateFormatRus($child->values['date']),
                    'date' => $child->values['date'],
                    'debit' => 0,
                    'credit' => $child->values['amount'],
                    'table_id' => Model_Tax_Shop_My_Invoice::TABLE_ID,
                );
            }
            $credit += $child->values['amount'];
        }

        // платежное поручение входящие / исходящее
        if (!Func::_empty($model->getShopMoneyIDsArray())) {
            $params['id']['value'] = $model->getShopMoneyIDsArray();
            $shopMoneyIDs = Request_Tax_Shop_Money::findShopMoneyIDs(
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE);

            foreach ($shopMoneyIDs->childs as $child) {
                $item = $items->addChild($child->id);

                $item->values = array(
                    'id' => $child->id,
                    'date' => $child->values['date'],
                    'debit' => 0,
                    'credit' => $child->values['amount'],
                    'table_id' => Model_Tax_Shop_Money::TABLE_ID,
                );
                $credit += $child->values['amount'];

                if ($child->values['is_coming'] == 1) {
                    if ($child->values['is_cash'] == 1) {
                        $item->values['name'] = 'Приходный кассовый ордер  №' . $child->values['number'] . ' от ' . Helpers_DateTime::getDateFormatRus($child->values['date']);
                    } else {
                        $item->values['name'] = 'Платежное поручение входящие №' . $child->values['number'] . ' от ' . Helpers_DateTime::getDateFormatRus($child->values['date']);
                    }
                } else {
                    if ($child->values['is_cash'] == 1) {
                        $item->values['name'] = 'Расходный кассовый ордер  №' . $child->values['number'] . ' от ' . Helpers_DateTime::getDateFormatRus($child->values['date']);
                    } else {
                        $item->values['name'] = 'Платежное поручение исходящие №' . $child->values['number'] . ' от ' . Helpers_DateTime::getDateFormatRus($child->values['date']);
                    }
                }
            }
        }

        // платежное поручение входящие
        if (!Func::_empty($model->getShopPaymentOrderIDsArray())) {
            $params['id']['value'] = $model->getShopPaymentOrderIDsArray();
            $shopPaymentOrderIDs = Request_Tax_Shop_Payment_Order::findShopPaymentOrderIDs(
                $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE);

            foreach ($shopPaymentOrderIDs->childs as $child) {
                $item = $items->addChild($child->id);

                $item->values = array(
                    'id' => $child->id,
                    'name' => 'Платежное поручение исходящие №' . $child->values['number'] . ' от ' . Helpers_DateTime::getDateFormatRus($child->values['date']),
                    'date' => $child->values['date'],
                    'debit' => 0,
                    'credit' => $child->values['amount'],
                    'table_id' => Model_Tax_Shop_Payment_Order::TABLE_ID,
                );
                $credit += $child->values['amount'];
            }
        }

        // сортируем по дате документа
        $arr = array();
        foreach ($items->childs as &$child){
            $arr[$child->values['date'].'_'.$child->id] = $child;

            $child->isFindDB = TRUE;
            $child->isLoadElements = TRUE;
            $child->isParseData = TRUE;
        }
        ksort($arr);
        $items->childs = $arr;

        $items->additionDatas = array(
            'debit' => $debit,
            'credit' => $credit,
        );


        return $items;
    }

    /**
     * Получаем новые документы актов сверки
     * @param $shopContractorID
     * @param $shopContractID
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isMinusOneDayDateFrom
     * @return MyArray
     */
    public static function newItems($shopContractorID, $shopContractID, $dateFrom, $dateTo,
                                    SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isMinusOneDayDateFrom = TRUE)
    {
        $debit = 0;
        $credit = 0;
        $items = new MyArray();

        if ($isMinusOneDayDateFrom && ($dateFrom !== NULL)){
            $dateFrom = strtotime($dateFrom, NULL);
            if ($dateFrom !== NULL){
                $dateFrom = date('Y-m-d', $dateFrom);
            }
        }

        $params = array(
            Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
            'shop_contractor_id' => $shopContractorID,
            'shop_contract_id' => $shopContractID,
            'date_from_equally' => $dateFrom,
            'date_to' => $dateTo,
        );

        // счета-фактуры реализации
        $shopInvoiceCommercialIDs = Request_Tax_Shop_Invoice_Commercial::findShopInvoiceCommercialIDs(
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE);

        foreach ($shopInvoiceCommercialIDs->childs as $child){
            $item = $items->addChild($child->id);

            $item->values = array(
                'id' => $child->id,
                'name' => 'Реализация ТМЗ и услуг №' . $child->values['number'] . ' от ' . Helpers_DateTime::getDateFormatRus($child->values['date'])
                    . "\r\n" . 'Счет-фактура выданный №' . $child->values['number'] . ' от ' . Helpers_DateTime::getDateFormatRus($child->values['date']),
                'date' => $child->values['date'],
                'debit' => $child->values['amount'],
                'credit' => 0,
                'table_id' => Model_Tax_Shop_Invoice_Commercial::TABLE_ID,
            );

            $debit += $child->values['amount'];
        }

        // счета-фактуры поступления
        $shopMyInvoiceIDs = Request_Tax_Shop_My_Invoice::findShopMyInvoiceIDs(
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE);

        foreach ($shopMyInvoiceIDs->childs as $child){
            $item = $items->addChild($child->id);

            $item->values = array(
                'id' => $child->id,
                'name' => 'Счет-фактура поступивший №'.$child->values['number'] . ' от '.Helpers_DateTime::getDateFormatRus($child->values['date']),
                'date' => $child->values['date'],
                'debit' => 0,
                'credit' => $child->values['amount'],
                'table_id' => Model_Tax_Shop_My_Invoice::TABLE_ID,
            );

            $credit += $child->values['amount'];
        }

        // платежное поручение входящие
        $shopMoneyIDs = Request_Tax_Shop_Money::findShopMoneyIDs( $sitePageData->shopID, $sitePageData, $driver,
            array_merge($params, array('is_coming' => 1)), 0, TRUE);

        foreach ($shopMoneyIDs->childs as $child){
            $item = $items->addChild($child->id);

            $item->values = array(
                'id' => $child->id,
                'date' => $child->values['date'],
                'debit' => 0,
                'credit' => $child->values['amount'],
                'table_id' => Model_Tax_Shop_Money::TABLE_ID,
            );

            if($child->values['is_cash'] == 1){
                $item->values['name'] = 'Приходный кассовый ордер  №'.$child->values['number'] . ' от '.Helpers_DateTime::getDateFormatRus($child->values['date']);
            }else{
                $item->values['name'] = 'Платежное поручение входящие №'.$child->values['number'] . ' от '.Helpers_DateTime::getDateFormatRus($child->values['date']);
            }

            $credit += $child->values['amount'];
        }

        // платежное поручение наличными исходящие
        $shopMoneyIDs = Request_Tax_Shop_Money::findShopMoneyIDs($sitePageData->shopID, $sitePageData, $driver,
            array_merge($params, array('is_coming' => 0)), 0, TRUE);

        foreach ($shopMoneyIDs->childs as $child){
            $item = $items->addChild($child->id);

            $item->values = array(
                'id' => $child->id,
                'date' => $child->values['date'],
                'debit' => abs($child->values['amount']),
                'credit' => 0,
                'table_id' => Model_Tax_Shop_Money::TABLE_ID,
            );

            if($child->values['is_cash'] == 1){
                $item->values['name'] = 'Расходный кассовый ордер  №'.$child->values['number'] . ' от '.Helpers_DateTime::getDateFormatRus($child->values['date']);
            }else{
                $item->values['name'] = 'Платежное поручение исходящие №'.$child->values['number'] . ' от '.Helpers_DateTime::getDateFormatRus($child->values['date']);
            }

            $debit += $child->values['amount'];
        }

        // платежное поручение банка исходящие
        $shopPaymentOrderIDs = Request_Tax_Shop_Payment_Order::findShopPaymentOrderIDs(
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE);

        foreach ($shopPaymentOrderIDs->childs as $child){
            $item = $items->addChild($child->id);

            $item->values = array(
                'id' => $child->id,
                'date' => $child->values['date'],
                'debit' => abs($child->values['amount']),
                'credit' => 0,
                'table_id' => Model_Tax_Shop_Payment_Order::TABLE_ID,
            );

            $item->values['name'] = 'Платежное поручение исходящие №'.$child->values['number'] . ' от '.Helpers_DateTime::getDateFormatRus($child->values['date']);

            $debit += abs($child->values['amount']);
        }

        // сортируем по дате документа
        $arr = array();
        foreach ($items->childs as &$child){
            $arr[$child->values['date'].'_'.$child->id] = $child;

            $child->isFindDB = TRUE;
            $child->isLoadElements = TRUE;
            $child->isParseData = TRUE;
        }
        ksort($arr);
        $items->childs = $arr;

        $items->additionDatas = array(
            'debit' => $debit,
            'credit' => $credit,
        );

        return $items;
    }

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Tax_Shop_Act_Revise();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Act revise not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamStr('number', $model);
        Request_RequestParams::setParamInt('shop_contractor_id', $model);
        Request_RequestParams::setParamInt('shop_contract_id', $model);
        Request_RequestParams::setParamDateTime('date_from', $model);
        Request_RequestParams::setParamDateTime('date_to', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $shopActReviseItems = Request_RequestParams::getParamArray('shop_act_revise_items');
        if(($shopActReviseItems !== NULL)) {
            if ((key_exists(Model_Tax_Shop_Invoice_Commercial::TABLE_ID, $shopActReviseItems)) && (is_array($shopActReviseItems[Model_Tax_Shop_Invoice_Commercial::TABLE_ID]))){
                $model->setShopInvoiceCommercialIDs($shopActReviseItems[Model_Tax_Shop_Invoice_Commercial::TABLE_ID]);
            }else{
                $model->setShopInvoiceCommercialIDs(array());
            }
            if ((key_exists(Model_Tax_Shop_My_Invoice::TABLE_ID, $shopActReviseItems)) && (is_array($shopActReviseItems[Model_Tax_Shop_My_Invoice::TABLE_ID]))){
                $model->setShopMyInvoiceIDs($shopActReviseItems[Model_Tax_Shop_My_Invoice::TABLE_ID]);
            }else{
                $model->setShopMyInvoiceIDs(array());
            }
            if ((key_exists(Model_Tax_Shop_Payment_Order::TABLE_ID, $shopActReviseItems)) && (is_array($shopActReviseItems[Model_Tax_Shop_Payment_Order::TABLE_ID]))){
                $model->setShopPaymentOrderIDs($shopActReviseItems[Model_Tax_Shop_Payment_Order::TABLE_ID]);
            }else{
                $model->setShopPaymentOrderIDs(array());
            }
            if ((key_exists(Model_Tax_Shop_Money::TABLE_ID, $shopActReviseItems)) && (is_array($shopActReviseItems[Model_Tax_Shop_Money::TABLE_ID]))){
                $model->setShopMoneyIDs($shopActReviseItems[Model_Tax_Shop_Money::TABLE_ID]);
            }else{
                $model->setShopMoneyIDs(array());
            }
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            if(Func::_empty($model->getNumber())){
                $model->setNumber(Api_Tax_Sequence::getSequence($model->tableName,
                    Helpers_DateTime::getYear($model->getDate()), $sitePageData, $driver));
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
}

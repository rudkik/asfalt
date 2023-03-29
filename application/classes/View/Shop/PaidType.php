<?php defined('SYSPATH') or die('No direct script access.');

class View_Shop_PaidType extends View_View {


	/**
	 * Получаем данные для оплаты банком
	 * @param integer $shopID
	 * @param string $viewObjects
	 * @param string $viewObject
	 * @param SitePageData $sitePageData
	 * @param Model_Driver_DBBasicDriver $driver
	 * хуй
	 */
	public static function getShopPaidTypeBank($dbObject, $shopID, $viewObject,
											SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                               array $params = array()){
		// ищем в мемкеше
        $urlParams = array('bill_id', 'test', 'id');
        $key = Helpers_DB::getURLParamDatas($urlParams, $params);
		$datas = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Shop_PaidType::getShopPaidTypeBank', array(Model_Shop_PaidType::TABLE_NAME, Model_PaidType::TABLE_NAME, Model_Shop_Bill::TABLE_NAME, Model_Shop_Bill_Item::TABLE_NAME),
            $viewObject, $sitePageData, $driver, $key);
		if ($datas !== NULL){
			$sitePageData->replaceDatas['view::'.$viewObject] = $datas;

			return $datas;
		}

        // получаем заказ
        $billID = Request_RequestParams::getParamInt('bill_id', $params);
        $model = new Model_Shop_Bill();
        $model->setDBDriver($driver);
        if(($billID === NULL) || ($billID < 1) || (! Helpers_DB::getDBObject($model, $billID, $sitePageData, $shopID))){
            throw new HTTP_Exception_404('Bill not found!');
        }

        // получаем оплату
        $modelPaid = new Model_Shop_PaidType();
        $modelPaid->setDBDriver($driver);

        $shopPaidTypeID = $model->getShopPaidTypeID();
        if ($shopPaidTypeID < 1){
            $shopPaidTypeID = Request_RequestParams::getParamInt('id', $params);
        }
        if(($shopPaidTypeID < 1) || (! Helpers_DB::getDBObject($modelPaid, $shopPaidTypeID, $sitePageData, $shopID))){
            throw new HTTP_Exception_404('Paid type not found!');
        }
        // получает товары заказа
        $billItemIDs = Request_Request::find(
            'DB_Shop_Bill_Item', $shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_bill_id' => $billID
                )
            ), 0, true
        );

        $billItems = array();
        foreach ($billItemIDs->childs as $billItemID){
            $modelBillItem = new Model_Shop_Bill_Item();
            $modelBillItem->setDBDriver($driver);
            $billItems[] = $modelBillItem;

            Helpers_View::getDBData($billItemID, $modelBillItem, $sitePageData, $shopID);

        }

        $data = new MyArray();
        $data->isFindDB = TRUE;
        $data->values['bill_id'] = $billID;

        switch($modelPaid->getPaidTypeID()){
            case Bank_Kazkom_Pay::BANK_PAY_TYPE_ID:
                // проверяем статус оплаты
                $bank = new Bank_Kazkom_Pay($modelPaid->getOptionsArray());

                $data->values['data'] = $bank->getHMTLCode($model, $billItems, $sitePageData);
                $data->values['bill'] = $model->getValues(TRUE, TRUE);
                $data->values['url_bank'] = $bank->getURL();

                $data->values['is_bank'] = 1;
                break;
            case Bank_ATF_Pay::BANK_PAY_TYPE_ID:
                // проверяем статус оплаты
                $bank = new Bank_ATF_Pay($modelPaid->getOptionsArray());

                $data->values['data'] = $bank->getHMTLCode($model, $billItems, $sitePageData);
                $data->values['bill'] = $model->getValues(TRUE, TRUE);
                if(Request_RequestParams::getParamBoolean('test', $params)) {
                    $data->values['url_bank'] = Bank_ATF_Pay::URL_BANK_TEST;
                }else{
                    $data->values['url_bank'] = Bank_ATF_Pay::URL_BANK;
                }

                $data->values['is_bank'] = 1;
                break;
            case Bank_Wooppay_Pay::BANK_PAY_TYPE_ID:
                // проверяем статус оплаты
                $bank = new Bank_Wooppay_Pay($modelPaid->getOptionsArray());

                $data->values['data'] = $bank->getHMTLCode($model, $billItems, $sitePageData);
                $data->values['bill'] = $model->getValues(TRUE, TRUE);
                $data->values['is_bank'] = 1;
                break;
            default:
                $data->values['is_bank'] = 0;
        }

        $datas = Helpers_View::getViewObject($data, $model,
            $viewObject, $sitePageData, $driver,
            $shopID);


        $sitePageData->replaceDatas['view::'.$viewObject] = $datas;

		// записываем в мемкеш
		Helpers_DB::setMemcacheFunctionView($datas, $shopID, 'View_Shop_PaidType::getShopPaidTypeBank', array(Model_Shop_PaidType::TABLE_NAME, Model_PaidType::TABLE_NAME, Model_Shop_Bill::TABLE_NAME, Model_Shop_Bill_Item::TABLE_NAME),
			$viewObject, $sitePageData, $driver, $key);

		return $datas;
	}

    /**
     * Получаем данные для оплаты банком для отеля
     * @param integer $shopID
     * @param string $viewObjects
     * @param string $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * хуй
     */
    public static function getShopPaidTypeBankHotel($dbObject, $shopID, $viewObject,
                                               SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                               array $params = array()){
        // ищем в мемкеше
        $urlParams = array('bill_id', 'test', 'id');
        $key = Helpers_DB::getURLParamDatas($urlParams, $params);
        $datas = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Shop_PaidType::getShopPaidTypeBankHotel', array(Model_Shop_PaidType::TABLE_NAME, Model_PaidType::TABLE_NAME, Model_Shop_Bill::TABLE_NAME, Model_Shop_Bill_Item::TABLE_NAME),
            $viewObject, $sitePageData, $driver, $key);
        if ($datas !== NULL){
            $sitePageData->replaceDatas['view::'.$viewObject] = $datas;

            return $datas;
        }

        // получаем заказ
        $billID = Request_RequestParams::getParamInt('bill_id', $params);
        $model = new Model_Hotel_Shop_Bill();
        $model->setDBDriver($driver);
        if(($billID === NULL) || ($billID < 1) || (! Helpers_DB::getDBObject($model, $billID, $sitePageData, $shopID))){
            throw new HTTP_Exception_404('Bill not found!');
        }

        // получаем оплату
        $modelPaid = new Model_Shop_PaidType();
        $modelPaid->setDBDriver($driver);

        $shopPaidTypeID = $model->getShopPaidTypeID();
        if ($shopPaidTypeID < 1){
            $shopPaidTypeID = Request_RequestParams::getParamInt('id', $params);
        }

        if(($shopPaidTypeID < 1) || (! Helpers_DB::getDBObject($modelPaid, $shopPaidTypeID, $sitePageData, $shopID))){
            throw new HTTP_Exception_404('Paid type not found!');
        }

        $model->setLimitTime(
            date('Y-m-d H:i:s', strtotime($model->getLimitTime()
                    .' +'.(Arr::path($modelPaid->getOptionsArray(), 'reserve_time', 0)*1).' hours')
            )
        );
        Helpers_DB::saveDBObject($model, $sitePageData);

        // получает товары заказа
        $billItemIDs = Request_Request::find(
            'DB_Shop_Bill_Item', $shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_bill_id' => $billID
                )
            ), 0, true
        );

        $billItems = array();
        foreach ($billItemIDs->childs as $billItemID){
            $modelBillItem = new Model_Shop_Bill_Item();
            $modelBillItem->setDBDriver($driver);
            $billItems[] = $modelBillItem;

            Helpers_View::getDBData($billItemID, $modelBillItem, $sitePageData, $shopID);

        }

        $data = new MyArray();
        $data->isFindDB = TRUE;
        $data->values['bill_id'] = $billID;

        $dataLanguageID = $sitePageData->dataLanguageID;
        $languageID = $sitePageData->languageID;
        $sitePageData->dataLanguageID = $model->languageID;
        $sitePageData->languageID = $model->languageID;

        switch($modelPaid->getPaidTypeID()){
            case Bank_Kazkom_Pay::BANK_PAY_TYPE_ID:
                // проверяем статус оплаты
                $bank = new Bank_Kazkom_Pay($modelPaid->getOptionsArray());

                $data->values['data'] = $bank->getHMTLCodeHotel($modelPaid->id, $model, $billItems, $sitePageData);
                $data->values['bill'] = $model->getValues(TRUE, TRUE);
                $data->values['url_bank'] = $bank->getURL();

                $data->values['is_bank'] = 1;
                break;
            case Bank_ATF_Pay::BANK_PAY_TYPE_ID:
                // проверяем статус оплаты
                $bank = new Bank_ATF_Pay($modelPaid->getOptionsArray());

                $data->values['data'] = $bank->getHMTLCodeHotel($model, $billItems, $sitePageData);
                $data->values['bill'] = $model->getValues(TRUE, TRUE);
                if(Request_RequestParams::getParamBoolean('test', $params)) {
                    $data->values['url_bank'] = Bank_ATF_Pay::URL_BANK_TEST;
                }else{
                    $data->values['url_bank'] = Bank_ATF_Pay::URL_BANK;
                }

                $data->values['is_bank'] = 1;
                break;
            case Bank_Wooppay_Pay::BANK_PAY_TYPE_ID:
                // проверяем статус оплаты
                $bank = new Bank_Wooppay_Pay($modelPaid->getOptionsArray());

                $data->values['data'] = $bank->getHMTLCodeHotel($model, $billItems, $sitePageData);
                $data->values['bill'] = $model->getValues(TRUE, TRUE);
                $data->values['is_bank'] = 1;
                break;
            case Bank_Cashless_Pay::BANK_PAY_TYPE_ID:
                // проверяем статус оплаты
                $bank = new Bank_Cahless_Pay($modelPaid->getOptionsArray());

                $data->values['data'] = $bank->getHMTLCodeHotel($model, $billItems, $sitePageData);
                $data->values['bill'] = $model->getValues(TRUE, TRUE);
                $data->values['is_bank'] = 1;
                break;
            default:
                $data->values['is_bank'] = 0;
        }

        $sitePageData->dataLanguageID = $dataLanguageID;
        $sitePageData->languageID = $languageID;

        $datas = Helpers_View::getViewObject($data, $model, $viewObject, $sitePageData, $driver, $shopID);


        $sitePageData->replaceDatas['view::'.$viewObject] = $datas;

        // записываем в мемкеш
        Helpers_DB::setMemcacheFunctionView($datas, $shopID, 'View_Shop_PaidType::getShopPaidTypeBankHotel', array(Model_Shop_PaidType::TABLE_NAME, Model_PaidType::TABLE_NAME, Model_Shop_Bill::TABLE_NAME, Model_Shop_Bill_Item::TABLE_NAME),
            $viewObject, $sitePageData, $driver, $key);

        return $datas;
    }
}
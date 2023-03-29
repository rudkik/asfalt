<?php defined('SYSPATH') or die('No direct script access.');

class Api_Shop_Bill
{
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Shop_Bill();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Bill not found.');
        }

        $options = Request_RequestParams::getParamArray('options');
        if($options !== NULL){
            $model->addOptionsArray($options);

            $name = trim(Arr::path($options, 'first_name').' '.Arr::path($options, 'last_name').' '.Arr::path($options, 'name'));
            $model->setName($name);
        }

        // доставка
        $shopDeliveryTypeID = Request_RequestParams::getParamInt('shop_delivery_type_id');
        if (($shopDeliveryTypeID !== NULL) && ($shopDeliveryTypeID > 0) && ($shopDeliveryTypeID != $model->getShopDeliveryTypeID())) {
            $modelDelivery = new Model_Shop_DeliveryType();
            $modelDelivery->setDBDriver($driver);

            if (Helpers_DB::getDBObject($modelDelivery, $shopDeliveryTypeID, $sitePageData)) {
                $model->setDeliveryAmount($modelDelivery->getPrice());
                $model->setShopDeliveryTypeID($modelDelivery->id);
            }
        }

        // оплата
        $shopPaidTypeID = Request_RequestParams::getParamInt('shop_paid_type_id');
        if (($shopPaidTypeID !== NULL) && ($shopPaidTypeID > 0) && ($shopPaidTypeID != $model->getShopPaidTypeID())) {
            $modelPaid = new Model_Shop_PaidType();
            $modelPaid->setDBDriver($driver);

            if (Helpers_DB::getDBObject($modelPaid, $shopPaidTypeID, $sitePageData)) {
                $model->setShopPaidTypeID($modelPaid->id);
            }
        }

        Request_RequestParams::setParamDateTime('delivery_at', $model);
        Request_RequestParams::setParamInt('shop_bill_status_id', $model);

        $result = array();
        if ($model->validationFields($result)) {
            $amountOld = $model->getAmount();
            // сохранение изменений в списке заказа
            Api_Shop_Bill_Item::saveShopBillItems($model, $sitePageData, $driver);

            if(($model->getShopRootID() > 0) && ($model->getAmount() !== $amountOld)){
                $modelShop = new Model_Shop();
                $modelShop->setDBDriver($driver);

                // редактируем баланс
                if (Helpers_DB::getDBObject($modelShop, $model->getShopRootID(), $sitePageData)) {
                    $modelShop->setBalance($modelShop->getBalance() + $amountOld - $model->getAmount());
                    Helpers_DB::saveDBObject($modelShop, $sitePageData);
                }
            }

            Helpers_DB::saveDBObject($model, $sitePageData);

            $result['values'] = $model->getValues();
        }

        // отправляем сообщение о создании/изменении заказа
        if($id > 0){
            Api_EMail::sendEditShopBill('', $sitePageData->shopID, $id, $sitePageData, $driver);
        }else{
            Api_EMail::sendCreateShopBill('', $sitePageData->shopID, $id, $sitePageData, $driver);
        }

        return array(
            'id' => $model->id,
            'type' => $model->getShopTableCatalogID(),
            'result' => $result,
        );
    }

    /**
     * удаление заказа
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

        $model = new Model_Shop_Bill();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Bill not found.');
        }

        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");
        if((($isUnDel === TRUE) && (!$model->getIsDelete()))
            || (($isUnDel !== TRUE) && ($model->getIsDelete()))){
            return FALSE;
        }

        if(($model->getShopRootID() > 0) && ($model->getAmount() != 0)){
            $modelShop = new Model_Shop();
            $modelShop->setDBDriver($driver);

            // редактируем баланс
            if (Helpers_DB::getDBObject($modelShop, $model->getShopRootID(), $sitePageData)) {
                if(Request_RequestParams::getParamBoolean("is_undel") === TRUE) {
                    $modelShop->setBalance($modelShop->getBalance() - $model->getAmount());
                }else{
                    $modelShop->setBalance($modelShop->getBalance() + $model->getAmount());
                }
                Helpers_DB::saveDBObject($modelShop, $sitePageData);
            }
        }

        if($isUnDel === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);

            $shopBillItemIDs = Request_Request::find('DB_Shop_Bill_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_bill_id' => $id, 'is_delete' => 1, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE))->getChildArrayID();
            $driver->unDeleteObjectIDs($shopBillItemIDs, $sitePageData->userID, Model_Shop_Bill_Item::TABLE_NAME,
                array(), $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);

            $shopBillItemIDs = Request_Request::find('DB_Shop_Bill_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_bill_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE))->getChildArrayID();
            $driver->deleteObjectIDs($shopBillItemIDs, $sitePageData->userID, Model_Shop_Bill_Item::TABLE_NAME,
                array(), $sitePageData->shopID);
        }

        return TRUE;
    }

    /**
     * Формирование отчета ABC и сохранение в файл Excel
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws Exception
     */
    public static function reportRatingABC(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isBranch = FALSE,
                                           $viewObjects = '_shop/bill/item/list/save/abc', $viewObject = '_shop/bill/item/one/save/abc') {
        if($isBranch) {
            $shopIDs = Request_Shop::getBranchShopIDs($sitePageData->shopID, $sitePageData, $driver);
        }else{
            $shopIDs = Request_Request::findNotShop('DB_Shop', $sitePageData, $driver,
                array('main_shop_id' => $sitePageData->shopMainID, 'shop_root_id' => $sitePageData->shopID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
            $shopIDs->addChild($sitePageData->shopID);
        }
        $shopIDs = $shopIDs->getChildArrayID();

        // получаем список ID заказов
        $shopBillIDs = Request_Shop_Bill::findBranchShopBillIDs($shopIDs, $sitePageData,
            $driver);

        if(count($shopBillIDs->childs) > 0) {
            // получаем список проданных позиций
            $shopBillItemIDs = Request_Request::findBranch('DB_Shop_Bill_Item', $shopIDs, $sitePageData,
                $driver, array('shop_bill_id' => $shopBillIDs->getChildArrayID(), 'group_by' => array('shop_good_id', 'shop_id'), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        }else{
            $shopBillItemIDs = new MyArray();
        }

        // считаем общее количество и сумму
        $count = 0;
        $amount = 0;
        foreach($shopBillItemIDs->childs as $shopBillItemID){
            $count = $count + $shopBillItemID->values['count'];
            $amount = $amount + $shopBillItemID->values['amount'];
        }

        // считаем процент товара от общего количества
        foreach($shopBillItemIDs->childs as $shopBillItemID){
            $shopBillItemID->additionDatas['percent_count'] = $shopBillItemID->values['count'] / $count * 100;
            $shopBillItemID->additionDatas['percent_amount'] = $shopBillItemID->values['amount'] / $amount * 100;
        }

        // сортируем по процентам
        $shopBillItemIDs->childsSortBy(array('percent_count'), FALSE);

        // проставляем категорию товара
        $percent = 0;
        $counts = array('a' => 0, 'b' => 0, 'c' => 0, 'c_minus' => 0);
        $percentCounts = array('a' => 0, 'b' => 0, 'c' => 0, 'c_minus' => 0);

        foreach($shopBillItemIDs->childs as $shopBillItemID){
            $percent = $percent + $shopBillItemID->additionDatas['percent_count'];
            if($percent <= 80){
                $shopBillItemID->additionDatas['category_count'] = 'A';

                $counts['a'] = $counts['a'] + $shopBillItemID->values['count'];
                $percentCounts['a'] = $percentCounts['a'] + $shopBillItemID->additionDatas['percent_count'];
            }elseif($percent <= 95){
                $shopBillItemID->additionDatas['category_count'] = 'B';

                $counts['b'] = $counts['b'] + $shopBillItemID->values['count'];
                $percentCounts['b'] = $percentCounts['b'] + $shopBillItemID->additionDatas['percent_count'];
            }elseif($percent <= 99){
                $shopBillItemID->additionDatas['category_count'] = 'C';

                $counts['c'] = $counts['c'] + $shopBillItemID->values['count'];
                $percentCounts['c'] = $percentCounts['c'] + $shopBillItemID->additionDatas['percent_count'];
            }else{
                $shopBillItemID->additionDatas['category_count'] = 'C-';

                $counts['c_minus'] = $counts['c_minus'] + $shopBillItemID->values['count'];
                $percentCounts['c_minus'] = $percentCounts['c_minus'] + $shopBillItemID->additionDatas['percent_count'];
            }
        }

        // сортируем по процентам
        $shopBillItemIDs->childsSortBy(array('percent_amount'), FALSE);

        // проставляем категорию товара
        $percent = 0;
        $amounts = array('a' => 0, 'b' => 0, 'c' => 0, 'c_minus' => 0);
        $percentAmounts = array('a' => 0, 'b' => 0, 'c' => 0, 'c_minus' => 0);

        foreach($shopBillItemIDs->childs as $shopBillItemID){
            $percent = $percent + $shopBillItemID->additionDatas['percent_amount'];
            if($percent <= 80){
                $shopBillItemID->additionDatas['category_amount'] = 'A';

                $amounts['a'] = $amounts['a'] + $shopBillItemID->values['amount'];
                $percentAmounts['a'] = $percentAmounts['a'] + $shopBillItemID->additionDatas['percent_amount'];
            }elseif($percent <= 95){
                $shopBillItemID->additionDatas['category_amount'] = 'B';

                $amounts['b'] = $amounts['b'] + $shopBillItemID->values['amount'];
                $percentAmounts['b'] = $percentAmounts['b'] + $shopBillItemID->additionDatas['percent_amount'];
            }elseif($percent <= 99){
                $shopBillItemID->additionDatas['category_amount'] = 'C';

                $amounts['c'] = $amounts['c'] + $shopBillItemID->values['amount'];
                $percentAmounts['c'] = $percentAmounts['c'] + $shopBillItemID->additionDatas['percent_amount'];
            }else{
                $shopBillItemID->additionDatas['category_amount'] = 'C-';

                $amounts['c_minus'] = $amounts['c_minus'] + $shopBillItemID->values['amount'];
                $percentAmounts['c_minus'] = $percentAmounts['c_minus'] + $shopBillItemID->additionDatas['percent_amount'];
            }
        }

        // общее количество
        foreach($counts as $key => $value){
            $sitePageData->replaceDatas['count_'.$key] = $value;
        }
        foreach($amounts as $key => $value){
            $sitePageData->replaceDatas['amount_'.$key] = $value;
        }
        foreach($percentAmounts as $key => $value){
            $sitePageData->replaceDatas['percent_'.$key] = $value;
        }
        $sitePageData->replaceDatas['count_total'] = $count;
        $sitePageData->replaceDatas['amount_total'] = $amount;


        $model = new Model_Shop_Bill_Item();
        $model->setDBDriver($driver);

        foreach($shopBillItemIDs->childs as $shopBillItemID){
            Helpers_View::getViewObject($shopBillItemID, $model,
                $viewObject, $sitePageData, $driver,
                $shopBillItemID->values['shop_id'], TRUE, array('shop_good_id', 'shop_id'));
        }

        $datas = Helpers_View::getViewObjects($shopBillItemIDs, $model,
            $viewObjects, $viewObject, $sitePageData, $driver,
            0);

        $datas = '<?xml version="1.0"?>'."\r\n".'<?mso-application progid="Excel.Sheet"?>'.$datas;
        header('Content-Description: File Transfer');
        header('Content-Type: application/excel');
        header('Content-Disposition: filename=save.xls');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($datas));

        echo $datas;
        exit;
    }

    /**
     * Формирование отчета по филиалам сгруппированным по заказах
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws Exception
     */
    public static function reportShopGroupByBillAmount(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isBranch = FALSE,
                                           $viewObjects = '_shop/bill/list/save/group-by-bill-amount', $viewObject = '_shop/bill/one/save/group-by-bill-amount',
                                           $groupBy = array('shop_id'), $sortBy = array('shop_id' => 'asc')) {
        if($isBranch) {
            $shopIDs = Request_Shop::getBranchShopIDs($sitePageData->shopID, $sitePageData, $driver);
        }else{
            $shopIDs = Request_Request::findNotShop('DB_Shop', $sitePageData, $driver,
                array('main_shop_id' => $sitePageData->shopMainID, 'shop_root_id' => $sitePageData->shopID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
            $shopIDs->addChild($sitePageData->shopID);
        }
        $shopIDs = $shopIDs->getChildArrayID();

        // получаем список ID заказов
        $shopBillIDs = Request_Shop_Bill::findBranchShopBillIDs($shopIDs, $sitePageData,
            $driver, array('group_by' => $groupBy, 'sort_by' => $sortBy));


        $model = new Model_Shop_Bill();
        $model->setDBDriver($driver);

        foreach($shopBillIDs->childs as $shopBillID){
            if(key_exists('shop_id', $shopBillID->values)){
                $shopID = $shopBillID->values['shop_id'];
            }else{
                $shopID = 0;
            }

            Helpers_View::getViewObject($shopBillID, $model,
                $viewObject, $sitePageData, $driver,
                $shopID, TRUE, $groupBy);
        }

        $datas = Helpers_View::getViewObjects($shopBillIDs, $model,
            $viewObjects, $viewObject, $sitePageData, $driver,
            0);

        $datas = '<?xml version="1.0"?>'."\r\n".'<?mso-application progid="Excel.Sheet"?>'.$datas;
        header('Content-Description: File Transfer');
        header('Content-Type: application/excel');
        header('Content-Disposition: filename=save.xls');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($datas));

        echo $datas;
        exit;
    }

    /**
     * Формирование отчета по филиалам root по последним заказам
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws Exception
     */
    public static function reportShopRootLastBill(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isBranch = FALSE,
                                                  $params = array(), $viewObjects = '_shop/branch/list/save/root-last-bill',
                                                  $viewObject = '_shop/branch/one/save/root-last-bill') {
        if($isBranch) {
            $shopIDs = Request_Shop::findShopBranchIDs($sitePageData->shopID, $sitePageData, $driver, array_merge($params, array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE)));
        }else{
            $shopIDs = Request_Request::findNotShop('DB_Shop',$sitePageData, $driver,
                array_merge($params, array('main_shop_id' => $sitePageData->shopMainID, 'shop_root_id' => $sitePageData->shopID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE)));
            $shopIDs->addChild($sitePageData->shopID);
        }

        // находим филиалы
        $arrShopIDs = Request_Shop::getBranchShopIDs($sitePageData->shopID, $sitePageData, $driver);
        $arrShopIDs = $arrShopIDs->getChildArrayID();

        foreach($shopIDs->childs as $shopID){
            // получаем список ID заказов
            $shopBillIDs = Request_Shop_Bill::findBranchShopBillIDs($arrShopIDs, $sitePageData,
                $driver, array('shop_root_id' => $shopID->id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 1, TRUE);

            if(count($shopBillIDs->childs) > 0){
                $shopID->values[Model_Basic_BasicObject::FIELD_ELEMENTS]['shop_bill_id'] = $shopBillIDs->childs[0]->values;
            }
        }

        $model = new Model_Shop();
        $model->setDBDriver($driver);

        $datas = Helpers_View::getViewObjects($shopIDs, $model,
            $viewObjects, $viewObject, $sitePageData, $driver,
            0);

        $datas = '<?xml version="1.0"?>'."\r\n".'<?mso-application progid="Excel.Sheet"?>'.$datas;
        header('Content-Description: File Transfer');
        header('Content-Type: application/excel');
        header('Content-Disposition: filename=save.xls');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($datas));

        echo $datas;
        exit;
    }

    /**
     * Списание товаров со склада
     * @param $shopBillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function applyShopBill($shopBillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopBillItemIDs = Request_Request::find(
            DB_Shop_Bill_Item::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(array('shop_bill_id' => $shopBillID))
        );

        $modelBillItem = new Model_Shop_Bill_Item();
        $modelBillItem->setDBDriver($driver);

        $modelGood = new Model_Shop_Good();
        $modelGood->setDBDriver($driver);

        $modelGoodItem = new Model_Shop_GoodItem();
        $modelGoodItem->setDBDriver($driver);

        foreach($shopBillItemIDs->childs as $shopBillItemID){
            Helpers_DB::getDBObject($modelBillItem, $shopBillItemID->id, $sitePageData);

            if($modelBillItem->getShopTableChildID() > 0){
                if (Helpers_DB::getDBObject($modelGoodItem, $modelBillItem->getShopTableChildID(), $sitePageData)) {
                    $tmp = $modelGoodItem->getStorageCount() - $modelBillItem->getCountElement();
                    if ($tmp < 0) {
                        $tmp = 0;
                    }

                    $modelGoodItem->setStorageCount($tmp);
                    Helpers_DB::saveDBObject($modelGoodItem, $sitePageData);
                }
            }else {
                if (Helpers_DB::getDBObject($modelGood, $modelBillItem->getShopGoodID(), $sitePageData)) {
                    $tmp = $modelGood->getStorageCount() - $modelBillItem->getCountElement();
                    if ($tmp < 0) {
                        $tmp = 0;
                    }
                    $modelGood->setStorageCount($tmp);
                    Helpers_DB::saveDBObject($modelGood, $sitePageData);
                }
            }

            self::countUpStorageShopGood($modelBillItem->getShopGoodID(), $sitePageData, $driver);
        }
    }

    /**
     * Возврат товара на склад
     * @param $shopBillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function cancelShopBill($shopBillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopBillItemIDs = Request_Request::find(
            DB_Shop_Bill_Item::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(array('shop_bill_id' => $shopBillID))
        );

        $modelBillItem = new Model_Shop_Bill_Item();
        $modelBillItem->setDBDriver($driver);

        $modelGood = new Model_Shop_Good();
        $modelGood->setDBDriver($driver);

        $modelGoodItem = new Model_Shop_GoodItem();
        $modelGoodItem->setDBDriver($driver);

        foreach($shopBillItemIDs->childs as $shopBillItemID){
            Helpers_DB::getDBObject($modelBillItem, $shopBillItemID->id, $sitePageData);

            if($modelBillItem->getShopTableChildID() > 0){
                if (Helpers_DB::getDBObject($modelGoodItem, $modelBillItem->getShopTableChildID(), $sitePageData)) {
                    $tmp = $modelGoodItem->getStorageCount() + $modelBillItem->getCountElement();
                    $modelGoodItem->setStorageCount($tmp);

                    Helpers_DB::saveDBObject($modelGoodItem, $sitePageData);
                }
            }else {
                if (Helpers_DB::getDBObject($modelGood, $modelBillItem->getShopGoodID(), $sitePageData)) {
                    $tmp = $modelGood->getStorageCount() + $modelBillItem->getCountElement();
                    $modelGood->setStorageCount($tmp);

                    Helpers_DB::saveDBObject($modelGood, $sitePageData);
                }
            }

            self::countUpStorageShopGood($modelBillItem->getShopGoodID(), $sitePageData, $driver);
        }
    }
}
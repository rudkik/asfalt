<?php defined('SYSPATH') or die('No direct script access.');

class Api_Hotel_Shop_Bill  {
    /**
     * Пересчет оплаты заказа
     * @param $shopBillID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSavePaidAmount
     * @return mixed
     */
    public static function recountBillPaidAmount($shopBillID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                $isSavePaidAmount = FALSE)
    {
        // сумма оплат
        $params = Request_RequestParams::setParams(
            array(
                'shop_bill_id' => $shopBillID,
                'is_paid' => TRUE,
                'sum_amount' => TRUE,
            )
        );
        $shopPaymentIDs = Request_Request::find('DB_Hotel_Shop_Payment', $sitePageData->shopID, $sitePageData, $driver, $params);

        $paidAmount = $shopPaymentIDs->childs[0]->values['amount'];

        if($isSavePaidAmount){
            $model = new Model_Hotel_Shop_Bill();
            $model->setDBDriver($driver);
            if(Helpers_DB::getDBObject($model, $shopBillID, $sitePageData)){
                $model->setPaidAmount($paidAmount);
                Helpers_DB::saveDBObject($model, $sitePageData);
            }
        }

        return $paidAmount;
    }

    /**
     * Пересчет оплаты всех заказов
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function recountBillsPaidAmount(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopBillIDs = Request_Request::find('DB_Hotel_Shop_Bill', $sitePageData->shopID, $sitePageData, $driver,
            array(), 0, TRUE);

        $model = new Model_Hotel_Shop_Bill();
        $model->setDBDriver($driver);
        foreach ($shopBillIDs->childs as $child){
            $model->clear();
            $model->__setArray(array('values' => $child->values));
            $model->setPaidAmount(self::recountBillPaidAmount($model->id, $sitePageData, $driver));
            Helpers_DB::saveDBObject($model, $sitePageData);
        }
    }

    /**
     * Отменить заказ
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $id
     * @throws HTTP_Exception_500
     */
    public static function cancel(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $id = 0)
    {
        $model = new Model_Hotel_Shop_Bill();
        $model->setDBDriver($driver);

        if ($id < 1) {
            $id = Request_RequestParams::getParamInt('id');
        }
        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, -1, TRUE)) {
            throw new HTTP_Exception_500('Bill not found.');
        }

        Api_Hotel_Shop_Bill_Item::cancel($model->id, $sitePageData, $driver);

        $model->setIsPublic(FALSE);
        $model->setBillCancelStatusID(Request_RequestParams::getParamInt('bill_cancel_status_id'));
        $model->setText(Request_RequestParams::getParamStr('text'));
        Helpers_DB::saveDBObject($model, $sitePageData);

        $modelClient = new Model_Hotel_Shop_Client();
        $modelClient->setDBDriver($driver);
        if (Helpers_DB::dublicateObjectLanguage($modelClient, $model->getShopClientID(), $sitePageData, -1, TRUE)) {
            $modelClient->setBlockAmount($modelClient->getBlockAmount() - $model->getAmount());
            Helpers_DB::saveDBObject($modelClient, $sitePageData);
        }
    }

    /**
     * Восстановить заказ
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function unCancel(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Bill();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, -1, TRUE)) {
            throw new HTTP_Exception_500('Bill not found.');
        }

        Api_Hotel_Shop_Bill_Item::unCancel($model->id, $sitePageData, $driver);

        $model->setIsPublic(TRUE);
        $model->setBillCancelStatusID(0);
        Helpers_DB::saveDBObject($model, $sitePageData);

        $modelClient = new Model_Hotel_Shop_Client();
        $modelClient->setDBDriver($driver);
        if (Helpers_DB::dublicateObjectLanguage($modelClient, $model->getShopClientID(), $sitePageData, -1, TRUE)) {
            $modelClient->setBlockAmount($modelClient->getBlockAmount() + $model->getAmount());
            Helpers_DB::saveDBObject($modelClient, $sitePageData);
        }
    }

    /**
     * Сохранение заказа оплаты через Любой банк и Народного банка в PDF
     * @param Model_Hotel_Shop_Bill $model
     * @param SitePageData $sitePageData
     * @param $fileName
     * @param bool $isPHPOutput
     */
    public static function savePaidBankAndHalykInPDF(Model_Hotel_Shop_Bill $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $fileName, $isPHPOutput = FALSE)
    {
        self::saveInPDF('bank-and-halyk', $model, $sitePageData, $driver, $fileName, $isPHPOutput);
    }

    /**
     * Сохранение заказа оплаты через Народного банка в PDF
     * @param Model_Hotel_Shop_Bill $model
     * @param SitePageData $sitePageData
     * @param $fileName
     * @param bool $isPHPOutput
     */
    public static function savePaidReserveInPDF(Model_Hotel_Shop_Bill $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $fileName, $isPHPOutput = FALSE)
    {
        self::saveInPDF('reserve', $model, $sitePageData, $driver, $fileName, $isPHPOutput);
    }

    /**
     * Сохранение заказа оплаты через Народного банка в PDF
     * @param Model_Hotel_Shop_Bill $model
     * @param SitePageData $sitePageData
     * @param $fileName
     * @param bool $isPHPOutput
     */
    public static function savePaidHalykInPDF(Model_Hotel_Shop_Bill $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $fileName, $isPHPOutput = FALSE)
    {
        self::saveInPDF('halyk', $model, $sitePageData, $driver, $fileName, $isPHPOutput);
    }

    /**
     * Сохранение заказа оплаты через Любой банк в PDF
     * @param Model_Hotel_Shop_Bill $model
     * @param SitePageData $sitePageData
     * @param $fileName
     * @param bool $isPHPOutput
     */
    public static function savePaidBankInPDF(Model_Hotel_Shop_Bill $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $fileName, $isPHPOutput = FALSE)
    {
        self::saveInPDF('bank', $model, $sitePageData, $driver, $fileName, $isPHPOutput);
    }

    /**
     * Сохранение заказа в PDF
     * @param $type
     * @param Model_Hotel_Shop_Bill $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $fileName
     * @param bool $isPHPOutput
     * @throws Exception
     */
    public static function saveInPDF($type, Model_Hotel_Shop_Bill $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $fileName, $isPHPOutput = FALSE)
    {
        $path = APPPATH.'views'.DIRECTORY_SEPARATOR.'hotel' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR
            . $sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR;

        $pdf = new PDF_Hotel_Page('ПОДТВЕРЖДЕНИЕ БРОНИ', '', FALSE);

        $options = include $path.'bill.php';

        $pdf->headerHTML($options['header']);

        $pdf->setFooterFont(Array('BookAntiqua', '', 9));
        $pdf->footerHtml = $options['footer'];

        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->AddPage(PDF_PAGE_ORIENTATION, PDF_PAGE_FORMAT);

        $pdf->SetFont('BookAntiqua', '', 11);

        $file = 'hotel' . DIRECTORY_SEPARATOR .'pdf'. DIRECTORY_SEPARATOR . $sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $options['body_file'];
        try {
            $view = View::factory($file);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$file.'" не найден.');
        }

        $model->getElement('shop_client_id', TRUE, $sitePageData->shopMainID);
        $view->bill = $model->getValues(TRUE, TRUE, $sitePageData->shopMainID);
        if ((empty($view->bill['limit_time'])) && ($model->getPaidAmount() == 0)){
            $view->bill['limit_time'] = strtotime('+9 days');
        }
        $view->siteData = $sitePageData;

        // собираем номера в строчку
        $rooms = '';
        $roomIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $model->shopID, $sitePageData, $driver,
            array(
                'is_public_ignore' => TRUE,
                'shop_bill_id' => $model->id,
                'sort_by' => array('value' => array('shop_room_id.name' => 'asc')),
                'group_by' => array('value' => array('shop_room_id.name', 'human_extra', 'child_extra')),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
            ),
            0, TRUE, array('shop_room_id' => array('name'))
        );

        foreach ($roomIDs->childs as $room){
            $rooms = $rooms . Arr::path($room->values, Model_Hotel_Shop_Room::FIELD_ELEMENTS.'.shop_room_id.name', '');
            if($room->values['human_extra'] > 0){
                $rooms = $rooms . ' +'.Func::getCountElementStrRus($room->values['human_extra'], 'взрослых мест', 'взрослое место', 'взрослых места');
            }
            if($room->values['child_extra'] > 0){
                $rooms = $rooms . ' +'.Func::getCountElementStrRus($room->values['child_extra'], 'детских мест', 'детское место', 'детских места');
            }
            $rooms = $rooms . ', ';
        }
        $rooms = mb_substr($rooms, 0, -2);
        $view->rooms = $rooms;

        $strView = Helpers_View::viewToStr($view);

        $pdf->writeHTML($strView);

        if ($isPHPOutput){
            $pdf->Output($fileName, 'D');
        }else {
            $pdf->Output($fileName, 'F');
        }
    }

    /**
     * Удаление просроченной брони
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function deleteRevise(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopBillIDs = Request_Request::find('DB_Hotel_Shop_Bill', $sitePageData->shopID, $sitePageData, $driver,
           array('limit_time_to' => date('Y-m-d H:i:s'), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        foreach ($shopBillIDs->childs as $shopBillIDs){
            self::cancel($sitePageData, $driver, $shopBillIDs->id);
        }
    }

    /**
     * удаление заказа
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $id
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $id = 0)
    {
        if ($id < 1) {
            $id = Request_RequestParams::getParamInt('id');
            if ($id < 0) {
                return FALSE;
            }
        }

        $model = new Model_Hotel_Shop_Bill();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Bill not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);

            $shopBillItemIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_bill_id' => $id, 'is_delete_ignore' => TRUE, 'is_public_ignore' => TRUE, 'old_id' => 1, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
            $driver->unDeleteObjectIDs($shopBillItemIDs->getChildArrayID(), $sitePageData->userID, Model_Hotel_Shop_Bill_Item::TABLE_NAME);

            $shopBillServiceIDs = Request_Request::find('DB_Hotel_Shop_Bill_Service', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_bill_id' => $id, 'is_delete_ignore' => TRUE, 'is_public_ignore' => TRUE, 'old_id' => 1, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
            $driver->unDeleteObjectIDs($shopBillServiceIDs->getChildArrayID(), $sitePageData->userID, Model_Hotel_Shop_Bill_Service::TABLE_NAME);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);

            $shopBillItemIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_bill_id' => $id, 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
            $driver->deleteObjectIDs($shopBillItemIDs->getChildArrayID(), $sitePageData->userID, Model_Hotel_Shop_Bill_Item::TABLE_NAME,
                array('old_id' => 1));

            $shopBillServiceIDs = Request_Request::find('DB_Hotel_Shop_Bill_Service', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_bill_id' => $id, 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
            $driver->deleteObjectIDs($shopBillServiceIDs->getChildArrayID(), $sitePageData->userID, Model_Hotel_Shop_Bill_Service::TABLE_NAME,
                array('old_id' => 1));
        }

        // пересчет баланса клиента
        Api_Hotel_Shop_Client::recountClientBalance($model->getShopClientID(), $sitePageData, $driver, TRUE);

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
        $model = new Model_Hotel_Shop_Bill();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Bill not found.');
            }
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);

        $oldShopClientID = $model->getShopClientID();
        Request_RequestParams::setParamInt('shop_client_id', $model);
        Request_RequestParams::setParamInt('paid_type_id', $model);
        $discount = Request_RequestParams::getParamFloat('discount');
        if($discount !== NULL) {
            $model->setDiscount($discount);
        }

        $isFinish = Request_RequestParams::getParamBoolean('is_finish');
        if($isFinish !== NULL) {
            $model->setIsFinish($isFinish);
        }

        if (!($model->getPaidAmount() > 0)){
            Request_RequestParams::setParamDateTime('limit_time', $model);
        }

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        // при создании нового контрагента
        if(Request_RequestParams::getParamBoolean('is_add_client')){
            $shopClient = Request_RequestParams::getParamArray('shop_client');
            if ($shopClient !== NULL){
                $shopClient = Api_Hotel_Shop_Client::saveOfArray($shopClient, $sitePageData, $driver, TRUE);
                $model->setShopClientID($shopClient['id']);
                $model->setName($shopClient['user_name']);
            }
        }

        if($model->getPaidAmount() > 0){
            $model->setLimitTime(NULL);
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            if(Func::_empty($model->getNumber())){
                $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'shop_bill\') as id;')->as_array(NULL, 'id')[0];
                $n = '000000'.$n;
                $n = 'K'.substr($n, strlen($n) - 7);
                $model->setNumber($n);
            }

            $shopBillItems = Request_RequestParams::getParamArray('shop_bill_items');
            if($shopBillItems !== NULL) {
                $tmp = Api_Hotel_Shop_Bill_Item::save($model->id, $model->getShopClientID(), $shopBillItems,
                    $sitePageData, $driver);

                $model->setAmountItems($tmp['amount']);
                $model->setDateFrom($tmp['date_from']);
                $model->setDateTo($tmp['date_to']);
                $model->setOptionsArray(array('detailed' => $tmp['detailed']));
            }

            $shopBillServices = Request_RequestParams::getParamArray('shop_bill_services');
            if($shopBillServices !== NULL) {
                $tmp = Api_Hotel_Shop_Bill_Service::save($model->id, $model->getShopClientID(), $shopBillServices,
                    $sitePageData, $driver);

                $model->setAmountServices($tmp['amount']);

                $date1 = strtotime($model->getDateFrom(), NULL);
                $date2 = strtotime($tmp['date_from'], NULL);
                if ((Func::_empty($model->getDateFrom())) || (($tmp['date_from'] !== NULL) && ($date1 > $date2))){
                    $model->setDateFrom($tmp['date_from']);
                }

                $date1 = strtotime($model->getDateTo(), NULL);
                $date2 = strtotime($tmp['date_to'], NULL);
                if ((Func::_empty($model->getDateTo())) || (($tmp['date_to'] !== NULL) && ($date1 < $date2))){
                    $model->setDateTo($tmp['date_to']);
                }
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            if ($model->getIsPublic() && (!$model->getIsDelete())) {
                // пересчет баланса клиента
                Api_Hotel_Shop_Client::recountClientBalance($model->getShopClientID(), $sitePageData, $driver, TRUE);
                if($oldShopClientID != $model->getShopClientID()) {
                    Api_Hotel_Shop_Client::recountClientBalance($oldShopClientID, $sitePageData, $driver, TRUE);
                }
            }
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Сохранение комнат по тику в заказе с проверкой свободности номеров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function saveRoomTypeAndCheckFree(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dFrom = strtotime($dateFrom, NULL);
        if ($dFrom === NULL){
            return array(
                'result' => array(
                    'error' => TRUE,
                    'msg' => 'Date from not found.',
                )
            );
        }

        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $dTo = strtotime($dateTo, NULL);
        if ($dTo === NULL){
            return array(
                'result' => array(
                    'error' => TRUE,
                    'msg' => 'Date to not found.',
                )
            );
        }

        if ($dFrom >= $dTo){
            return array(
                'result' => array(
                    'error' => TRUE,
                    'msg' => 'Date from more date to not found.',
                )
            );
        }

        // получаем свободные номера в заданный период
        $freeRoomIDs = Api_Hotel_Shop_Room::getFreeRooms($dateFrom, date('Y-m-d', $dTo - 24 * 60 * 60),
            $sitePageData, $driver, TRUE);

        $roomTypes = Request_RequestParams::getParamArray('room_types');
        if (empty($roomTypes)){
            return array(
                'result' => array(
                    'error' => TRUE,
                    'msg' => 'Bill empty.',
                )
            );
        }

        $model = new Model_Hotel_Shop_Room_Type();
        $model->setDBDriver($driver);
        //print_r($freeRoomIDs->childs);
        $result = array();
        $shopBillItems = array();
        foreach ($roomTypes as $roomType){
            $shopRoomTypeID = intval(Arr::path($roomType, 'shop_room_type_id', 0));

            // находим свободную комнату
            $shopRoom = FALSE;
            foreach ($freeRoomIDs->childs as $key => $freeRoomID){
                if ($freeRoomID->values['shop_room_type_id'] == $shopRoomTypeID){
                    $shopRoom = $freeRoomID;
                    unset($freeRoomIDs->childs[$key]);
                    break;
                }
            }
            if ($shopRoom === FALSE){
                if(Helpers_DB::getDBObject($model, $shopRoomTypeID, $sitePageData)){
                    $result[$shopRoomTypeID] = $model->getName().' not free room.';
                }else{
                    $result[$shopRoomTypeID] = $shopRoomTypeID.' not room type.';
                }

                continue;
            }

            $adults = intval(Arr::path($roomType, 'adults', 0));
            if ($adults < 0){
                $adults = 0;
            }
            $childs = intval(Arr::path($roomType, 'childs', 0));
            if ($childs < 0){
                $childs = 0;
            }

            if ($shopRoom->values['human_extra'] < $adults + $childs){
                $result[$shopRoomTypeID] = 'Not extra place.';
                continue;
            }

            $shopBillItems[] = array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'shop_room_id' => $shopRoom->id,
                'human_extra' => $adults,
                'child_extra' => $childs,
            );
        }       // print_r($result);
       // print_r($shopBillItems);die;

        if (!empty($result)){
            return array(
                'result' => array(
                    'error' => TRUE,
                    'msg' => $result,
                )
            );
        }

        $model = new Model_Hotel_Shop_Bill();
        $model->setDBDriver($driver);

        // брокируем на 2 часа
        $model->setLimitTime(date('Y-m-d H:i:s', strtotime('+2 hours')));

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);

        Request_RequestParams::setParamInt('shop_client_id', $model);
        Request_RequestParams::setParamInt('paid_type_id', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        // при создании нового контрагента
        if(Request_RequestParams::getParamBoolean('is_add_client')){
            $shopClient = Request_RequestParams::getParamArray('shop_client');
            if ($shopClient !== NULL){
                $shopClient = Api_Hotel_Shop_Client::saveOfArray($shopClient, $sitePageData, $driver);
                $model->setShopClientID($shopClient['id']);
            }
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // сохраняем комнаты заказа
            $tmp = Api_Hotel_Shop_Bill_Item::save($model->id, $model->getShopClientID(), $shopBillItems, $sitePageData, $driver);
            $model->setAmount($tmp['amount']);
            $model->setDateFrom($tmp['date_from']);
            $model->setDateTo($tmp['date_to']);
            $model->setOptionsArray(array('detailed' => $tmp['detailed']));

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
     * Сохранение комнат в заказе с проверкой свободности номеров
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function saveRoomAndCheckFree(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dFrom = strtotime($dateFrom, NULL);
        if ($dFrom === NULL){
            return array(
                'result' => array(
                    'error' => TRUE,
                    'msg' => 'Date from not found.',
                )
            );
        }

        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $dTo = strtotime($dateTo, NULL);
        if ($dTo === NULL){
            return array(
                'result' => array(
                    'error' => TRUE,
                    'msg' => 'Date to not found.',
                )
            );
        }

        if ($dFrom >= $dTo){
            return array(
                'result' => array(
                    'error' => TRUE,
                    'msg' => 'Date from more date to not found.',
                )
            );
        }

        // получаем свободные номера в заданный период
        $freeRoomIDs = Api_Hotel_Shop_Room::getFreeRooms($dateFrom, date('Y-m-d', $dTo - 24 * 60 * 60),
            $sitePageData, $driver, TRUE);
        $freeRoomIDs->runIndex();

        $rooms = Request_RequestParams::getParamArray('rooms');
        if (empty($rooms)){
            return array(
                'result' => array(
                    'error' => TRUE,
                    'msg' => 'Bill empty.',
                )
            );
        }

        $model = new Model_Hotel_Shop_Room();
        $model->setDBDriver($driver);

        $result = array();
        $shopBillItems = array();
        foreach ($rooms as $room){
            $shopRoomID = intval(Arr::path($room, 'shop_room_id', 0));

            // находим свободную комнату
            if (!key_exists($shopRoomID, $freeRoomIDs->childs)){
                if(Helpers_DB::getDBObject($model, $shopRoomID, $sitePageData)){
                    $result[$shopRoomID] = $model->getName().' not free room.';
                }else{
                    $result[$shopRoomID] = $shopRoomID.' not room.';
                }
                continue;
            }
            $shopRoom = $freeRoomIDs->childs[$shopRoomID];
            unset($freeRoomIDs->childs[$shopRoomID]);

            $adults = intval(Arr::path($room, 'adults', 0));
            if ($adults < 0){
                $adults = 0;
            }
            $childs = intval(Arr::path($room, 'childs', 0));
            if ($childs < 0){
                $childs = 0;
            }

            if ($shopRoom->values['human_extra'] < $adults + $childs){
                $result[$shopRoomID] = 'Not extra place.';
                continue;
            }

            $shopBillItems[] = array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'shop_room_id' => $shopRoom->id,
                'human_extra' => $adults,
                'child_extra' => $childs,
            );
        }
        if (!empty($result)){
            return array(
                'result' => array(
                    'error' => TRUE,
                    'msg' => $result,
                )
            );
        }

        $model = new Model_Hotel_Shop_Bill();
        $model->setDBDriver($driver);

        // брокируем на 2 часа
        $model->setLimitTime(date('Y-m-d H:i:s', strtotime('+2 hours')));

        Request_RequestParams::setParamStr('name', $model);

        Request_RequestParams::setParamInt('shop_client_id', $model);
        Request_RequestParams::setParamInt('paid_type_id', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        // при создании нового контрагента
        if(Request_RequestParams::getParamBoolean('is_add_client')){
            $shopClient = Request_RequestParams::getParamArray('shop_client');
            if ($shopClient !== NULL){
                $shopClient = Api_Hotel_Shop_Client::saveOfArray($shopClient, $sitePageData, $driver);
                $model->setShopClientID($shopClient['id']);
            }
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            if(Func::_empty($model->getNumber())){
                $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'shop_bill\') as id;')->as_array(NULL, 'id')[0];
                $n = '000000'.$n;
                $n = substr($n, strlen($n) - 7);
                $model->setNumber($n);
            }

            // сохраняем комнаты заказа
            $tmp = Api_Hotel_Shop_Bill_Item::save($model->id, $model->getShopClientID(), $shopBillItems, $sitePageData, $driver);
            $model->setAmount($tmp['amount']);
            $model->setDateFrom($tmp['date_from']);
            $model->setDateTo($tmp['date_to']);
            $model->setOptionsArray(array('detailed' => $tmp['detailed']));

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
     * Сохраняем список актов на оказания услуг в XML
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveActServiceXML(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        $dateTo = date('Y-m-d', strtotime(Request_RequestParams::getParamDateTime('created_at_to'))). ' 23:59:59';

        // получаем список заказов
        $params = array(
            'finish_date_from_equally' => Request_RequestParams::getParamDateTime('created_at_from'),
            'finish_date_to' => $dateTo,
            'is_finish' => TRUE,
            Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
        );

        $shopBillIDs = Request_Request::find('DB_Hotel_Shop_Bill', $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE);

        $modelClient = new Model_Hotel_Shop_Client();
        $modelClient->setDBDriver($driver);

        $modelRoom = new Model_Hotel_Shop_Room();
        $modelRoom->setDBDriver($driver);

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($shopBillIDs->childs as $shopBillID){
            if (!Helpers_DB::getDBObject($modelClient, $shopBillID->values['shop_client_id'], $sitePageData)){
                continue;
            }

            // список комнат
            $shopBillItemIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_bill_id' => $shopBillID->id, 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
                0, TRUE, array('shop_room_id' => array('old_id', 'name')));

            // список услуг
            $shopBillServiceIDs = Request_Request::find('DB_Hotel_Shop_Bill_Service', $sitePageData->shopID, $sitePageData, $driver,
                array('shop_bill_id' => $shopBillID->id, 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
                0, TRUE, array('shop_service_id' => array('old_id', 'name')));

            if ((count($shopBillItemIDs) == 0) && (count($shopBillItemIDs) == 0)){
                continue;
            }

            $data .= '<act>'
                .'<bill_id>'.$shopBillID->values['id'].'</bill_id>'
                .'<idm>'.$shopBillID->values['number'].'</idm>'
                .'<created_at>'.$shopBillID->values['date_to'].'</created_at>'
                .'<amount>'.$shopBillID->values['amount'].'</amount>'
                .'<amount_nds>'.round($shopBillID->values['amount']  / 112 * 12, 2).'</amount_nds>';

            // данные клиента
            $data .= '<client>'
                .'<id>'.$modelClient->id.'</id>'
                .'<id_1c>'.$modelClient->getOldID().'</id_1c>'
                .'<name>'.htmlspecialchars($modelClient->getName(), ENT_XML1).'</name>'
                .'<bik>'.htmlspecialchars($modelClient->getBIK(), ENT_XML1).'</bik>'
                .'<bin>'.htmlspecialchars($modelClient->getBIN(), ENT_XML1).'</bin>'
                .'<bank>'.htmlspecialchars($modelClient->getBank(), ENT_XML1).'</bank>'
                .'<account>'.htmlspecialchars($modelClient->getAccount(), ENT_XML1).'</account>'
                .'<address>'.htmlspecialchars($modelClient->getAccount(), ENT_XML1).'</address>'
                .'</client>';

            // список комнат
            $data .= '<rooms>';
            foreach ($shopBillItemIDs->childs as $shopBillItemID){
                if (!Helpers_DB::getDBObject($modelRoom, $shopBillItemID->values['shop_room_id'], $sitePageData)){
                    continue;
                }

                $data .= '<room>'
                    .'<id_r>'.$shopBillItemID->values['shop_room_id'].'</id_r>'
                    .'<id_1c_r>'.$modelRoom->getOldID().'</id_1c_r>'
                    .'<name_r>'.$modelRoom->getName().'</name_r>'
                    .'<date_from_r>'.$shopBillItemID->values['date_from'].'</date_from_r>'
                    .'<date_to_r>'.date('Y-m-d', strtotime($shopBillItemID->values['date_to']) + 24*60*60).'</date_to_r>'
                    .'<amount_r>'.$shopBillItemID->values['amount'].'</amount_r>'
                    .'<amount_nds_r>'.round($shopBillItemID->values['amount']  / 112 * 12, 2).'</amount_nds_r>'
                    .'<human_r>'.$modelRoom->getHuman().'</human_r>';

                // тип номера
                $modelRoomType = $modelRoom->getElement('shop_room_type_id', TRUE, $sitePageData->shopMainID);
                if ($modelRoomType !== NULL){
                    $data .= '<id_t>'.$modelRoomType->id.'</id_t>'
                        .'<id_1c_t>'.$modelRoomType->getOldID().'</id_1c_t>'
                        .'<name_t>'.$modelRoomType->getName().'</name_t>';
                }

                $data .= '</room>';
            }
            $data .= '</rooms>';

            // список услуг
            $data .= '<services>';
            foreach ($shopBillServiceIDs->childs as $shopBillServiceID){
                $data .= '<service>'
                    .'<id_s>'.$shopBillServiceID->values['shop_service_id'].'</id_s>'
                    .'<id_1c_s>'.Arr::path($shopBillServiceID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_service_id.old_id', '').'</id_1c_s>'
                    .'<name_s>'.Arr::path($shopBillServiceID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_service_id.name', '').'</name_s>'
                    .'<quantity_s>'.$shopBillServiceID->values['quantity'].'</quantity_s>'
                    .'<price_s>'.$shopBillServiceID->values['price'].'</price_s>'
                    .'<amount_s>'.$shopBillServiceID->values['amount'].'</amount_s>'
                    .'<amount_nds_s>'.round($shopBillServiceID->values['amount']  / 112 * 12, 2).'</amount_nds_s>'
                    .'</service>';
            }
            $data .= '</services>';

            $data .= '</act>';
        }
        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="act_service.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }
}

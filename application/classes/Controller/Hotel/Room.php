<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_Room extends Controller_BasicControler
{
    /**
     * Проверяем права доступа
     * @return  void
     */
    public function before()
    {
        $this->_sitePageData->shopShablonPath = 'hotel';
        $this->_sitePageData->languageID = Model_Language::LANGUAGE_RUSSIAN;
        $this->_sitePageData->dataLanguageID = Model_Language::LANGUAGE_RUSSIAN;
    }

    public function action_bill_bank()
    {
        $this->_sitePageData->url = '/hotel/room/bill_bank';

        $result = array(
           'is_error' => 0,
        );

        $shopID = Request_RequestParams::getParamInt('shop_id');
        $this->_sitePageData->shopID = $shopID;
        $this->_sitePageData->shopMainID = $shopID;

        $model = new Model_Shop();
        if(! $this->getDBObject($model, $shopID)){
            $result['is_error'] = 1;
            $result['msg_error'] = 'Заведение не найдено';
            $this->response->body(json_encode($result));
            return TRUE;
        }
        $this->_sitePageData->shop = $model;
        $this->_sitePageData->shopMain = $model;

        $shopBillID = Request_RequestParams::getParamInt('bill_id');

        $model = new Model_Hotel_Shop_Bill();
        $model->setDBDriver($this->_driverDB);
        if(! $this->getDBObject($model, $shopBillID)){
            $result['is_error'] = 1;
            $result['msg_error'] = 'Заказ не найден';
            $this->response->body(json_encode($result));
            return TRUE;
        }

        $shopBillItemIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData,
            $this->_driverDB, array('shop_bill_id'=> $shopBillID, 'is_public_ignore' => TRUE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE, array('shop_room_id' => array('name')));

        $rooms = array();
        foreach ($shopBillItemIDs->childs as $shopBillItemID){
            $rooms[] = array(
                'room' => Arr::path($shopBillItemID->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_room_id.name', ''),
                'date_from' => $shopBillItemID->values['date_from'],
                'date_to' => $shopBillItemID->values['date_to'],
            );
        }

        $client = $model->getElement('shop_client_id', TRUE, $this->_sitePageData->shopMainID);
        if ($client !== NULL){
            $client = $client->getName();
        }else{
            $client = '';
        }
        $result['data'] = array(
            'id' => $model->id,
            'client' => $client,
            'amount' => $model->getAmount() - $model->getPaidAmount(),
            'rooms' => $rooms,
        );

        $this->response->body(json_encode($result));
    }

    public function action_bill_bank_pay()
    {
        $this->_sitePageData->url = '/hotel/room/bill_bank_pay';

        $result = array(
            'is_error' => 0,
        );

        $shopID = Request_RequestParams::getParamInt('shop_id');
        $this->_sitePageData->shopID = $shopID;
        $this->_sitePageData->shopMainID = $shopID;

        $model = new Model_Shop();
        if(! $this->getDBObject($model, $shopID)){
            $result['is_error'] = 1;
            $result['msg_error'] = 'Заведение не найдено';
            $this->response->body(json_encode($result));
            return TRUE;
        }
        $this->_sitePageData->shop = $model;
        $this->_sitePageData->shopMain = $model;

        $shopBillID = Request_RequestParams::getParamInt('bill_id');

        $model = new Model_Hotel_Shop_Bill();
        $model->setDBDriver($this->_driverDB);
        if(! $this->getDBObject($model, $shopBillID)){
            $result['is_error'] = 1;
            $result['msg_error'] = 'Заказ не найден';
            $this->response->body(json_encode($result));
            return TRUE;
        }

        $amount = Request_RequestParams::getParamFloat('amount');
        if ($amount < 0){
            $amount = 0;
        }
        $model->setPaidAmount($model->getPaidAmount() + $amount);

        $this->response->body(json_encode($result));
    }

    public function action_get_amount()
    {
        $this->_sitePageData->url = '/hotel/room/get_amount';

        $shopRoomID = Request_RequestParams::getParamInt('shop_room_id');
        $adults = Request_RequestParams::getParamInt('adults');
        $childs = Request_RequestParams::getParamInt('childs');
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $dateTo = date('Y-m-d', strtotime($dateTo) - 60 * 60 * 24);

        $result = 0;
        if ($shopRoomID > 0) {
            $result = Api_Hotel_Shop_Room::getAmountRoom($shopRoomID, $adults, $childs, $dateFrom, $dateTo,
                $this->_sitePageData, $this->_driverDB);
        }else{
            $shopRoomTypeID = Request_RequestParams::getParamInt('shop_room_type_id');
            if ($shopRoomTypeID > 0) {
                $result = Api_Hotel_Shop_Room_Type::getAmountRoomType($shopRoomTypeID, $adults, $childs, $dateFrom, $dateTo,
                    $this->_sitePageData, $this->_driverDB);
            }
        }

        $this->response->body(json_encode(
            array(
                'amount' => $result,
            )
        ));
    }

    public function action_add_bill_room_type()
    {
        $this->_sitePageData->url = '/hotel/room/add_bill_room_type';

        $shopID = Request_RequestParams::getParamInt('shop_id');
        $this->_sitePageData->shopID = $shopID;
        $this->_sitePageData->shopMainID = $shopID;

        $model = new Model_Shop();
        if(! $this->getDBObject($model, $shopID)){
            throw new HTTP_Exception_500('Shop not found!');
        }
        $this->_sitePageData->shop = $model;
        $this->_sitePageData->shopMain = $model;

        $model = new Model_Shop();
        $model->setDBDriver($this->_driverDB);

        $result = Api_Hotel_Shop_Bill::saveRoomTypeAndCheckFree($this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult($result);
    }

    public function action_add_bill_room()
    {
        $this->_sitePageData->url = '/hotel/room/add_bill_room';

        $shopID = Request_RequestParams::getParamInt('shop_id');
        $this->_sitePageData->shopID = $shopID;
        $this->_sitePageData->shopMainID = $shopID;

        $model = new Model_Shop();
        if(! $this->getDBObject($model, $shopID)){
            throw new HTTP_Exception_500('Shop not found!');
        }
        $this->_sitePageData->shop = $model;
        $this->_sitePageData->shopMain = $model;

        $model = new Model_Shop();
        $model->setDBDriver($this->_driverDB);

        $result = Api_Hotel_Shop_Bill::saveRoomAndCheckFree($this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult($result);
    }

    public function action_save_bill()
    {
        $this->_sitePageData->url = '/hotel/room/save_bill';

        $shopID = Request_RequestParams::getParamInt('shop_id');
        $this->_sitePageData->shopID = $shopID;
        $this->_sitePageData->shopMainID = $shopID;

        $model = new Model_Shop();
        if(! $this->getDBObject($model, $shopID)){
            throw new HTTP_Exception_500('Shop not found!');
        }
        $this->_sitePageData->shop = $model;
        $this->_sitePageData->shopMain = $model;

        $model = new Model_Shop();
        $model->setDBDriver($this->_driverDB);

        $result = Api_Hotel_Shop_Bill::save($this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult($result);
    }

    /**
     * Возвращаем результать сохранения
     * @param array $result
     */
    protected function _redirectSaveResult(array $result)
    {
        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $url = Request_RequestParams::getParamStr('url_error');
            if (empty($url)) {
                $this->response->body(Json::json_encode($result['result']));
            }else{
                $params = URL::query(array('result' => $result['result']), FALSE);
                if (strpos($url, '?') !== FALSE) {
                    $params = str_replace('?', '&', $params);
                }
                $this->redirect($url.$params);
            }
        } else {
            $branchID = '';
            if ($this->_sitePageData->branchID > 0) {
                $branchID = '&shop_branch_id=' . $this->_sitePageData->branchID;
            }

            $params = array();
            foreach ($result as $key => $value) {
                if (!is_array($value)) {
                    $params[$key] = $value;
                }
            }
            $params = URL::query($params, FALSE) . $branchID;

            $url = Request_RequestParams::getParamStr('url');
            if (!empty($url)) {
                if (strpos($url, '?') !== FALSE) {
                    $params = str_replace('?', '&', $params);
                }
                $this->redirect($url . $params);
            } else {
                $this->response->body(Json::json_encode($result['result']));
            }
        }
    }
}
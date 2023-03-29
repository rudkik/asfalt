<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopRoom extends Controller_Hotel_BasicHotel {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Hotel_Shop_Room';
        $this->controllerName = 'shoproom';
        $this->tableID = Model_Hotel_Shop_Room::TABLE_ID;
        $this->tableName = Model_Hotel_Shop_Room::TABLE_NAME;
        $this->objectName = 'room';

        parent::__construct($request, $response);
    }

    public function action_select_free() {
        $adults = Request_RequestParams::getParamInt('adults');
        if($adults < 1){
            $adults = 1;
        }
        $childs = Request_RequestParams::getParamInt('childs');
        if($childs < 0){
            $childs = 0;
        }
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        if($dateFrom === NULL){
            $dateFrom = date('Y-m-d');
        }
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        if($dateTo === NULL){
            $dateTo = $dateFrom;
        }

        // свободные номера на заданный период и количество человек
        $freeRooms = Api_Hotel_Shop_Room_Type::selectionFreeRoomTypes($adults, $childs, $dateFrom, $dateTo,
            $this->_sitePageData, $this->_driverDB);
        print_r($freeRooms);
    }

    public function action_index() {
        $this->_sitePageData->url = '/hotel/shoproom/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/room/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Hotel_Shop_Room', $this->_sitePageData->shopID, "_shop/room/list/index",
            "_shop/room/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/room/index');
    }

    public function action_current_free() {
        $this->_sitePageData->url = '/hotel/shoproom/current_free';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/room/list/current/free',
            )
        );

        $data = Helpers_View::getViewObjects(new MyArray(), new Model_Hotel_Shop_Room(), "_shop/room/list/current/free",
            "_shop/room/one/current/free", $this->_sitePageData, $this->_driverDB,
            -1, TRUE, NULL, TRUE);
        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_json_free() {
        $this->_sitePageData->url = '/hotel/shoproom/json_free';

        $params = array_merge($_POST, $_GET);
        if ((key_exists('offset', $params)) && (intval($params['offset']) > 0)) {
            $params['page'] =  round($params['offset'] / $params['limit']) + 1;
        }
        if ((key_exists('sort', $params)) ) {
            $params['sort_by'] = array('value' => array($params['sort'] => Arr::path($params, 'order', 'asc')));
        }
        if ((key_exists('limit', $params)) ) {
            $params['limit_page'] = intval($params['limit']);
            unset($params['limit']);
        }else{
            $params['limit_page'] = 5000;
        }
        $params[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = TRUE;

        // получаем список
        $ids = Api_Hotel_Shop_Room::getFreeRooms(date('Y-m-d'), date('Y-m-d'), $this->_sitePageData,
            $this->_driverDB, TRUE, $params);

        $fields = Request_RequestParams::getParam('_fields');
        if(!is_array($fields)){
            if($fields != '*'){
                $fields = array($fields);
            }
        }

        $result = array();
        if($fields == '*'){
            foreach ($ids->childs as $child) {
                $result[] = $child->values;
            }
        }elseif(!empty($fields)) {
            foreach ($ids->childs as $child) {
                $values = array('id' => $child->id);
                foreach ($fields as $field) {
                    if (key_exists($field, $child->values)) {
                        $values[$field] = $child->values[$field];
                    }
                }

                $result[] = $values;
            }
        }

        if (Request_RequestParams::getParamBoolean('is_total')) {
            $this->response->body(json_encode(array('total' => $this->_sitePageData->countRecord, 'rows' => $result)));
        }else{
            $this->response->body(json_encode($result));
        }
    }

    public function action_free() {
        $this->_sitePageData->url = '/hotel/shoproom/free';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/room/list/free',
            )
        );

        // получаем список
        $roomsIDs = Request_Request::find( 'DB_Hotel_Shop_Room', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);
        $roomsIDs->runIndex();

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        if($dateFrom === NULL){
            $dateFrom = date('Y-m-d');
        }
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        if($dateTo === NULL){
            $dateTo = date('Y-m-d', strtotime('1 months'));
        }
        $dateTo = date('Y-m-d', strtotime($dateTo) - 24 * 60 * 60);

        // создаем массив дат
        $period = array();
        $from = $dFrom = strtotime($dateFrom);
        $dTo = strtotime($dateTo);
        while ($from <= $dTo){
            $period[strftime('%d.%m.%Y', $from)] = array(
                'bill_id' => 0,
                'paid_amount' => 0,
                'price' => 0,
            );
            $from = $from + 60 * 60 * 24;
        }

        // присваеваем комнате массив занятости
        foreach ($roomsIDs->childs as $roomsID){
            $roomsID->additionDatas['date'] = $period;
        }

        // находим праздничные дня
        $feastDayIDs = Request_Request::find('DB_Hotel_Shop_Feast_Day', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('period_from' => $dateFrom, 'period_to' => $dateTo, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE);
        $feastDays = array();
        foreach ($feastDayIDs->childs as $feastDayID){
            $feastDays[$feastDayID->values['date']] = 1;
        }

        // находим дни предоплат
        $holidayDayIDs = Request_Request::find('DB_Hotel_Shop_Holiday_Day', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('period_from' => $dateFrom, 'period_to' => $dateTo, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE);
        $holidayDays = array();
        foreach ($holidayDayIDs->childs as $holidayDayID){
            $holidayDays[Helpers_DateTime::getDateFormatRus($holidayDayID->values['date'])] = 1;
        }

        // находим занятые даты номеров
        $data = Request_Request::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('period_from' => $dateFrom, 'period_to' => $dateTo,
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),0, TRUE,
            array('shop_room_id' => array('name'), 'shop_client_id' => array('name'), 'shop_bill_id' => array('paid_amount')));
        foreach ($data->childs as $child){
            $roomsID = $roomsIDs->childs[$child->values['shop_room_id']];
            $billID = $child->values['shop_bill_id'];
            $clientName = $child->getElementValue('shop_client_id');
            $paidAmount = $child->getElementValue('shop_bill_id', 'paid_amount');

            // проставляем ID заказов у занятых дней
            $from = strtotime($child->values['date_from']);
            $to = strtotime($child->values['date_to']);

            if ($from < $dFrom){
                $from = $dFrom;
            }
            if ($to > $dTo){
                $to = $dTo;
            }
            while ($from <= $to){
                $date = strftime('%d.%m.%Y', $from);
                $roomsID->additionDatas['date'][$date]['bill_id'] = $billID;
                $roomsID->additionDatas['date'][$date]['shop_client_name'] = $clientName;
                $roomsID->additionDatas['date'][$date]['paid_amount'] = $paidAmount;
                $from = $from + 60 * 60 * 24;
            }
        }

        // проставляем стоимость дня, включая праздничные дни
        foreach ($roomsIDs->childs as $roomsID) {
            $from = $dFrom;
            while ($from <= $dTo) {
                $date = date('Y-m-d', $from);

                $weekDay = strftime('%u', $from);
                $isFeastDay = (Api_Hotel_Shop_Room::IS_DAY_OFF && (($weekDay == 6) || ($weekDay == 7))) || (key_exists($date, $feastDays));

                $price = Api_Hotel_Shop_Room::getAmountRoomOfDay(array(), $roomsID->id, $date, $isFeastDay, 0, 0,
                    $this->_sitePageData, $this->_driverDB, TRUE);

                $date = date('d.m.Y', $from);
                $roomsID->additionDatas['date'][$date]['price'] = $price['price'];
                $roomsID->values['price_feast'] = $price['detailed']['price_feast'];
                $roomsID->values['price'] = $price['detailed']['price'];
                $roomsID->values['price_extra'] = $price['detailed']['price_extra'];
                $roomsID->values['price_child'] = $price['detailed']['price_child'];
                $roomsID->additionDatas['date'][$date]['is_holiday'] = (($weekDay == 6) || ($weekDay == 7) || (key_exists($date, $holidayDays)));
                $from = $from + 60 * 60 * 24;
            }
        }

        $roomsIDs->additionDatas['date_from'] = $dateFrom;
        $roomsIDs->additionDatas['date_to'] = $dateTo;
        $data = Helpers_View::getViewObjects($roomsIDs, new Model_Hotel_Shop_Bill_Item(), "_shop/room/list/free",
                "_shop/room/one/free", $this->_sitePageData, $this->_driverDB);
        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_free_modal() {
        $this->_sitePageData->url = '/hotel/shoproom/free_modal';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/room/list/free',
            )
        );

        $shopBillID = Request_RequestParams::getParamInt('bill_id');
        $model = new Model_Hotel_Shop_Bill();
        if (! $this->dublicateObjectLanguage($model, $shopBillID)) {
            throw new HTTP_Exception_404('Bill not is found!');
        }

        // получаем список
        $roomsIDs = Request_Request::find( 'DB_Hotel_Shop_Room', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);
        $roomsIDs->runIndex();

        $dateFrom = $model->getDateFrom();
        if(empty($dateFrom)){
            $dateFrom = date('Y-m-d');
        }
        $dateTo = $model->getDateTo();
        if(empty($dateTo)){
            $dateTo = date('Y-m-d', strtotime('1 months'));
        }
        $dateTo = date('Y-m-d', strtotime($dateTo) - 24 * 60 * 60);

        // создаем массив дат
        $period = array();
        $from = $dFrom = strtotime($dateFrom);
        $dTo = strtotime($dateTo);
        while ($from <= $dTo){
            $period[strftime('%d.%m.%Y', $from)] = array(
                'bill_id' => 0,
                'price' => 0,
                'paid_amount' => 0,
            );
            $from = $from + 60 * 60 * 24;
        }

        // присваеваем комнате массив занятости
        foreach ($roomsIDs->childs as $roomsID){
            $roomsID->additionDatas['date'] = $period;
        }

        // находим праздничные дня
        $feastDayIDs = Request_Request::find('DB_Hotel_Shop_Feast_Day', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('period_from' => $dateFrom, 'period_to' => $dateTo, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE);
        $feastDays = array();
        foreach ($feastDayIDs->childs as $feastDayID){
            $feastDays[$feastDayID->values['date']] = 1;
        }

        // находим дни предоплат
        $holidayDayIDs = Request_Request::find('DB_Hotel_Shop_Holiday_Day', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('period_from' => $dateFrom, 'period_to' => $dateTo, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE);
        $holidayDays = array();
        foreach ($holidayDayIDs->childs as $holidayDayID){
            $holidayDays[Helpers_DateTime::getDateFormatRus($holidayDayID->values['date'])] = 1;
        }

        // находим занятые даты номеров
        $data = Request_Request::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('period_from' => $dateFrom, 'period_to' => $dateTo, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE, array('shop_room_id' => array('name'), 'shop_client_id' => array('name'), 'shop_bill_id' => array('paid_amount')));
        foreach ($data->childs as $child){
            $roomsID = $roomsIDs->childs[$child->values['shop_room_id']];
            $billID = $child->values['shop_bill_id'];
            $clientName = $child->getElementValue('shop_client_id');
            $paidAmount = $child->getElementValue('shop_bill_id', 'paid_amount');

            // проставляем ID заказов у занятых дней
            $from = strtotime($child->values['date_from']);
            $to = strtotime($child->values['date_to']);

            if ($from < $dFrom){
                $from = $dFrom;
            }
            if ($to > $dTo){
                $to = $dTo;
            }
            while ($from <= $to){
                $date = strftime('%d.%m.%Y', $from);
                $roomsID->additionDatas['date'][$date]['bill_id'] = $billID;
                $roomsID->additionDatas['date'][$date]['shop_client_name'] = $clientName;
                $roomsID->additionDatas['date'][$date]['paid_amount'] = $paidAmount;
                $from = $from + 60 * 60 * 24;
            }
        }

        // проставляем стоимость дня, включая праздничные дни
        foreach ($roomsIDs->childs as $roomsID) {
            $from = $dFrom;
            while ($from <= $dTo) {
                $date = date('Y-m-d', $from);

                $weekDay = strftime('%u', $from);
                $isFeastDay = (Api_Hotel_Shop_Room::IS_DAY_OFF && (($weekDay == 6) || ($weekDay == 7))) || (key_exists($date, $feastDays));

                $price = Api_Hotel_Shop_Room::getAmountRoomOfDay(array(), $roomsID->id, $date, $isFeastDay, 0, 0,
                    $this->_sitePageData, $this->_driverDB, TRUE);

                $date = date('d.m.Y', $from);
                $roomsID->additionDatas['date'][$date]['price'] = $price['price'];
                $roomsID->values['price_feast'] = $price['detailed']['price_feast'];
                $roomsID->values['price'] = $price['detailed']['price'];
                $roomsID->values['price_extra'] = $price['detailed']['price_extra'];
                $roomsID->values['price_child'] = $price['detailed']['price_child'];
                $roomsID->additionDatas['date'][$date]['is_holiday'] = (($weekDay == 6) || ($weekDay == 7) || (key_exists($date, $holidayDays)));
                $from = $from + 60 * 60 * 24;
            }
        }

        $roomsIDs->additionDatas['date_from'] = $dateFrom;
        $roomsIDs->additionDatas['date_to'] = $dateTo;
        $this->_sitePageData->replaceDatas['view::_shop/room/list/free'] = Helpers_View::getViewObjects($roomsIDs, new Model_Hotel_Shop_Bill_Item(), "_shop/room/list/free",
            "_shop/room/one/free", $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $dataID->values['date_from'] = $dateFrom;
        $dataID->values['date_to'] = $dateTo;
        $dataID->values['bill_id'] = $shopBillID;

        $data = Helpers_View::getViewObject($dataID, new Model_Hotel_Shop_Room(), "_shop/room/modal/free",
            $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_json() {
        $this->_sitePageData->url = '/hotel/shoproom/json';

        $params = array_merge($_POST, $_GET);
        if ((key_exists('offset', $params)) && (intval($params['offset']) > 0)) {
            $params['page'] =  round($params['offset'] / $params['limit']) + 1;
        }
        if ((key_exists('sort', $params)) ) {
            $params['sort_by'] = array('value' => array($params['sort'] => Arr::path($params, 'order', 'asc')));
        }
        if ((key_exists('limit', $params)) ) {
            $params['limit_page'] = intval($params['limit']);
            unset($params['limit']);
        }else{
            $params['limit_page'] = 25;
        }
        $params[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = TRUE;

        // получаем список
        $ids = Request_Request::find( 'DB_Hotel_Shop_Room', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params, 5000, TRUE, array('shop_building_id' => array('name'),
                'shop_floor_id' => array('name'), 'shop_room_type_id' => array('name')));

        $fields = Request_RequestParams::getParam('_fields');
        if(!is_array($fields)){
            if($fields != '*'){
                $fields = array($fields);
            }
        }

        $result = array();
        if($fields == '*'){
            foreach ($ids->childs as $child) {
                $result[] = $child->values;
            }
        }elseif(!empty($fields)) {
            foreach ($ids->childs as $child) {
                $values = array('id' => $child->id);
                foreach ($fields as $field) {
                    if (key_exists($field, $child->values)) {
                        $values[$field] = $child->values[$field];
                    }elseif ($field == 'shop_building_name'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_building_id.name', '');
                    }elseif ($field == 'shop_floor_name'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_floor_id.name', '');
                    }elseif ($field == 'shop_room_type_name'){
                        $values[$field] = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_room_type_id.name', '');
                    }
                }

                $result[] = $values;
            }
        }

        if (Request_RequestParams::getParamBoolean('is_total')) {
            $this->response->body(json_encode(array('total' => $this->_sitePageData->countRecord, 'rows' => $result)));
        }else{
            $this->response->body(json_encode($result));
        }
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/hotel/shoproom/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/room/one/new',
            )
        );

        $this->_requestShopBuildings();
        $this->_requestShopRoomTypes();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/room/one/new'] = Helpers_View::getViewObject($dataID, new Model_Hotel_Shop_Room(),
            '_shop/room/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/hotel/shoproom/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/room/one/edit',
            )
        );

        // id записи
        $shopRoomID = Request_RequestParams::getParamInt('id');
        if ($shopRoomID === NULL) {
            throw new HTTP_Exception_404('Room not is found!');
        }else {
            $model = new Model_Hotel_Shop_Room();
            if (! $this->dublicateObjectLanguage($model, $shopRoomID)) {
                throw new HTTP_Exception_404('Room not is found!');
            }
        }

        $this->_requestShopBuildings($model->getShopBuildingID());
        $this->_requestShopFloors($model->getShopBuildingID(), $model->getShopFloorID());
        $this->_requestShopRoomTypes($model->getShopRoomTypeID());

        // получаем данные
        $data = View_View::findOne('DB_Hotel_Shop_Room', $this->_sitePageData->shopID, "_shop/room/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopRoomID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/hotel/shoproom/save';

        $result = Api_Hotel_Shop_Room::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];
            $result['values']['shop_building_name'] = '';

            $tmp = $result['values']['shop_building_id'];
            if ($tmp > 0){
                $model = new Model_Hotel_Shop_Building();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['shop_building_name'] = $model->getName();
                }
            }

            $tmp = $result['values']['shop_floor_id'];
            if ($tmp > 0){
                $model = new Model_Hotel_Shop_Floor();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['shop_floor_name'] = $model->getName();
                }
            }

            $tmp = $result['values']['shop_room_type_id'];
            if ($tmp > 0){
                $model = new Model_Hotel_Shop_Room_Type();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['shop_room_type_name'] = $model->getName();
                }
            }

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/hotel/shoproom/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/hotel/shoproom/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestShopBuildings($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/building/list/list',
            )
        );
        $data = View_View::find('DB_Hotel_Shop_Building', $this->_sitePageData->shopID,
            "_shop/building/list/list", "_shop/building/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/building/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestShopFloors($shopBuildingID, $currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/floor/list/list',
            )
        );
        $data = View_View::find('DB_Hotel_Shop_Floor', $this->_sitePageData->shopID,
            "_shop/floor/list/list", "_shop/floor/one/list", $this->_sitePageData, $this->_driverDB,
            array('shop_building_id' => $shopBuildingID, 'sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/floor/list/list'] = $data;
        }
    }

    /**
     * Делаем запрос на список доставок
     * @param null|int $currentID
     */
    protected function _requestShopRoomTypes($currentID = NULL)
    {
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/room/type/list/list',
            )
        );
        $data = View_View::find('DB_Hotel_Shop_Room_Type', $this->_sitePageData->shopID,
            "_shop/room/type/list/list", "_shop/room/type/one/list", $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if ($currentID !== NULL) {
            $s = 'data-id="' . $currentID . '"';
            $data = str_replace($s, $s . ' selected', $data);
            $this->_sitePageData->replaceDatas['view::_shop/room/type/list/list'] = $data;
        }
    }
}

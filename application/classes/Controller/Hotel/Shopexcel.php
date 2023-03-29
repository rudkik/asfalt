<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopExcel extends Controller_Hotel_BasicHotel {
    // остатки на 01.10.2018
    const BASIC_COMING = 1288900.36;
    const BASIC_EXPENSE = 0;
    // балоный день
    const BASIC_DATE = '2018-10-01';

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopreport';
        $this->objectName = 'report';

        parent::__construct($request, $response);
    }

    /**
     * Сортировка по имени
     * @param $x
     * @param $y
     * @return int
     */
    function mySortMethod($x, $y) {
        return strcasecmp($x['name'], $y['name']);
    }

    /**
     * Сортировка по дате и номеру
     * @param $x
     * @param $y
     * @return int
     */
    function cashBookSortMethod($x, $y) {
        $result = strcasecmp($x['date'], $y['date']);
        if ($result === 0) {
            $result = strcasecmp($x['number_1c'], $y['number_1c']);
        }

        return $result;
    }

    /** Отчет по занятым дополнительным местам **/
    public function action_addition_room_busy() {
        $this->_sitePageData->url = '/hotel/shopexcel/addition_room_busy';
        set_time_limit(36000);

        $from = Request_RequestParams::getParamDateTime('period_from');
        $to = Request_RequestParams::getParamDateTime('period_to');
        $diff = Helpers_DateTime::diffDays($to, $from) + 1;

        $from = strtotime($from);
        $to = strtotime($to);

        $roomIDs = Request_Request::find(
            'DB_Hotel_Shop_Room', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(
                'sort_by' => array('value' => array('name' => 'asc')),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE
            ),
            0, TRUE
        );

        $rooms = array(
            'data' => array(),
            'human' => 0,
        );
        $humanAll = 0;
        foreach ($roomIDs->childs as $child){
            $rooms['data'][$child->id] = array(
                'name' => $child->values['name'],
                'data' => array(),
                'human_day' => $child->values['human_extra'],
                'human' => 0,
                'human_all' => $child->values['human_extra'] * $diff,
            );
            $humanAll += $child->values['human_extra'];
        }

        $dates = array();
        for ($d = $from; $d <= $to; $d=$d+24*60*60 ){
            $s = date('Y-m-d', $d);
            $dates[$s] = array(
                'date' => $s,
                'human' => 0,
                'human_all' => $humanAll,
            );
        }

        $billItemsIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(), 0, TRUE, array());

        $dataBillItems = array(
            'data' => $rooms['data'],
            'human' => 0,
            'human_all' => 0,
        );
        foreach ($dataBillItems['data'] as $key =>  $child){
            $dataBillItems['data'][$key]['data'] = $dates;
        }

        foreach ($billItemsIDs->childs as $child){
            $room = $child->values['shop_room_id'];

            $fromItem = strtotime($child->values['date_from']);
            if($fromItem < $from){
                $fromItem = $from;
            }
            $toItem  = strtotime($child->values['date_to']);
            if($toItem > $to){
                $toItem = $to;
            }

            $human = $child->values['human_extra'] + $child->values['child_extra'];
            for ($d = $fromItem ; $d <= $toItem ; $d = $d + 24*60*60 ){
                $date = date('Y-m-d', $d);

                $dataBillItems['data'][$room]['data'][$date]['human'] = $human;
                $dataBillItems['data'][$room]['human'] += $human;
                $dataBillItems['human'] += $human;

                $dates[$date]['human'] += $human;
            }
        }

        $dataBillItems['human_all'] = $humanAll * $diff;

        // print_r($dataBillItems);die;

        $filePath = 'hotel' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'addition_room_busy';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->billItems = $dataBillItems;
        $view->dates = array('data' => $dates);
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по занятости номеров.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /** Отчет по реализации номеров **/
    public function action_income_finish() {
        $this->_sitePageData->url = '/hotel/shopexcel/income_finish';
        set_time_limit(36000);

        $from = Request_RequestParams::getParamDateTime('period_from');
        $to = Request_RequestParams::getParamDateTime('period_to');
        $diff = Helpers_DateTime::diffDays($to, $from) + 1;

        $from = strtotime($from);
        $to = strtotime($to);

        $roomIDs = Request_Request::find( 'DB_Hotel_Shop_Room',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(
                'sort_by' => array('value' => array('name' => 'asc')),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE
            ), 0, TRUE
        );

        $rooms = array(
            'data' => array(),
            'human' => 0,
            'human_all' => 0,
        );

        $amountAll = 0;
        foreach ($roomIDs->childs as $child){
            $rooms['data'][$child->id] = array(
                'name' => $child->values['name'],
                'data' => array(),
                'amount' => 0,
                'amount_all' => $child->values['price'] * $diff,
                'human' => $child->values['human'],
            );

            $amountAll += $child->values['price'];
            $rooms['human_all'] += $child->values['human'] * $diff;
        }

        $dates = array();
        for ($d = $from; $d <= $to; $d = $d + 24 * 60 * 60 ){
            $s = date('Y-m-d', $d);
            $dates[$s] = array(
                'date' => $s,
                'amount' => 0,
                'amount_all' => $amountAll,
            );
        }

        $params = Request_RequestParams::setParams(
            array(
                'period_from' => $from,
                'period_to' => $to,
                'is_finish' => 1,
            )
        );
        $billIDs = Request_Request::find('DB_Hotel_Shop_Bill',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params
        );
        $billIDs->runIndex();

        if(count($billIDs->childs) > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'period_from' => $from,
                    'period_to' => $to,
                    'shop_bill_id' => $billIDs->getChildArrayID(),
                )
            );
            $billItemsIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params, 0, TRUE, array()
            );
        }else{
            $billItemsIDs = new MyArray();
        }

        $dataBillItems = array(
            'data' => $rooms['data'],
            'amount' => 0,
            'amount_all' => 0,
        );
        foreach ($dataBillItems['data'] as $key =>  $child){
            $dataBillItems['data'][$key]['data'] = $dates;
        }

        foreach ($billItemsIDs->childs as $child){
            $room = $child->values['shop_room_id'];

            $fromItem = strtotime($child->values['date_from']);
            if($fromItem < $from){
                $fromItem = $from;
            }
            $toItem  = strtotime($child->values['date_to']);
            if($toItem > $to){
                $toItem = $to;
            }

            if ($child->values['days'] < 1){
                $child->values['days'] = 1;
            }
            $amount = $child->values['amount'] / $child->values['days'];

            $discount = $billIDs->childs[$child->values['shop_bill_id']]->values['discount'];
            if($discount != 0){
                $amount = $amount / 100 * (100 - $discount);
            }
            for ($d = $fromItem ; $d <= $toItem ; $d = $d + 24 * 60 * 60 ){
                $date = date('Y-m-d', $d);

                $dataBillItems['data'][$room]['data'][$date]['amount'] = $amount;
                $dataBillItems['data'][$room]['amount'] += $amount;
                $dataBillItems['amount'] += $amount;

                $dates[$date]['amount'] += $amount;
                $rooms['human'] += $rooms['data'][$room]['human'];
            }
        }

        $dataBillItems['amount_all'] = $amountAll * $diff;

        $filePath = 'hotel' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'income_finish';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->billItems = $dataBillItems;
        $view->dates = array('data' => $dates);
        $view->rooms = $rooms;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по реализации номеров.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /** Отчет по ожидаемой реализации **/
    public function action_income_expected() {
        $this->_sitePageData->url = '/hotel/shopexcel/income_expected';
        set_time_limit(36000);

        $from = Request_RequestParams::getParamDateTime('period_from');
        $to = Request_RequestParams::getParamDateTime('period_to');
        $diff = Helpers_DateTime::diffDays($to, $from) + 1;

        $from = strtotime($from);
        $to = strtotime($to);

        $roomIDs = Request_Request::find(
            'DB_Hotel_Shop_Room',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(
                'sort_by' => array('value' => array('name' => 'asc')),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE
            ),
            0, TRUE
        );

        $rooms = array(
            'data' => array(),
            'human' => 0,
        );

        $amountAll = 0;
        foreach ($roomIDs->childs as $child){
            $rooms['data'][$child->id] = array(
                'name' => $child->values['name'],
                'data' => array(),
                'amount' => 0,
                'amount_all' => $child->values['price'] * $diff,
            );
            $amountAll += $child->values['price'];
        }

        $dates = array();
        for ($d = $from; $d <= $to; $d=$d+24*60*60 ){
            $s = date('Y-m-d', $d);
            $dates[$s] = array(
                'date' => $s,
                'amount' => 0,
                'amount_all' => $amountAll,
            );
        }

        $params = Request_RequestParams::setParams(
            array(
                'period_from' => $from,
                'period_to' => $to,
                'is_finish' => 0,
            )
        );
        $billIDs = Request_Request::find('DB_Hotel_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params);


        if(count($billIDs->childs) > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'period_from' => $from,
                    'period_to' => $to,
                    'shop_bill_id' => $billIDs->getChildArrayID(),
                )
            );
            $billItemsIDs = Request_Request::find(
                'DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params, 0, TRUE, array());
        }else{
            $billItemsIDs = new MyArray();
        }

        $dataBillItems = array(
            'data' => $rooms['data'],
            'amount' => 0,
            'amount_all' => 0,
        );
        foreach ($dataBillItems['data'] as $key =>  $child){
            $dataBillItems['data'][$key]['data'] = $dates;
        }

        foreach ($billItemsIDs->childs as $child){
            $room = $child->values['shop_room_id'];

            $fromItem = strtotime($child->values['date_from']);
            if($fromItem < $from){
                $fromItem = $from;
            }
            $toItem  = strtotime($child->values['date_to']);
            if($toItem > $to){
                $toItem = $to;
            }

            if ($child->values['days'] < 1){
                $child->values['days'] = 1;
            }
            $amount = $child->values['amount'] / $child->values['days'];
            for ($d = $fromItem ; $d <= $toItem ; $d = $d+24*60*60 ){
                $date = date('Y-m-d', $d);

                $dataBillItems['data'][$room]['data'][$date]['amount'] = $amount;
                $dataBillItems['data'][$room]['amount'] += $amount;
                $dataBillItems['amount'] += $amount;

                $dates[$date]['amount'] += $amount;
            }
        }

        $dataBillItems['amount_all'] = $amountAll * $diff;

         //print_r($dataBillItems);die;

        $filePath = 'hotel' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'income_expected';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->billItems = $dataBillItems;
        $view->dates = array('data' => $dates);
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по ожидаемой реализации.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /** Отчет по типам оплаты **/
    public function action_payments_paid_type(){
        $this->_sitePageData->url = '/hotel/shopexcel/payments_paid_type';
        set_time_limit(36000);

        $params = Request_RequestParams::setParams(
            array(
                'paid_at_from_equally' => Request_RequestParams::getParamDateTime('period_from'),
                'paid_at_to' => Request_RequestParams::getParamDateTime('period_to'),
                'is_paid' => 1,
                'shop_paid_type_id' => Request_RequestParams::getParamInt('shop_paid_type_id'),
                'sort_by' => array('paid_at' => 'asc')
            )
        );
        $ids = Request_Request::find('DB_Hotel_Shop_Payment',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_client_id' => array('name'),
                'shop_paid_type_id' => array('name'),
                'create_user_id' => array('name'),
            )
        );

        $dataPayments = array(
            'data' => array(),
            'amount' => 0,
        );
        $dataPaymentTypes = array(
            'data' => array(),
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $dataPayments['data'][] = array(
                'bill_id' => $child->values['shop_bill_id'],
                'client' => Arr::path($child->values, Model_Hotel_Shop_Room::FIELD_ELEMENTS.'.shop_client_id.name', ''),
                'paid_name' => Arr::path($child->values, Model_Hotel_Shop_Room::FIELD_ELEMENTS.'.shop_paid_type_id.name', ''),
                'user' => Arr::path($child->values, Model_Hotel_Shop_Room::FIELD_ELEMENTS.'.create_user_id.name', ''),
                'amount' => $child->values['amount'],
                'paid_at' => $child->values['paid_at'],
                'name' => $child->values['name'],
                'id' => $child->values['id'],
            );

            $shopPaidTypeID = $child->values['shop_paid_type_id'];
            if(!key_exists($shopPaidTypeID, $dataPaymentTypes['data'])){
                $dataPaymentTypes['data'][$shopPaidTypeID] = array(
                    'name' => Arr::path($child->values, Model_Hotel_Shop_Room::FIELD_ELEMENTS.'.shop_paid_type_id.name', ''),
                    'percent' => 0,
                    'amount' => 0,
                );
            }
            $dataPaymentTypes['data'][$shopPaidTypeID]['amount'] += $child->values['amount'];
            $dataPaymentTypes['amount'] += $child->values['amount'];

            $dataPayments['amount'] += $child->values['amount'];
        }

        foreach ($dataPaymentTypes['data'] as &$child){
            $child['percent'] = round($child['amount'] / $dataPaymentTypes['amount'] * 100, 2);
        }

        $filePath = 'hotel' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'payments_paid_type';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $model = new Model_Shop_PaidType();
        $model->setDBDriver($this->_driverDB);
        Helpers_DB::getDBObject($model, Request_RequestParams::getParamInt('shop_paid_type_id'), $this->_sitePageData);

        $view->payments = $dataPayments;
        $view->paymentTypes = $dataPaymentTypes;
        $view->shopPaidTypeName = $model->getName();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по типам оплат.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /** Отчет по возвратам **/
    public function action_refunds() {
        $this->_sitePageData->url = '/hotel/shopexcel/refunds';
        set_time_limit(36000);

        $params = Request_RequestParams::setParams(
            array(
                'date_from' => Request_RequestParams::getParamDateTime('date_from'),
                'date_to' => Request_RequestParams::getParamDateTime('date_to'),
                'sort_by' => array('date' => 'asc'),
            )
        );

        $ids = Request_Request::find('DB_Hotel_Shop_Refund', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name')));

        $dataRefunds = array(
            'data' => array(),
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $dataRefunds['data'][] = array(
                'date' => $child->values['date'],
                'client' => Arr::path($child->values, Model_Hotel_Shop_Room::FIELD_ELEMENTS.'.shop_client_id.name', ''),
                'amount' => $child->values['amount'],
            );

            $dataRefunds['amount'] += $child->values['amount'];
        }

        $filePath = 'hotel' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'refunds';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->refunds = $dataRefunds;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по возвратам.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /** Отчет по занятым койко-местам **/
    public function action_beds_busy() {
        $this->_sitePageData->url = '/hotel/shopexcel/beds_busy';
        set_time_limit(36000);

        $from = Request_RequestParams::getParamDateTime('period_from');
        $to = Request_RequestParams::getParamDateTime('period_to');
        $diff = Helpers_DateTime::diffDays($to, $from) + 1;

        $from = strtotime($from);
        $to = strtotime($to);

        $roomIDs = Request_Request::find(
            'DB_Hotel_Shop_Room', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $rooms = array(
            'data' => array(),
            'human' => 0,
        );
        $humanAll = 0;
        foreach ($roomIDs->childs as $child){
            $rooms['data'][$child->id] = array(
                'name' => $child->values['name'],
                'data' => array(),
                'human_day' => $child->values['human'],
                'human' => 0,
                'human_all' => $child->values['human'] * $diff,
            );
            $humanAll += $child->values['human'];
        }

        $dates = array();
        for ($d = $from; $d <= $to; $d=$d+24*60*60 ){
            $s = date('Y-m-d', $d);
            $dates[$s] = array(
                'date' => $s,
                'human' => 0,
                'human_all' => $humanAll,
            );
        }

        $billItemsIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(), 0, TRUE, array());

        $dataBillItems = array(
            'data' => $rooms['data'],
            'human' => 0,
            'human_all' => 0,
        );
        foreach ($dataBillItems['data'] as $key =>  $child){
            $dataBillItems['data'][$key]['data'] = $dates;
        }

        foreach ($billItemsIDs->childs as $child){
            $room = $child->values['shop_room_id'];

            $fromItem = strtotime($child->values['date_from']);
            if($fromItem < $from){
                $fromItem = $from;
            }
            $toItem  = strtotime($child->values['date_to']);
            if($toItem > $to){
                $toItem = $to;
            }

            $human = $dataBillItems['data'][$room]['human_day'];
            for ($d = $fromItem ; $d <= $toItem ; $d = $d+24*60*60 ){
                $date = date('Y-m-d', $d);

                $dataBillItems['data'][$room]['data'][$date]['human'] = $human;
                $dataBillItems['data'][$room]['human'] += $human;
                $dataBillItems['human'] += $human;

                $dates[$date]['human'] += $human;
            }
        }

        $dataBillItems['human_all'] = $humanAll * $diff;

       // print_r($dataBillItems);die;

        $filePath = 'hotel' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'beds_busy';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->billItems = $dataBillItems;
        $view->dates = array('data' => $dates);
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по занятости номеров.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /** Акт сверки разбит по клиентам **/
    public function action_act_check_group_client(){
        $this->_sitePageData->url = '/hotel/shopexcel/act_check_group_client';
        set_time_limit(36000);

        $dataItems = array(
            'data' => array(),
            'coming' => 0,
            'expense' => 0,
        );

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        if (($dateFrom === NULL) || (strtotime($dateFrom) < strtotime(self::BASIC_DATE))){
            $dateFrom = self::BASIC_DATE;
        }

        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        if($dateTo === NULL){
            $dateTo = time();
        }else {
            $dateTo = strtotime($dateTo);
        }
        if ($dateTo > time()){
            $dateTo = time();
        }
        $dateTo = date('Y-m-d', $dateTo);


        /** Считаем предыдущее приход и расход **/
        if ($dateFrom === NULL) {
            $expense = 0;
            $coming = 0;
        }else{
            $params = Request_RequestParams::setParams(
                array(
                    'date_to_to' => $dateFrom,
                    'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                    'sum_amount' => TRUE,
                    'old_id_empty' => TRUE,
                )
            );
            $ids = Request_Request::find('DB_Hotel_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params);
            $expense = $ids->childs[0]->values['amount'];

            $params = Request_RequestParams::setParams(
                array(
                    'date_to' => $dateFrom,
                    'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                    'sum_amount' => TRUE,
                    'old_id_empty' => TRUE,
                )
            );
            $ids = Request_Request::find('DB_Hotel_Shop_Refund', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params);
            $expense += $ids->childs[0]->values['amount'];

            $params = Request_RequestParams::setParams(
                array(
                    'paid_at_to' => $dateFrom,
                    'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                    'is_paid' => TRUE,
                    'sum_amount' => TRUE,
                    'old_id_empty' => TRUE,
                )
            );
            $ids = Request_Request::find('DB_Hotel_Shop_Payment', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params);
            $coming = $ids->childs[0]->values['amount'];
        }


        /** Считаем текущие расход и приход **/


        /** Расход **/
        $params = Request_RequestParams::setParams(
            array(
                'date_to_from' => $dateFrom,
                'date_to_to' => $dateTo,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                'old_id_empty' => TRUE,
            )
        );

        // расход
        $ids = Request_Request::find('DB_Hotel_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name', 'bin', 'old_id'), 'shop_paid_type_id' => array('name')));

        foreach ($ids->childs as $child){
            if (!Func::_empty(Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_client_id.old_id', ''))){
                continue;
            }

            $shopClientID = $child->values['shop_client_id'];
            if (!key_exists($shopClientID, $dataItems['data'])){
                $name = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_client_id.bin', '');
                if (!empty($name)){
                    $name = ', БИН '.$name;
                }
                $name = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_client_id.name', ''). $name;
                $dataItems['data'][$shopClientID] = array(
                    'data' => array(),
                    'name' => $name,
                    'coming' => 0,
                    'expense' => 0,
                );
            }

            $dataItems['data'][$shopClientID]['data'][] = array(
                'name' => $child->values['date_to'],
                'document' => 'Оказание услуг в Кара Дале/РКО - № брони '.$child->id,
                'coming' => 0,
                'expense' => $child->values['amount'],
            );

            $dataItems['data'][$shopClientID]['expense'] += $child->values['amount'];
            $dataItems['expense'] += $child->values['amount'];
        }

        /** Приход **/
        $params = Request_RequestParams::setParams(
            array(
                'paid_at_from' => $dateFrom,
                'paid_at_to' => $dateTo,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                'is_paid' => TRUE,
                'old_id_empty' => TRUE,
            )
        );
        $ids = Request_Request::find('DB_Hotel_Shop_Payment', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name', 'bin', 'old_id'), 'shop_paid_type_id' => array('name')));

        foreach ($ids->childs as $child){
            if (!Func::_empty(Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_client_id.old_id', ''))){
                continue;
            }
            $shopClientID = $child->values['shop_client_id'];
            if (!key_exists($shopClientID, $dataItems['data'])){
                $name = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_client_id.bin', '');
                if (!empty($name)){
                    $name = ', БИН '.$name;
                }
                $name = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_client_id.name', ''). $name;
                $dataItems['data'][$shopClientID] = array(
                    'data' => array(),
                    'name' => $name,
                    'coming' => 0,
                    'expense' => 0,
                );
            }

            $dataItems['data'][$shopClientID]['data'][] = array(
                'name' => $child->values['paid_at'],
                'document' => 'Оплата через '.Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_paid_type_id.name', '').' - № брони '.$child->values['shop_bill_id'],
                'coming' => $child->values['amount'],
                'expense' => 0,
            );

            $dataItems['data'][$shopClientID]['coming'] += $child->values['amount'];
            $dataItems['coming'] += $child->values['amount'];
        }

        /** Возврат **/
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                'old_id_empty' => TRUE,
            )
        );
        $ids = Request_Request::find('DB_Hotel_Shop_Refund', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name', 'bin', 'old_id')));

        foreach ($ids->childs as $child){
            if (!Func::_empty(Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_client_id.old_id', ''))){
                continue;
            }
            $shopClientID = $child->values['shop_client_id'];
            if (!key_exists($shopClientID, $dataItems['data'])){
                $name = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_client_id.bin', '');
                if (!empty($name)){
                    $name = ', БИН '.$name;
                }
                                $name = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_client_id.name', ''). $name;
                $dataItems['data'][$shopClientID] = array(
                    'data' => array(),
                    'name' => $name,
                    'coming' => 0,
                    'expense' => 0,
                );
            }

            $dataItems['data'][$shopClientID]['data'][] = array(
                'name' => $child->values['date'],
                'document' => 'Возврат денег клиенту',
                'coming' => 0,
                'expense' => $child->values['amount'],
            );

            $dataItems['data'][$shopClientID]['expense'] += $child->values['amount'];
            $dataItems['expense'] += $child->values['amount'];
        }
        foreach ($dataItems['data'] as &$client){
            uasort($client['data'], array($this, 'mySortMethod'));
        }
        uasort($dataItems['data'], array($this, 'mySortMethod'));

        $filePath = 'hotel' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'act_check_group_client';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataItems;
        $view->coming = $coming;
        $view->expense = $expense;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getName();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Акт сверки по контрагенту 1С покупатель Кара Дала.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /** Акт сверки по клиенту **/
    public function action_act_check(){
        $this->_sitePageData->url = '/hotel/shopexcel/act_check';
        set_time_limit(36000);

        $dataItems = array(
            'data' => array(),
            'coming' => 0,
            'expense' => 0,
        );

        $dateFrom = Request_RequestParams::getParamDateTime('created_at_from');
        if (($dateFrom === NULL) || (strtotime($dateFrom) < strtotime(self::BASIC_DATE))){
            $dateFrom = self::BASIC_DATE;
        }

        $dateTo = Request_RequestParams::getParamDateTime('created_at_to');
        if($dateTo === NULL){
            $dateTo = time();
        }else {
            $dateTo = strtotime($dateTo);
        }
        if ($dateTo > time()){
            $dateTo = time();
        }
        $dateTo = date('Y-m-d', $dateTo);

        /** Считаем предыдущее приход и расход **/
        if ($dateFrom === NULL) {
            $expense = 0;
            $coming = 0;
        }else{
            $params = Request_RequestParams::setParams(
                array(
                    'date_to_to' => $dateFrom,
                    'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                    'sum_amount' => TRUE,
                )
            );
            $ids = Request_Request::find('DB_Hotel_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params);
            $expense = $ids->childs[0]->values['amount'];

            $params = Request_RequestParams::setParams(
                array(
                    'date_to' => $dateFrom,
                    'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                    'sum_amount' => TRUE,
                )
            );
            $ids = Request_Request::find('DB_Hotel_Shop_Refund', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params);
            $expense += $ids->childs[0]->values['amount'];

            $params = Request_RequestParams::setParams(
                array(
                    'paid_at_to' => $dateFrom,
                    'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                    'is_paid' => TRUE,
                    'sum_amount' => TRUE,
                )
            );
            $ids = Request_Request::find('DB_Hotel_Shop_Payment', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                $params);
            $coming = $ids->childs[0]->values['amount'];
        }


        /** Считаем текущие расход и приход **/

        /** Расход **/
        $params = Request_RequestParams::setParams(
            array(
                'date_to_from' => $dateFrom,
                'date_to_to' => $dateTo,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
            )
        );

        // расход
        $ids = Request_Request::find('DB_Hotel_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name'), 'shop_paid_type_id' => array('name')));

        foreach ($ids->childs as $child){
            $dataItems['data'][] = array(
                'name' => $child->values['date_to'],
                'document' => 'Оказание услуг в Кара Дале/РКО - № брони '.$child->id,
                'coming' => 0,
                'expense' => $child->values['amount'],
            );

            $dataItems['expense'] += $child->values['amount'];
        }

        /** Приход **/
        $params = Request_RequestParams::setParams(
            array(
                'paid_at_from' => $dateFrom,
                'paid_at_to' => $dateTo,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                'is_paid' => TRUE,
            )
        );
        $ids = Request_Request::find('DB_Hotel_Shop_Payment', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name'), 'shop_paid_type_id' => array('name')));

        foreach ($ids->childs as $child){
            $dataItems['data'][] = array(
                'name' => $child->values['paid_at'],
                'document' => 'Оплата через '.Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_paid_type_id.name', '').' - № брони '.$child->values['shop_bill_id'],
                'coming' => $child->values['amount'],
                'expense' => 0,
            );

            $dataItems['coming'] += $child->values['amount'];
        }

        /** Возврат **/
        $params = Request_RequestParams::setParams(
            array(
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
            )
        );
        $ids = Request_Request::find('DB_Hotel_Shop_Refund', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name')));

        foreach ($ids->childs as $child){
            $dataItems['data'][] = array(
                'name' => $child->values['date'],
                'document' => 'Возврат денег клиенту',
                'coming' => 0,
                'expense' => $child->values['amount'],
            );

            $dataItems['expense'] += $child->values['amount'];
        }

        $modelClient = new Model_Hotel_Shop_Client();
        $modelClient->setDBDriver($this->_driverDB);
        Helpers_DB::getDBObject($modelClient, Request_RequestParams::getParamInt('shop_client_id'), $this->_sitePageData);

        uasort($dataItems['data'], array($this, 'mySortMethod'));

        $filePath = 'hotel' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'act_check';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->items = $dataItems;
        $view->client = $modelClient->getName();
        $view->bin = $modelClient->getBIN();
        $view->coming = $coming;
        $view->expense = $expense;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getName();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Акт сверки по клиенту.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /** Отчет по приходу и расходу клиентов **/
    public function action_clients_coming_expense(){
        $this->_sitePageData->url = '/hotel/shopexcel/clients_coming_expense';
        set_time_limit(36000);

        $dataClients = array(
            'data' => array(),
            'coming' => 0,
            'expense' => 0,
        );

        /** Расход **/
        $params = Request_RequestParams::setParams(
            array(
                'date_to_from' => Request_RequestParams::getParamDateTime('created_at_from'),
                'date_to_to' => Request_RequestParams::getParamDateTime('created_at_to'),
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
            )
        );

        // расход
        $ids = Request_Request::find('DB_Hotel_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name')));

        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];

            if (!key_exists($shopClientID, $dataClients['data'])){
                $dataClients['data'][$shopClientID] = array(
                    'name' => Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_client_id.name', ''),
                    'coming' => 0,
                    'expense' => 0,
                );
            }

            $dataClients['data'][$shopClientID]['expense'] += $child->values['amount'];
            $dataClients['expense'] += $child->values['amount'];
        }

        /** Приход **/
        $params = Request_RequestParams::setParams(
            array(
                'paid_at_from' => Request_RequestParams::getParamDateTime('created_at_from'),
                'paid_at_to' => Request_RequestParams::getParamDateTime('created_at_to'),
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                'is_paid' => TRUE,
            )
        );
        $ids = Request_Request::find('DB_Hotel_Shop_Payment', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name')));

        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];

            if (!key_exists($shopClientID, $dataClients['data'])){
                $dataClients['data'][$shopClientID] = array(
                    'name' => Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS. '.shop_client_id.name', ''),
                    'coming' => 0,
                    'expense' => 0,
                );
            }

            $dataClients['data'][$shopClientID]['coming'] += $child->values['amount'];
            $dataClients['coming'] += $child->values['amount'];
        }

        uasort($dataClients['data'], array($this, 'mySortMethod'));

        $filePath = 'hotel' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'clients_coming_expense';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->clients = $dataClients;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по приходу и расходу клиентов.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /** Отчет Задолженность АБ1 **/
    public function action_bills_not_finish(){
        $this->_sitePageData->url = '/hotel/shopexcel/bills_not_finish';
        set_time_limit(36000);

        $ids = Request_Request::find('DB_Hotel_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('date_to_from' => Request_RequestParams::getParamDateTime('date'), 'paid_amount_from' => 0,
                'sort_by' => array('value' => array('date_from' => 'asc'))), 0, TRUE,
            array('shop_client_id' => array('name')));

        $dataBills = array(
            'data' => array(),
            'paid_amount' => 0,
        );
        foreach ($ids->childs as $child){
            // собираем оплаты в строчку
            $payments = '';
            $paymentIDs = Request_Request::find('DB_Hotel_Shop_Payment', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array(
                    'shop_bill_id' => $child->id,
                    'is_paid' => true,
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                ),
                0, TRUE
            );

            foreach ($paymentIDs->childs as $paymentID){
                $payments = $payments . Helpers_DateTime::getDateFormatRus($paymentID->values['paid_at']) ."\r\n";
            }

            $dataBills['data'][] = array(
                'date_from' => $child->values['date_from'],
                'date_to' => $child->values['date_to'],
                'client' => Arr::path($child->values, Model_Hotel_Shop_Room::FIELD_ELEMENTS.'.shop_client_id.name', ''),
                'paid_amount' => $child->values['paid_amount'],
                'paid_date' => $payments,
            );

            $dataBills['paid_amount'] += $child->values['paid_amount'];
        }

        $filePath = 'hotel' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'bills_not_finish';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->bills = $dataBills;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет 7 Задолженность АБ1.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /** Отчет 2 Предоплаты по брони **/
    public function action_payments() {
        $this->_sitePageData->url = '/hotel/shopexcel/payments';
        set_time_limit(36000);

        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array('date_from' => 'asc'),
                'date_to_from_equally' => Request_RequestParams::getParamDateTime('period_from'),
                'date_from_to' => Request_RequestParams::getParamDateTime('period_to'),
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                'amount_more_paid_amount' => TRUE,
            )
        );
        $ids = Request_Request::find('DB_Hotel_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name', 'phone')));

        $dataPayments = array(
            'data' => array(),
            'amount' => 0,
            'paid_amount' => 0,
        );
        foreach ($ids->childs as $child){
            // собираем номера в строчку
            $rooms = '';
            $roomIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array(
                    'shop_bill_id' => $child->id,
                    'sort_by' => array('value' => array('shop_room_id.name' => 'asc')),
                    'group_by' => array('value' => array('shop_room_id.name')),
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                ),
                0, TRUE, array('shop_room_id' => array('name')));

            foreach ($roomIDs->childs as $room){
                $rooms = $rooms . Arr::path($room->values, Model_Hotel_Shop_Room::FIELD_ELEMENTS.'.shop_room_id.name', '')."\r\n";
            }

            $dateFrom = $child->values['date_from'];
            if (!key_exists($dateFrom, $dataPayments['data'])){
                $dataPayments['data'][$dateFrom] = array(
                    'data' => array(),
                    'date' => $dateFrom,
                );
            }

            // собираем оплаты в строчку
            $payments = '';
            $paymentIDs = Request_Request::find('DB_Hotel_Shop_Payment', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array(
                    'shop_bill_id' => $child->id,
                    'is_paid' => true,
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                ),
                0, TRUE
            );

            foreach ($paymentIDs->childs as $paymentID){
                $payments = $payments . Helpers_DateTime::getDateFormatRus($paymentID->values['paid_at']) ."\r\n";
            }

            $dataPayments['data'][$dateFrom]['data'][] = array(
                'rooms' => trim($rooms),
                'shop_bill_id' => $child->values['id'],
                'date_from' => $child->values['date_from'],
                'date_to' => $child->values['date_to'],
                'client' => Arr::path($child->values, Model_Hotel_Shop_Room::FIELD_ELEMENTS.'.shop_client_id.name', ''),
                'phone' => Arr::path($child->values, Model_Hotel_Shop_Room::FIELD_ELEMENTS.'.shop_client_id.phone', ''),
                'amount' => $child->values['amount'],
                'paid_amount' => $child->values['paid_amount'],
                'paid_date' => $payments,
            );

            $dataPayments['amount'] += $child->values['amount'];
            $dataPayments['paid_amount'] += $child->values['paid_amount'];
        }

        $filePath = 'hotel' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'payments';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->payments = $dataPayments;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет 2 Предоплаты по брони.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /** По завершенным броням **/
    public function action_payments_finish_bill() {
        $this->_sitePageData->url = '/hotel/shopexcel/payments_finish_bill';
        set_time_limit(36000);

        $dateTo = Request_RequestParams::getParamDateTime('period_to');
        if($dateTo === NULL){
            $dateTo = time();
        }else {
            $dateTo = strtotime($dateTo);
        }
        if ($dateTo > time()){
            $dateTo = time();
        }
        $dateTo = date('Y-m-d', $dateTo);

        $params = Request_RequestParams::setParams(
            array(
                'date_to_from_equally' => Request_RequestParams::getParamDateTime('period_from'),
                'date_to_to' => $dateTo,
                'sort_by' => array('date_from' => 'asc'),
                'is_finish' => TRUE,
            )
        );

        $ids = Request_Request::find('DB_Hotel_Shop_Bill', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name', 'phone', 'bin')));

        $dataPayments = array(
            'data' => array(),
            'amount' => 0,
            'paid_amount' => 0,
        );
        foreach ($ids->childs as $child){
            // собираем номера в строчку
            $rooms = '';
            $roomIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                array(
                    'shop_bill_id' => $child->id,
                    'sort_by' => array('value' => array('shop_room_id.name' => 'asc')),
                    'group_by' => array('value' => array('shop_room_id.name')),
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
                ),
                0, TRUE, array('shop_room_id' => array('name')));

            foreach ($roomIDs->childs as $room){
                $rooms = $rooms . Arr::path($room->values, Model_Hotel_Shop_Room::FIELD_ELEMENTS.'.shop_room_id.name', '')."\r\n";
            }

            $dateFrom = $child->values['date_from'];
            if (!key_exists($dateFrom, $dataPayments['data'])){
                $dataPayments['data'][$dateFrom] = array(
                    'data' => array(),
                    'date' => $dateFrom,
                );
            }

            $dataPayments['data'][$dateFrom]['data'][] = array(
                'rooms' => trim($rooms),
                'shop_bill_id' => $child->id,
                'date_from' => $child->values['date_from'],
                'date_to' => $child->values['date_to'],
                'client' => $child->getElementValue('shop_client_id'),
                'bin' => $child->getElementValue('shop_client_id', 'bin'),
                'phone' => $child->getElementValue('shop_client_id', 'phone'),
                'amount' => $child->values['amount'],
                'paid_amount' => $child->values['paid_amount'],
            );

            $dataPayments['amount'] += $child->values['amount'];
            $dataPayments['paid_amount'] += $child->values['paid_amount'];
        }

        $filePath = 'hotel' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'payments_finish_bill';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->payments = $dataPayments;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет 6 По завершенным броням.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /** Отчет 1 Календарь бронирования **/
    public function action_rooms_clients() {
        $this->_sitePageData->url = '/hotel/shopexcel/rooms_clients';
        set_time_limit(36000);

        $from = strtotime(Request_RequestParams::getParamDateTime('period_from'));
        $to = strtotime(Request_RequestParams::getParamDateTime('period_to'));

        $dates = array();
        for ($d = $from; $d <= $to; $d=$d+24*60*60 ){
            $s = date('Y-m-d', $d);
            $dates[$s] = array(
                'date' => $s,
                'client' => '',
                'phone' => '',
                'paid_amount' => '0',
            );
        }

        $roomIDs = Request_Request::find(
            'DB_Hotel_Shop_Room', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $rooms = array(
            'data' => array(),
        );
        foreach ($roomIDs->childs as $child){
            $rooms['data'][$child->id] = array(
                'name' => $child->values['name'],
                'data' => array(),
            );
        }

        $billItemsIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(), 0, TRUE, array('shop_client_id' => array('name', 'phone'), 'shop_bill_id' => array('paid_amount')));

        $dataBillItems = array(
            'data' => $rooms['data'],
            'count' => 0,
        );
        foreach ($dataBillItems['data'] as $key =>  $child){
            $dataBillItems['data'][$key]['data'] = $dates;
        }

        foreach ($billItemsIDs->childs as $child){
            $room = $child->values['shop_room_id'];

            $fromItem = strtotime($child->values['date_from']);
            if($fromItem < $from){
                $fromItem = $from;
            }
            $toItem  = strtotime($child->values['date_to']);
            if($toItem > $to){
                $toItem = $to;
            }

            $client = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.name', '');
            if(empty($client)){
                $client = 'Без ФИО';
            }
            $phone = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.phone', '');
            $paidAmount = Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_bill_id.paid_amount', '');
            for ($d = $fromItem ; $d <= $toItem ; $d = $d + 24 * 60 * 60 ){
                $date = date('Y-m-d', $d);
                $dataBillItems['data'][$room]['data'][$date]['client'] = $client;
                $dataBillItems['data'][$room]['data'][$date]['phone'] = $phone;
                $dataBillItems['data'][$room]['data'][$date]['paid_amount'] = $paidAmount;
            }
        }

        $filePath = 'hotel' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'rooms_clients';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->billItems = $dataBillItems;
        $view->dates = array('data' => $dates);
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет Календарь бронирования.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    public function action_cash_book() {
        $this->_sitePageData->url = '/hotel/shopexcel/cash_book';

        $cashBook = array();
        $cashBook['created_at_from'] = Request_RequestParams::getParamDateTime('created_at_from');
        if (($cashBook['created_at_from'] === NULL) || (strtotime($cashBook['created_at_from']) < strtotime(self::BASIC_DATE))){
            $cashBook['created_at_from'] = self::BASIC_DATE;
        }

        $cashBook['created_at_from_str'] = Helpers_DateTime::getDateTimeDayMonthRus($cashBook['created_at_from'], TRUE);

        $cashBook['created_at_to'] = Request_RequestParams::getParamDateTime('created_at_to');
        $cashBook['created_at_to_str'] = Helpers_DateTime::getDateTimeDayMonthRus($cashBook['created_at_to'], TRUE);

        $cashBook['coming_from'] = self::BASIC_COMING;
        $cashBook['expense_from'] = self::BASIC_EXPENSE;

        // Получаем все приходники оплаченные за прошлый период
        $params = array(
            'paid_at_from_equally' => self::BASIC_DATE,
            'paid_at_to' => Helpers_DateTime::minusDays($cashBook['created_at_from'], 1),
            Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
            'shop_paid_type_id' => array(899),
            'sum_amount' => TRUE,
        );
        $shopPaymentIDs = Request_Request::find('DB_Hotel_Shop_Payment', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE);
        $cashBook['coming_from'] += floatval($shopPaymentIDs->childs[0]->values['amount']);

        // Получаем все приходники оплаченные в данный период
        $params = array(
            'paid_at_from_equally' => $cashBook['created_at_from'],
            'paid_at_to' => $cashBook['created_at_to'],
            Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
            'shop_paid_type_id' => array(899),
        );
        $shopPaymentIDs = Request_Request::find('DB_Hotel_Shop_Payment', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE, array('shop_client_id' => array('name')));

        $cashBookItems = array();

        $amount = 0;
        foreach ($shopPaymentIDs->childs as $child){
            $cashBookItems[] = array(
                'name' => $child->values['paid_at'],
                'title' => 'Приходный кассовый ордер '.$child->values['number'].' ('.Helpers_DateTime::getDateFormatRus($child->values['paid_at']).')',
                'from' => Arr::path($child->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.name', ''),
                'number' => '3510',
                'coming' => $child->values['amount'],
                'expense' => '',
                'date' => $child->values['paid_at'],
                'number_1c' => $child->values['number'],
            );

            $amount += $child->values['amount'];
        }
        $cashBook['coming'] = $amount;
        $cashBook['payment_count_str'] = Func::numberToStr(count($shopPaymentIDs->childs));

        // Получаем все расходники созданные за прошлый период
        $params = array(
            'created_at_from_equally' => self::BASIC_DATE,
            'created_at_to' => Helpers_DateTime::minusDays($cashBook['created_at_from'], 1),
            Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
            'sum_amount' => TRUE,
        );
        $shopConsumableIDs = Request_Request::find('DB_Hotel_Shop_Consumable', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE);
        $cashBook['expense_from'] += floatval($shopConsumableIDs->childs[0]->values['amount']);

        // Получаем все расходники созданные в данный период
        $params = array(
            'created_at_from_equally' => $cashBook['created_at_from'],
            'created_at_to' => $cashBook['created_at_to'],
            Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE,
        );
        $shopConsumableIDs = Request_Request::find('DB_Hotel_Shop_Consumable',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE
        );

        $amount = 0;
        foreach ($shopConsumableIDs->childs as $child){
            $cashBookItems[] = array(
                'name' => $child->values['created_at'],
                'title' => 'Расходный кассовый ордер '.$child->values['number'].' ('.Helpers_DateTime::getDateFormatRus($child->values['created_at']).')',
                'from' => $child->values['extradite'],
                'number' => $child->values['code'],
                'coming' => '',
                'expense' => $child->values['amount'],
                'date' => $child->values['created_at'],
                'number_1c' => $child->values['number'],
            );

            $amount += $child->values['amount'];
        }
        $cashBook['expense'] = $amount;
        $cashBook['consumable_count_str'] = Func::numberToStr(count($shopConsumableIDs->childs));

        $cashBook['expense_to'] = $cashBook['expense'] + $cashBook['expense_from'];
        $cashBook['coming_to'] = $cashBook['coming'] + $cashBook['coming_from'];

        if ($cashBook['expense_to'] > $cashBook['coming_to']){
            $cashBook['expense_to'] = $cashBook['expense_to'] - $cashBook['coming_to'];
            $cashBook['coming_to'] = '';
        }elseif ($cashBook['expense_to'] < $cashBook['coming_to']){
            $cashBook['coming_to'] = $cashBook['coming_to'] - $cashBook['expense_to'];
            $cashBook['expense_to'] = '';
        }else{
            $cashBook['expense_to'] = '';
            $cashBook['coming_to'] = '';
        }

        if ($cashBook['expense_from'] > $cashBook['coming_from']){
            $cashBook['expense_from'] = $cashBook['expense_from'] - $cashBook['coming_from'];
            $cashBook['coming_from'] = '';
        }elseif ($cashBook['expense_from'] < $cashBook['coming_from']){
            $cashBook['coming_from'] = $cashBook['coming_from'] - $cashBook['expense_from'];
            $cashBook['expense_from'] = '';
        }else{
            $cashBook['expense_from'] = '';
            $cashBook['coming_from'] = '';
        }

        uasort($cashBookItems, array($this, 'cashBookSortMethod'));

        $filePath = 'hotel' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $viewObject = $filePath . 'cash_book';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->cashBook = $cashBook;
        $view->operation = $this->_sitePageData->operation->getName();
        $view->shop = $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        $view->cashBookItems = array('data' => $cashBookItems);
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        header('Content-Disposition: attachment;filename="Касса за период с '.Helpers_DateTime::getDateFormatRus($cashBook['created_at_from']).' по '.Helpers_DateTime::getDateFormatRus($cashBook['created_at_to']).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();


        $n = ceil(count($cashBookItems) / 100);
        if($n < 1){
            $n = 1;
        }

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'hotel' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $filePath = $filePath . 'cash_book' . DIRECTORY_SEPARATOR . $n . '.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon "'.$filePath.'" not is found.');
        }

        Helpers_Excel::saleInFile($filePath,
            array(
                'cash_book' => $cashBook,
                'operation' => array('name' => $this->_sitePageData->operation->getName()),
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array(
                'cash_book_items' => $cashBookItems,
            ),
            'php://output',
            'Касса за период с '.Helpers_DateTime::getDateFormatRus($cashBook['created_at_from']).' по '.Helpers_DateTime::getDateFormatRus($cashBook['created_at_to']).'.xls'
        );

        exit();
    }

    public function action_consumable() {
        $this->_sitePageData->url = '/hotel/shopexcel/consumable';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'hotel' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $filePath = $filePath . 'consumable.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Consumable not is found!');
        }else {
            $model = new Model_Hotel_Shop_Consumable();
            if (!$this->getDBObject($model, $id)) {
                throw new HTTP_Exception_404('Consumable not is found!');
            }
        }

        $consumable = $model->getValues(TRUE, TRUE);
        $consumable['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $consumable['created_at'] = strftime('%d.%m.%Y %H:%M', strtotime($model->getCreatedAt()));

        Helpers_Excel::saleInFile(
            $filePath,
            array(
                'consumable' => $consumable,
                'operation' => array('name' => $this->_sitePageData->operation->getName()
                )
            ),
            array(),
            'php://output',
            'consumable.xls'
        );

        exit();
    }

    public function action_payment_order() {
        $this->_sitePageData->url = '/hotel/shopexcel/payment_order';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Hotel_Shop_Payment();
        $model->setDBDriver($this->_driverDB);
        if (!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Payment not is found!');
        }

        $model->dbGetElements($this->_sitePageData->shopMainID, array('shop_client_id'), $this->_sitePageData->languageIDDefault);

        $invoice = $model->getValues(TRUE, TRUE);
        $invoice['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $invoice['created_at'] = strftime('%d.%m.%Y', strtotime($model->getCreatedAt()));
        $invoice['created_at_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getCreatedAt(), TRUE);
        $invoice['date'] = strftime('%d.%m.%Y', strtotime($model->getCreatedAt()));
        $invoice['date_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getCreatedAt(), TRUE);
        $invoice['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);

        $text = '';
        // получаем товары и услуги
        $shopPaymentItemIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_bill_id' => $model->getShopBillID(), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE, array('shop_room_id' => array('name')));
        foreach($shopPaymentItemIDs->childs as &$shopPaymentItemID){
            if ($shopPaymentItemID->values['date_from'] == $shopPaymentItemID->values['date_to']){
                $s = Helpers_DateTime::getDateFormatRus($shopPaymentItemID->values['date_from']);
            }else{
                $s = 'за период c '.Helpers_DateTime::getDateFormatRus($shopPaymentItemID->values['date_from']).' по '.Helpers_DateTime::getDateFormatRus($shopPaymentItemID->values['date_to']);
            }
            $text .= $shopPaymentItemID->values[Model_Basic_BasicObject::FIELD_ELEMENTS]['shop_room_id']['name'] . ', '.$s . ', ';
        }

        $shopBillServiceIDs = Request_Request::find('DB_Hotel_Shop_Bill_Service', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_bill_id' => $model->getShopBillID(), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE, array('shop_service_id' => array('name')));
        foreach($shopBillServiceIDs->childs as $shopBillServiceID){
            $text .= $shopBillServiceID->values[Model_Basic_BasicObject::FIELD_ELEMENTS]['shop_service_id']['name'] . ', ';
        }
        $invoice['text'] = $text;

        $invoice['count'] = count($shopPaymentItemIDs->childs) + count($shopBillServiceIDs->childs);

        $this->_sitePageData->shop->getElement('requisites_bank_id', TRUE, $this->_sitePageData->shopID);

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'hotel' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        $filePath = $filePath . 'payment_order.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        Helpers_Excel::saleInFile($filePath,
            array(
                'payment_order' => $invoice,
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array(),
            'php://output',
            'Платежное поручение №'.$model->getNumber().'.xls'
        );

        exit();
    }

    public function action_pko() {
        $this->_sitePageData->url = '/hotel/shopexcel/pko';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'hotel' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . 'pko.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Hotel_Shop_Payment();
        $model->setDBDriver($this->_driverDB);
        if (!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Payment not is found!');
        }

        $model->getElement('shop_client_id', TRUE, $this->_sitePageData->shopID);

        $payment = $model->getValues(TRUE, TRUE);
        $payment['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $payment['created_at'] = Helpers_DateTime::getDateFormatRus($model->getPaidAt());
        $payment['created_at_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getPaidAt(), TRUE);
        $payment['date'] = Helpers_DateTime::getDateFormatRus($model->getPaidAt());
        $payment['date_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getPaidAt(), TRUE);
        $payment['amount_nds'] = Func::getNumberStr(round($payment['amount'] / 112 * 12, 2), TRUE, 2, FALSE);
        $payment['amount'] = Func::getNumberStr($payment['amount'], TRUE, 2, FALSE);
        $payment['contract_str'] = 'без договора';

        $text = '';
        // получаем товары и услуги
        $shopPaymentItemIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_bill_id' => $model->getShopBillID(), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE, array('shop_room_id' => array('name')));
        foreach($shopPaymentItemIDs->childs as &$shopPaymentItemID){
            if ($shopPaymentItemID->values['date_from'] == $shopPaymentItemID->values['date_to']){
                $s = Helpers_DateTime::getDateFormatRus($shopPaymentItemID->values['date_from']);
            }else{
                $s = 'за период c '.Helpers_DateTime::getDateFormatRus($shopPaymentItemID->values['date_from']).' по '.Helpers_DateTime::getDateFormatRus(Helpers_DateTime::plusDays($shopPaymentItemID->values['date_to'], 1));
            }
            $text .= $shopPaymentItemID->values[Model_Basic_BasicObject::FIELD_ELEMENTS]['shop_room_id']['name'] . ', '.$s . ', ';
        }

        $shopBillServiceIDs = Request_Request::find('DB_Hotel_Shop_Bill_Service', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_bill_id' => $model->getShopBillID(), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE, array('shop_service_id' => array('name')));
        foreach($shopBillServiceIDs->childs as $shopBillServiceID){
            $text .= $shopBillServiceID->values[Model_Basic_BasicObject::FIELD_ELEMENTS]['shop_service_id']['name'] . ', ';
        }

        $payment['text'] = mb_substr($text, 0, -2);

        Helpers_Excel::saleInFile($filePath,
            array(
                'payment' => $payment,
                'operation' => array('name' => $this->_sitePageData->operation->getName()),
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array(),
            'php://output',
            'ПКО №'.$model->getNumber().'.xls'
        );

        exit();
    }

    public function action_invoice_proforma() {
        $this->_sitePageData->url = '/hotel/shopexcel/invoice_proforma';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'hotel' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . 'invoice_proforma.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Hotel_Shop_Payment();
        $model->setDBDriver($this->_driverDB);
        if (!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Payment not is found!');
        }

        $model->getElement('shop_client_id', TRUE, $this->_sitePageData->shopID)->getElement('bank_id', TRUE, $this->_sitePageData->shopID);

        $invoice = $model->getValues(TRUE, TRUE);
        $invoice['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $invoice['created_at'] = strftime('%d.%m.%Y', strtotime($model->getCreatedAt()));
        $invoice['created_at_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getCreatedAt(), TRUE);
        $invoice['date'] = strftime('%d.%m.%Y', strtotime($model->getCreatedAt()));
        $invoice['date_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getCreatedAt(), TRUE);
        $invoice['amount_nds'] = Func::getNumberStr(round($invoice['amount']/112*12, 2), TRUE, 2, FALSE);
        $invoice['amount'] = Func::getNumberStr($invoice['amount'], TRUE, 2, FALSE);
        $invoice['contract_str'] = 'без договора';

        // получаем товары и услуги
        $shopInvoiceItemIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_bill_id' => $model->getShopBillID(), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE, array('shop_room_id' => array('name')));
        foreach($shopInvoiceItemIDs->childs as &$shopInvoiceItemID){
            if ($shopInvoiceItemID->values['date_from'] == $shopInvoiceItemID->values['date_to']){
                $s = Helpers_DateTime::getDateFormatRus($shopInvoiceItemID->values['date_from']);
            }else{
                $s = 'за период c '.Helpers_DateTime::getDateFormatRus($shopInvoiceItemID->values['date_from']).' по '.Helpers_DateTime::getDateFormatRus($shopInvoiceItemID->values['date_to']);
            }
            $shopInvoiceItemID->values[Model_Basic_BasicObject::FIELD_ELEMENTS]['shop_room_id']['name'] .= ', '.$s;
        }

        $shopBillServiceIDs = Request_Request::find('DB_Hotel_Shop_Bill_Service', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_bill_id' => $model->getShopBillID(), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE, array('shop_service_id' => array('name')));

        $shopInvoiceItemIDs->childs = array_merge($shopInvoiceItemIDs->childs, $shopBillServiceIDs->childs);

        $shopInvoiceItems = array();
        foreach($shopInvoiceItemIDs->childs as $shopInvoiceItemID){
            $shopInvoiceItemID->values['quantity'] = 1;
            $shopInvoiceItems[] = $shopInvoiceItemID->values;
        }

        $invoice['line_count'] = count($shopInvoiceItems);

        $this->_sitePageData->shop->getElement('requisites_bank_id', TRUE, $this->_sitePageData->shopID);
        Helpers_Excel::saleInFile($filePath,
            array(
                'invoice' => $invoice,
                'operation' => array('name' => $this->_sitePageData->operation->getName()),
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array('invoice_items' => $shopInvoiceItems),
            'php://output',
            'Счет на оплату №'.$model->getNumber().'.xls'
        );

        exit();
    }

    public function action_act_service() {
        $this->_sitePageData->url = '/tax/shopexcel/act_service';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'hotel' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . 'act_service.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Hotel_Shop_Bill();
        $model->setDBDriver($this->_driverDB);
        if (!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Bill not is found!');
        }

        $model->getElement('shop_client_id', TRUE, $this->_sitePageData->shopID);

        $invoice = $model->getValues(TRUE, TRUE);
        $invoice['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $invoice['created_at'] = strftime('%d.%m.%Y', strtotime($model->getDateTo()));
        $invoice['created_at_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getDateTo(), TRUE);
        $invoice['date'] = date('%d.%m.%Y');
        $invoice['date_str'] = Helpers_DateTime::getDateTimeDayMonthRus(date('%d.%m.%Y'), TRUE);
        $invoice['attorney_str'] = 'без доверенности';
        $invoice['contract_str'] = 'без договора';


        // получаем товары и услуги
        $shopInvoiceItemIDs = Request_Request::find('DB_Hotel_Shop_Bill_Item', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_bill_id' => $model->id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE, array('shop_room_id' => array('name')));
        foreach($shopInvoiceItemIDs->childs as &$shopInvoiceItemID){
            if ($shopInvoiceItemID->values['date_from'] == $shopInvoiceItemID->values['date_to']){
                $s = Helpers_DateTime::getDateFormatRus($shopInvoiceItemID->values['date_from']);
            }else{
                $s = 'за период c '.Helpers_DateTime::getDateFormatRus($shopInvoiceItemID->values['date_from']).' по '.Helpers_DateTime::getDateFormatRus($shopInvoiceItemID->values['date_to']);
            }
            $shopInvoiceItemID->values[Model_Basic_BasicObject::FIELD_ELEMENTS]['shop_room_id']['name'] .= ', '.$s;
        }

        $shopBillServiceIDs = Request_Request::find('DB_Hotel_Shop_Bill_Service', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_bill_id' => $model->id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE, array('shop_service_id' => array('name')));

        $shopInvoiceItemIDs->childs = array_merge($shopInvoiceItemIDs->childs, $shopBillServiceIDs->childs);

        $shopInvoiceItems = array();
        foreach($shopInvoiceItemIDs->childs as $shopInvoiceItemID){
            $shopInvoiceItemID->values['quantity'] = 1;
            $shopInvoiceItems[] = $shopInvoiceItemID->values;
        }

        $invoice['service_amount'] = $model->getAmount();
        $invoice['service_quantity'] = count($shopInvoiceItems);
        $invoice['service_count'] = count($shopInvoiceItems);

        $this->_sitePageData->shop->getElement('requisites_bank_id', TRUE, $this->_sitePageData->shopID);
        Helpers_Excel::saleInFile($filePath,
            array(
                'invoice' => $invoice,
                'operation' => array('name' => $this->_sitePageData->operation->getName()),
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array('invoice_services' => $shopInvoiceItems),
            'php://output',
            'Акт выполненных работ №'.$model->getNumber().'.xls'
        );

        exit();
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_ShopReport extends Controller_Magazine_BasicList {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopreport';
        $this->objectName = 'report';

        parent::__construct($request, $response);
    }

    /**
     * сортировка по имени
     * @param $x
     * @param $y
     * @return int
     */
    function mySortMethod($x, $y) {
        return strcasecmp($x['name'], $y['name']);
    }


    /*
     * Отчет по поступлению денежных средств по фискальному регистратору
     */
    public function action_cashbox_days() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/cashbox_days';

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to').' 23:59:59';

        $params = Request_RequestParams::setParams(
            array(
                'created_at_less' => $dateFrom,
                'sum_amount' => TRUE,
                'is_special' =>  Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC,
                'shop_worker_id' => 0,
            )
        );

        /** Сколько денег было прихода на начало **/
        $ids = Request_Request::find('DB_Magazine_Shop_Realization',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        $total = 0;
        if(count($ids->childs) > 0){
            $total = $ids->childs[0]->values['amount'];
        }
        $totalPayment = $total;

        /** Сколько денег было возврата на начало **/
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        if(count($ids->childs) > 0){
            $total -= $ids->childs[0]->values['amount'];
        }

        /** Сколько денег было расхода на начало **/
        $params = Request_RequestParams::setParams(
            array(
                'created_at_less' => $dateFrom,
                'sum_amount' => TRUE,
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Consumable',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        if(count($ids->childs) > 0){
            $total -= $ids->childs[0]->values['amount'];
        }

        /** Группировка по дням **/
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo,
                'sum_amount' => TRUE,
                'is_special' => [
                    Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC,
                    Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT,
                ],
                'group_by' => array(
                    'created_at_date',
                    'is_special',
                    'shop_worker_id',
                ),
                'sort_by' => array(
                    'created_at_date' => 'asc',
                ),
            )
        );

        /** Группировка по дням оплаты **/
        $ids = Request_Request::find('DB_Magazine_Shop_Realization',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );

        $dataDates = array(
            'data' => array(),
            'cash' => 0,
            'special' => 0,
            'worker' => 0,
            'card' => 0,
            'return_cash' => 0,
            'return_card' => 0,
            'consumable' => 0,
        );
        foreach ($ids->childs as $child){
            $date = Helpers_DateTime::getDateFormatPHP($child->values['created_at_date']);
            $amount = $child->values['amount'];

            if(!key_exists($date, $dataDates['data'])){
                $dataDates['data'][$date] = array(
                    'date' => $date,
                    'from' => 0,
                    'from_all' => 0,
                    'cash' => 0,
                    'special' => 0,
                    'worker' => 0,
                    'card' => 0,
                    'return_cash' => 0,
                    'return_card' => 0,
                    'consumable' => 0,
                );
            }

            if($child->values['is_special'] == Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT){
                $dataDates['data'][$date]['special'] += $amount;
                $dataDates['special'] += $amount;
            }elseif($child->values['shop_worker_id'] > 0){
                $dataDates['data'][$date]['worker'] += $amount;
                $dataDates['worker'] += $amount;
            }else{
                $dataDates['data'][$date]['cash'] += $amount;
                $dataDates['cash'] += $amount;
            }
        }

        /** Группировка по дням расходники **/
        $ids = Request_Request::find('DB_Magazine_Shop_Consumable',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        foreach ($ids->childs as $child){
            $date = Helpers_DateTime::getDateFormatPHP($child->values['created_at_date']);
            $amount = $child->values['amount'];

            if(!key_exists($date, $dataDates['data'])){
                $dataDates['data'][$date] = array(
                    'date' => $date,
                    'from' => 0,
                    'from_all' => 0,
                    'cash' => 0,
                    'special' => 0,
                    'worker' => 0,
                    'card' => 0,
                    'return_cash' => 0,
                    'return_card' => 0,
                    'consumable' => 0,
                );
            }
            $dataDates['data'][$date]['consumable'] += $amount;
            $dataDates['consumable'] += $amount;
        }

        /** Группировка по дням возврата **/
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        foreach ($ids->childs as $child){
            $date = Helpers_DateTime::getDateFormatPHP($child->values['created_at_date']);
            $amount = $child->values['amount'];

            if(!key_exists($date, $dataDates['data'])){
                $dataDates['data'][$date] = array(
                    'date' => $date,
                    'from' => 0,
                    'from_all' => 0,
                    'cash' => 0,
                    'special' => 0,
                    'worker' => 0,
                    'card' => 0,
                    'return_cash' => 0,
                    'return_card' => 0,
                    'consumable' => 0,
                );
            }

            $dataDates['data'][$date]['return_cash'] += $amount;
            $dataDates['return_cash'] += $amount;
        }

        uasort($dataDates['data'], function ($x, $y) {
            return strcasecmp($x['date'], $y['date']);
        });

        foreach ($dataDates['data'] as &$child) {
            $child['from'] = $total;
            $total = $total + $child['cash'] - $child['return_cash'] - $child['consumable'];

            $child['from_payment'] = $totalPayment;
            $totalPayment = $totalPayment + $child['cash'] + $child['card'];
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/cashbox/days';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->dates = $dataDates;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по поступлению денежных средств по фискальному регистратору за период '.Helpers_DateTime::getDateFormatRus($dateFrom).'-'.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Развернутый отчет по реализации по чекам
     */
    public function action_tax_checks() {
        $this->_sitePageData->url = '/bar/shopreport/tax_checks';

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo . ' 23:59:59',
                'is_special' => [
                    Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC,
                    Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT,
                ]
            )
        );
        $ids = Request_Request::find('DB_Magazine_Shop_Realization',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array('shop_worker_id' => array('name'))
        );

        $dataRealizations = array(
            'data' => array(),
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $amount = $child->values['amount'];

            $dataRealizations['data'][] = array(
                'created_at' => $child->values['created_at'],
                'fiscal_check' => $child->values['fiscal_check'],
                'worker' => $child->getElementValue('shop_worker_id'),
                'amount' => $amount,
            );

            $dataRealizations['amount'] += $amount;
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/realization/tax-checks';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->realizations = $dataRealizations;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->siteData = $this->_sitePageData;
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Развернутый отчет по реализации по чекам с '.Helpers_DateTime::getDateFormatRus($dateFrom).' по '.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Список продукции для оператора в приемки
     */
    public function action_receive_production_barcode_operation() {
        $this->_sitePageData->url = '/bar/shopreport/receive_production_barcode_operation';

        $params = Request_RequestParams::setParams(
            array(
                'shop_receive_id' => Request_RequestParams::getParamInt('shop_receive_id'),
            )
        );
        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_production_id' => array('name', 'barcode'),
            )
        );

        $dataProductions = array(
            'data' => array(),
        );
        foreach ($ids->childs as $child){
            $dataProductions['data'][] = array(
                'name' => $child->getElementValue('shop_production_id'),
                'barcode' => $child->getElementValue('shop_production_id', 'barcode'),
            );
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/production/barcode-operation';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->productions = $dataProductions;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->siteData = $this->_sitePageData;
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Список продукции для оператора.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Список продукции для лотков в приемки
     */
    public function action_receive_production_barcode_tray() {
        $this->_sitePageData->url = '/bar/shopreport/receive_production_barcode_tray';

        $params = Request_RequestParams::setParams(
            array(
                'shop_receive_id' => Request_RequestParams::getParamInt('shop_receive_id'),
            )
        );
        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_production_id' => array('name', 'barcode'),
            )
        );

        $dataProductions = array(
            'data' => array(),
        );
        foreach ($ids->childs as $child){
            $dataProductions['data'][] = array(
                'name' => $child->getElementValue('shop_production_id'),
                'barcode' => $child->getElementValue('shop_production_id', 'barcode'),
            );
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/production/barcode-tray';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->productions = $dataProductions;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->siteData = $this->_sitePageData;
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Список продукции для лотков.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Список продукции для оператора
     */
    public function action_production_barcode_operation() {
        $this->_sitePageData->url = '/bar/shopreport/production_barcode_operation';

        $shopReceiveID = Request_RequestParams::getParamInt('shop_receive_id');
        if($shopReceiveID > 0){

        }else {

        }

        $ids = Request_Request::find('DB_Magazine_Shop_Production',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, array(), 0, TRUE
        );

        $dataProductions = array(
            'data' => array(),
        );
        foreach ($ids->childs as $child){
            $dataProductions['data'][] = array(
                'name' => $child->values['name'],
                'barcode' => $child->values['barcode'],
            );
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/production/barcode-operation';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->productions = $dataProductions;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->siteData = $this->_sitePageData;
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Список продукции для оператора.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Список продукции для лотков
     */
    public function action_production_barcode_tray() {
        $this->_sitePageData->url = '/bar/shopreport/production_barcode_tray';

        $ids = Request_Request::find('DB_Magazine_Shop_Production',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, array(), 0, TRUE
        );

        $dataProductions = array(
            'data' => array(),
        );
        foreach ($ids->childs as $child){
            $dataProductions['data'][] = array(
                'name' => $child->values['name'],
                'barcode' => $child->values['barcode'],
            );
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/production/barcode-tray';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->productions = $dataProductions;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->siteData = $this->_sitePageData;
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Список продукции для лотков.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Акт списания
     */
    public function action_act_write_off() {
        $this->_sitePageData->url = '/bar/shopreport/act_write_off';

        // id записи
        $id = Request_RequestParams::getParamInt('shop_realization_id');
        $model = new Model_Magazine_Shop_Realization();
        if (!$this->getDBObject($model, $id)) {
            throw new HTTP_Exception_404('Realization not is found!');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_realization_id' => $id,
            )
        );
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
            array(
                'shop_production_id' => array('name', 'old_id', 'coefficient'),
                'shop_write_off_type_id' => array('name'),
                'shop_product_id' => array('price_cost', 'unit_id'),
            )
        );

        $dataRealizationItems = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $coefficient = $child->getElementValue('shop_production_id', 'coefficient', 0);
            if($coefficient == 0){
                $coefficient = 1;
            }

            $quantity = round($child->values['quantity'] / $coefficient, 3);
            $price = round($child->values['price'] * $coefficient, 2);
            $amount = round($price * $quantity, 2);

            $unitID = $child->getElementValue('shop_product_id', 'unit_id');
            $modelUnit = new Model_Magazine_Unit();
            $modelUnit->setDBDriver($this->_driverDB);
            Helpers_DB::getDBObject($modelUnit, $unitID, $this->_sitePageData, 0);

            $dataRealizationItems['data'][] = array(
                'name' => $child->getElementValue('shop_production_id'),
                'shop_write_off_type' => $child->getElementValue('shop_write_off_type_id'),
                'old_id' => $child->getElementValue('shop_production_id', 'old_id'),
                'unit' => $modelUnit->getName(),
                'price' => $price,
                'quantity' => $quantity,
                'amount' => $amount,
            );

            $dataRealizationItems['quantity'] += $quantity;
            $dataRealizationItems['amount'] += $amount;
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/realization/act-write-off';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->realization = $model->getValues();
        $view->realizationItems = $dataRealizationItems;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->siteData = $this->_sitePageData;
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Акт списания №'.$model->id.'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Расходно-кассовый ордер
     */
    public function action_consumable_one() {
        $this->_sitePageData->url = '/bar/shopreport/consumable_one';

        // id записи
        $id = Request_RequestParams::getParamInt('shop_consumable_id');
        $model = new Model_Magazine_Shop_Consumable();
        if (!$this->getDBObject($model, $id)) {
            throw new HTTP_Exception_404('Consumable not is found!');
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/consumable/one';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->consumable = $model->getValues();
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->siteData = $this->_sitePageData;
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Передача выручки №'.$model->getNumber().'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет по движению денег
     */
    public function action_cashbox_index() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/cashbox_index';

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');

        $total = 0;

        /** Сколько денег было прихода на начало **/
        $params = Request_RequestParams::setParams(
            array(
                'created_at_to' => Helpers_DateTime::minusSeconds($dateFrom, 1),
                'sum_amount' => TRUE,
                'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC,
                'shop_worker_id' => 0,
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        if(count($ids->childs) > 0){
            $total = $ids->childs[0]->values['amount'];
        }

        /** Сколько денег было возврата на начало **/
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        if(count($ids->childs) > 0){
            $total -= $ids->childs[0]->values['amount'];
        }

        /** Сколько денег было расхода на начало **/
        $params = Request_RequestParams::setParams(
            array(
                'created_at_to' => Helpers_DateTime::minusSeconds($dateFrom, 1),
                'sum_amount' => TRUE
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Consumable',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        if(count($ids->childs) > 0){
            $total -= $ids->childs[0]->values['amount'];
        }

        /** Группировка по дням реализации **/
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'sum_amount' => TRUE,
                'group_by' => array(
                    'created_at_date',
                    'is_special',
                    'shop_worker_id',
                    'shop_write_off_type_id',
                ),
                'sort_by' => array(
                    'created_at_date' => 'asc',
                ),
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );

        $dataDates = array(
            'data' => array(),
            'cache' => 0,
            'workers' => 0,
            'special' => 0,
            'cache_out' => 0,
            'return' => 0,
        );
        foreach ($ids->childs as $child){
            $date = Helpers_DateTime::getDateFormatPHP($child->values['created_at_date']);
            $amount = $child->values['amount'];

            if(!key_exists($date, $dataDates['data'])){
                $dataDates['data'][$date] = array(
                    'date' => $date,
                    'from' => 0,
                    'cache' => 0,
                    'workers' => 0,
                    'special' => 0,
                    'cache_out' => 0,
                    'return' => 0,
                );
            }

            switch ($child->values['is_special']){
                case Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC:
                    if($child->values['shop_worker_id'] > 0) {
                        $dataDates['data'][$date]['workers'] += $amount;
                        $dataDates['workers'] += $amount;
                    }else {
                        $dataDates['data'][$date]['cache'] += $amount;
                        $dataDates['cache'] += $amount;
                    }
                    break;
                case Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF:
                    if($child->values['shop_write_off_type_id'] == Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_REDRESS) {
                        $dataDates['data'][$date]['workers'] += $amount;
                        $dataDates['workers'] += $amount;
                    }
                    break;
                case Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT:
                    $dataDates['data'][$date]['special'] += $amount;
                    $dataDates['special'] += $amount;
                    break;
            }
        }

        /** Группировка по дням расходники **/
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'sum_amount' => TRUE,
                'group_by' => array(
                    'created_at_date',
                ),
                'sort_by' => array(
                    'created_at_date' => 'asc',
                ),
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Consumable',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        foreach ($ids->childs as $child){
            $date = Helpers_DateTime::getDateFormatPHP($child->values['created_at_date']);
            $amount = $child->values['amount'];

            if(!key_exists($date, $dataDates['data'])){
                $dataDates['data'][$date] = array(
                    'date' => $date,
                    'from' => 0,
                    'cache' => 0,
                    'workers' => 0,
                    'special' => 0,
                    'cache_out' => 0,
                    'return' => 0,
                );
            }
            $dataDates['data'][$date]['cache_out'] += $amount;
            $dataDates['cache_out'] += $amount;
        }

        /** Группировка по дням возврата **/
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'sum_amount' => TRUE,
                'group_by' => array(
                    'created_at_date',
                ),
                'sort_by' => array(
                    'created_at_date' => 'asc',
                ),
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        foreach ($ids->childs as $child){
            $date = Helpers_DateTime::getDateFormatPHP($child->values['created_at_date']);
            $amount = $child->values['amount'];

            if(!key_exists($date, $dataDates['data'])){
                $dataDates['data'][$date] = array(
                    'date' => $date,
                    'from' => 0,
                    'cache' => 0,
                    'workers' => 0,
                    'special' => 0,
                    'cache_out' => 0,
                    'return' => 0,
                );
            }
            $dataDates['data'][$date]['return'] += $amount;
            $dataDates['return'] += $amount;
        }

        uasort($dataDates['data'], function ($x, $y) {
            return strcasecmp($x['date'], $y['date']);
        });

        foreach ($dataDates['data'] as &$child) {
            $child['from'] = $total;
            $total = $total + $child['cache'] - $child['cache_out'] - $child['return'];
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/cashbox/index';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->dates = $dataDates;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по движению денег за период '.Helpers_DateTime::getDateFormatRus($dateFrom).'-'.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет Ведомость удержаний
     */
    public function action_realization_special_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/realization_special_list';

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'sum_amount' => TRUE,
                'is_special' => [Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC, Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF],
                'shop_worker_id_from' => 0,
                'shop_write_off_type_id' => [0, Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_REDRESS],
                'group_by' => array(
                    'created_at_date',
                    'shop_worker_id', 'shop_worker_id.name',
                ),
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_worker_id' => array('name'),
            )
        );

        $dataWorkers = array(
            'data' => array(),
            'amount' => 0,
        );
        $dataDates = array(
            'data' => array(),
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $worker = $child->values['shop_worker_id'];
            $amount = $child->values['amount'];
            $date = Helpers_DateTime::getDateFormatPHP($child->values['created_at_date']);

            if(!key_exists($worker, $dataWorkers['data'])) {
                $dataWorkers['data'][$worker] = array(
                    'name' => $child->getElementValue('shop_worker_id'),
                    'dates' => array(),
                    'amount' => 0,
                );
            }

            if(!key_exists($date, $dataWorkers['data'][$worker]['dates'])){
                $dataWorkers['data'][$worker]['dates'][$date] = $amount;
            }else{
                $dataWorkers['data'][$worker]['dates'][$date] += $amount;
            }
            $dataWorkers['data'][$worker]['amount'] += $amount;
            $dataWorkers['amount'] += $amount;

            if(!key_exists($date, $dataDates['data'])){
                $dataDates['data'][$date] = array(
                    'date' => $date,
                    'amount' => $amount,
                );
            }else{
                $dataDates['data'][$date]['amount'] += $amount;
            }
            $dataDates['amount'] += $amount;
        }
        uasort($dataWorkers['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        uasort($dataDates['data'], function ($x, $y) {
            return strcasecmp($x['date'], $y['date']);
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/realization/special-list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->workers = $dataWorkers;
        $view->dates = $dataDates;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Ведомость удержаний за период '.Helpers_DateTime::getDateFormatRus($dateFrom).'-'.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет приемки по поставщикам
     */
    public function action_receive_supplier() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/receive_supplier';

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'shop_supplier_id' => Request_RequestParams::getParamInt('shop_supplier_id'),
                'sort_by' => array(
                    'created_at' => 'asc',
                    'shop_supplier_id.name' => 'asc',
                ),
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Receive',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_supplier_id' => array('name'),
            )
        );

        $dataSuppliers = array(
            'data' => array(),
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $dataSuppliers['data'][] = array(
                'name' => $child->getElementValue('shop_supplier_id'),
                'amount' => $child->values['amount'],
                'date' => $child->values['created_at'],
            );
            $dataSuppliers['amount'] += $child->values['amount'];
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/receive/supplier';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->suppliers = $dataSuppliers;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет приемки по поставщикам за период с '.Helpers_DateTime::getDateTimeFormatRusMonthStr($dateFrom).' по '.Helpers_DateTime::getDateTimeFormatRusMonthStr($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет по талонам поиск по дате реализации
     */
    public function action_talon_list_period() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/talon_list_period';


        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');

        if($dateFrom != null && $dateTo != null){
            $dateTo = $dateTo . ' 23:59:59';

            $periodFrom = $dateFrom;
            $periodTo = $dateTo;
        }else{
            $month = Request_RequestParams::getParamInt('month');
            $year = Request_RequestParams::getParamInt('year');

            $dateFrom = Helpers_DateTime::getMonthBeginStr($month, $year);
            $dateTo = Helpers_DateTime::plusDays(Helpers_DateTime::getMonthEndStr($month, $year), 1);

            $periodFrom = $dateFrom;
            $periodTo = Helpers_DateTime::getMonthEndStr($month, $year) . '23:59:59';
        }


        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT,
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'shop_worker_id', 'shop_worker_id.name'
                ),
                'sort_by' => array(
                    'shop_worker_id.name' => 'asc',
                )
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            0, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_worker_id' => array('name'),
            )
        );

        $dataWorkers = array(
            'data' => array(),
            'quantity_spent' => 0,
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $shopWorkerID = $child->values['shop_worker_id'];
            if(!key_exists($shopWorkerID, $dataWorkers['data'])){
                $dataWorkers['data'][$shopWorkerID] = array(
                    'name' => $child->getElementValue('shop_worker_id'),
                    'quantity_spent' => 0,
                    'quantity' => 0,
                );
            }

            $quantity = $child->values['quantity'] * 2;
            $dataWorkers['data'][$shopWorkerID]['quantity_spent'] += $quantity;
            $dataWorkers['quantity_spent'] += $quantity;
        }

        // лимит талонов
        $params = Request_RequestParams::setParams(
            array(
                'period_from' => $periodFrom,
                'period_to' => $periodTo,
                'sum_quantity' => true,
                'group_by' => array(
                    'shop_worker_id', 'shop_worker_id.name',
                    'date',
                ),
                'validity' => $periodTo,
            )
        );
        $ids = Request_Request::find('DB_Magazine_Shop_Talon',
            0, $this->_sitePageData, $this->_driverDB, $params, 0, true,
            array(
                'shop_worker_id' => array('name'),
            )
        );

        $months = array();
        foreach ($ids->childs as $child){
            $shopWorkerID = $child->values['shop_worker_id'];
            if(!key_exists($shopWorkerID, $dataWorkers['data'])){
                $dataWorkers['data'][$shopWorkerID] = array(
                    'name' => $child->getElementValue('shop_worker_id'),
                    'quantity_spent' => 0,
                    'quantity' => 0,
                );
            }

            $dataWorkers['data'][$shopWorkerID]['quantity'] += $child->values['quantity'];
            $dataWorkers['quantity'] += $child->values['quantity'];

            $date = $child->values['date'];
            if(!key_exists($date, $months)) {
                $months[$date] = Helpers_DateTime::getMonthRusStr(Helpers_DateTime::getMonth($date), false);
            }
        }

        $months = implode(', ', $months);

        uasort($dataWorkers['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/talon/list-period';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->workers = $dataWorkers;
        $view->months = $months;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по талонам за '.Helpers_DateTime::getPeriodRus($dateFrom, $dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет по талонам
     */
    public function action_talon_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/talon_list';

        $month = Request_RequestParams::getParamInt('month');
        $year = Request_RequestParams::getParamInt('year');
        $params = Request_RequestParams::setParams(
            array(
                'month' => $month,
                'year' => $year,
                'sort_by' => array(
                    'shop_worker_id.name' => 'asc',
                )
            )
        );

        $ids = Request_Request::find(
            'DB_Magazine_Shop_Talon',
            0, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_worker_id' => array('name'),
            )
        );

        $dataWorkers = array(
            'data' => array(),
            'quantity' => 0,
            'quantity_spent' => 0,
            'quantity_balance' => 0,
        );
        foreach ($ids->childs as $child){
            $dataWorkers['data'][] = array(
                'name' => $child->getElementValue('shop_worker_id'),
                'quantity' => $child->values['quantity'],
                'quantity_spent' => $child->values['quantity_spent'],
                'quantity_balance' => $child->values['quantity_balance'],
            );
            $dataWorkers['quantity'] += $child->values['quantity'];
            $dataWorkers['quantity_spent'] += $child->values['quantity_spent'];
            $dataWorkers['quantity_balance'] += $child->values['quantity_balance'];
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/talon/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->workers = $dataWorkers;
        $view->month = $month;
        $view->year = $year;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по талонам за '.Helpers_DateTime::getMonthRusStr($month).' '.$year.' г.'.'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Материальный отчет по товарам
     */
    public function action_total() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/total';

        $dateFrom = Request_RequestParams::getParamDate('date_from');
        if($dateFrom === NULL){
            $dateFrom = date('Y-m').'-01';
        }
        $this->_sitePageData->urlParams['date_from'] = $dateFrom;

        $dateTo = Request_RequestParams::getParamDate('date_to');
        if($dateTo === NULL){
            $dateTo = Helpers_DateTime::getMonthEndStr(date('m'), date('Y'));
        }
        $this->_sitePageData->urlParams['date_to'] = $dateTo;

        $shopProductIDs = Api_Magazine_Shop_Total::getShopProductTotal(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB
        );

        $dataProducts = array(
            'data' => array(),
            'stock_from' => 0,
            'receive' => 0,
            'move_receive' => 0,
            'realization' => 0,
            'realization_return' => 0,
            'return' => 0,
            'move_expense' => 0,
            'write_off' => 0,
            'adjustment' => 0,
            'stock_to' => 0,
        );
        foreach ($shopProductIDs->childs as $child){

            $dataProducts['data'][] = array(
                'name' => $child->values['name'],
                'stock_from' => Arr::path($child->additionDatas, 'stock_from', ''),
                'receive' => Arr::path($child->additionDatas, 'receive', ''),
                'move_receive' => Arr::path($child->additionDatas, 'move_receive', ''),
                'realization' => Arr::path($child->additionDatas, 'realization', ''),
                'realization_return' => Arr::path($child->additionDatas, 'realization_return', ''),
                'return' => Arr::path($child->additionDatas, 'return', ''),
                'move_expense' => Arr::path($child->additionDatas, 'move_expense', ''),
                'write_off' => Arr::path($child->additionDatas, 'write_off', ''),
                'adjustment' => Arr::path($child->additionDatas, 'adjustment', ''),
                'stock_to' => Arr::path($child->additionDatas, 'stock_to', ''),
            );

            $dataProducts['stock_from'] += Arr::path($child->additionDatas, 'stock_from', 0);
            $dataProducts['receive'] += Arr::path($child->additionDatas, 'receive', 0);
            $dataProducts['move_receive'] += Arr::path($child->additionDatas, 'move_receive', 0);
            $dataProducts['realization'] += Arr::path($child->additionDatas, 'realization', 0);
            $dataProducts['realization_return'] += Arr::path($child->additionDatas, 'realization_return', 0);
            $dataProducts['return'] += Arr::path($child->additionDatas, 'return', 0);
            $dataProducts['move_expense'] += Arr::path($child->additionDatas, 'move_expense', 0);
            $dataProducts['write_off'] += Arr::path($child->additionDatas, 'write_off', 0);
            $dataProducts['adjustment'] += Arr::path($child->additionDatas, 'adjustment', 0);
            $dataProducts['stock_to'] += Arr::path($child->additionDatas, 'stock_to', 0);
        }

        $shopProductionIDs = Api_Magazine_Shop_Total::getShopProductionTotal(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB
        );

        $dataProductions = array(
            'data' => array(),
            'stock_from' => 0,
            'move_receive' => 0,
            'realization' => 0,
            'realization_return' => 0,
            'move_expense' => 0,
            'write_off' => 0,
            'adjustment' => 0,
            'stock_to' => 0,
        );
        foreach ($shopProductionIDs->childs as $child){
            $dataProductions['data'][] = array(
                'name' => $child->values['name'],
                'stock_from' => Arr::path($child->additionDatas, 'stock_from', ''),
                'move_receive' => Arr::path($child->additionDatas, 'move_receive', ''),
                'realization' => Arr::path($child->additionDatas, 'realization', ''),
                'realization_return' => Arr::path($child->additionDatas, 'realization_return', ''),
                'move_expense' => Arr::path($child->additionDatas, 'move_expense', ''),
                'write_off' => Arr::path($child->additionDatas, 'write_off', ''),
                'adjustment' => Arr::path($child->additionDatas, 'adjustment', ''),
                'stock_to' => Arr::path($child->additionDatas, 'stock_to', ''),
            );

            $dataProductions['stock_from'] += Arr::path($child->additionDatas, 'stock_from', 0);
            $dataProductions['move_receive'] += Arr::path($child->additionDatas, 'move_receive', 0);
            $dataProductions['realization'] += Arr::path($child->additionDatas, 'realization', 0);
            $dataProductions['realization_return'] += Arr::path($child->additionDatas, 'realization_return', 0);
            $dataProductions['move_expense'] += Arr::path($child->additionDatas, 'move_expense', 0);
            $dataProductions['write_off'] += Arr::path($child->additionDatas, 'write_off', 0);
            $dataProductions['adjustment'] += Arr::path($child->additionDatas, 'adjustment', 0);
            $dataProductions['stock_to'] += Arr::path($child->additionDatas, 'stock_to', 0);
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/product/total';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->productions = $dataProductions;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Материальный отчет по товарам за '.$dateFrom.' - '.$dateTo.'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Акт списания
     */
    public function action_realization_write_off() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/realization_write_off';

        $shopRealizationID = Request_RequestParams::getParamInt('shop_realization_id');

        $model = new Model_Magazine_Shop_Realization();
        $model->setDBDriver($this->_driverDB);
        if(! Helpers_DB::getDBObject($model, $shopRealizationID, $this->_sitePageData)){
            throw new HTTP_Exception_404('Realization not found.');
        }

        $realization = array(
            'number' => $model->getNumber(),
            'created_at' => $model->getCreatedAt(),
            'shop_name' => '',
            'shop_write_off_type_name' => '',
        );

        $modelObj = $model->getElement('shop_id', TRUE);
        if($modelObj !== NULL){
            $realization['shop_name'] = $modelObj->getName();
        }

        $modelObj = $model->getElement('shop_write_off_type_id', TRUE);
        if($modelObj !== NULL){
            $realization['shop_write_off_type_name'] = $modelObj->getName();
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_realization_id' => $shopRealizationID,
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_production_id' => array('name', 'old_id', 'unit_id'),
            )
        );

        $dataProductions = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $price = $child->values['price'];
            $amount = $quantity * $price;

            $dataProductions['data'][] = array(
                'name' => $child->getElementValue('shop_production_id'),
                'old_id' => $child->getElementValue('shop_production_id', 'old_id'),
                'unit' => $child->getElementValue('shop_production_id', 'unit_id'),
                'price' => $price,
                'quantity' => $quantity,
                'amount' => $amount,
            );
            $dataProductions['quantity'] += $quantity;
            $dataProductions['amount'] += $amount;
        }
        uasort($dataProductions['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/realization/write-off';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->productions = $dataProductions;
        $view->shopRealizationID = $shopRealizationID;
        $view->realization = $realization;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Списание №'.$shopRealizationID.' на '.date('d.m.Y').'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /**
     * Расходно-кассовый ордер
     */
    public function action_consumablexls() {
        $this->_sitePageData->url = '/bar/shopreport/consumablexls';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'magazine/_report/'.$this->_sitePageData->languageID.'/consumable/one.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Consumable not is found!');
        }else {
            $model = new Model_Magazine_Shop_Consumable();
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
                'operation' => array('name' => $this->_sitePageData->operation->getName())
            ),
            array(),
            'php://output',
            'consumable.xls'
        );

        exit();
    }

    /*
     * Акт перемещения
     */
    public function action_move_one() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/move_one';

        $shopMoveID = Request_RequestParams::getParamInt('shop_move_id');

        $model = new Model_Magazine_Shop_Move();
        $model->setDBDriver($this->_driverDB);
        if(! Helpers_DB::getDBObject($model, $shopMoveID, $this->_sitePageData)){
            throw new HTTP_Exception_404('Move not found.');
        }

        $move = array(
            'id' => $model->getOldID(),
            'created_at' => $model->getCreatedAt(),
            'shop_name' => '',
            'branch_move_name' => '',
        );

        $modelObj = $model->getElement('shop_id', TRUE);
        if($modelObj !== NULL){
            $move['shop_name'] = $modelObj->getName();
        }

        $modelObj = $model->getElement('branch_move_id', TRUE);
        if($modelObj !== NULL){
            $move['branch_move_name'] = $modelObj->getName();
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_move_id' => $shopMoveID,
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_production_id' => array('name', 'price', 'old_id', 'unit_id'),
                'unit_id' => array('name'),
            )
        );

        $dataProductions = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $price = $child->getElementValue('shop_production_id', 'price', 0);
            $amount = $quantity * $price;

            $dataProductions['data'][] = array(
                'name' => $child->getElementValue('shop_production_id'),
                'old_id' => $child->getElementValue('shop_production_id', 'old_id'),
                'unit' => $child->getElementValue('unit_id'),
                'price' => $price,
                'quantity' => $quantity,
                'amount' => $amount,
            );
            $dataProductions['quantity'] += $quantity;
            $dataProductions['amount'] += $amount;
        }
        uasort($dataProductions['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/move/one';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->productions = $dataProductions;
        $view->shopMoveID = $shopMoveID;
        $view->move = $move;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Перемещение №'.$shopMoveID.' на '.date('d.m.Y').'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Накладная на перемещения
     */
    public function action_move_invoice() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/move_invoice';

        $shopMoveID = Request_RequestParams::getParamInt('shop_move_id');

        $model = new Model_Magazine_Shop_Move();
        $model->setDBDriver($this->_driverDB);
        if(! Helpers_DB::getDBObject($model, $shopMoveID, $this->_sitePageData)){
            throw new HTTP_Exception_404('Move not found.');
        }

        $move = array(
            'id' => $model->getOldID(),
            'created_at' => $model->getCreatedAt(),
            'shop_name' => '',
            'branch_move_name' => '',
        );

        $modelObj = $model->getElement('shop_id', TRUE);
        if($modelObj !== NULL){
            $move['shop_name'] = $modelObj->getName();
        }

        $modelObj = $model->getElement('branch_move_id', TRUE);
        if($modelObj !== NULL){
            $move['branch_move_name'] = $modelObj->getName();
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_move_id' => $shopMoveID,
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_production_id' => array('name', 'price', 'unit_id'),
                'unit_id' => array('name'),
            )
        );

        $dataProductions = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $price = $child->getElementValue('shop_production_id', 'price', 0);
            $amount = $quantity * $price;

            $dataProductions['data'][] = array(
                'name' => $child->getElementValue('shop_production_id'),
                'unit' => $child->getElementValue('unit_id'),
                'price' => $price,
                'quantity' => $quantity,
                'amount' => $amount,
            );
            $dataProductions['quantity'] += $quantity;
            $dataProductions['amount'] += $amount;
        }
        uasort($dataProductions['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/move/invoice';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->productions = $dataProductions;
        $view->move = $move;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $view->siteData = $this->_sitePageData;
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Накладная на перемещение №'.$shopMoveID.' на '.date('d.m.Y').'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет приемки продуктов ГТД за период
     */
    public function action_receive_gtd() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/receive_gtd';

        /** Планируемая реализация продукции **/
        $params = Request_RequestParams::setParams(
            array(
                'quantity_balance_from' > 0,
                'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
                'sum_quantity_invoice' => TRUE,
                'group_by' => array(
                    'price',
                    'shop_product_id', 'shop_product_id.name',
                    'shop_supplier_id', 'shop_supplier_id.name'
                ),
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item_GTD',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_product_id' => array('name'),
                'shop_supplier_id' => array('name'),
            )
        );

        $dataProducts = array(
            'data' => array(),
            'amount' => 0,
            'quantity' => 0,
            'quantity_invoice' => 0,
        );
        foreach ($ids->childs as $child){
            $dataProducts['data'][] = array(
                'name' => $child->getElementValue('shop_product_id'),
                'supplier' => $child->getElementValue('shop_supplier_id'),
                'price' => $child->values['price'],
                'quantity' => $child->values['quantity'],
                'quantity_invoice' => $child->values['quantity_invoice'],
                'amount' => $child->values['amount'],
            );
            $dataProducts['amount'] += $child->values['amount'];
            $dataProducts['quantity'] += $child->values['quantity'];
            $dataProducts['quantity_invoice'] += $child->values['quantity_invoice'];
        }
        uasort($dataProducts['data'], function ($x, $y) {
            $result = strcasecmp($x['supplier'], $y['supplier']);
            if($result == 0){
                $result = strcasecmp($x['name'], $y['name']);
            }

            return $result;
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/receive/gtd';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по приемки продуктов ГТД на '.date('d.m.Y').'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет реализации спецпродукта за период
     */
    public function action_realization_special() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/realization_special';

        /** Планируемая реализация продукции **/

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
                'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT,
                'group_by' => array(
                    'price',
                    'shop_production_id', 'shop_production_id.name',
                    'shop_worker_id', 'shop_worker_id.name',
                ),
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_production_id' => array('name'),
                'shop_worker_id' => array('name'),
            )
        );

        $dataProductions = array(
            'data' => array(),
            'amount' => 0,
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $dataProductions['data'][] = array(
                'name' => $child->getElementValue('shop_production_id'),
                'worker' => $child->getElementValue('shop_worker_id'),
                'price' => $child->values['price'],
                'quantity' => $child->values['quantity'],
                'amount' => $child->values['amount'],
            );
            $dataProductions['amount'] += $child->values['amount'];
            $dataProductions['quantity'] += $child->values['quantity'];
        }
        uasort($dataProductions['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/realization/special';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->productions = $dataProductions;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет реализации спецпродукта за период '.Helpers_DateTime::getDateFormatRus($dateFrom).'-'.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет по возврату
     */
    public function action_return_one() {
        set_time_limit(36000);
        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/return_one';

        $shopReturnID = Request_RequestParams::getParamInt('shop_return_id');

        $model = new Model_Magazine_Shop_Return();
        $model->setDBDriver($this->_driverDB);
        Helpers_DB::getDBObject($model, $shopReturnID, $this->_sitePageData);
        $supplier = $model->getElement('shop_supplier_id', TRUE, $this->_sitePageData->shopMainID);
        if($supplier !== NULL){
            $supplier = $supplier->getName();
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_return_id' => $shopReturnID,
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Return_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_product_id' => array('name'),
            )
        );

        $dataProducts = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];

            $dataProducts['data'][] = array(
                'name' => $child->getElementValue('shop_product_id'),
                'price' => $child->values['price'],
                'amount' => $child->values['amount'],
                'quantity' => $quantity,
            );
            $dataProducts['quantity'] += $quantity;
            $dataProducts['amount'] += $child->values['amount'];
        }
        uasort($dataProducts['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/return/one';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->shopReturnID = $shopReturnID;
        $view->supplier = $supplier;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Возврат №'.$shopReturnID.' на '.date('d.m.Y').'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет по приемки
     */
    public function action_receive_one() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/receive_one';

        /** Планируемая реализация продукции **/

        $shopReceiveID = Request_RequestParams::getParamInt('shop_receive_id');

        $params = Request_RequestParams::setParams(
            array(
                'shop_receive_id' => $shopReceiveID,
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_production_id' => array('name', 'price'),
            )
        );

        $dataProducts = array(
            'data' => array(),
        );
        foreach ($ids->childs as $child){
            $dataProducts['data'][] = array(
                'name' => $child->getElementValue('shop_production_id'),
                'price' => $child->getElementValue('shop_production_id', 'price'),
            );
        }
        uasort($dataProducts['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/receive/one';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->shopReceiveID = $shopReceiveID;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Приемка №'.$shopReceiveID.' на '.date('d.m.Y').'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет возврата продуктов за период
     */
    public function action_return_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/return_list';

        /** Планируемая реализация продукции **/

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
                'group_by' => array('price', 'shop_product_id', 'shop_product_id.name', 'shop_supplier_id', 'shop_supplier_id.name'),
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Return_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_product_id' => array('name'),
                'shop_supplier_id' => array('name'),
            )
        );

        $dataProducts = array(
            'data' => array(),
            'amount' => 0,
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $dataProducts['data'][] = array(
                'name' => $child->getElementValue('shop_product_id'),
                'supplier' => $child->getElementValue('shop_supplier_id'),
                'price' => $child->values['price'],
                'quantity' => $child->values['quantity'],
                'amount' => $child->values['amount'],
            );
            $dataProducts['amount'] += $child->values['amount'];
            $dataProducts['quantity'] += $child->values['quantity'];
        }
        uasort($dataProducts['data'], function ($x, $y) {
            $result = strcasecmp($x['supplier'], $y['supplier']);
            if($result == 0){
                $result = strcasecmp($x['name'], $y['name']);
            }

            return $result;
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/return/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по возратам продуктов за период '.Helpers_DateTime::getDateFormatRus($dateFrom).'-'.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет по ревизии
     */
    public function action_revise_one_old() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/revise_one';

        /** Планируемая реализация продукции **/

        $shopReviseID = Request_RequestParams::getParamInt('shop_revise_id');
        $model = new Model_Magazine_Shop_Revise();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $shopReviseID, $this->_sitePageData)){
            throw new Exception('Revise not found.');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_revise_id' => $shopReviseID,
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Revise_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_product_id' => array('name', 'barcode'),
            )
        );

        $dataProducts = array(
            'data' => array(),
            'quantity' => 0,
            'quantity_actual' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $quantityActual = $child->values['quantity_actual'];

            $dataProducts['data'][] = array(
                'name' => $child->getElementValue('shop_product_id'),
                'barcode' => $child->getElementValue('shop_product_id', 'barcode'),
                'quantity' => $quantity,
                'quantity_actual' => $quantityActual,
            );
            $dataProducts['quantity'] += $quantity;
            $dataProducts['quantity_actual'] += $quantityActual;
        }
        uasort($dataProducts['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/revise/one_old';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->shopReviseID = $shopReviseID;
        $view->dateRevise = $model->getCreatedAt();
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Ревизия №'.$shopReviseID.' на '.date('d.m.Y').'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет по ревизии
     */
    public function action_revise_one() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/revise_one';

        /** Планируемая реализация продукции **/

        $shopReviseID = Request_RequestParams::getParamInt('shop_revise_id');
        $model = new Model_Magazine_Shop_Revise();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $shopReviseID, $this->_sitePageData)){
            throw new Exception('Revise not found.');
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_revise_id' => $shopReviseID,
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Revise_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_product_id' => array('name', 'barcode', 'price_cost', 'coefficient_revise'),
                'unit_id' => array('name'),
            )
        );

        $dataProducts = array(
            'data' => array(),
            'quantity' => 0,
            'quantity_actual' => 0,
            'quantity_diff' => 0,
            'amount' => 0,
            'amount_actual' => 0,
            'amount_diff' => 0,
        );
        foreach ($ids->childs as $child){
            $price = $child->getElementValue('shop_product_id', 'price_cost');

            $coefficientRevise = $child->getElementValue('shop_product_id', 'coefficient_revise');
            if($coefficientRevise == 0) {
                $coefficientRevise = 1;
            }
            $quantity = $child->values['quantity'] / $coefficientRevise;
            $quantityActual = $child->values['quantity_actual'] / $coefficientRevise;

            $dataProducts['data'][] = array(
                'name' => $child->getElementValue('shop_product_id'),
                'barcode' => $child->getElementValue('shop_product_id', 'barcode'),
                'unit' => $child->getElementValue('unit_id'),
                'price' => $price,
                'quantity' => round($quantity, 3),
                'quantity_actual' => round($quantityActual, 3),
                'quantity_diff' => round($quantityActual - $quantity, 3),
                'amount' => round($quantity * $price, 2),
                'amount_actual' => round($quantityActual * $price, 2),
                'amount_diff' => round(($quantityActual - $quantity) * $price, 2),
            );
            $dataProducts['quantity'] += round($quantity, 3);
            $dataProducts['quantity_actual'] += round($quantityActual, 3);
            $dataProducts['quantity_diff'] += round($quantityActual - $quantity, 3);

            $dataProducts['amount'] += round($quantity * $price, 2);
            $dataProducts['amount_actual'] += round($quantityActual * $price, 2);
            $dataProducts['amount_diff'] += round(($quantityActual - $quantity) * $price, 2);
        }
        uasort($dataProducts['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/revise/one';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->reviseNumber = $model->getOldID();
        $view->reviseDate = $model->getCreatedAt();
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Ревизия №'.$shopReviseID.' на '.date('d.m.Y').'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет прайс-лист продукции за период
     */
    public function action_production_stock_price() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/production_stock_price';

        $dataProductions = array(
            'data' => array(),
            'quantity' => 0,
        );

        $isAll = Request_RequestParams::getParamBoolean('is_all');

        if(!$isAll) {
            $params = Request_RequestParams::setParams(
                array(
                    'quantity_from' => 0,
                    'sort_by' => array(
                        'name' => 'asc',
                    ),
                )
            );

            $ids = Request_Request::find('DB_Magazine_Shop_Production',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );
            foreach ($ids->childs as $child) {
                $dataProductions['data'][] = array(
                    'name' => $child->values['name'],
                    'price' => $child->values['price'],
                );
            }

            $ids = Request_Request::find('DB_Magazine_Shop_Product',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                array(
                    'shop_production_id' => array('price')
                )
            );
            foreach ($ids->childs as $child){
                $price = $child->getElementValue('shop_production_id', 'price', 0);
                if($isAll || $price > 0) {
                    $dataProductions['data'][] = array(
                        'name' => $child->values['name'],
                        'price' => $price,
                    );
                }
            }
        }else{
            $params = Request_RequestParams::setParams(
                array(
                    'price_from' => 0,
                    'sort_by' => array(
                        'name' => 'asc',
                    ),
                )
            );

            $ids = Request_Request::find('DB_Magazine_Shop_Production',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );
            foreach ($ids->childs as $child) {
                $dataProductions['data'][] = array(
                    'name' => $child->values['name'],
                    'price' => $child->values['price'],
                );
            }
        }

        uasort($dataProductions['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/production/price';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->productions = $dataProductions;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Прайс-лист продукции на '.date('d.m.Y').'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет перемещение продукции за период
     */
    public function action_move_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/move_list';

        /** Планируемая реализация продукции **/

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'sum_quantity' => TRUE,
                'group_by' => array(
                    'shop_production_id', 'shop_production_id.name',
                    'shop_id', 'shop_id.name',
                    'branch_move_id', 'branch_move_id.name'
                ),
            )
        );

        $ids = Request_Request::findBranch('DB_Magazine_Shop_Move_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_production_id' => array('name'),
                'shop_id' => array('name'),
                'branch_move_id' => array('name'),
            )
        );

        $dataProductions = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            if($child->values['shop_id'] == $this->_sitePageData->shopID){
                $quantity = $quantity * (-1);
            }

            $dataProductions['data'][] = array(
                'name' => $child->getElementValue('shop_production_id'),
                'shop' => $child->getElementValue('shop_id'),
                'branch_move' => $child->getElementValue('branch_move_id'),
                'quantity' => $quantity,
            );
            $dataProductions['quantity'] += $quantity;
        }
        uasort($dataProductions['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/move/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->productions = $dataProductions;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет перемещения продукции за период '.Helpers_DateTime::getDateFormatRus($dateFrom).'-'.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет о перемещении продукции собственного производства
     */
    public function action_move_list_v2() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/move_list_v2';

        /** Планируемая реализация продукции **/

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');
        $branchMoveID = Request_RequestParams::getParamInt('branch_move_id');

        $model = new Model_Shop();
        $model->setDBDriver($this->_driverDB);
        Helpers_DB::getDBObject($model, $branchMoveID, $this->_sitePageData, 0);

        $params = Request_RequestParams::setParams(
            array(
                'branch_move_id' => $branchMoveID,
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'sum_quantity' => TRUE,
                'sum_amount' => TRUE,
                'group_by' => array(
                    'shop_production_id', 'shop_production_id.name', 'shop_production_id.price', 'shop_production_id.unit_id',
                    'unit_id.name',
                ),
            )
        );

        $ids = Request_Request::find(
            'DB_Magazine_Shop_Move_Item', $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_production_id' => array('name', 'price', 'unit_id'),
                'unit_id' => array('name'),
            )
        );

        $dataProductions = array(
            'data' => array(),
            'quantity' => 0,
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->values['quantity'];
            $price = $child->getElementValue('shop_production_id', 'price', 0);
            $amount = $quantity * $price;

            $dataProductions['data'][] = array(
                'name' => $child->getElementValue('shop_production_id'),
                'unit' => $child->getElementValue('unit_id'),
                'price' => $price,
                'quantity' => $quantity,
                'amount' => $amount,
            );
            $dataProductions['quantity'] += $quantity;
            $dataProductions['amount'] += $amount;
        }
        uasort($dataProductions['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/move/list-v2';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->productions = $dataProductions;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->branchMove = $model->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет о перемещении продукции собственного производства с '.Helpers_DateTime::getDateFormatRus($dateFrom).' по '.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет по отаткам продуктам
     */
    public function action_product_stock() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/product_stock';


        $params = Request_RequestParams::setParams(
            array(
                'quantity_not_equally' => 0,
                'sort_by' => array('name' => 'asc')
            )
        );

        $dateStock = Request_RequestParams::getParamDate('date_stock');

        if(empty($dateStock) || $dateStock == date('Y-m-d')) {
            $ids = Request_Request::find('DB_Magazine_Shop_Product',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
                array(
                    'shop_product_stock_id' => array('quantity_balance'),
                )
            );
        }else {
            $shopProductIDs = Api_Magazine_Shop_Product::stockPeriod(
                NULL, $dateStock, $this->_sitePageData, $this->_driverDB
            );

            $ids = Request_Request::find('DB_Magazine_Shop_Product',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                array(
                    'unit_id' => array('name'),
                )
            );

            foreach ($ids->childs as $child) {
                Arr::set_path(
                    $child->values,
                    Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_product_stock_id.quantity_balance',
                    Arr::path($shopProductIDs, $child->id, 0)
                );
            }
        }

        $ids->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_product_stock_id.quantity_balance' => 'desc'
            ),
            TRUE, TRUE
        );

        $dataProducts = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->getElementValue('shop_product_stock_id', 'quantity_balance');
            $dataProducts['data'][] = array(
                'name' => $child->values['name'],
                'quantity' => $quantity,
            );
            $dataProducts['quantity'] += $quantity;
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/product/stock';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по остаткам продуктов на '.date('d.m.Y').'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет по отаткам продукции
     */
    public function action_production_stock() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/production_stock';


        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => 0,
                'quantity_not_equally' => 0,
                'sort_by' => array('name' => 'asc')
            )
        );

        $dateStock = Request_RequestParams::getParamDate('date_stock');

        if(empty($dateStock) || $dateStock == date('Y-m-d')) {
            $ids = Request_Request::find('DB_Magazine_Shop_Production',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
                array(
                    'shop_production_stock_id' => array('quantity_balance'),
                )
            );
        }else {
            $shopProductIDs = Api_Magazine_Shop_Production::stockPeriod(
                NULL, $dateStock, $this->_sitePageData, $this->_driverDB
            );

            $ids = Request_Request::find('DB_Magazine_Shop_Production',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                array(
                    'unit_id' => array('name'),
                )
            );

            foreach ($ids->childs as $child) {
                Arr::set_path(
                    $child->values,
                    Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_production_stock_id.quantity_balance',
                    Arr::path($shopProductIDs, $child->id, 0)
                );
            }
        }

        $ids->childsSortBy(
            array(
                Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_production_stock_id.quantity_balance' => 'desc'
            ),
            TRUE, TRUE
        );

        $dataProductions = array(
            'data' => array(),
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $quantity = $child->getElementValue('shop_production_stock_id', 'quantity_balance', 0);
            $dataProductions['data'][] = array(
                'name' => $child->values['name'],
                'quantity' => $quantity,
            );
            $dataProductions['quantity'] += $quantity;
        }

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/production/stock';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->productions = $dataProductions;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по остаткам продукции на '.date('d.m.Y').'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет реализации продукции за период
     */
    public function action_realization_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/realization_list';

        /** Планируемая реализация продукции **/

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'shop_production_rubric_id' => Request_RequestParams::getParamInt('shop_production_rubric_id'),
                'shop_write_off_type_id' => array(
                    0,
                    Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_REDRESS,
                ),
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_production_id' => array('name', 'coefficient'),
            )
        );

        $dataProductions = array(
            'data' => array(),
            'amount' => 0,
            'quantity' => 0,
            'amount_coefficient' => 0,
            'quantity_coefficient' => 0,
        );
        foreach ($ids->childs as $child){
            $coefficient = $child->getElementValue('shop_production_id', 'coefficient', 1);
            if($coefficient == 0){
                $coefficient = 1;
            }

            $quantityCoefficient = round($child->values['quantity'] / $coefficient, 3);
            $priceCoefficient = round($child->values['price'] * $coefficient, 2);
            $amountCoefficient = $quantityCoefficient * $priceCoefficient;

            $key = $child->values['shop_production_id'].'_'. $child->values['price'];
            if(!key_exists($key, $dataProductions['data'])){
                $dataProductions['data'][$key] = array(
                    'name' => $child->getElementValue('shop_production_id'),
                    'price' => $child->values['price'],
                    'quantity' => 0,
                    'amount' => 0,
                    'quantity_coefficient' => 0,
                    'price_coefficient' => $priceCoefficient,
                    'amount_coefficient' => 0,
                );
            }

            $dataProductions['data'][$key]['amount'] += $child->values['amount'];
            $dataProductions['data'][$key]['quantity'] += $child->values['quantity'];
            $dataProductions['data'][$key]['quantity_coefficient'] += $quantityCoefficient;
            $dataProductions['data'][$key]['amount_coefficient'] += $amountCoefficient;

            $dataProductions['amount'] += $child->values['amount'];
            $dataProductions['quantity'] += $child->values['quantity'];
            $dataProductions['quantity_coefficient'] += $quantityCoefficient;
        }

        // округляем сумму и пересчитываем значение
        foreach ($dataProductions['data'] as &$child){
            $child['amount_coefficient'] = round($child['amount_coefficient'], 2);
            $dataProductions['amount_coefficient'] += $child['amount_coefficient'];
        }

        uasort($dataProductions['data'], function ($x, $y) {
            return strcasecmp($x['name'], $y['name']);
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/realization/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->productions = $dataProductions;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет реализации продукции за период '.Helpers_DateTime::getDateFormatRus($dateFrom).'-'.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет приемки продуктов за период
     */
    public function action_receive_list() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/receive_list';

        /** Планируемая реализация продукции **/

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'sum_amount' => TRUE,
                'sum_quantity' => TRUE,
                'group_by' => array('price', 'shop_product_id', 'shop_product_id.name', 'shop_supplier_id', 'shop_supplier_id.name'),
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_product_id' => array('name'),
                'shop_supplier_id' => array('name'),
            )
        );

        $dataProducts = array(
            'data' => array(),
            'amount' => 0,
            'quantity' => 0,
        );
        foreach ($ids->childs as $child){
            $dataProducts['data'][] = array(
                'name' => $child->getElementValue('shop_product_id'),
                'supplier' => $child->getElementValue('shop_supplier_id'),
                'price' => $child->values['price'],
                'quantity' => $child->values['quantity'],
                'amount' => $child->values['amount'],
            );
            $dataProducts['amount'] += $child->values['amount'];
            $dataProducts['quantity'] += $child->values['quantity'];
        }
        uasort($dataProducts['data'], function ($x, $y) {
            $result = strcasecmp($x['supplier'], $y['supplier']);
            if($result == 0){
                $result = strcasecmp($x['name'], $y['name']);
            }

            return $result;
        });

        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/receive/list';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->products = $dataProducts;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет прием продуктов за период '.Helpers_DateTime::getDateFormatRus($dateFrom).'-'.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет реализации товаров по сотруднику за период
     */
    public function action_realization_worker() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/realization_worker';

        /** Планируемая реализация продукции **/

        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');

        $shopWorkerID = Request_RequestParams::getParamInt('shop_worker_id');
        $model = new Model_Ab1_Shop_Worker();
        $model->setDBDriver($this->_driverDB);
        Helpers_DB::getDBObject($model, $shopWorkerID, $this->_sitePageData, 0);
        $workerName = $model->getName();

        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'shop_worker_id' => $shopWorkerID,
                'sum_amount' => TRUE,
                'group_by' => array(
                    'shop_write_off_type_id',
                    'is_special',
                    'created_at_date',
                ),
            )
        );

        $ids = Request_Request::findBranch('DB_Magazine_Shop_Realization_Item',
            array(), $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );

        $dataDays = array(
            'data' => array(),
            'realization' => 0,
            'special' => 0,
            'amount' => 0,
        );
        foreach ($ids->childs as $child){
            $date = $child->values['created_at_date'];
            $amount = $child->values['amount'];

            if(!key_exists($date, $dataDays['data'])){
                $dataDays['data'][$date] = array(
                    'date' => $date,
                    'realization' => 0,
                    'special' => 0,
                    'amount' => 0,
                );
            }

            if($child->values['is_special'] == Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT){
                $dataDays['data'][$date]['special'] += $amount;
                $dataDays['special'] += $amount;
            }else{
                $dataDays['data'][$date]['realization'] += $amount;
                $dataDays['realization'] += $amount;
            }

            $dataDays['data'][$date]['amount'] += $amount;
            $dataDays['amount'] += $child->values['amount'];
        }
        uasort($dataDays['data'], function ($x, $y) {
            return strcasecmp($x['date'], $y['date']);
        });


        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/realization/worker';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->days = $dataDays;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->worker = $workerName;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет реализации товаров по сотруднику за период '.Helpers_DateTime::getDateFormatRus($dateFrom).'-'.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }

    /*
     * Отчет реализации товаров по сотрудникам за период
     */
    public function action_realization_workers() {
        set_time_limit(36000);

        $this->_sitePageData->url = '/'.$this->actionURLName.'/shopreport/realization_workers';

        /** Реализация продукции сотрудников **/
        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'shop_worker_id_from' => 0,
                'shop_write_off_type_id' => [0, Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_REDRESS],
                'sum_amount' => TRUE,
                'group_by' => array(
                    'shop_write_off_type_id',
                    'is_special',
                    'shop_worker_id', 'shop_worker_id.name',
                ),
                'sort_by' => array(
                    'shop_worker_id.name' => 'asc',
                ),
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE,
            array(
                'shop_worker_id' => array('name'),
            )
        );

        $dataWorkers = array(
            'data' => array(),
            'realization' => 0,
            'special' => 0,
        );
        foreach ($ids->childs as $child){
            $shopWorkerID = $child->values['shop_worker_id'];
            $amount = $child->values['amount'];

            if(!key_exists($shopWorkerID, $dataWorkers['data'])){
                $dataWorkers['data'][$shopWorkerID] = array(
                    'name' => $child->getElementValue('shop_worker_id'),
                    'realization' => 0,
                    'special' => 0,
                );
            }

            if($child->values['is_special'] == Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT){
                $dataWorkers['data'][$shopWorkerID]['realization'] += $amount;
                $dataWorkers['realization'] += $amount;
            }else{
                $dataWorkers['data'][$shopWorkerID]['special'] += $amount;
                $dataWorkers['special'] += $amount;
            }
        }

        /** Реализация продукции за наличные **/
        $dateFrom = Request_RequestParams::getParamDate('created_at_from');
        $dateTo = Request_RequestParams::getParamDate('created_at_to');
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from_equally' => $dateFrom,
                'created_at_to' => $dateTo.' 23:59:59',
                'shop_worker_id' => 0,
                'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC,
                'sum_amount' => TRUE
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Realization',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,0, TRUE
        );
        if(count($ids->childs) > 0){
            $cache = $ids->childs[0]->values['amount'];
        }else{
            $cache = 0;
        }


        $viewObject = 'magazine/_report/'.$this->_sitePageData->languageID.'/realization/workers';
        $tmp = str_replace('\\', '/', $viewObject);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->workers = $dataWorkers;
        $view->cache = $cache;
        $view->dateFrom = $dateFrom;
        $view->dateTo = $dateTo;
        $view->operation = $this->_sitePageData->operation->getValues();
        $view->shop = $this->_sitePageData->shop->getName();
        $view->shopOptions = $this->_sitePageData->shop->getOptionsArray();
        $strView = Helpers_View::viewToStr($view);

        header('Content-Type: application/x-download;charset=UTF-8');
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Отчет по реализации суммовой за период '.Helpers_DateTime::getDateFormatRus($dateFrom).'-'.Helpers_DateTime::getDateFormatRus($dateTo).'.xml"');
        header('Cache-Control: max-age=0');

        echo $strView;
        exit();
    }
}

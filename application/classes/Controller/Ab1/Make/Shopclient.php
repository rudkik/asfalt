<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Make_ShopClient extends Controller_Ab1_Make_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client';
        $this->controllerName = 'shopclient';
        $this->tableID = Model_Ab1_Shop_Client::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client::TABLE_NAME;
        $this->objectName = 'client';

        parent::__construct($request, $response);
    }

    public function action_json() {
        $this->_sitePageData->url = '/make/shopclient/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }

    public function action_index() {
        $this->_sitePageData->url = '/make/shopclient/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/index',
            )
        );
        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        // получаем список
        View_View::find('DB_Ab1_Shop_Client', $this->_sitePageData->shopMainID, "_shop/client/list/index", "_shop/client/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25, 'id_not' => 175747));

        $this->_putInMain('/main/_shop/client/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/make/shopclient/new';
        $this->_actionShopClientNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/make/shopclient/edit';
        $this->_actionShopClientEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/make/shopclient/save';

        $result = Api_Ab1_Shop_Client::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/make/shopclient/statistics';
        $this->_actionShopClientStatistics();
    }

    public function action_charity_statistics()
    {
        $this->_sitePageData->url = '/make/shopclient/charity_statistics';
        $this->_actionCharityShopClientStatistics();
    }

    public function action_compensation()
    {
        $this->_sitePageData->url = '/make/shopclient/compensation';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/compensation',
            )
        );

        $isAllBranch = Request_RequestParams::getParamInt('shop_branch_id') == -1;
        $isAll = Request_RequestParams::getParamBoolean('is_all');
        $isDebt = Request_RequestParams::getParamBoolean('is_debt');
        $shopProductIDs = Api_Ab1_Shop_Product::findAllByMainRubric(
            Request_RequestParams::getParamInt('shop_product_rubric_id'), $this->_sitePageData, $this->_driverDB
        );

        $this->_requestShopProductRubrics();
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        // задаем время выборки с начала дня
        $dateFrom = date('Y-m-d').' 06:00:00';
        $listIDs = new MyArray();
        $params = Request_RequestParams::setParams(
            array(
                'is_exit' => 1,
                'exit_at_from' => $dateFrom,
                'sum_quantity' => TRUE,
                'quantity_from' => 0,
                'is_charity' => FALSE,
                'shop_product_id' => $shopProductIDs,
                'shop_client_id' => Request_RequestParams::getParamInt('shop_client_id'),
                'group_by' => array(
                    'shop_client_id',
                    'shop_client_id.name',
                    'shop_client_id.balance',
                    'shop_product_id.volume',
                ),
            )
        );
        $elements = array(
            'shop_client_id' => array('name', 'balance'),
            'shop_product_id' => array('volume')
        );

        $resultArray = array(
            'quantity_day' => 0,
            'quantity_yesterday' => 0,
            'quantity_week' => 0,
            'quantity_month' => 0,
            'quantity_month_previous' => 0,
            'quantity_year' => 0,
        );

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        $clientIDs = array();
        if(!$isAll){
            $clientIDs = $listIDs->getChildArrayInt('shop_client_id', TRUE);
        }

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }

        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_day'] += $child->values['quantity'];
        }

        if(!$isAll){
            $clientIDs = array_merge($clientIDs, $listIDs->getChildArrayInt('shop_client_id', TRUE));
            if(!empty($clientIDs)) {
                $params['shop_client_id'] = array(
                    'value' => $clientIDs,
                );
            }
        }

        // задаем время выборки вчера
        $paramsYesterday = $params;
        $paramsYesterday['exit_at_to'] = $dateFrom;
        $dateFrom = Helpers_DateTime::minusDays($dateFrom, 1);
        $paramsYesterday['exit_at_from'] = $dateFrom;

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] +=
                $child->values['quantity'];
        }

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsYesterday, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_yesterday'] +=
                $child->values['quantity'];
        }

        // задаем время выборки с начала недели
        $dateFrom = Helpers_DateTime::getWeekBeginStr(date('Y-m-d')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] +=
                $child->values['quantity'];
        }

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_week'] +=
                $child->values['quantity'];
        }

        // задаем время выборки с начала месяца
        $dateFrom = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] +=
                $child->values['quantity'];
        }

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month'] +=
                $child->values['quantity'];
        }

        // задаем время выборки с предыдущего месяца
        $paramsPreviousMonth = $params;
        $tmp = Helpers_DateTime::getMonthBeginStr(date('m'), date('Y')).' 06:00:00';
        $paramsPreviousMonth['exit_at_to'] = $tmp;
        $paramsPreviousMonth['exit_at_from'] = Helpers_DateTime::minusMonth($tmp, 1, true);

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $paramsPreviousMonth, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_month_previous'] += $child->values['quantity'];
        }

        // задаем время выборки с начала года
        $dateFrom = Helpers_DateTime::getYearBeginStr(date('Y')).' 06:00:00';
        $params['exit_at_from'] = $dateFrom;

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Car_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Car_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] +=
                $child->values['quantity'];
        }

        if($isAllBranch) {
            $ids = Request_Request::findBranch('DB_Ab1_Shop_Piece_Item',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }else{
            $ids = Request_Request::find('DB_Ab1_Shop_Piece_Item',
                $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params, 0, TRUE,
                $elements
            );
        }
        foreach ($ids->childs as $child){
            $shopClientID = $child->values['shop_client_id'];
            if(!key_exists($shopClientID, $listIDs->childs)){
                if(!$isAll){
                    continue;
                }
                $child->additionDatas = $resultArray;
                $listIDs->childs[$shopClientID] = $child;
            }

            $listIDs->childs[$shopClientID]->additionDatas['quantity_year'] +=
                $child->values['quantity'];
        }

        // получаем список клиентов
        $clientIDs = new MyArray();
        foreach ($listIDs->childs as $child){
            $client = $clientIDs->addChild($child->values['shop_client_id']);
            $client->values = array(
                'id' => $child->values['shop_client_id'],
                'name' => $child->getElementValue('shop_client_id'),
            );
            $client->setIsFind(TRUE);
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/client/list/list'] = Helpers_View::getViewObjects(
            $clientIDs, new Model_Ab1_Shop_Client(),
            '_shop/client/list/list','_shop/client/one/list',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        // если требуется в долг, то удаляем всех клиентов с плюсовым балансом
        if($isDebt){
            foreach ($listIDs->childs as $key => $child){
                $amount = $child->getElementValue('shop_client_id', 'balance');
                if($amount < -1) {
                    $child->additionDatas['balance'] = $amount;
                }else{
                    unset($listIDs->childs[$key]);
                }
            }
        }

        // сортировка
        $sortBy = Request_RequestParams::getParamArray('sort_by', array(), array());
        if(empty($sortBy)){
            if($isDebt){
                $sortBy = array('balance' => 'desc');
            }elseif($isAll){
                $sortBy = array('quantity_year' => 'desc');
            }else{
                $sortBy = array('quantity_day' => 'desc');
            }
        }
        $listIDs->childsSortBy($sortBy, true, true);

        // итог
        $listIDs->additionDatas = $listIDs->calcTotalsChild(
            array(
                'quantity_day',
                'quantity_yesterday',
                'quantity_week',
                'quantity_month',
                'quantity_month_previous',
                'quantity_year',
            ),
            true
        );

        $listIDs->additionDatas['balance'] = $listIDs->calcTotalsChild(
            array(
                '$elements$.shop_client_id.balance',
            ),
            false
        )['$elements$.shop_client_id.balance'];

        $this->_sitePageData->countRecord = count($listIDs->childs);

        if($isDebt){
            // получаем сумму машин на территории
            $params = Request_RequestParams::setParams(
                array(
                    'is_exit' => 0,
                    'quantity_from' => 0,
                    'sum_amount' => true,
                    'group_by' => array(
                        'shop_client_id'
                    )
                )
            );
            $shopCarIDs = Request_Request::findBranch('DB_Ab1_Shop_Car',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );

            foreach ($shopCarIDs->childs as $child){
                $tmp = $listIDs->findChildValues(
                    array(
                        'shop_client_id' => $child->values['shop_client_id'],
                    ),
                    false
                );

                if($tmp != null){
                    $tmp->additionDatas['territory'] = $child->values['amount'];
                }
            }

            // получаем пометку по поставщикам  по договорам
            $params = Request_RequestParams::setParams(
                array(
                    'date' => date('Y-m-d'),
                    'is_receive' => false,
                    'group_by' => array(
                        'shop_client_id',
                    )
                )
            );
            $shopClientContractIDs = Request_Request::findBranch('DB_Ab1_Shop_Client_Contract',
                array(), $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );

            foreach ($shopClientContractIDs->childs as $child){
                $tmp = $listIDs->findChildValues(
                    array(
                        'shop_client_id' => $child->values['shop_client_id'],
                    ),
                    false
                );

                if($tmp != null){
                    $tmp->additionDatas['is_supplier'] = true;
                }
            }
        }


        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/client/list/compensation'] = Helpers_View::getViewObjects(
            $listIDs, new Model_Ab1_Shop_Product_Rubric(),
            '_shop/client/list/compensation','_shop/client/one/compensation',
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/client/compensation');
    }
}

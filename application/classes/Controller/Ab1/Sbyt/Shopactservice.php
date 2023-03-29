<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sbyt_ShopActService extends Controller_Ab1_Sbyt_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Act_Service';
        $this->controllerName = 'shopactservice';
        $this->tableID = Model_Ab1_Shop_Act_Service::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Act_Service::TABLE_NAME;
        $this->objectName = 'actservice';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/sbyt/shopactservice/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/service/list/index',
            )
        );

        $this->_requestShopProducts();
        $this->_requestActServicePaidTypes();
        $this->_requestCheckTypes(Request_RequestParams::getParamInt('check_type_id'));

        if(Request_RequestParams::getParamBoolean('is_last_day')){
            $params = Request_RequestParams::setParams(
                array(
                    'limit' => 1000, 'limit_page' => 25,
                    'date' => Helpers_DateTime::minusDays(date('Y-m-d'), 9),
                    'is_send_esf' => Request_RequestParams::getParamBoolean('is_send_esf'),
                ),
                FALSE
            );
        }else{
            $params = array('limit' => 1000, 'limit_page' => 25);
        }

        // получаем список
        View_View::find('DB_Ab1_Shop_Act_Service',
            $this->_sitePageData->shopID,
            "_shop/act/service/list/index", "_shop/act/service/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_client_id' => array('name'),
                'shop_client_attorney_id' => array('number'),
                'shop_client_contract_id' => array('number'),
                'act_service_paid_type_id' => array('name'),
                'shop_delivery_department_id' => array('name'),
                'product_type_id' => array('name'),
                'check_type_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/act/service/index');
    }

    public function action_add() {
        $this->_sitePageData->url = '/sbyt/shopactservice/add';

        $date = Request_RequestParams::getParamDateTime('date');
        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        $shopClientContractID = Request_RequestParams::getParamInt('shop_client_contract_id');
        $shopClientAttorneyID = Request_RequestParams::getParamInt('shop_client_attorney_id');

        $result = Api_Ab1_Shop_Act_Service::addActService(
            $shopClientID, $shopClientContractID, $shopClientAttorneyID, $date, $dateFrom, $dateTo,
            $this->_sitePageData, $this->_driverDB
        );

        if($result === FALSE) {
            throw new HTTP_Exception_500('Cars not found.');
        }

        self::redirect(
            '/sbyt/shopactservice/edit'
            . URL::query(
                array(
                    'id' => $result->id,
                ), FALSE
            )
        );
    }
    
    public function action_edit()
    {
        $this->_sitePageData->url = '/sbyt/shopactservice/edit';
        $this->_actionShopActServiceEdit();
    }

    /**
     * Заново перестраиваем Акт выполненных работ, добавляем за выбранный период дополнительные услуги
     * @throws HTTP_Exception_404
     */
    public function action_rebuild()
    {
        $this->_sitePageData->url = '/sbyt/shopactservice/rebuild';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        Api_Ab1_Shop_Act_Service::rebuild($id, $this->_sitePageData, $this->_driverDB);

        self::redirect(
            '/sbyt/shopactservice/edit'
            . URL::query(
                array(
                    'id' => $id,
                ), FALSE
            )
        );
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sbyt/shopactservice/save';

        $result = Api_Ab1_Shop_Act_Service::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_virtual_index() {
        $this->_sitePageData->url = '/sbyt/shopactservice/virtual_index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/service/list/virtual/index',
            )
        );

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        if($dateFrom === NULL){
            $dateFrom = date('Y-m-d').' 06:00:00';
        }
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        if($dateTo === NULL){
            $dateTo = date('Y-m-d',strtotime('+1 day')).' 06:00:00';
        }

        // Получение виртуальные актов выполненных работ
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => Request_RequestParams::getParam('shop_client_id'),
                'delivery_shop_client_contract_id' => Request_RequestParams::getParam('shop_client_contract_id'),
                'delivery_shop_client_attorney_id' => Request_RequestParams::getParam('shop_client_attorney_id'),
            )
        );
        $paramsAdditionService = Request_RequestParams::setParams(
            array(
                'shop_client_id' => Request_RequestParams::getParam('shop_client_id'),
                'shop_client_contract_id' => Request_RequestParams::getParam('shop_client_contract_id'),
                'shop_client_attorney_id' => Request_RequestParams::getParam('shop_client_attorney_id'),
            )
        );
        $ids = Api_Ab1_Shop_Act_Service::getVirtualActServices(
            $dateFrom, $dateTo, $this->_sitePageData, $this->_driverDB, $params, $paramsAdditionService, $this->_sitePageData->shopID
        );

        $this->_sitePageData->replaceDatas['view::_shop/act/service/list/virtual/index'] = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Car(),
            '_shop/act/service/list/virtual/index', '_shop/act/service/one/virtual/index',
            $this->_sitePageData, $this->_driverDB, -1, FALSE
        );

        $this->_putInMain('/main/_shop/act/service/virtual/index');
    }

    public function action_virtual_show() {
        $this->_sitePageData->url = '/sbyt/shopactservice/virtual_show';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/service/list/virtual/show',
                'view::_shop/act/service/list/virtual/addition-service',
            )
        );

        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        $shopClientContractID = Request_RequestParams::getParamInt('shop_client_contract_id');
        $shopClientAttorneyID = Request_RequestParams::getParamInt('shop_client_attorney_id');

        // обновляем балансы клиента (дополнительно, перед формирование акта выполненных работ)
        Api_Ab1_Shop_Client::recountBalanceObject(
            null, $this->_sitePageData, $this->_driverDB, $shopClientID
        );

        $this->_requestShopClientAttorney($shopClientID, $shopClientAttorneyID, 'option');
        $this->_requestShopClientContract($shopClientID, $shopClientContractID, 'list', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK);

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        if($dateFrom === NULL){
            $dateFrom = date('Y-m-d').' 06:00:00';
        }
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        if($dateTo === NULL){
            $dateTo = date('Y-m-d',strtotime('+1 day')).' 06:00:00';
        }

        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'shop_client_id' => $shopClientID,
                'delivery_shop_client_contract_id' => $shopClientContractID,
                'delivery_shop_client_attorney_id' => $shopClientAttorneyID,
                'is_exit' => TRUE,
                'is_charity' => FALSE,
                'is_delivery' => TRUE,
                'shop_act_service_id' => 0,
                'delivery_quantity_from' => 0,
                'sort_by' => array('shop_product_id.name' => 'asc'),
            )
        );

        // получаем список реализации
        $shopCarIDs = Request_Request::find('DB_Ab1_Shop_Car',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_delivery_id' => array('name'),
            )
        );
        $shopCarIDs->addAdditionDataChilds(array('is_shop_car' => TRUE));

        $shopPieceIDs = Request_Request::find('DB_Ab1_Shop_Piece',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_delivery_id' => array('name'),
            )
        );
        $shopPieceIDs->addAdditionDataChilds(array('is_shop_car' => FALSE));

        if (empty($shopCarIDs->childs)) {
            $shopCarIDs->childs = $shopPieceIDs->childs;
        } elseif (!empty($shopPieceIDs->childs)) {
            $shopCarIDs->childs = array_merge($shopCarIDs->childs, $shopPieceIDs->childs);
        }

        $total = new MyArray();
        $total->setIsFind();
        $total->values['delivery_quantity'] = 0;
        $total->values['delivery_amount'] = 0;
        $total->additionDatas['is_total'] = TRUE;
        foreach ($shopCarIDs->childs as $child){
            $total->values['delivery_quantity'] += $child->values['delivery_quantity'];
            $total->values['delivery_amount'] += $child->values['delivery_amount'];
        }

        $shopCarIDs->childsSortBy(array(Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_delivery_id.name', 'quantity'));
        $shopCarIDs->childs[] = $total;

        $this->_sitePageData->replaceDatas['view::_shop/act/service/list/virtual/show'] = Helpers_View::getViewObjects(
            $shopCarIDs, new Model_Ab1_Shop_Car(),
            '_shop/act/service/list/virtual/show', '_shop/act/service/one/virtual/show',
            $this->_sitePageData, $this->_driverDB
        );

        $params = Request_RequestParams::setParams(
            array(
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'shop_client_id' => $shopClientID,
                'shop_client_contract_id' => $shopClientContractID,
                'shop_client_attorney_id' => $shopClientAttorneyID,
                'is_exit' => TRUE,
                'is_charity' => FALSE,
                'is_delivery' => TRUE,
                'shop_act_service_id' => 0,
                'sort_by' => array('shop_product_id.name' => 'asc'),
            )
        );
        // получаем список дополнительных услуг
        $shopAdditionIDs = Request_Request::find('DB_Ab1_Shop_Addition_Service_Item',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_product_id' => array('name'),
                'shop_car_id' => array('ticket', 'name', 'id'),
                'shop_piece_id' => array('ticket', 'name', 'id'),
            )
        );

        $this->_sitePageData->replaceDatas['view::_shop/act/service/list/virtual/addition-service'] = Helpers_View::getViewObjects(
            $shopAdditionIDs, new Model_Ab1_Shop_Addition_Service_Item(),
            '_shop/act/service/list/virtual/addition-service', '_shop/act/service/one/virtual/addition-service',
            $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/act/service/virtual/show');
    }

    public function action_virtual_edit() {
        $this->_sitePageData->url = '/sbyt/shopactservice/virtual_edit';

        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        $shopClientAttorneyID = Request_RequestParams::getParamInt('shop_client_attorney_id');
        $shopClientContractID = Request_RequestParams::getParamInt('shop_client_contract_id');

        $this->_requestShopClientAttorney($shopClientID, $shopClientAttorneyID, 'option');
        $this->_requestShopClientContract($shopClientID, $shopClientContractID, 'list', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK);

        $dataID = new MyArray();
        $dataID->id = $shopClientID;

        $model = new Model_Ab1_Shop_Client();
        $model->setDBDriver($this->_driverDB);
        $result = Helpers_View::getViewObject($dataID, $model,
            '_shop/act/service/one/virtual/edit', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
    }

    public function action_virtual_break() {
        $this->_sitePageData->url = '/sbyt/shopactservice/virtual_break';

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');
        $shopClientID = Request_RequestParams::getParamInt('shop_client_id');
        $shopClientAttorneyIDFrom = Request_RequestParams::getParamInt('shop_client_attorney_id_from');
        $shopClientAttorneyIDTo = Request_RequestParams::getParamInt('shop_client_attorney_id_to');
        $shopClientContractIDFrom = Request_RequestParams::getParamInt('shop_client_contract_id_from');
        $shopClientContractIDTo = Request_RequestParams::getParamInt('shop_client_contract_id_to');

        Api_Ab1_Shop_Car::breakDeliveryAttorney(
            $dateFrom, $dateTo,
            $shopClientID,
            $shopClientAttorneyIDFrom, $shopClientAttorneyIDTo,
            $shopClientContractIDFrom, $shopClientContractIDTo,
            Request_RequestParams::getParamFloat('amount'),
            $this->_sitePageData, $this->_driverDB
        );

        self::redirect(
            '/sbyt/shopactservice/virtual_index'
            .URL::query(
                array(
                    'date_from' => $dateFrom,
                    'date_to' => $dateTo,
                    'shop_client_id' =>  array($shopClientID),
                ), FALSE
            )
        );
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/sbyt/shopactservice/del';
        $result = Api_Ab1_Shop_Act_Service::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => !$result)));
    }
}
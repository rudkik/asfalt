<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopClientContract extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client_Contract';
        $this->controllerName = 'shopclientcontract';
        $this->tableID = Model_Ab1_Shop_Client_Contract::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client_Contract::TABLE_NAME;
        $this->objectName = 'client/contract';

        parent::__construct($request, $response);
    }

    public function action_json() {
        $this->_sitePageData->url = '/atc/shopclientcontract/json';
        $this->_getJSONList(
            $this->_sitePageData->shopMainID,
            Request_RequestParams::setParams(
                array(
                    'client_contract_type_id' => Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT,
                    'sort_by' => array(
                        'number' => 'desc'
                    )
                )
            )
        );
    }

    public function action_index() {
        $this->_sitePageData->url = '/atc/shopclientcontract/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/contract/list/index',
            )
        );

        $this->_requestClientContractTypes(null, true);
        $this->_requestClientContractStatuses();
        $this->_requestShopWorkers();
        $this->_requestListDB('DB_Ab1_ClientContract_View');

        $params = array(
            'is_basic' => true,
            'sort_by' => [
                'operation_updated_at' => 'desc',
                'updated_at' => 'desc',
            ],
            'limit' => 1000,
            'limit_page' => 25,
            'client_contract_type_id.interface_ids_in' => [Model_Ab1_Shop_Operation::RUBRIC_ATC],
        );

        if($this->_sitePageData->operation->getShopDepartmentID() > 0){
            $params['shop_department_id'] = $this->_sitePageData->operation->getShopDepartmentID();
        }

        // получаем список
        View_View::find('DB_Ab1_Shop_Client_Contract',
            $this->_sitePageData->shopMainID,
            "_shop/client/contract/list/index", "_shop/client/contract/one/index",
            $this->_sitePageData, $this->_driverDB,
            $params,
            array(
                'shop_client_id' => array('name', 'bin'),
                'client_contract_type_id' => array('name'),
                'client_contract_status_id' => array('name'),
                'client_contract_view_id' => array('name'),
                'executor_shop_worker_id' => array('name'),
                'currency_id' => array('symbol'),
            )
        );

        $this->_putInMain('/main/_shop/client/contract/index');
    }

    public function action_child() {
        $this->_sitePageData->url = '/atc/shopclientcontract/child';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/contract/list/index',
            )
        );

        // получаем список
        $data = View_View::find('DB_Ab1_Shop_Client_Contract',
            $this->_sitePageData->shopMainID, "_shop/client/contract/list/child",
            "_shop/client/contract/one/child",
            $this->_sitePageData, $this->_driverDB, array('is_public_ignore' => true),
            array(
                'shop_client_id' => array('name'),
                'client_contract_type_id' => array('name'),
                'client_contract_view_id' => array('name'),
                'client_contract_status_id' => array('name'),
                'executor_shop_worker_id' => array('name'),
                'currency_id' => array('symbol'),
            )
        );

        $this->response->body($data);
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/atc/shopclientcontract/edit';
        $this->_actionShopClientContractEdit();
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/atc/shopclientcontract/new';
        $this->_actionShopClientContractNew();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/atc/shopclientcontract/save';

        $result = Api_Ab1_Shop_Client_Contract::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/atc/shopclientcontract/del';
        $result = Api_Ab1_Shop_Client_Contract::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_items()
    {
        $this->_sitePageData->url = '/atc/shopclientcontract/items';
        $this->_actionShopClientContractItems();
    }
}

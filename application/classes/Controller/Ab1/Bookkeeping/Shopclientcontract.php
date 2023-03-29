<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bookkeeping_ShopClientContract extends Controller_Ab1_Bookkeeping_BasicAb1 {

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
        $this->_sitePageData->url = '/bookkeeping/shopclientcontract/json';

        $this->_getJSONList(
            $this->_sitePageData->shopMainID,
            Request_RequestParams::setParams(
                array(
                    'client_contract_type_id' => Model_Ab1_ClientContract_Type::CLIENT_CONTRACT_TYPE_SALE_PRODUCT,
                    'is_basic' => true,
                    'sort_by' => array(
                        'number' => 'desc'
                    )
                )
            )
        );
    }

    public function action_index() {
        $this->_sitePageData->url = '/bookkeeping/shopclientcontract/index';

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

        $view = Request_RequestParams::getParamInt('client_contract_view_id');
        $params = array(
            'limit' => 1000, 'limit_page' => 25,
            'is_basic' => true,
            'sort_by' => [
                'operation_updated_at' => 'desc',
                'updated_at' => 'desc',
            ],
            //'is_basic' =>  empty($view) || $view == Model_Ab1_ClientContract_View::CLIENT_CONTRACT_VIEW_BASIC
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Client_Contract',
            $this->_sitePageData->shopMainID,
            "_shop/client/contract/list/index", "_shop/client/contract/one/index",
            $this->_sitePageData, $this->_driverDB,
            $params,
            array(
                'shop_client_id' => array('name'),
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
        $this->_sitePageData->url = '/bookkeeping/shopclientcontract/child';

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
        $this->_sitePageData->url = '/bookkeeping/shopclientcontract/edit';
        $this->_actionShopClientContractEdit();
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bookkeeping/shopclientcontract/new';
        $this->_actionShopClientContractNew();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bookkeeping/shopclientcontract/save';

        $result = Api_Ab1_Shop_Client_Contract::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/bookkeeping/shopclientcontract/del';
        $result = Api_Ab1_Shop_Client_Contract::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_save_word()
    {
        $this->_sitePageData->url = '/bookkeeping/shopclientcontract/save_word';

        Api_Ab1_Shop_Client_Contract::saveContractWord('contract.docx', $this->_sitePageData, $this->_driverDB);
        exit;
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/contract/one/edit',
                'view::_shop/client/contract/item/list/item',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Client_Contract();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Client contract not is found!');
        }

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestShopProductRubrics();


        $params = Request_RequestParams::setParams(
            array(
                'shop_client_contract_id' => $id,
                'sort_by' => array('id' => 'asc'),
            )
        );
        View_View::find('DB_Ab1_Shop_Client_Contract_Item', $this->_sitePageData->shopMainID, '_shop/client/contract/item/list/item',
            '_shop/client/contract/item/one/item', $this->_sitePageData, $this->_driverDB, $params);

        // получаем данные
        $model->getElement('shop_client_id', TRUE, $this->_sitePageData->shopMainID);
        $dataID = new MyArray();
        $dataID->setValues($model, $this->_sitePageData);
        $this->_sitePageData->replaceDatas['view::_shop/client/contract/one/edit'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Client_Contract(),
            '_shop/client/contract/one/edit', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/client/contract/edit');
    }
}

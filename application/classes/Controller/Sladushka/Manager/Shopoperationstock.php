<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sladushka_Manager_ShopOperationStock extends Controller_Sladushka_Manager_BasicCabinet {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopoperationstock';
        $this->tableID = Model_Shop_Operation_Stock::TABLE_ID;
        $this->tableName = Model_Shop_Operation_Stock::TABLE_NAME;
        $this->objectName = 'operationstock';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index(){
        $this->_sitePageData->url = '/manager/shopoperationstock/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/stock/list/index',
            )
        );

        View_View::find('DB_Shop_Operation_Stock', $this->_sitePageData->shopID, '_shop/operation/stock/list/index', '_shop/operation/stock/one/index',
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25, 'create_user_id' => $this->_sitePageData->userID));

        $this->_putInMain('/main/_shop/operation/stock/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/manager/shopoperationstock/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('OperationStock not is found!');
        }else {
            $model = new Model_Shop_Operation_Stock();
            if (!$this->getDBObject($model, $id)) {
                throw new HTTP_Exception_404('OperationStock not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/stock/one/edit',
                'view::_shop/operation/stock/item/list/index',
            )
        );

        // получаем список товаров
        View_View::find('DB_Shop_Operation_Stock_Item', $this->_sitePageData->shopID, "_shop/operation/stock/item/list/index", "_shop/operation/stock/item/one/index",
            $this->_sitePageData, $this->_driverDB, array('shop_operationstock_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array('shop_good_id'));

        // получаем данные
        View_View::findOne('DB_Shop_Operation_Stock', $this->_sitePageData->shopID, "_shop/operation/stock/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_operationstock_catalog_id'));

        $this->_putInMain('/main/_shop/operation/stock/edit');
    }

    /**
     * Изменение
     */
    public function action_save(){
        $this->_sitePageData->url = '/manager/shopoperationstock/save';
        $result = Api_Shop_Operation_Stock::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del() {
        $this->_sitePageData->url = '/manager/shopoperationstock/del';
        Api_Shop_Operation_Stock::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => FALSE)));
    }
}

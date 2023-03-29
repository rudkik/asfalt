<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sladushka_Manager_ShopBill extends Controller_Sladushka_Manager_BasicCabinet {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopbill';
        $this->tableID = Model_Shop_Bill::TABLE_ID;
        $this->tableName = Model_Shop_Bill::TABLE_NAME;
        $this->objectName = 'bill';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index(){
        $this->_sitePageData->url = '/manager/shopbill/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/list/index',
            )
        );

        View_View::find('DB_Shop_Bill', $this->_sitePageData->shopID, '_shop/bill/list/index', '_shop/bill/one/index',
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25, 'create_user_id' => $this->_sitePageData->userID), array('shop_root_id'));

        $this->_putInMain('/main/_shop/bill/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/manager/shopbill/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Bill not is found!');
        }else {
            $model = new Model_Shop_Bill();
            if (!$this->getDBObject($model, $id)) {
                throw new HTTP_Exception_404('Bill not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bill/one/edit',
                'view::_shop/bill/item/list/index',
            )
        );

        // получаем список товаров
        View_View::find('DB_Shop_Bill_Item', $this->_sitePageData->shopID, "_shop/bill/item/list/index", "_shop/bill/item/one/index",
            $this->_sitePageData, $this->_driverDB, array('shop_bill_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array('shop_good_id'));

        // получаем данные
        View_View::findOne('DB_Shop_Bill', $this->_sitePageData->shopID, "_shop/bill/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/bill/edit');
    }

    /**
     * Изменение
     */
    public function action_save(){
        $this->_sitePageData->url = '/manager/shopbill/save';
        $result = Api_Shop_Bill::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del() {
        $this->_sitePageData->url = '/manager/shopbill/del';
        Api_Shop_Bill::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => FALSE)));
    }
}

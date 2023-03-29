<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sladushka_Manager_ShopReturn extends Controller_Sladushka_Manager_BasicCabinet {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopreturn';
        $this->tableID = Model_Shop_Return::TABLE_ID;
        $this->tableName = Model_Shop_Return::TABLE_NAME;
        $this->objectName = 'return';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index(){
        $this->_sitePageData->url = '/manager/shopreturn/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/return/list/index',
            )
        );

        View_View::find('DB_Shop_Return', $this->_sitePageData->shopID, '_shop/return/list/index', '_shop/return/one/index',
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25, 'create_user_id' => $this->_sitePageData->userID), array('shop_root_id'));

        $this->_putInMain('/main/_shop/return/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/manager/shopreturn/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Return not is found!');
        }else {
            $model = new Model_Shop_Return();
            if (!$this->getDBObject($model, $id)) {
                throw new HTTP_Exception_404('Return not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/return/one/edit',
                'view::_shop/return/item/list/index',
            )
        );

        // получаем список товаров
        View_View::find('DB_Shop_Return_Item', $this->_sitePageData->shopID, "_shop/return/item/list/index", "_shop/return/item/one/index",
            $this->_sitePageData, $this->_driverDB, array('shop_return_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array('shop_good_id'));

        // получаем данные
        View_View::find('DB_Shop_Return', $this->_sitePageData->shopID, "_shop/return/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_return_catalog_id'));

        $this->_putInMain('/main/_shop/return/edit');
    }

    /**
     * Изменение
     */
    public function action_save(){
        $this->_sitePageData->url = '/manager/shopreturn/save';
        $result = Api_Shop_Return::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del() {
        $this->_sitePageData->url = '/manager/shopreturn/del';
        Api_Shop_Return::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => FALSE)));
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopClientGuarantee extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client_Guarantee';
        $this->controllerName = 'shopclientguarantee';
        $this->tableID = Model_Ab1_Shop_Client_Guarantee::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client_Guarantee::TABLE_NAME;
        $this->objectName = 'client/guarantee';

        parent::__construct($request, $response);
    }

    public function action_json() {
        $this->_sitePageData->url = '/peo/shopclientguarantee/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }

    public function action_index() {
        $this->_sitePageData->url = '/peo/shopclientguarantee/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/guarantee/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Client_Guarantee', $this->_sitePageData->shopMainID, "_shop/client/guarantee/list/index",
            "_shop/client/guarantee/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_main_shop' => FALSE, 'limit' => 1000, 'limit_page' => 25), array('shop_client_id' => array('name')));

        $this->_putInMain('/main/_shop/client/guarantee/index');
    }


    public function action_edit()
    {
        $this->_sitePageData->url = '/peo/shopclientguarantee/edit';
        $this->_actionShopClientGuaranteeEdit();
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/peo/shopclientguarantee/new';
        $this->_actionShopClientGuaranteeNew();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/peo/shopclientguarantee/save';

        $result = Api_Ab1_Shop_Client_Guarantee::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/peo/shopclientguarantee/del';
        $result = Api_Ab1_Shop_Client_Guarantee::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}

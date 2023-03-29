<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopRegisterRaw extends Controller_Ab1_Abc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Register_Raw';
        $this->controllerName = 'shopregisterraw';
        $this->tableID = Model_Ab1_Shop_Register_Raw::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Register_Raw::TABLE_NAME;
        $this->objectName = 'registerraw';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/abc/shopregisterraw/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/register/raw/list/index',
            )
        );

        // основная продукция
        $this->_requestShopRaws();

        // получаем список
        View_View::findBranch(
            'DB_Ab1_Shop_Register_Raw', array(),
            "_shop/register/raw/list/index", "_shop/register/raw/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_raw_id' => array('name'),
                'shop_subdivision_id' => array('name'),
                'shop_heap_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/register/raw/index');
    }
}

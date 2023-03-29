<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_ShopHeap extends Controller_Ab1_Abc_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Heap';
        $this->controllerName = 'shopheap';
        $this->tableID = Model_Ab1_Shop_Heap::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Heap::TABLE_NAME;
        $this->objectName = 'heap';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/abc/shopheap/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/heap/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Heap',
            $this->_sitePageData->shopID,
            "_shop/heap/list/index", "_shop/heap/one/index",
            $this->_sitePageData, $this->_driverDB,
            array(
                'limit' => 1000,
                'limit_page' => 25
            ),
            array('shop_subdivision_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/heap/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/abc/shopheap/new';
        $this->_actionShopHeapNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/abc/shopheap/edit';
        $this->_actionShopHeapEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/abc/shopheap/save';

        $result = Api_Ab1_Shop_Heap::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

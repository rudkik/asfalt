<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Train_ShopRaw extends Controller_Ab1_Train_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Raw';
        $this->controllerName = 'shopraw';
        $this->tableID = Model_Ab1_Shop_Raw::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Raw::TABLE_NAME;
        $this->objectName = 'raw';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/train/shopraw/index';

        $this->_requestListDB(DB_Ab1_Shop_Raw_Rubric::NAME);

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Raw', $this->_sitePageData->shopMainID,
            "_shop/raw/list/index", "_shop/raw/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array('shop_raw_rubric_id' => ['name'])
        );

        $this->_putInMain('/main/_shop/raw/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/train/shopraw/new';
        $this->_actionShopRawNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/train/shopraw/edit';
        $this->_actionShopRawEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/train/shopraw/save';

        $result = Api_Ab1_Shop_Raw::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

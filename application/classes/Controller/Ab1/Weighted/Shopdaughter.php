<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopDaughter extends Controller_Ab1_Weighted_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Daughter';
        $this->controllerName = 'shopdaughter';
        $this->tableID = Model_Ab1_Shop_Daughter::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Daughter::TABLE_NAME;
        $this->objectName = 'daughter';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shopdaughter/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/daughter/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Daughter', $this->_sitePageData->shopMainID, "_shop/daughter/list/index", "_shop/daughter/one/index",
            $this->_sitePageData, $this->_driverDB, array('is_main_shop' => FALSE, 'limit' => 1000, 'limit_page' => 25));

        $this->_putInMain('/main/_shop/daughter/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopdaughter/new';
        $this->_actionShopDaughterNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopdaughter/edit';
        $this->_actionShopDaughterEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopdaughter/save';

        $result = Api_Ab1_Shop_Daughter::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_json() {
        $this->_sitePageData->url = '/weighted/shopdaughter/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }
}

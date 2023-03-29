<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopTurnPlace extends Controller_Ab1_Weighted_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Turn_Place';
        $this->controllerName = 'shopturnplace';
        $this->tableID = Model_Ab1_Shop_Turn_Place::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Turn_Place::TABLE_NAME;
        $this->objectName = 'turnplace';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shopturnplace/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/turn/place/list/index',
            )
        );

        $this->_requestShopTurnTypes();

        // получаем список
        View_View::find('DB_Ab1_Shop_Turn_Place',
            $this->_sitePageData->shopID,
            "_shop/turn/place/list/index", "_shop/turn/place/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('is_main_shop' => FALSE, 'limit' => 1000, 'limit_page' => 25),
            array(
                'shop_turn_type_id' => array('name'),
                'shop_subdivision_id' => array('name'),
                'shop_storage_id' => array('name'),
                'shop_heap_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/turn/place/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopturnplace/new';
        $this->_actionShopTurnPlaceNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopturnplace/edit';
        $this->_actionShopTurnPlaceEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopturnplace/save';

        $result = Api_Ab1_Shop_Turn_Place::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

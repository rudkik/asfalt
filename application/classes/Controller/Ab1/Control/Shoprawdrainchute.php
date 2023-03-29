<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Control_ShopRawDrainChute extends Controller_Ab1_Control_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Raw_DrainChute';
        $this->controllerName = 'shoprawdrainchute';
        $this->tableID = Model_Ab1_Shop_Raw_DrainChute::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Raw_DrainChute::TABLE_NAME;
        $this->objectName = 'rawdrainchute';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/control/shoprawdrainchute/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/drain-chute/list/index',
            )
        );

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Raw_DrainChute', $this->_sitePageData->shopID,
            "_shop/raw/drain-chute/list/index", "_shop/raw/drain-chute/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_raw_id' => array('name'),
                'shop_boxcar_client_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/raw/drain-chute/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/control/shoprawdrainchute/new';
        $this->_actionShopRawDrainChuteNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/control/shoprawdrainchute/edit';
        $this->_actionShopRawDrainChuteEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/control/shoprawdrainchute/save';

        $result = Api_Ab1_Shop_Raw_DrainChute::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

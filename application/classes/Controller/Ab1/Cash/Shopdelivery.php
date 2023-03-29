<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cash_ShopDelivery extends Controller_Ab1_Cash_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Delivery';
        $this->controllerName = 'shopdelivery';
        $this->tableID = Model_Ab1_Shop_Delivery::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Delivery::TABLE_NAME;
        $this->objectName = 'delivery';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/cash/shopdelivery/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/list/index',
            )
        );

        $this->_requestShopDeliveryGroups();

        // получаем список
        View_View::find('DB_Ab1_Shop_Delivery',
            $this->_sitePageData->shopMainID,
            "_shop/delivery/list/index", "_shop/delivery/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25),
            array('delivery_type_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/delivery/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cash/shopdelivery/new';
        $this->_actionShopDeliveryNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cash/shopdelivery/edit';
        $this->_actionShopDeliveryEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cash/shopdelivery/save';

        $result = Api_Ab1_Shop_Delivery::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

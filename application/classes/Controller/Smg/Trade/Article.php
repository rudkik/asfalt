<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Trade_Article extends Controller_Smg_Trade_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Product';
        $this->controllerName = 'article';
        $this->tableID = Model_AutoPart_Shop_Product::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Product::TABLE_NAME;
        $this->objectName = 'article';

        parent::__construct($request, $response);
    }

    public function action_about()
    {
        $this->_sitePageData->url = '/trade/about';

        View_View::find(
            'DB_Shop_New',
            $this->_sitePageData->shopID,
            "_shop/article/about/list/index", "_shop/article/about/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('shop_table_rubric_id' => 1)
        );


        $this->_putInMain('/main/_shop/article/about');
    }

    public function action_ruleswork()
    {
        $this->_sitePageData->url = '/trade/ruleswork';

        View_View::find(
            'DB_Shop_New',
            $this->_sitePageData->shopID,
            "_shop/article/ruleswork/list/index", "_shop/article/ruleswork/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('shop_table_rubric_id' => 2)
        );



        $this->_putInMain('/main/_shop/article/ruleswork');
    }

    public function action_payment()
    {
        $this->_sitePageData->url = '/trade/payment';

        View_View::find(
            'DB_Shop_New',
            $this->_sitePageData->shopID,
            "_shop/article/payment/list/index", "_shop/article/payment/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('shop_table_rubric_id' => 3)
        );


        $this->_putInMain('/main/_shop/article/payment');
    }

    public function action_delivery()
    {
        $this->_sitePageData->url = '/trade/delivery';

        View_View::find(
            'DB_Shop_New',
            $this->_sitePageData->shopID,
            "_shop/article/delivery/list/index", "_shop/article/delivery/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('shop_table_rubric_id' => 4)
        );

        $this->_putInMain('/main/_shop/article/delivery');
    }

    public function action_partners()
    {
        $this->_sitePageData->url = '/trade/partners';

        View_View::find(
            'DB_Shop_New',
            $this->_sitePageData->shopID,
            "_shop/article/partners/list/index", "_shop/article/partners/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('shop_table_rubric_id' => 5)
        );

        $this->_putInMain('/main/_shop/article/partners');
    }

    public function action_bonus()
    {
        $this->_sitePageData->url = '/trade/bonus';

        View_View::find(
            'DB_Shop_New',
            $this->_sitePageData->shopID,
            "_shop/article/bonus/list/index", "_shop/article/bonus/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('shop_table_rubric_id' => 6)
        );


        $this->_putInMain('/main/_shop/article/bonus');
    }
}

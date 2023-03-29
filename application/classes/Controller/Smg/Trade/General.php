<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Trade_General extends Controller_Smg_Trade_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Product';
        $this->controllerName = 'general';
        $this->tableID = Model_AutoPart_Shop_Product::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Product::TABLE_NAME;
        $this->objectName = 'general';

        parent::__construct($request, $response);
    }


    public function action_index()
    {
        $this->_sitePageData->url = '/trade/general/index';

        // получаем Меню
        View_View::find(
            'DB_AutoPart_Shop_Rubric',
            $this->_sitePageData->shopID,
            "_shop/rubric/list/menu", "_shop/rubric/one/menu",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'is_tree' => true,
                )
            )
        );

        // Рекомендованные товары
        View_View::find(
            'DB_AutoPart_Shop_Product',
            $this->_sitePageData->shopID,
            "_shop/product/list/recommend", "_shop/product/one/main",
            $this->_sitePageData, $this->_driverDB,
            array(
                'limit_page' => 10,
                //'is_recommend' => true,
            )
        );

        // Популярные товары
        View_View::find(
            'DB_AutoPart_Shop_Product',
            $this->_sitePageData->shopID,
            "_shop/product/list/popular", "_shop/product/one/main",
            $this->_sitePageData, $this->_driverDB,
            array(
                'limit_page' => 5,
                //'is_popular' => true,
            )
        );

        // лучшие цены на  товары
        View_View::find(
            'DB_AutoPart_Shop_Product',
            $this->_sitePageData->shopID,
            "_shop/product/list/price", "_shop/product/one/main",
            $this->_sitePageData, $this->_driverDB,
            array(
                'limit_page' => 5,
            )
        );

        // получаем список (часто ищут)
        View_View::find(
            'DB_AutoPart_Shop_Rubric',
            $this->_sitePageData->shopID,
            "_shop/rubric/list/common", "_shop/rubric/one/common",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                'limit_page' => 20,
                //'is_common' => true,
                )
            )

        );

            
        $this->_putInMain('/main/_shop/general/index');
    }


}

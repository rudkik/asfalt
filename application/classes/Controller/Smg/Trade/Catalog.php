<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Trade_Catalog extends Controller_Smg_Trade_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Product';
        $this->controllerName = 'catalog';
        $this->tableID = Model_AutoPart_Shop_Product::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Product::TABLE_NAME;
        $this->objectName = 'catalog';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/trade/catalog/index';
        $id = intval(Request_RequestParams::getParamInt('id'));


        //Хлебные крошки
        View_Shop_Table_Rubric::findBreadCrumbs(
            'DB_AutoPart_Shop_Rubric',
            $this->_sitePageData->shopID,
            "_shop/rubric/list/breadcrumb", "_shop/rubric/one/breadcrumb",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['id' => $id])
        );

        //Название
        View_View::findOne(
            'DB_AutoPart_Shop_Rubric',
            $this->_sitePageData->shopID, "_shop/rubric/one/show",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['id' => $id])
        );

        //список Рубрики
        View_View::find(
            'DB_AutoPart_Shop_Rubric',
            $this->_sitePageData->shopID,
            "_shop/rubric/list/index", "_shop/rubric/one/index",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['root_id' => $id])
        );

        // получаем список продуктов
        View_View::find(
            'DB_AutoPart_Shop_Product',
            $this->_sitePageData->shopID,
            "_shop/product/list/index", "_shop/product/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit_page' => 16)
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

        $this->_putInMain('/main/_shop/product/index');

    }

    public function action_product()
    {
        $this->_sitePageData->url = '/trade/catalog/product';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Product();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        //Хлебные крошки
        View_Shop_Table_Rubric::findBreadCrumbs(
            'DB_AutoPart_Shop_Rubric',
            $this->_sitePageData->shopID,
            "_shop/rubric/list/breadcrumb", "_shop/rubric/one/breadcrumb",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['id' => $model->getShopRubricID()])
        );

        // получаем данные
        View_View::findOne('DB_AutoPart_Shop_Product', $this->_sitePageData->shopID, "_shop/product/one/show",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_rubric_id'));

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

        $this->_putInMain('/main/_shop/product/show');
    }

    public function action_main()
    {
        $this->_sitePageData->url = '/trade/catalog/main';

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
            
        $this->_putInMain('/main/_shop/product/main');
    }

    //поиск
    public function action_find()
    {
        $this->_sitePageData->url = '/trade/catalog/find';

        //список Рубрики
        View_View::find(
            'DB_AutoPart_Shop_Rubric',
            $this->_sitePageData->shopID,
            "_shop/rubric/list/index", "_shop/rubric/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit_page' => 16)
        );

        // получаем список продуктов
        View_View::find(
            'DB_AutoPart_Shop_Product',
            $this->_sitePageData->shopID,
            "_shop/product/list/index", "_shop/product/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit_page' => 16)
        );


        $this->_putInMain('/main/_shop/product/find');
    }




    public function action_messageadd()
    {
        $this->_sitePageData->url = '/trade/catalog/messageadd';




        $this->_putInMain('/main/_shop/messageadd');
    }

}

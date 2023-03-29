<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cash_ShopProduct extends Controller_Ab1_Cash_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Product';
        $this->controllerName = 'shopproduct';
        $this->tableID = Model_Ab1_Shop_Product::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Product::TABLE_NAME;
        $this->objectName = 'product';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/cash/shopproduct/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/list/index',
            )
        );

        $this->_requestShopProductRubrics();
        $this->_requestShopProductPricelistRubrics();

        // получаем список
        View_View::find('DB_Ab1_Shop_Product',
            $this->_sitePageData->shopID, "_shop/product/list/index", "_shop/product/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_product_rubric_id' => array('name'),
                'shop_product_group_id' => array('name'),
                'product_type_id' => array('name'),
                'product_view_id' => array('name'),
                'shop_subdivision_id' => array('name'),
                'shop_storage_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/product/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cash/shopproduct/new';
        $this->_actionShopProductNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cash/shopproduct/edit';
        $this->_actionShopProductEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cash/shopproduct/save';

        $result = Api_Ab1_Shop_Product::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_get_price()
    {
        $this->_sitePageData->url = '/cash/shopproduct/get_price';
        $this->_actionShopCarGetPrice();
    }

    public function action_define_time_price()
    {
        set_time_limit(3600000);
        ignore_user_abort(TRUE);
        ini_set('max_execution_time', 360000);
        $this->_sitePageData->url = '/cash/shopproduct/define_time_price';

        Api_Ab1_Shop_Product_Time_Price::defineProductTimePrice($this->_sitePageData, $this->_driverDB);
        Api_Ab1_Shop_Product_Time_Price::checkProductPrice($this->_sitePageData, $this->_driverDB);
        Api_Ab1_Shop_Product_Time_Price::correctProductPrice($this->_sitePageData, $this->_driverDB);
        Api_Ab1_Shop_Product_Time_Price::checkProductPrice($this->_sitePageData, $this->_driverDB);

        if(Request_RequestParams::getParamBoolean('is_calc_client')) {
            $shopClientIDs = Request_Request::find('DB_Ab1_Shop_Client',
                $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    array(
                        'sort_by' => array('updated_at' => 'desc')
                    )
                )
            );

            foreach ($shopClientIDs->childs as $child) {
                Api_Ab1_Shop_Client::recountBalanceAll($child->id, $this->_sitePageData, $this->_driverDB);
            }
        }
        echo 'ok'; die;
        self::redirect('/cash/shopproduct/index');
    }
}

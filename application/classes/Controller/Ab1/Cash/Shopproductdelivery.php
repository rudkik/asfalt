<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cash_ShopProductDelivery extends Controller_Ab1_Cash_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Product_Delivery';
        $this->controllerName = 'shopproductdelivery';
        $this->tableID = Model_Ab1_Shop_Product_Delivery::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Product_Delivery::TABLE_NAME;
        $this->objectName = 'productdelivery';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/cash/shopproductdelivery/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/delivery/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Product_Delivery', $this->_sitePageData->shopMainID, "_shop/product/delivery/list/index", "_shop/product/delivery/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array('shop_product_id' => array('name'), 'shop_delivery_id' => array('name')));

        $this->_putInMain('/main/_shop/product/delivery/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cash/shopproductdelivery/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/delivery/one/new',
                'view::_shop/delivery/list/to-product',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        View_View::find('DB_Ab1_Shop_Delivery', $this->_sitePageData->shopMainID,
            "_shop/delivery/list/to-product", "_shop/delivery/one/to-product", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 'sort_by' => array('value' => array('name' => 'asc'))));

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/product/delivery/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Product_Delivery(),
            '_shop/product/delivery/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/product/delivery/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cash/shopproductdelivery/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/delivery/one/edit',
                'view::_shop/delivery/list/to-product',
            )
        );

        // id записи
        $shopProductID = Request_RequestParams::getParamInt('shop_product_id');
        if ($shopProductID === NULL) {
            throw new HTTP_Exception_404('Product not is found!');
        }

        // основная продукция
        $this->_requestShopProducts(
            $shopProductID, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $deliveries = Request_Request::find('DB_Ab1_Shop_Delivery', $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            array('sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $productDeliveries = Request_Request::find('DB_Ab1_Shop_Product_Delivery', $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            array('shop_product_id' => $shopProductID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        foreach($productDeliveries->childs as $productDelivery){
            $delivery = $deliveries->findChild($productDelivery->values['shop_delivery_id']);
            if($delivery !== NULL){
                $delivery->additionDatas['group'] = 1;
            }
        }
        $this->_sitePageData->replaceDatas['view::_shop/delivery/list/to-product'] = Helpers_View::getViewObjects($deliveries, new Model_Ab1_Shop_Delivery(),
            '_shop/delivery/list/to-product', '_shop/delivery/one/to-product', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Product_Delivery', $this->_sitePageData->shopMainID, "_shop/product/delivery/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopProductID));

        $this->_putInMain('/main/_shop/product/delivery/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cash/shopproductdelivery/save';

        $result = Api_Ab1_Shop_Product_Delivery::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/cash/shopproductdelivery/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/cash/shopproductdelivery/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }
        }
    }

    public function action_save_list()
    {
        $this->_sitePageData->url = '/cash/shopproductdelivery/save_list';

        $result = Api_Ab1_Shop_Product_Delivery::saveList($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result === FALSE) {
            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/cash/shopproductdelivery/edit'
                    . URL::query(
                        array(
                            'shop_product_id' => $result['shop_product_id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/cash/shopproductdelivery/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }
        }
    }
}

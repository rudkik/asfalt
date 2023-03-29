<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bid_ShopSupplierPrice extends Controller_Ab1_Bid_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Supplier_Price';
        $this->controllerName = 'shopsupplierprice';
        $this->tableID = Model_Ab1_Shop_Supplier_Price::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Supplier_Price::TABLE_NAME;
        $this->objectName = 'supplierprice';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/bid/shopsupplierprice/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/supplier/price/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );
        $this->_requestShopSuppliers();

        // получаем список
        View_View::find('DB_Ab1_Shop_Supplier_Price', $this->_sitePageData->shopID,
            "_shop/supplier/price/list/index", "_shop/supplier/price/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array('shop_product_id' => array('name'), 'shop_supplier_id' => array('name')));

        $this->_putInMain('/main/_shop/supplier/price/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bid/shopsupplierprice/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/supplier/price/one/new',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestShopSuppliers();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/supplier/price/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Supplier_Price(),
            '_shop/supplier/price/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/supplier/price/new');
    }

    public function action_new_list()
    {
        $this->_sitePageData->url = '/bid/shopsupplierprice/new_list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/supplier/price/one/new',
                'view::_shop/supplier/price/list/item',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestShopSuppliers();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/supplier/price/list/item'] =
            Helpers_View::getViewObjects($dataID, new Model_Ab1_Shop_Supplier_Price(),
                '_shop/supplier/price/list/item', '_shop/supplier/price/one/item',
                $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/supplier/price/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Supplier_Price(),
            '_shop/supplier/price/one/list/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/supplier/price/new-list');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bid/shopsupplierprice/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/supplier/price/one/edit',
            )
        );

        // id записи
        $shopSupplierPriceID = Request_RequestParams::getParamInt('id');
        if ($shopSupplierPriceID === NULL) {
            throw new HTTP_Exception_404('Supplier price not is found!');
        } else {
            $model = new Model_Ab1_Shop_Supplier_Price();
            if (!$this->dublicateObjectLanguage($model, $shopSupplierPriceID)) {
                throw new HTTP_Exception_404('Supplier price not is found!');
            }
        }

        // основная продукция
        $this->_requestShopProducts(
            $model->getShopProductID(), 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestShopSuppliers($model->getShopSupplierID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Supplier_Price', $this->_sitePageData->shopID,
            "_shop/supplier/price/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopSupplierPriceID), array('shop_supplier_id'));

        $this->_putInMain('/main/_shop/supplier/price/edit');
    }

    public function action_edit_list()
    {
        $this->_sitePageData->url = '/bid/shopsupplierprice/edit_list';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/supplier/price/one/edit',
                'view::_shop/supplier/price/list/item',
            )
        );

        // id записи
        $shopSupplierPriceID = Request_RequestParams::getParamInt('id');
        if ($shopSupplierPriceID === NULL) {
            throw new HTTP_Exception_404('Supplier price not is found!');
        } else {
            $model = new Model_Ab1_Shop_Supplier_Price();
            if (!$this->dublicateObjectLanguage($model, $shopSupplierPriceID)) {
                throw new HTTP_Exception_404('Supplier price not is found!');
            }
        }

        // основная продукция
        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestShopSuppliers($model->getShopSupplierID());

        $this->_sitePageData->replaceDatas['view::_shop/supplier/price/list/item'] = View_View::find('DB_Ab1_Shop_Supplier_Price',
            $this->_sitePageData->shopID,
            "_shop/supplier/price/list/item", '_shop/supplier/price/one/item', $this->_sitePageData, $this->_driverDB,
            array('shop_supplier_id' => $model->getShopSupplierID(), 'date' => $model->getDate(),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), array('shop_supplier_id'));

        // получаем данные
        $this->_sitePageData->replaceDatas['view::_shop/supplier/price/one/edit'] =
            View_View::findOne('DB_Ab1_Shop_Supplier_Price', $this->_sitePageData->shopID, "_shop/supplier/price/one/list/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopSupplierPriceID), array('shop_supplier_id'));

        $this->_putInMain('/main/_shop/supplier/price/edit-list');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bid/shopsupplierprice/save';

        $result = Api_Ab1_Shop_Supplier_Price::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if ($this->_sitePageData->branchID > 0) {
                $branchID = '&shop_branch_id=' . $this->_sitePageData->branchID;
            }

            if (Request_RequestParams::getParamBoolean('is_close') === FALSE) {
                $this->redirect('/bid/shopsupplierprice/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    . $branchID
                );
            } else {
                $this->redirect('/bid/shopsupplierprice/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    . $branchID
                );
            }
        }
    }

    public function action_save_list()
    {
        $this->_sitePageData->url = '/bid/shopsupplierprice/save_list';

        $result = Api_Ab1_Shop_Supplier_Price::saveList($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if ($this->_sitePageData->branchID > 0) {
                $branchID = '&shop_branch_id=' . $this->_sitePageData->branchID;
            }

            if ((Request_RequestParams::getParamBoolean('is_close') === FALSE) && ($result['id'] > 0)) {
                $this->redirect('/bid/shopsupplierprice/edit_list'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    . $branchID
                );
            } else {
                $this->redirect('/bid/shopsupplierprice/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    . $branchID
                );
            }
        }
    }
}

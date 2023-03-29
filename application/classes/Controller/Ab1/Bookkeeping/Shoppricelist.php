<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bookkeeping_ShopPricelist extends Controller_Ab1_Bookkeeping_BasicAb1  {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Pricelist';
        $this->controllerName = 'shoppricelist';
        $this->tableID = Model_Ab1_Shop_Pricelist::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Pricelist::TABLE_NAME;
        $this->objectName = 'pricelist';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/bookkeeping/shoppricelist/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/pricelist/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Pricelist',
            $this->_sitePageData->shopMainID,
            "_shop/pricelist/list/index", "_shop/pricelist/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_client_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/pricelist/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bookkeeping/shoppricelist/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/pricelist/one/new',
                'view::_shop/product-price/list/index',
            )
        );

        $this->_requestShopProductsBranches(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestOrganizationTypes();
        $this->_requestKatos();
        $this->_requestBanks();
        $this->_requestShopProductRubrics();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/product-price/list/index'] = Helpers_View::getViewObjects(
            $dataID, new Model_Ab1_Shop_Product(),
            '_shop/product-price/list/index', '_shop/product-price/one/index',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/pricelist/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Pricelist(), '_shop/pricelist/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $this->_putInMain('/main/_shop/pricelist/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bookkeeping/shoppricelist/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/pricelist/one/edit',
                'view::_shop/product-price/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Pricelist();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Pricelist not is found!');
        }

        $this->_requestShopProductsBranches(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestOrganizationTypes();
        $this->_requestKatos();
        $this->_requestBanks();
        $this->_requestShopProductRubrics();

        $params = Request_RequestParams::setParams(
            array(
                'shop_pricelist_id' => $id,
                'sort_by' => array('id' => 'asc')
            )
        );
        View_View::find('DB_Ab1_Shop_Product_Price',
            $this->_sitePageData->shopMainID,
            '_shop/product-price/list/index', '_shop/product-price/one/index',
            $this->_sitePageData, $this->_driverDB, $params
        );

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Pricelist', $this->_sitePageData->shopMainID, "_shop/pricelist/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_client_id'));

        $this->_putInMain('/main/_shop/pricelist/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bookkeeping/shoppricelist/save';

        $result = Api_Ab1_Shop_Pricelist::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_calc_balance()
    {
        $this->_sitePageData->url = '/bookkeeping/shoppricelist/calc_balance';

        $id = Request_RequestParams::getParamInt('id');

        $params = Request_RequestParams::setParams(
            array(
                'shop_pricelist_id' => $id,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Product_Price',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params
        );

        foreach ($ids->childs as $child){
            Api_Ab1_Shop_Product_Price::calcBalanceBlock(
                $child->id, $this->_sitePageData, $this->_driverDB
            );
        }

        $this->redirect('/bookkeeping/shoppricelist/index?id='.$id);
    }
}

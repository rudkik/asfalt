<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopProductTurnPlace extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Product_TurnPlace';
        $this->controllerName = 'shopproductturnplace';
        $this->tableID = Model_Ab1_Shop_Product_TurnPlace::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Product_TurnPlace::TABLE_NAME;
        $this->objectName = 'productturnplace';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/peo/shopproductturnplace/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/turn-place/list/index',
            )
        );

        $this->_requestShopTurnPlaces(null, 0, true);

        // получаем список
        View_View::find('DB_Ab1_Shop_Product_TurnPlace',
            $this->_sitePageData->shopID,
            "_shop/product/turn-place/list/index", "_shop/product/turn-place/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_turn_place_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/product/turn-place/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/peo/shopproductturnplace/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/turn-place/one/new',
                'view::_shop/product/turn-place/item/list/index',
            )
        );

        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestShopTurnPlaces(null, 0, true);

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/product/turn-place/item/list/index'] = Helpers_View::getViewObjects(
            $dataID, new Model_Ab1_Shop_Product(),
            '_shop/product/turn-place/item/list/index', '_shop/product/turn-place/item/one/index',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/product/turn-place/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Product_TurnPlace(), '_shop/product/turn-place/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/product/turn-place/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/peo/shopproductturnplace/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/turn-place/one/edit',
                'view::_shop/product/turn-place/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Product_TurnPlace();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Product turn place not is found!');
        }

        $this->_requestShopProducts(
            NULL, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestShopTurnPlaces($model->getShopTurnPlaceID(), 0, true);

        $params = Request_RequestParams::setParams(
            array(
                'shop_product_turn_place_id' => $id,
                'sort_by' => array('id' => 'asc')
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        View_View::find('DB_Ab1_Shop_Product_TurnPlace_Item',
            $this->_sitePageData->shopID,
            '_shop/product/turn-place/item/list/index', '_shop/product/turn-place/item/one/index',
            $this->_sitePageData, $this->_driverDB, $params
        );

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Product_TurnPlace',
            $this->_sitePageData->shopID, "_shop/product/turn-place/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array()
        );

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/product/turn-place/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/peo/shopproductturnplace/save';

        $result = Api_Ab1_Shop_Product_TurnPlace::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/peo/shopproductturnplace/del';

        $result = Api_Ab1_Shop_Product_TurnPlace::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}

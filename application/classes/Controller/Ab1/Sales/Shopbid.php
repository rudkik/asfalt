<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sales_ShopBid extends Controller_Ab1_Sales_BasicAb1
{
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Bid';
        $this->controllerName = 'shopbid';
        $this->tableID = Model_Ab1_Shop_Bid::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Bid::TABLE_NAME;
        $this->objectName = 'bid';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/sales/shopbid/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bid/list/index',
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

        // получаем список
        View_View::findBranch('DB_Ab1_Shop_Bid',
            $this->_sitePageData->shopID, "_shop/bid/list/index", "_shop/bid/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array('shop_client_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/bid/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/sales/shopbid/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bid/one/new',
                'view::_shop/bid/item/list/index',
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

        $this->_requestRejectionReasons();
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/bid/item/list/index'] =
            Helpers_View::getViewObjects(
                $dataID, new Model_Ab1_Shop_Bid(),
                '_shop/bid/item/list/index', '_shop/bid/item/one/index',
                $this->_sitePageData, $this->_driverDB
            );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/bid/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Bid(), '_shop/bid/one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/bid/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/sales/shopbid/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bid/one/edit',
                'view::_shop/bid/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Bid();
        if (!$this->dublicateObjectLanguage($model, $id, NULL, FALSE)) {
            throw new HTTP_Exception_404('Bid not is found!');
        }


        // основная продукция
        $this->_requestShopProducts(
            NULL, $this->_sitePageData->shopMainID, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestRejectionReasons();
        $this->_requestShopBranches($model->shopID, TRUE);

        $params = Request_RequestParams::setParams(
            array(
                'shop_bid_id' => $id,
                'sort_by' => array('id' => 'asc')
            )
        );
        $this->_sitePageData->replaceDatas['view::_shop/bid/item/list/index'] = View_View::find('DB_Ab1_Shop_Bid_Item',
            $this->_sitePageData->shopID, '_shop/bid/item/list/index', '_shop/bid/item/one/index',
            $this->_sitePageData, $this->_driverDB, $params
        );

        // получаем данные
        $this->_sitePageData->replaceDatas['view::_shop/bid/one/edit'] =
            View_View::findOne('DB_Ab1_Shop_Bid',
                $this->_sitePageData->shopID, "_shop/bid/one/edit",
                $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_client_id')
            );

        $this->_putInMain('/main/_shop/bid/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sales/shopbid/save';
        $result = Api_Ab1_Shop_Bid::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/sales/shopbid/del';
        $result = Api_Ab1_Shop_Bid::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}

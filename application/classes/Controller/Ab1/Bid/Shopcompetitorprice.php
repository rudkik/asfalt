<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bid_ShopCompetitorPrice extends Controller_Ab1_Bid_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Competitor_Price';
        $this->controllerName = 'shopcompetitorprice';
        $this->tableID = Model_Ab1_Shop_Competitor_Price::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Competitor_Price::TABLE_NAME;
        $this->objectName = 'competitorprice';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/bid/shopcompetitorprice/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/competitor/price/list/index',
            )
        );

        $this->_requestShopCompetitors();

        // получаем список
        View_View::find('DB_Ab1_Shop_Competitor_Price', $this->_sitePageData->shopID, "_shop/competitor/price/list/index", "_shop/competitor/price/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array('shop_product_id' => array('name'), 'shop_competitor_id' => array('name')));

        $this->_putInMain('/main/_shop/competitor/price/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bid/shopcompetitorprice/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/competitor/price/one/new',
                'view::_shop/competitor/price/item/list/index',
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

        $this->_requestShopCompetitors();


        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/competitor/price/item/list/index'] =
            Helpers_View::getViewObjects(
                $dataID, new Model_Ab1_Shop_Competitor_Price(),
                '_shop/competitor/price/item/list/index', '_shop/competitor/price/item/one/index',
                $this->_sitePageData, $this->_driverDB
            );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/competitor/price/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Competitor_Price(),
            '_shop/competitor/price/one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/competitor/price/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bid/shopcompetitorprice/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/competitor/price/one/edit',
                'view::_shop/competitor/price/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Competitor_Price();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Competitor price not is found!');
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

        $this->_requestShopCompetitors($model->getShopCompetitorID());

        $params = Request_RequestParams::setParams(
            array(
                'shop_competitor_price_id' => $id
            )
        );
        $this->_sitePageData->replaceDatas['view::_shop/competitor/price/item/list/index'] =
            View_View::find('DB_Ab1_Shop_Competitor_Price_Item',
                $this->_sitePageData->shopID,
            "_shop/competitor/price/item/list/index", '_shop/competitor/price/item/one/index',
                $this->_sitePageData, $this->_driverDB, $params
            );

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Competitor_Price',
            $this->_sitePageData->shopID, "_shop/competitor/price/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );

        $this->_putInMain('/main/_shop/competitor/price/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bid/shopcompetitorprice/save';

        $result = Api_Ab1_Shop_Competitor_Price::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

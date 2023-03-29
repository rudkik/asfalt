<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bid_ShopPlan extends Controller_Ab1_Bid_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Plan';
        $this->controllerName = 'shopplan';
        $this->tableID = Model_Ab1_Shop_Plan::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Plan::TABLE_NAME;
        $this->objectName = 'plan';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/bid/shopplan/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/plan/list/index',
            )
        );

        // получаем список
        View_View::findBranch('DB_Ab1_Shop_Plan', $this->_sitePageData->shopMainID, "_shop/plan/list/index",
            "_shop/plan/one/index", $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25), array('shop_turn_place_id' => array('name'), 'shop_client_id' => array('name'),
                'shop_product_id' => array('name')));

        $this->_putInMain('/main/_shop/plan/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bid/shopplan/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/plan/one/new',
                'view::_shop/plan/item/list/index',
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

        $this->_requestShopSpecialTransports();
        $this->_requestShopTurnPlaces();
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/plan/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Plan(),
            '_shop/plan/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/plan/item/list/index'] = Helpers_View::getViewObjects($dataID,
            new Model_Ab1_Shop_Plan_Item(), '_shop/plan/item/list/index',
            '_shop/plan/item/one/index', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/plan/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bid/shopplan/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/plan/one/edit',
                'view::_shop/plan/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Plan();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Plan not is found!');
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

        $this->_requestShopSpecialTransports();
        $this->_requestShopBranches($model->shopID);
        $this->_requestShopTurnPlaces(NULL, $this->_sitePageData->shopMainID);
        $this->_requestShopBranches($model->shopID, TRUE);

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Plan', $this->_sitePageData->shopID, "_shop/plan/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('shop_client_id'));

        View_View::find('DB_Ab1_Shop_Plan_Item', $this->_sitePageData->shopID, '_shop/plan/item/list/index',
            '_shop/plan/item/one/index', $this->_sitePageData, $this->_driverDB, array('shop_plan_id' => $id,
                'sort_by'=>array('value'=>array('id'=>'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));


        $this->_putInMain('/main/_shop/plan/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bid/shopplan/save';

        $result = Api_Ab1_Shop_Plan::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/bid/shopplan/del';
        $result = Api_Ab1_Shop_Plan::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}

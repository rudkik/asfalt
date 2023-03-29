<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sales_ShopPlanTransport extends Controller_Ab1_Sales_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Plan_Transport';
        $this->controllerName = 'shopplantransport';
        $this->tableID = Model_Ab1_Shop_Plan_Transport::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Plan_Transport::TABLE_NAME;
        $this->objectName = 'plantransport';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/sales/shopplantransport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/plan/transport/list/index',
            )
        );

        // получаем список
        View_View::findBranch('DB_Ab1_Shop_Plan_Transport',
            $this->_sitePageData->shopMainID,
            "_shop/plan/transport/list/index", "_shop/plan/transport/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_special_transport_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/plan/transport/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/sales/shopplantransport/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/plan/transport/one/new',
                'view::_shop/plan/transport/item/list/index',
            )
        );

        $this->_requestShopSpecialTransports();
        $this->_requestShopBranches($this->_sitePageData->shopID, TRUE);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/plan/transport/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Plan_Transport(), '_shop/plan/transport/one/new',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/plan/transport/item/list/index'] = Helpers_View::getViewObjects(
            $dataID, new Model_Ab1_Shop_Plan_Item(),
            '_shop/plan/transport/item/list/index', '_shop/plan/transport/item/one/index',
            $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $this->_putInMain('/main/_shop/plan/transport/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/sales/shopplantransport/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/plan/transport/one/edit',
                'view::_shop/plan/transport/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Plan_Transport();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Plan transport not is found!');
        }

        $this->_requestShopSpecialTransports();
        $this->_requestShopBranches($model->shopID, TRUE);

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Plan_Transport',
            $this->_sitePageData->shopID, "_shop/plan/transport/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array()
        );

        View_View::find('DB_Ab1_Shop_Plan_Transport_Item',
            $this->_sitePageData->shopID,
            '_shop/plan/transport/item/list/index', '_shop/plan/transport/item/one/index',
            $this->_sitePageData, $this->_driverDB,
            array(
                'shop_plan_transport_id' => $id,
                'sort_by'=>array('value'=>array('id'=>'asc')),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE
            )
        );


        $this->_putInMain('/main/_shop/plan/transport/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sales/shopplantransport/save';

        $result = Api_Ab1_Shop_Plan_Transport::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/sales/shopplantransport/del';
        $result = Api_Ab1_Shop_Plan_Transport::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}

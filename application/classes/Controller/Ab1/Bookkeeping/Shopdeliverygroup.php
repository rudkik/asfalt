<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bookkeeping_ShopDeliveryGroup extends Controller_Ab1_Bookkeeping_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Delivery_Group';
        $this->controllerName = 'shopdeliverygroup';
        $this->tableID = Model_Ab1_Shop_Delivery_Group::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Delivery_Group::TABLE_NAME;
        $this->objectName = 'deliverygroup';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/bookkeeping/shopdeliverygroup/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/group/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Delivery_Group', $this->_sitePageData->shopMainID, "_shop/delivery/group/list/index", "_shop/delivery/group/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array('root_id' => array('name')));

        $this->_putInMain('/main/_shop/delivery/group/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/bookkeeping/shopdeliverygroup/list';

        // получаем список
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->response->body(View_View::find('DB_Ab1_Shop_Delivery_Group', $this->_sitePageData->shopMainID,
            "_shop/delivery/group/list/list", "_shop/delivery/group/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)));
        $this->_sitePageData->previousShopShablonPath();
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bookkeeping/shopdeliverygroup/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/group/one/new',
            )
        );

        $this->_requestShopDeliveries();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/delivery/group/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Delivery_Group(),
            '_shop/delivery/group/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/delivery/group/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bookkeeping/shopdeliverygroup/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/group/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Delivery_Group();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Group delivery not is found!');
        }
        
        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Delivery_Group', $this->_sitePageData->shopMainID, "_shop/delivery/group/one/edit",
            $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/delivery/group/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bookkeeping/shopdeliverygroup/save';

        $result = Api_Ab1_Shop_Delivery_Group::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

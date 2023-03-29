<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sbyt_ShopDeliveryDepartment extends Controller_Ab1_Sbyt_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Delivery_Department';
        $this->controllerName = 'shopdeliverydepartment';
        $this->tableID = Model_Ab1_Shop_Delivery_Department::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Delivery_Department::TABLE_NAME;
        $this->objectName = 'deliverydepartment';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/sbyt/shopdeliverydepartment/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/department/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Delivery_Department', $this->_sitePageData->shopMainID, "_shop/delivery/department/list/index", "_shop/delivery/department/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array('root_id' => array('name')));

        $this->_putInMain('/main/_shop/delivery/department/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/sbyt/shopdeliverydepartment/list';

        // получаем список
        $this->response->body(View_View::find('DB_Ab1_Shop_Delivery_Department', $this->_sitePageData->shopMainID,
            "_shop/delivery/department/list/list", "_shop/delivery/department/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/sbyt/shopdeliverydepartment/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/department/one/new',
            )
        );

        $this->_requestShopDeliveries();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/delivery/department/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Delivery_Department(),
            '_shop/delivery/department/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/delivery/department/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/sbyt/shopdeliverydepartment/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/delivery/department/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Delivery_Department();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Department delivery not is found!');
        }
        
        // получаем данные
        View_View::findOne(
            'DB_Ab1_Shop_Delivery_Department', $this->_sitePageData->shopMainID,
            "_shop/delivery/department/one/edit",
            $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/delivery/department/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/sbyt/shopdeliverydepartment/save';

        $result = Api_Ab1_Shop_Delivery_Department::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

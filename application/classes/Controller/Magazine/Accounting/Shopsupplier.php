<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopSupplier extends Controller_Magazine_Accounting_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Supplier';
        $this->controllerName = 'shopsupplier';
        $this->tableID = Model_Magazine_Shop_Supplier::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Supplier::TABLE_NAME;
        $this->objectName = 'supplier';

        parent::__construct($request, $response);
    }
    
    public function action_json() {
        $this->_sitePageData->url = '/accounting/shopsupplier/json';

        $this->_actionJSON(
            'Request_Magazine_Shop_Supplier',
            'findShopSupplierIDs',
            array(
            ),
            new Model_Magazine_Shop_Supplier()
        );
    }

    public function action_index() {
        $this->_sitePageData->url = '/accounting/shopsupplier/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/supplier/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Magazine_Shop_Supplier',
            $this->_sitePageData->shopMainID, "_shop/supplier/list/index", "_shop/supplier/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), ['shop_client_id' => ['name']]
        );

        $this->_putInMain('/main/_shop/supplier/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/accounting/shopsupplier/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/supplier/one/new',
            )
        );

        $this->_requestOrganizationTypes();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/supplier/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Supplier(), '_shop/supplier/one/new', $this->_sitePageData,
            $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $this->_putInMain('/main/_shop/supplier/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/accounting/shopsupplier/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/supplier/one/edit',
            )
        );

        // id записи
        $shopSupplierID = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Supplier();
        if (! $this->dublicateObjectLanguage($model, $shopSupplierID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Supplier not is found!');
        }

        $this->_requestOrganizationTypes($model->getOrganizationTypeID());

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_Supplier',
            $this->_sitePageData->shopMainID, "_shop/supplier/one/edit", $this->_sitePageData, $this->_driverDB,
            array('id' => $shopSupplierID), array()
        );

        $this->_putInMain('/main/_shop/supplier/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/accounting/shopsupplier/save';

        $result = Api_Magazine_Shop_Supplier::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/accounting/shopsupplier/del';
        $result = Api_Magazine_Shop_Supplier::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}

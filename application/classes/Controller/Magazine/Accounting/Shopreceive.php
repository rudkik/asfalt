<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopReceive extends Controller_Magazine_Accounting_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Receive';
        $this->controllerName = 'shopreceive';
        $this->tableID = Model_Magazine_Shop_Receive::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Receive::TABLE_NAME;
        $this->objectName = 'receive';

        parent::__construct($request, $response);
    }

    public function action_index() {
        if($this->_sitePageData->operation->getShopTableUnitID()){
            self::redirect('/accounting/shoppiece/index');
        }

        $this->_sitePageData->url = '/accounting/shopreceive/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/receive/list/index',
            )
        );

        $this->_requestShopProducts(null, $this->_sitePageData->shopMainID);
        $this->_requestShopSupplier();

        // получаем список
        View_View::find('DB_Magazine_Shop_Receive',
            $this->_sitePageData->shopID, "_shop/receive/list/index", "_shop/receive/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25),
            array('shop_supplier_id' => array('name', 'bin'), 'esf_type_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/receive/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/accounting/shopreceive/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/receive/one/new',
                '_shop/receive/item/list/index',
            )
        );

        $this->_requestShopSupplier();

        $params = Request_RequestParams::setParams(
            array(
                'shop_receive_id' => 0,
                'sort_by' => array('shop_product_id.name' => 'asc'),
            )
        );
        View_View::find('DB_Magazine_Shop_Receive_Item',
            $this->_sitePageData->shopID,
            '_shop/receive/item/list/index', '_shop/receive/item/one/index',
            $this->_sitePageData, $this->_driverDB, $params,
            array('shop_product_id' => array('name', 'barcode'))
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/receive/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Receive(),
            '_shop/receive/one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/receive/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/accounting/shopreceive/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/receive/one/edit',
                '_shop/receive/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Receive();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Receive not is found!');
        }
        $this->_requestShopSupplier($model->getShopSupplierID());

        $params = Request_RequestParams::setParams(
            array(
                'shop_receive_id' => $id,
                'sort_by' => array('shop_product_id.name' => 'asc'),
            )
        );
        View_View::find('DB_Magazine_Shop_Receive_Item',
            $this->_sitePageData->shopID,
            '_shop/receive/item/list/index', '_shop/receive/item/one/index',
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_product_id' => array('name', 'barcode', 'image_path'),
            )
        );

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_Receive',
            $this->_sitePageData->shopID, "_shop/receive/one/edit", $this->_sitePageData,
            $this->_driverDB, array('id' => $id), array()
        );

        $this->_putInMain('/main/_shop/receive/edit');
    }

    public function action_production()
    {
        $this->_sitePageData->url = '/accounting/shopreceive/production';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/receive/one/production',
                '_shop/receive/item/list/production',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Receive();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Receive not is found!');
        }

        $this->_requestUnits();
        $this->_requestShopProductRubrics();
        $this->_requestShopProductionRubrics();

        $params = Request_RequestParams::setParams(
            array(
                'shop_receive_id' => $id,
                'sort_by' => array('shop_product_id.name' => 'asc'),
            )
        );
        View_View::find('DB_Magazine_Shop_Receive_Item',
            $this->_sitePageData->shopID,
            '_shop/receive/item/list/production', '_shop/receive/item/one/production',
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_product_id' => array('name', 'barcode', 'coefficient_revise', 'unit_id', 'shop_product_rubric_id'),
                'shop_production_id' => array('id', 'name', 'barcode', 'price', 'coefficient', 'coefficient_rubric', 'weight_kg', 'unit_id', 'shop_production_rubric_id'),
            )
        );

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_Receive',
            $this->_sitePageData->shopID, "_shop/receive/one/production", $this->_sitePageData,
            $this->_driverDB, array('id' => $id), array()
        );

        $this->_putInMain('/main/_shop/receive/production');
    }

    public function action_esf()
    {
        $this->_sitePageData->url = '/accounting/shopreceive/esf';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/receive/one/esf',
                '_shop/receive/item/list/esf',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Receive();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Receive not is found!');
        }
        $this->_requestShopSupplier($model->getShopSupplierID());
        $this->_requestESFTypes($model->getESFTypeID());

        $params = Request_RequestParams::setParams(
            array(
                'shop_receive_id' => $id,
                'sort_by' => array('shop_product_id.name' => 'asc'),
            )
        );
        View_View::find('DB_Magazine_Shop_Receive_Item',
            $this->_sitePageData->shopID,
            '_shop/receive/item/list/esf', '_shop/receive/item/one/esf',
            $this->_sitePageData, $this->_driverDB, $params,
            array('shop_product_id' => array('name', 'barcode'))
        );

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_Receive',
            $this->_sitePageData->shopID, "_shop/receive/one/esf", $this->_sitePageData,
            $this->_driverDB, array('id' => $id), array()
        );

        $this->_putInMain('/main/_shop/receive/esf');
    }

    public function action_load_esf() {
        $this->_sitePageData->url = '/cash/shopreceive/load_esf';

        $s = microtime(true);
        if(key_exists('file', $_FILES) && key_exists('tmp_name', $_FILES['file'])
            && !is_array($_FILES['file']['tmp_name']) && file_exists($_FILES['file']['tmp_name'])) {
            Api_Magazine_Shop_Receive::loadESFToFile(
                $_FILES['file']['tmp_name'], Request_RequestParams::getParamInt('id'),
                $this->_sitePageData, $this->_driverDB
            );
        }
        echo '<!--'.(microtime(true) - $s).'--!>';

        $this->action_esf();
    }

    public function action_save_esf()
    {
        $this->_sitePageData->url = '/accounting/shopreceive/save_esf';

        Api_Magazine_Shop_Receive::saveESF($this->_sitePageData, $this->_driverDB);
        $this->redirect('/accounting/shopreceive/esf'.URL::query(array('id' => Request_RequestParams::getParamInt('id')), FALSE));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/accounting/shopreceive/save';
        Helpers_Token::checkAccess($this->_sitePageData->url);

        $result = Api_Magazine_Shop_Receive::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/accounting/shopreceive/del';
        $result = Api_Magazine_Shop_Receive::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_save_basic() {
        $this->_sitePageData->url = '/accounting/shopreceive/save_basic';

        $shopProductID = Request_RequestParams::getParamInt('shop_product_id');
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => $shopProductID,
                'shop_receive_id' => 0,
            )
        );
        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 1, TRUE
        );

        $model = new Model_Magazine_Shop_Receive_Item();
        $model->setDBDriver($this->_driverDB);

        if(count($ids->childs) > 0){
            $ids->childs[0]->setModel($model);
        }else{
            $model->setShopProductID($shopProductID);
            $model->setShopReceiveID(0);
        }

        $model->getIsPublic(FALSE);
        $model->setQuantity(Request_RequestParams::getParamFloat('quantity'));
        $model->setPrice(Request_RequestParams::getParamFloat('price'));

        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        $this->response->body('OK');
    }
}

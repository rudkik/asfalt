<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Bar_ShopReturn extends Controller_Magazine_Bar_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Return';
        $this->controllerName = 'shopreturn';
        $this->tableID = Model_Magazine_Shop_Return::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Return::TABLE_NAME;
        $this->objectName = 'return';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/bar/shopreturn/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/return/list/index',
            )
        );

        $this->_requestShopProducts(null, $this->_sitePageData->shopMainID);
        $this->_requestShopSupplier();

        // получаем список
        View_View::find('DB_Magazine_Shop_Return',
            $this->_sitePageData->shopID, "_shop/return/list/index", "_shop/return/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25),
            array('shop_supplier_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/return/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bar/shopreturn/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/return/one/new',
                '_shop/return/item/list/index',
            )
        );

        $this->_requestShopSupplier();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/return/item/list/index'] = Helpers_View::getViewObjects($dataID,
            new Model_Magazine_Shop_Return(), '_shop/return/item/list/index',
            '_shop/return/item/one/index', $this->_sitePageData, $this->_driverDB
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/return/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Return(),
            '_shop/return/one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/return/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bar/shopreturn/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/return/one/edit',
                '_shop/return/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Return();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Return not is found!');
        }
        $this->_requestShopSupplier($model->getShopSupplierID());

        $params = Request_RequestParams::setParams(
            array(
                'shop_return_id' => $id,
                'sort_by' => array('shop_product_id.name' => 'asc'),
            )
        );
        View_View::find('DB_Magazine_Shop_Return_Item',
            $this->_sitePageData->shopID,
            '_shop/return/item/list/index', '_shop/return/item/one/index',
            $this->_sitePageData, $this->_driverDB, $params,
            array('shop_product_id' => array('name', 'barcode'))
        );

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_Return',
            $this->_sitePageData->shopID, "_shop/return/one/edit", $this->_sitePageData,
            $this->_driverDB, array('id' => $id), array()
        );

        $this->_putInMain('/main/_shop/return/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bar/shopreturn/save';
        Helpers_Token::checkAccess($this->_sitePageData->url);

        $result = Api_Magazine_Shop_Return::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/bar/shopreturn/del';
        $result = Api_Magazine_Shop_Return::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_esf()
    {
        $this->_sitePageData->url = '/bar/shopreturn/esf';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/return/one/esf',
                '_shop/return/item/list/esf',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Return();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Return not is found!');
        }
        $this->_requestShopSupplier($model->getShopSupplierID());
        $this->_requestESFTypes($model->getESFTypeID());

        $params = Request_RequestParams::setParams(
            array(
                'shop_return_id' => $id,
                'sort_by' => array('shop_product_id.name' => 'asc'),
            )
        );
        View_View::find('DB_Magazine_Shop_Return_Item',
            $this->_sitePageData->shopID,
            '_shop/return/item/list/esf', '_shop/return/item/one/esf',
            $this->_sitePageData, $this->_driverDB, $params,
            array('shop_product_id' => array('name', 'barcode'))
        );

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_Return',
            $this->_sitePageData->shopID, "_shop/return/one/esf", $this->_sitePageData,
            $this->_driverDB, array('id' => $id), array()
        );

        $this->_putInMain('/main/_shop/return/esf');
    }

    public function action_load_esf() {
        $this->_sitePageData->url = '/cash/shopreturn/load_esf';

        $s = microtime(true);
        if(key_exists('file', $_FILES) && key_exists('tmp_name', $_FILES['file'])
            && !is_array($_FILES['file']['tmp_name']) && file_exists($_FILES['file']['tmp_name'])) {
            Api_Magazine_Shop_Return::loadESFToFile(
                $_FILES['file']['tmp_name'], Request_RequestParams::getParamInt('id'),
                $this->_sitePageData, $this->_driverDB
            );
        }
        echo '<!--'.(microtime(true) - $s).'--!>';

        $this->action_esf();
    }

    public function action_save_esf()
    {
        $this->_sitePageData->url = '/bar/shopreturn/save_esf';

        Api_Magazine_Shop_Return::saveESF($this->_sitePageData, $this->_driverDB);
        $this->redirect('/bar/shopreturn/esf'.URL::query(array('id' => Request_RequestParams::getParamInt('id')), FALSE));
    }
}

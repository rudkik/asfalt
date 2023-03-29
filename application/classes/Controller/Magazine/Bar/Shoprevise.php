<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Bar_ShopRevise extends Controller_Magazine_Bar_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Revise';
        $this->controllerName = 'shoprevise';
        $this->tableID = Model_Magazine_Shop_Revise::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Revise::TABLE_NAME;
        $this->objectName = 'revise';

        parent::__construct($request, $response);
    }

    public function action_index() {
        if($this->_sitePageData->operation->getShopTableUnitID()){
            self::redirect('/bar/shoppiece/index');
        }

        $this->_sitePageData->url = '/bar/shoprevise/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/revise/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Magazine_Shop_Revise',
            $this->_sitePageData->shopID, "_shop/revise/list/index", "_shop/revise/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25),
            array('shop_supplier_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/revise/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bar/shoprevise/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/revise/one/new',
                '_shop/product/list/revise',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'quantity_not_equally' => 0,
            )
        );
        $ids = Request_Request::find('DB_Magazine_Shop_Product',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, TRUE,
            array(
                'shop_product_stock_id' => array('quantity_coming', 'quantity_expense', 'quantity_balance'),
            )
        );
        $this->_sitePageData->replaceDatas['view::_shop/product/list/revise'] = Helpers_View::getViewObjects($ids,
            new Model_Magazine_Shop_Product(), '_shop/product/list/revise',
            '_shop/product/one/revise', $this->_sitePageData, $this->_driverDB
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/revise/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Shop_Revise(),
            '_shop/revise/one/new', $this->_sitePageData, $this->_driverDB
        );



        $this->_putInMain('/main/_shop/revise/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bar/shoprevise/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/revise/one/edit',
                '_shop/revise/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Revise();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Revise not is found!');
        }


        $params = Request_RequestParams::setParams(
            array(
                'shop_revise_id' => $id,
                'sort_by' => array(
                    'quantity_diff' => 'desc',
                    'shop_product_id.name' => 'asc'
                ),
            )
        );
        View_View::find('DB_Magazine_Shop_Revise_Item',
            $this->_sitePageData->shopID,
            '_shop/revise/item/list/index', '_shop/revise/item/one/index',
            $this->_sitePageData, $this->_driverDB, $params,
            array('shop_product_id' => array('name', 'barcode'))
        );

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_Revise',
            $this->_sitePageData->shopID, "_shop/revise/one/edit", $this->_sitePageData,
            $this->_driverDB, array('id' => $id), array()
        );

        $this->_putInMain('/main/_shop/revise/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bar/shoprevise/save';
        Helpers_Token::checkAccess($this->_sitePageData->url);

        $result = Api_Magazine_Shop_Revise::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/bar/shoprevise/del';
        $result = Api_Magazine_Shop_Revise::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}

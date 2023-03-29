<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Bar_ShopProductRubric extends Controller_Magazine_Bar_BasicMagazine
{
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Product_Rubric';
        $this->controllerName = 'shopproductrubric';
        $this->tableID = Model_Magazine_Shop_Product_Rubric::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Product_Rubric::TABLE_NAME;
        $this->objectName = 'productrubric';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/bar/shopproductrubric/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/rubric/list/index',
            )
        );
        $this->_requestShopProductRubrics();

        // получаем список
        View_View::find('DB_Magazine_Shop_Product_Rubric', $this->_sitePageData->shopMainID, "_shop/product/rubric/list/index", "_shop/product/rubric/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array('root_id' => array('name')));

        $this->_putInMain('/main/_shop/product/rubric/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/bar/shopproductrubric/list';

        // получаем список
        $this->response->body(View_View::find('DB_Magazine_Shop_Product_Rubric', $this->_sitePageData->shopMainID,
            "_shop/product/rubric/list/list", "_shop/product/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bar/shopproductrubric/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/rubric/one/new',
            )
        );

        $this->_requestShopProductRubrics();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/product/rubric/one/new'] = Helpers_View::getViewObject($dataID, new Model_Magazine_Shop_Product_Rubric(),
            '_shop/product/rubric/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/product/rubric/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bar/shopproductrubric/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/rubric/one/edit',
            )
        );

        // id записи
        $shopProductRubricID = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Shop_Product_Rubric();
        if (!$this->dublicateObjectLanguage($model, $shopProductRubricID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Rubric product not is found!');
        }

        $this->_requestShopProductRubrics();

        // получаем данные
        View_View::findOne('DB_Magazine_Shop_Product_Rubric', $this->_sitePageData->shopMainID, "_shop/product/rubric/one/edit",
            $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/product/rubric/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bar/shopproductrubric/save';

        $result = Api_Magazine_Shop_Product_Rubric::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

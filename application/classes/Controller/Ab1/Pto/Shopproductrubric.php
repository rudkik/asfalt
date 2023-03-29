<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Pto_ShopProductRubric extends Controller_Ab1_Pto_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Product_Rubric';
        $this->controllerName = 'shopproductrubric';
        $this->tableID = Model_Ab1_Shop_Product_Rubric::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Product_Rubric::TABLE_NAME;
        $this->objectName = 'productrubric';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/pto/shopproductrubric/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/rubric/list/index',
            )
        );
        $this->_requestShopProductRubrics();

        // получаем список
        View_View::find('DB_Ab1_Shop_Product_Rubric', $this->_sitePageData->shopMainID, "_shop/product/rubric/list/index", "_shop/product/rubric/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array('root_id' => array('name')));

        $this->_putInMain('/main/_shop/product/rubric/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/pto/shopproductrubric/list';

        // получаем список
        $this->response->body(View_View::find('DB_Ab1_Shop_Product_Rubric', $this->_sitePageData->shopMainID,
            "_shop/product/rubric/list/list", "_shop/product/rubric/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/pto/shopproductrubric/new';
        $this->_actionShopProductRubricNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/pto/shopproductrubric/edit';
        $this->_actionShopProductRubricEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/pto/shopproductrubric/save';

        $result = Api_Ab1_Shop_Product_Rubric::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/pto/shopproductrubric/statistics';

        $this->_actionShopProductRubricStatistics();
    }

}

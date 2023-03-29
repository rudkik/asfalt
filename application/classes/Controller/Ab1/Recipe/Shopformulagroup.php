<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Recipe_ShopFormulaGroup extends Controller_Ab1_Recipe_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Formula_Group';
        $this->controllerName = 'shopformulagroup';
        $this->tableID = Model_Ab1_Shop_Formula_Group::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Formula_Group::TABLE_NAME;
        $this->objectName = 'formulagroup';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/recipe/shopformulagroup/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/formula/group/list/index',
            )
        );
        $this->_requestShopFormulaGroups();

        // получаем список
        View_View::find('DB_Ab1_Shop_Formula_Group',
            $this->_sitePageData->shopMainID, 
            "_shop/formula/group/list/index", "_shop/formula/group/one/index",
            $this->_sitePageData, $this->_driverDB, 
            array('limit' => 1000, 'limit_page' => 25), array('shop_product_rubric_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/formula/group/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/recipe/shopformulagroup/list';

        // получаем список
        $this->response->body(
            View_View::find('DB_Ab1_Shop_Formula_Group',
                $this->_sitePageData->shopMainID,
                "_shop/formula/group/list/list", "_shop/formula/group/one/list",
                $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/recipe/shopproductrubric/new';
        $this->_actionShopFormulaGroupNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/recipe/shopproductrubric/edit';
        $this->_actionShopFormulaGroupEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/recipe/shopformulagroup/save';

        $result = Api_Ab1_Shop_Formula_Group::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

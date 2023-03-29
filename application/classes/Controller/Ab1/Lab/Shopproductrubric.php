<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Lab_ShopProductRubric extends Controller_Ab1_Lab_BasicAb1
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

    public function action_statistics()
    {
        $this->_sitePageData->url = '/lab/shopproductrubric/statistics';

        $this->_actionShopProductRubricStatistics();
    }

}

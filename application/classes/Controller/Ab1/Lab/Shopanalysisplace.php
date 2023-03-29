<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Lab_ShopAnalysisPlace extends Controller_Ab1_Lab_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Analysis_Place';
        $this->controllerName = 'shopanalysisplace';
        $this->tableID = Model_Ab1_Shop_Analysis_Place::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Analysis_Place::TABLE_NAME;
        $this->objectName = 'analysisplace';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
    }
}


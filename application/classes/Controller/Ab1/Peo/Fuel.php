<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_Fuel extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Fuel';
        $this->controllerName = 'fuel';
        $this->tableID = Model_Ab1_Fuel::TABLE_ID;
        $this->tableName = Model_Ab1_Fuel::TABLE_NAME;
        $this->objectName = 'fuel';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/peo/fuel/statistics';

        $this->_actionFuelStatistics();
    }
}

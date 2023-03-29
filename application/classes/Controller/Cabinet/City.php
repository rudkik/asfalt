<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_City extends Controller_Cabinet_File
{
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_City';
        $this->controllerName = 'city';
        $this->tableID = Model_City::TABLE_ID;
        $this->tableName = Model_City::TABLE_NAME;
        $this->objectName = 'city';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_select()
    {
        $this->_sitePageData->url = '/cabinet/city/select';

        $landID = Request_RequestParams::getParamInt('land_id');
        if($landID !== NULL) {
            $cityIDAll = View_View::find('DB_City', $this->_sitePageData->shopID, "city/list/list", "city/one/list",
                $this->_sitePageData, $this->_driverDB,
                array('land_id' => $landID, 'sort_by' => array('value' => array('name' => 'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

            $s = 'data-id="' . $landID . '"';
            $cityIDAll = str_replace($s, $s . ' selected', $cityIDAll);
        }else{
            $cityIDAll = '';
        }

        $this->response->body($cityIDAll);
    }
}

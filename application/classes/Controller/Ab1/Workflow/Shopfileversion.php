<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Workflow_ShopFileVersion extends Controller_Ab1_Workflow_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_File_Version';
        $this->controllerName = 'shopfileversion';
        $this->tableID = Model_Ab1_Shop_File_Version::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_File_Version::TABLE_NAME;
        $this->objectName = 'fileversion';

        parent::__construct($request, $response);
    }

    public function action_json() {
        $this->_sitePageData->url = '/workflow/shopfileversion/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }

    public function action_index() {
        $this->_sitePageData->url = '/workflow/shopfileversion/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/file/list/index',
            )
        );

        // получаем список
        $data = View_View::find('DB_Ab1_Shop_File_Version', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::getParamInt('type_view'), array('limit' => 1000, 'limit_page' => 25));

        $this->response->body($data);
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/workflow/shopfileversion/save';

        $result = Api_Ab1_Shop_File_Version::save($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode($result['result']));
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/workflow/shopfileversion/del';
        $result = Api_Ab1_Shop_File_Version::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Workflow_ShopFile extends Controller_Ab1_Workflow_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_File';
        $this->controllerName = 'shopfile';
        $this->tableID = Model_Ab1_Shop_File::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_File::TABLE_NAME;
        $this->objectName = 'file';

        parent::__construct($request, $response);
    }

    public function action_json() {
        $this->_sitePageData->url = '/workflow/shopfile/json';
        $this->_getJSONList($this->_sitePageData->shopMainID);
    }

    public function action_index() {
        $this->_sitePageData->url = '/workflow/shopfile/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/file/list/index',
            )
        );

        // получаем список
        $data = View_View::find('DB_Ab1_Shop_File', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::getParamInt('type_view'), array('limit' => 1000, 'limit_page' => 25));

        $this->response->body($data);
    }

    /** Получить объект по пути **/
    public function action_get_file_by_path()
    {
        $this->_sitePageData->url = '/workflow/shopfile/get_file_by_path';

        $result = View_View::findOne('DB_Ab1_Shop_File', $this->_sitePageData->shopID, '', $this->_sitePageData, $this->_driverDB,
            array('is_error_404' => FALSE), NULL, FALSE);

        $this->response->body(Json::json_encode($result->values));
    }

    /** Получить пути по ID объекта **/
    public function action_get_path()
    {
        $this->_sitePageData->url = '/workflow/shopfile/get_path';

        $result = '';
        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            $model = new Model_Ab1_Shop_File();
            $model->setDBDriver($this->_driverDB);

            if (Helpers_DB::dublicateObjectLanguage($model, $id, $this->_sitePageData)) {
                $result = $model->getName();

                while ($model->getRootID() > 0){
                    if (!Helpers_DB::dublicateObjectLanguage($model, $model->getRootID(), $this->_sitePageData)) {
                        $result = '';
                        break;
                    }

                    $result = $model->getName().'\\'.$result;
                }
            }
        }

        $this->response->body(Json::json_encode(array('path' => $result)));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/workflow/shopfile/save';

        $result = Api_Ab1_Shop_File::save($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode($result['result']));
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/workflow/shopfile/del';
        $result = Api_Ab1_Shop_File::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}

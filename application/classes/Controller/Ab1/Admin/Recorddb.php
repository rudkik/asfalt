<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_RecordDB extends Controller_Ab1_Admin_BasicAb1 {
    /**
     * @var Model_Basic_DBObject | null
     */
    protected $model = null;

    public function __construct(Request $request, Response $response)
    {
        $dbObject = Request_RequestParams::getParamStr('db');
        if(!empty($dbObject)) {
            $this->model = DB_Basic::createModel($dbObject);

            $this->dbObject = $dbObject;
            $this->controllerName = 'recorddb';
            $this->tableID = $this->model::TABLE_ID;
            $this->tableName = $this->model::TABLE_NAME;
        }

        parent::__construct($request, $response);
    }

    public function action_table() {
        $this->_sitePageData->url = '/ab1-admin/recorddb/table';

        $name = Request_RequestParams::getParamStr('name');

        $result = new MyArray();

        $filePath = Helpers_Path::getPathFile(APPPATH, ['classes', 'DB', 'Ab1']);
        foreach (Helpers_Path::globTreeSearch($filePath, '*.php') as $file) {
            $dbObject = DB_Basic::getDBObjectByPath($file);

            if(!empty($name) && mb_strpos($dbObject::TITLE, $name) === false){
                continue;
            }

            $result->addChild(0)->values = [
                'db' => $dbObject,
                'name' => $dbObject::TITLE,
            ];
        }

        Helpers_View::getViews(
            'record-db/list/table', 'record-db/one/table',
            $this->_sitePageData, $this->_driverDB, $result
        );

        $this->_putInMain('/main/record-db/table');
    }

    public function action_index() {
        $this->_sitePageData->url = '/ab1-admin/recorddb/index';

        $dbObject = $this->dbObject;

        $elements = [];
        $list = [];
        foreach ($dbObject::FIELDS as $name => $field){
            echo Arr::path($field, 'table', '');
            if(!key_exists('table', $field) || !$field['table']::IS_CATALOG){
                continue;
            }

            if($field['table'] != DB_Ab1_Shop_Client::NAME && !key_exists($field['table'], $list)) {
                $this->_requestListDB($field['table'], null, 0, ['is_public_ignore' => 1, 'is_delete_ignore' => 1]);
                $list[$field['table']] = '';
            }

            $elements[$name] = ['name'];
        }

        $ids = Request_Request::find(
            $dbObject, 0,
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25), 0
        );
        $ids->additionDatas['fields'] = $dbObject::FIELDS;
        $ids->additionDatas['name'] = $dbObject;//$dbObject::TITLE;
        $ids->addAdditionDataChilds(['fields' => $dbObject::FIELDS]);

        Helpers_View::getViews(
            'record-db/list/index', 'record-db/one/index',
            $this->_sitePageData, $this->_driverDB, $ids
        );

        $this->_putInMain('/main/record-db/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ab1-admin/recorddb/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if (! $this->dublicateObjectLanguage($this->model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $dbObject = $this->dbObject;
        $list = [];
        foreach ($dbObject::FIELDS as $name => $field){
            if(!key_exists('table', $field) || !$field['table']::IS_CATALOG){
                continue;
            }

            if($field['table'] != DB_Ab1_Shop_Client::NAME && !key_exists($field['table'], $list)) {
                $this->_requestListDB($field['table'], null, 0, ['is_public_ignore' => 1, 'is_delete_ignore' => 1]);
                $list[$field['table']] = '';
            }
        }

        $viewPath = 'record-db/';

        // получаем данные
        $ids = new MyArray();
        $ids->setValues($this->model, $this->_sitePageData);
        $ids->additionDatas['name'] = $dbObject::TITLE;
        $ids->additionDatas['fields'] = $dbObject::FIELDS;

        $result = Helpers_View::getViewObject(
            $ids, $this->model, $viewPath . 'one/edit', $this->_sitePageData, $this->_driverDB, 0
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::' . $viewPath . 'one/edit',  $result);

        $this->_putInMain('/main/' . $viewPath . 'edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ab1-admin/shopdepartment/save';

        $result = DB_Basic::save($this->dbObject, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult($result, '', array('db' => $this->dbObject));
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_Unit extends Controller_Magazine_Accounting_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Unit';
        $this->controllerName = 'unit';
        $this->tableID = Model_Magazine_Unit::TABLE_ID;
        $this->tableName = Model_Magazine_Unit::TABLE_NAME;
        $this->objectName = 'unit';

        parent::__construct($request, $response);
    }
    
    public function action_json() {
        $this->_sitePageData->url = '/accounting/unit/json';

        $this->_actionJSON(
            'Request_Magazine_Unit',
            'find',
            array(
            ),
            new Model_Magazine_Unit()
        );
    }

    public function action_index() {
        $this->_sitePageData->url = '/accounting/unit/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::unit/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Magazine_Unit',
            $this->_sitePageData->shopMainID, "unit/list/index", "unit/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25)
        );

        $this->_putInMain('/main/unit/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/accounting/unit/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::unit/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::unit/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Magazine_Unit(), 'unit/one/new', $this->_sitePageData,
            $this->_driverDB, $this->_sitePageData->shopMainID
        );

        $this->_putInMain('/main/unit/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/accounting/unit/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::unit/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Magazine_Unit();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Unit not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Magazine_Unit',
            $this->_sitePageData->shopMainID, "unit/one/edit", $this->_sitePageData, $this->_driverDB,
            array('id' => $id), array()
        );

        $this->_putInMain('/main/unit/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/accounting/unit/save';

        $result = Api_Magazine_Unit::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/accounting/unit/del';
        $result = Api_Magazine_Unit::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}

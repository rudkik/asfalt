<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_Interface extends Controller_Ab1_Admin_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Interface';
        $this->controllerName = 'interface';
        $this->tableID = Model_Ab1_Interface::TABLE_ID;
        $this->tableName = Model_Ab1_Interface::TABLE_NAME;
        $this->objectName = 'operation';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/ab1-admin/interface/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::interface/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Interface',
            $this->_sitePageData->shopID,
            "interface/list/index", "interface/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25, 'shop_table_rubric_id' => 0),
            array('shop_table_rubric_id' => array('name'))
        );

        $this->_putInMain('/main/interface/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ab1-admin/interface/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::interface/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Interface();
        if (! $this->dublicateObjectLanguage($model, $id, 0)) {
            throw new HTTP_Exception_404('Interface not is found!');
        }

        // получаем данные
        View_View::findOne(
            'DB_Ab1_Interface', 0, "interface/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );

        $this->_putInMain('/main/interface/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ab1-admin/interface/save';

        $result = Api_Ab1_Interface::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

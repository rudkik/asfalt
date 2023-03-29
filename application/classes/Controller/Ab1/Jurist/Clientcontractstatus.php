<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Jurist_ClientContractStatus extends Controller_Ab1_Jurist_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_ClientContract_Status';
        $this->controllerName = 'clientcontractstatus';
        $this->tableID = Model_Ab1_ClientContract_Status::TABLE_ID;
        $this->tableName = Model_Ab1_ClientContract_Status::TABLE_NAME;
        $this->objectName = 'raw';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/jurist/clientcontractstatus/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::client-contract/status/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_ClientContract_Status',
            $this->_sitePageData->shopMainID, "client-contract/status/list/index", "client-contract/status/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array()
        );

        $this->_putInMain('/main/client-contract/status/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/jurist/clientcontractstatus/new';
        $this->_actionClientContractStatusNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/jurist/clientcontractstatus/edit';
        $this->_actionClientContractStatusEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/jurist/clientcontractstatus/save';

        $result = Api_Ab1_ClientContract_Status::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

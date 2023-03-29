<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Jurist_ClientContractView extends Controller_Ab1_Jurist_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_ClientContract_View';
        $this->controllerName = 'clientcontractview';
        $this->tableID = Model_Ab1_ClientContract_View::TABLE_ID;
        $this->tableName = Model_Ab1_ClientContract_View::TABLE_NAME;
        $this->objectName = 'raw';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/jurist/clientcontractview/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::client-contract/view/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_ClientContract_View',
            $this->_sitePageData->shopMainID, "client-contract/view/list/index", "client-contract/view/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array()
        );

        $this->_putInMain('/main/client-contract/view/index');
    }

    public function action_template() {
        $this->_sitePageData->url = '/jurist/clientcontractview/template';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::client-contract/view/list/template',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_ClientContract_View',
            $this->_sitePageData->shopMainID,
            "client-contract/view/list/template", "client-contract/view/one/template",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array()
        );

        $this->_putInMain('/main/client-contract/view/template');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/jurist/clientcontractview/new';
        $this->_actionClientContractViewNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/jurist/clientcontractview/edit';
        $this->_actionClientContractViewEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/jurist/clientcontractview/save';

        $result = Api_Ab1_ClientContract_View::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

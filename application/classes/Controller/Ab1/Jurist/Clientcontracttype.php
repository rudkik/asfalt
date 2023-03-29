<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Jurist_ClientContractType extends Controller_Ab1_Jurist_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_ClientContract_Type';
        $this->controllerName = 'clientcontracttype';
        $this->tableID = Model_Ab1_ClientContract_Type::TABLE_ID;
        $this->tableName = Model_Ab1_ClientContract_Type::TABLE_NAME;
        $this->objectName = 'raw';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/jurist/clientcontracttype/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::client-contract/type/list/index',
            )
        );
        $this->_requestClientContractTypes(null, true);

        $ids = Request_Request::findNotShop(
            'DB_Ab1_ClientContract_Type', $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25), 0, true, array('root_id' => array('name'))
        );

        foreach ($ids->childs as $child){
            if(empty($child->values['interface_ids'])){
                continue;
            }
            /** @var Model_Ab1_ClientContract_Type $model */
            $model = $child->createModel('DB_Ab1_ClientContract_Type', $this->_driverDB);

            $interfaceIDs = Request_Request::find(
                'DB_Ab1_Interface', $this->_sitePageData->shopMainID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    array(
                        'id' => $model->getInterfaceIDsArray(),
                    )
                ),
                0, true
            );
            $child->values['interface_ids'] = implode(', ', $interfaceIDs->getChildArrayValue('name'));
        }

        $result = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_ClientContract_Type(),
            "client-contract/type/list/index", "client-contract/type/one/index",
            $this->_sitePageData, $this->_driverDB, 0, TRUE,
            array('root_id' => array('name'))
        );
        $this->_sitePageData->replaceDatas['view::client-contract/type/list/index'] = $result;

        $this->_putInMain('/main/client-contract/type/index');
    }

    public function action_template() {
        $this->_sitePageData->url = '/jurist/clientcontracttype/template';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::client-contract/type/list/template',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_ClientContract_Type',
            $this->_sitePageData->shopMainID,
            "client-contract/type/list/template", "client-contract/type/one/template",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array()
        );

        $this->_putInMain('/main/client-contract/type/template');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/jurist/clientcontracttype/new';
        $this->_actionClientContractTypeNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/jurist/clientcontracttype/edit';
        $this->_actionClientContractTypeEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/jurist/clientcontracttype/save';

        $result = Api_Ab1_ClientContract_Type::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopRubric extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Rubric';
        $this->controllerName = 'shoprubric';
        $this->tableID = Model_AutoPart_Shop_Rubric::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Rubric::TABLE_NAME;
        $this->objectName = 'rubric';

        parent::__construct($request, $response);
    }
    
    public function action_index() {
        $this->_sitePageData->url = '/market/shoprubric/index';

        $this->_requestListDB('DB_AutoPart_Shop_Rubric');

        parent::_actionIndex(
            array(
                'root_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/market/shoprubric/new';

        $this->_requestListDB('DB_AutoPart_Shop_Rubric');

        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/market/shoprubric/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Rubric();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Rubric', $model->getRootID(), 0, array('id_not' => $model->id));

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_ShopRawRubric extends Controller_Ab1_Admin_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Raw_Rubric';
        $this->controllerName = 'shoprawrubric';
        $this->tableID = Model_Ab1_Shop_Raw_Rubric::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Raw_Rubric::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/ab1-admin/shoprawrubric/index';
        $this->_requestListDB(DB_Ab1_Shop_Raw_Rubric::NAME);

        parent::_actionIndex(
            array(
                'root_id' => array('name'),
            )
        );

    }

    public function action_new(){
        $this->_sitePageData->url = '/ab1-admin/shoprawrubric/new';
        $this->_requestListDB(DB_Ab1_Shop_Raw_Rubric::NAME);

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/ab1-admin/shoprawrubric/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Raw_Rubric();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB(
            DB_Ab1_Shop_Raw_Rubric::NAME, $model->getRootID(), 0,
            Request_RequestParams::setParams(['id_not' =>  $id])
        );

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

}

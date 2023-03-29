<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_ShopBranch extends Controller_Ab1_Admin_BasicAb1
{
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Branch';
        $this->controllerName = 'shopbranch';
        $this->tableID = Model_Ab1_Shop::TABLE_ID;
        $this->tableName = Model_Ab1_Shop::TABLE_NAME;
        $this->objectName = 'branch';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_new(){
        $this->_sitePageData->url = '/ab1-admin/shopbranch/new';

        $this->_requestShopBranchType();
        $this->_requestListDB('DB_Bank');

        parent::action_new();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ab1-admin/shopbranch/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Branch();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestShopBranchType($model->getShopTableRubricID());
        $this->_requestListDB('DB_Bank', $model->getBankID());

        $this->_actionEdit($model, 0);
    }
}

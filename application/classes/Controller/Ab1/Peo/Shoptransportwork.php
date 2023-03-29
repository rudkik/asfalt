<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopTransportWork extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Work';
        $this->controllerName = 'shoptransportwork';
        $this->tableID = Model_Ab1_Shop_Transport_Work::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Work::TABLE_NAME;
        $this->objectName = 'transportwork';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_new(){
        $this->_sitePageData->url = '/peo/shoptransportwork/new';

        $this->_requestListDB('DB_Ab1_Indicator_Type');

        $this->_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/peo/shoptransportwork/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Work();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Indicator_Type', $model->getIndicatorTypeID());

        $this->_actionEdit($model, $this->_sitePageData->shopMainID);
    }
}
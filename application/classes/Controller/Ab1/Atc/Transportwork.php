<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_TransportWork extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Transport_Work';
        $this->controllerName = 'transportwork';
        $this->tableID = Model_Ab1_Transport_Work::TABLE_ID;
        $this->tableName = Model_Ab1_Transport_Work::TABLE_NAME;

        parent::__construct($request, $response);
    }

    public function action_new(){
        $this->_sitePageData->url = '/atc/transportwork/new';

        $this->_requestListDB(DB_Ab1_Shop_Transport_Work::NAME);

        parent::action_new();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/atc/transportwork/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Transport_Work();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB(DB_Ab1_Shop_Transport_Work::NAME);

        $this->_actionEdit($model, 0);
    }
}

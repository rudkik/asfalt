<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_SeasonTime extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Season_Time';
        $this->controllerName = 'seasontime';
        $this->tableID = Model_Ab1_Season_Time::TABLE_ID;
        $this->tableName = Model_Ab1_Season_Time::TABLE_NAME;
        $this->objectName = 'seasontime';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/atc/seasontime/index';

        $this->_requestListDB('DB_Ab1_Season');

        parent::_actionIndex(
            array(
                'season_id' => array('name'),
            )
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/atc/seasontime/new';

        $this->_requestListDB('DB_Ab1_Season');

        parent::action_new();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/atc/seasontime/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Season_Time();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Season', $model->getSeasonID());

        $this->_actionEdit($model, 0);
    }
}

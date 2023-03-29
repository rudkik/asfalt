<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_Fuel extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Fuel';
        $this->controllerName = 'fuel';
        $this->tableID = Model_Ab1_Fuel::TABLE_ID;
        $this->tableName = Model_Ab1_Fuel::TABLE_NAME;
        $this->objectName = 'fuel';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }
    public function action_index() {
        $this->_sitePageData->url = '/atc/fuel/index';

        $this->_requestListDB('DB_Ab1_Fuel_Type');

        parent::_actionIndex(
            array(
                'fuel_type_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/atc/fuel/new';

        $this->_requestListDB('DB_Ab1_Fuel_Type');
        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/atc/fuel/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Fuel();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Fuel_Type', $model->getFuelTypeID());

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }


    public function action_statistics()
    {
        $this->_sitePageData->url = '/atc/fuel/statistics';

        $this->_actionFuelStatistics();
    }
}

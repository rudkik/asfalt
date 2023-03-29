<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Config_MVC extends Controller_Config_Basic {

    public function action_index() {
        $this->_sitePageData->url = '/config/mvc/index';

        $this->_putInMain('/main/mvc/index');
    }

    public function action_index2() {
        $this->_sitePageData->url = '/config/mvc/index2';

        $tableName = Request_RequestParams::getParamStr('tableName');
        $projectName = Request_RequestParams::getParamStr('projectName');
        $interfaceName = Request_RequestParams::getParamStr('interfaceName');

        if (Request_RequestParams::getParamBoolean('updateDB')){
            Api_MVC::createDB($tableName, $projectName, $this->_driverDB);
        }
        if (Request_RequestParams::getParamBoolean('updateModel')){
            Api_MVC::createModel($tableName);
        }
        if (Request_RequestParams::getParamBoolean('updateController')){
            Api_MVC::createController($tableName, $projectName, $interfaceName);
        }

        $this->_putInMain('/main/mvc/index2');
    }

    public function action_index3(){
        $this->_sitePageData->url = '/config/mvc/index3';

        $tableName = Request_RequestParams::getParamStr('tableName');
        $projectName = Request_RequestParams::getParamStr('projectName');
        $interfaceName = Request_RequestParams::getParamStr('interfaceName');

        $titleIndex = Request_RequestParams::getParamStr('name-index');
        $title = '';

        $requiredFields = Request_RequestParams::getParamArray('fields', [], []);
        $titles = Request_RequestParams::getParamArray('titles', [], []);

        if (Request_RequestParams::getParamBoolean('updateIndex')){
            Api_MVC::createViews($tableName, $projectName, $interfaceName, $titleIndex, $title, $title, $title, '', $requiredFields, $titles, 'index');
        }

        $this->_putInMain('/main/mvc/index3');
    }

    public function action_index4(){
        $this->_sitePageData->url = '/config/mvc/index4';

        $tableName = Request_RequestParams::getParamStr('tableName');
        $projectName = Request_RequestParams::getParamStr('projectName');
        $interfaceName = Request_RequestParams::getParamStr('interfaceName');

        $title = '';

        $requiredFields = Request_RequestParams::getParamArray('fields', [], []);
        $titles = Request_RequestParams::getParamArray('titles', [], []);

        if (Request_RequestParams::getParamBoolean('updateEditNew')){
            Api_MVC::createViews($tableName, $projectName, $interfaceName, $title, $_POST['name-new'], $_POST['name-edit'], $title, '', $requiredFields, $titles, 'edit');
        }
        $this->_putInMain('/main/mvc/index4');
    }

    public function action_create() {
        $this->_sitePageData->url = '/config/mvc/create';

        $tableName = Request_RequestParams::getParamStr('tableName');
        $projectName = Request_RequestParams::getParamStr('projectName');
        $interfaceName = Request_RequestParams::getParamStr('interfaceName');

        $title = '';

        $requiredFields = Request_RequestParams::getParamArray('fields', [], []);
        $titles = Request_RequestParams::getParamArray('titles', [], []);


        if (Request_RequestParams::getParamBoolean('updateFilter')){
            Api_MVC::createViews($tableName, $projectName, $interfaceName, $title, $title, $title, $_POST['name-filter'], '', $requiredFields, $titles, 'filter');
        }

        echo 'Ура, мы молодцы!!!';
    }
}
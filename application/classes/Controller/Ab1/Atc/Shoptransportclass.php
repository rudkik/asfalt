<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopTransportClass extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Class';
        $this->controllerName = 'shoptransportclass';
        $this->tableID = Model_Ab1_Shop_Transport_Class::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Class::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    
    public function action_index()
    {
        $this->_sitePageData->url = '/atc/shoptransportclass/index';


        parent::_actionIndex(
            array(
            )
        );

    }

    public function action_new(){
        $this->_sitePageData->url = '/atc/shoptransportclass/new';


        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/atc/shoptransportclass/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Class();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }


        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

}

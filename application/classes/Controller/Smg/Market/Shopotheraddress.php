<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopOtherAddress extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Other_Address';
        $this->controllerName = 'shopotheraddress';
        $this->tableID = Model_AutoPart_Shop_Other_Address::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Other_Address::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    
    public function action_index()
    {
        $this->_sitePageData->url = '/market/shopotheraddress/index';

            $this->_requestListDB('DB_City');
    
        parent::_actionIndex(
            array(
                'city_id' => ['name'],
            )
        );

    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shopotheraddress/new';

        $this->_requestListDB('DB_City');

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shopotheraddress/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Other_Address();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_City', $model->getValueInt('city_id'));

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

}

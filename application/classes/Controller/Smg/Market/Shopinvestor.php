<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopInvestor extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Investor';
        $this->controllerName = 'shopinvestor';
        $this->tableID = Model_AutoPart_Shop_Investor::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Investor::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    
    public function action_index()
    {
        $this->_sitePageData->url = '/market/shopinvestor/index';

    
        parent::_actionIndex(
            array(
            )
        );

    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shopinvestor/new';


        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shopinvestor/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Investor();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }


        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

}

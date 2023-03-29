<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopInvestorIncome extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Investor_Income';
        $this->controllerName = 'shopinvestorincome';
        $this->tableID = Model_AutoPart_Shop_Investor_Income::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Investor_Income::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    
    public function action_index()
    {
        $this->_sitePageData->url = '/market/shopinvestorincome/index';

            $this->_requestListDB('DB_AutoPart_Shop_Investor');
    
        parent::_actionIndex(
            array(
                'shop_investor_id' => ['name'],
            )
        );

    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shopinvestorincome/new';

        $this->_requestListDB('DB_AutoPart_Shop_Investor');

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shopinvestorincome/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Investor_Income();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Investor', $model->getValueInt('shop_investor_id'));

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

}

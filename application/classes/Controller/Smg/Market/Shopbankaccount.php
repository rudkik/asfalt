<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopBankAccount extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Bank_Account';
        $this->controllerName = 'shopbankaccount';
        $this->tableID = Model_AutoPart_Shop_Bank_Account::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Bank_Account::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/market/shopbankaccount/index';

            $this->_requestListDB('DB_Bank');
            $this->_requestListDB('DB_AutoPart_Shop_Company');
    
        parent::_actionIndex(
            array(
                'bank_id' => ['name'],
                'shop_company_id' => ['name'],
            )
        );

    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shopbankaccount/new';

        $this->_requestListDB('DB_Bank');
        $this->_requestListDB('DB_AutoPart_Shop_Company');

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shopbankaccount/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Bank_Account();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Bank', $model->getValueInt('bank_id'));
        $this->_requestListDB('DB_AutoPart_Shop_Company', $model->getValueInt('shop_company_id'));

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

}

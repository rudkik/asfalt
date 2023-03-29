<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopBankAccountBalance extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Bank_Account_Balance';
        $this->controllerName = 'shopbankaccountbalance';
        $this->tableID = Model_AutoPart_Shop_Bank_Account_Balance::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Bank_Account_Balance::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    
    public function action_index()
    {
        $this->_sitePageData->url = '/market/shopbankaccountbalance/index';

            $this->_requestListDB('DB_AutoPart_Shop_Company');
            $this->_requestListDB('DB_AutoPart_Shop_Bank_Account', NULL, 0, [], ['shop_company_id' => ['name']]);

        parent::_actionIndex(
            array(
                'shop_company_id' => ['name'],
                'shop_bank_account_id' => ['name'],
            )
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shopbankaccountbalance/new';

        $this->_requestListDB('DB_AutoPart_Shop_Company');
        $this->_requestListDB('DB_AutoPart_Shop_Bank_Account', NULL, 0, [], ['shop_company_id' => ['name']]);

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shopbankaccountbalance/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Bank_Account_Balance();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Company', $model->getShopCompanyID());
        $this->_requestListDB('DB_AutoPart_Shop_Bank_Account', $model->getShopBankAccountID(), 0, [], ['shop_company_id' => ['name']]);

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

}

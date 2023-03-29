<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopBillReturn extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Bill_Return';
        $this->controllerName = 'shopbillreturn';
        $this->tableID = Model_AutoPart_Shop_Bill_Return::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Bill_Return::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    
    public function action_index()
    {
        $this->_sitePageData->url = '/market/shopbillreturn/index';

            $this->_requestListDB('DB_AutoPart_Shop_Bill');
            $this->_requestListDB('DB_AutoPart_Shop_Bill_Return_Status');
    
        parent::_actionIndex(
            array(
                'shop_bill_id' => ['name'],
                'shop_bill_return_status_id' => ['name'],
            )
        );

    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shopbillreturn/new';

        $this->_requestListDB('DB_AutoPart_Shop_Bill');
        $this->_requestListDB('DB_AutoPart_Shop_Bill_Return_Status');

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shopbillreturn/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Bill_Return();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Bill', $model->getValueInt('shop_bill_id'));
        $this->_requestListDB('DB_AutoPart_Shop_Bill_Return_Status', $model->getValueInt('shop_bill_return_status_id'));

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

}

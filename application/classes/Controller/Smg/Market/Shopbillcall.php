<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopBillCall extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Bill_Call';
        $this->controllerName = 'shopbillcall';
        $this->tableID = Model_AutoPart_Shop_Bill_Call::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Bill_Call::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    
    public function action_index()
    {
        $this->_sitePageData->url = '/market/shopbillcall/index';

            $this->_requestListDB('DB_AutoPart_Shop_Operation');
            $this->_requestListDB('DB_AutoPart_Shop_Bill_Call_Status');
            $this->_requestListDB('DB_AutoPart_Shop_Bill');
    
        parent::_actionIndex(
            array(
                'shop_operation_id' => ['name'],
                'shop_bill_call_status_id' => ['name'],
                'shop_bill_id' => ['name'],
            )
        );

    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shopbillcall/new';

        $this->_requestListDB('DB_AutoPart_Shop_Operation');
        $this->_requestListDB('DB_AutoPart_Shop_Bill_Call_Status');
        $this->_requestListDB('DB_AutoPart_Shop_Bill');

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shopbillcall/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Bill_Call();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Operation', $model->getValueInt('shop_operation_id'));
        $this->_requestListDB('DB_AutoPart_Shop_Bill_Call_Status', $model->getValueInt('shop_bill_call_status_id'));
        $this->_requestListDB('DB_AutoPart_Shop_Bill', $model->getValueInt('shop_bill_id'));

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

}

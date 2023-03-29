<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopPurchaseProduct extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Purchase_Product';
        $this->controllerName = 'shoppurchaseproduct';
        $this->tableID = Model_AutoPart_Shop_Purchase_Product::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Purchase_Product::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    
    public function action_index()
    {
        $this->_sitePageData->url = '/market/shoppurchaseproduct/index';

            $this->_requestListDB('DB_AutoPart_Shop_Supplier');
            $this->_requestListDB('DB_AutoPart_Shop_Courier');
    
        parent::_actionIndex(
            array(
                'shop_supplier_id' => ['name'],
                'shop_courier_id' => ['name'],
            )
        );

    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shoppurchaseproduct/new';

        $this->_requestListDB('DB_AutoPart_Shop_Supplier');
        $this->_requestListDB('DB_AutoPart_Shop_Courier');

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shoppurchaseproduct/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Purchase_Product();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Supplier', $model->getValueInt('shop_supplier_id'));
        $this->_requestListDB('DB_AutoPart_Shop_Courier', $model->getValueInt('shop_courier_id'));

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

}

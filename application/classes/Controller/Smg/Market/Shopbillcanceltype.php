<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopBillCancelType extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Bill_CancelType';
        $this->controllerName = 'shopbillcanceltype';
        $this->tableID = Model_AutoPart_Shop_Bill_CancelType::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Bill_CancelType::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    
    public function action_index()
    {
        $this->_sitePageData->url = '/market/shopbillcanceltype/index';

            $this->_requestListDB('DB_AutoPart_Shop_Source');
    
        parent::_actionIndex(
            array(
                'shop_source_id' => ['name'],
            )
        );

    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shopbillcanceltype/new';

        $this->_requestListDB('DB_AutoPart_Shop_Source');

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shopbillcanceltype/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Bill_CancelType();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Source', $model->getValueInt('shop_source_id'));

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

}

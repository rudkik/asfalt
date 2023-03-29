<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopCourierAddress extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Courier_Address';
        $this->controllerName = 'shopcourieraddress';
        $this->tableID = Model_AutoPart_Shop_Courier_Address::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Courier_Address::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    
    public function action_index()
    {
        $this->_sitePageData->url = '/market/shopcourieraddress/index';

            $this->_requestListDB('DB_City');
            $this->_requestListDB('DB_AutoPart_Shop_Courier');
    
        parent::_actionIndex(
            array(
                'city_id' => ['name'],
                'shop_courier_id' => ['name'],
            )
        );

    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shopcourieraddress/new';

        $this->_requestListDB('DB_City');
        $this->_requestListDB('DB_AutoPart_Shop_Courier');

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shopcourieraddress/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Courier_Address();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_City', $model->getValueInt('city_id'));
        $this->_requestListDB('DB_AutoPart_Shop_Courier', $model->getValueInt('shop_courier_id'));

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopProductAttribute extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Attribute';
        $this->controllerName = 'shopproductattribute';
        $this->tableID = Model_AutoPart_Shop_Attribute::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Attribute::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    
    public function action_index()
    {
        $this->_sitePageData->url = '/market/shopproductattribute/index';

            $this->_requestListDB('DB_AutoPart_Shop_Attribute');
            $this->_requestListDB('DB_AutoPart_Shop_Product');
            $this->_requestListDB('DB_AutoPart_Shop_Attribute_Type');
            $this->_requestListDB('DB_AutoPart_Shop_Attribute_Rubric');
    
        parent::_actionIndex(
            array(
                'shop_attribute_id' => ['name'],
                'shop_product_id' => ['name'],
                'shop_product_attribute_type_id' => ['name'],
                'shop_product_attribute_rubric_id' => ['name'],
            )
        );

    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shopproductattribute/new';

        $this->_requestListDB('DB_AutoPart_Shop_Attribute');
        $this->_requestListDB('DB_AutoPart_Shop_Product');
        $this->_requestListDB('DB_AutoPart_Shop_Attribute_Type');
        $this->_requestListDB('DB_AutoPart_Shop_Attribute_Rubric');

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shopproductattribute/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Attribute();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Attribute', $model->getValueInt('shop_attribute_id'));
        $this->_requestListDB('DB_AutoPart_Shop_Product', $model->getValueInt('shop_product_id'));
        $this->_requestListDB('DB_AutoPart_Shop_Attribute_Type', $model->getValueInt('shop_product_attribute_type_id'));
        $this->_requestListDB('DB_AutoPart_Shop_Attribute_Rubric', $model->getValueInt('shop_product_attribute_rubric_id'));

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

}

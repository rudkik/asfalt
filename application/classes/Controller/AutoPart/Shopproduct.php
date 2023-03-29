<?php defined('SYSPATH') or die('No direct script access.');

class Controller_AutoPath_ShopProduct extends Controller_BasicAdmin{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Product';
        $this->controllerName = 'shopproduct';
        $this->tableID = Model_AutoPart_Shop_Product::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Product::TABLE_NAME;
        $this->objectName = 'product';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'smg/_all';
    }
    public function action_index() {
        $this->_sitePageData->url = '/shopproduct/index';

        $this->_requestListDB('DB_AutoPart_Shop_Mark');
        $this->_requestListDB('DB_AutoPart_Shop_Model');
        $this->_requestListDB('DB_AutoPart_Shop_Brand');
        $this->_requestListDB('DB_AutoPart_Shop_Storage');
        $this->_requestListDB('DB_AutoPart_Work_Type');

        parent::_actionIndex(
            array(
                'shop_storage_id' => array('name'),
                'work_type_id' => array('name'),
                'shop_mark_id' => array('name'),
                'shop_model_id' => array('name'),
                'shop_brand_id' => array('name'),

            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/shopproduct/new';

        $this->_requestListDB('DB_AutoPart_Shop_Mark');
        $this->_requestListDB('DB_AutoPart_Shop_Model');
        $this->_requestListDB('DB_AutoPart_Shop_Brand');
        $this->_requestListDB('DB_AutoPart_Shop_Storage');
        $this->_requestListDB('DB_AutoPart_Work_Type');
        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/shopproduct/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Product();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }
        $this->_requestListDB('DB_AutoPart_Shop_Model', $model->getShopModelID());
        $this->_requestListDB('DB_AutoPart_Shop_Brand', $model->getShopBrandID());
        $this->_requestListDB('DB_AutoPart_Shop_Storage', $model->getShopStorageID());
        $this->_requestListDB('DB_AutoPart_Work_Type', $model->getWorkTypeID());
        $this->_requestListDB('DB_AutoPart_Shop_Mark', $model->getShopMarkID());

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }
}


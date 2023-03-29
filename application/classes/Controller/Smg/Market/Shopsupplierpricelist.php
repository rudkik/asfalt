<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopSupplierPriceList extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Supplier_PriceList';
        $this->controllerName = 'shopsupplierpricelist';
        $this->tableID = Model_AutoPart_Shop_Supplier_PriceList::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Supplier_PriceList::TABLE_NAME;
        $this->objectName = 'supplierpricelist';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/market/shopsupplierpricelist/index';

        $this->_requestListDB('DB_AutoPart_Shop_Supplier');

        parent::_actionIndex(
            array(
                'shop_supplier_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/market/shopsupplierpricelist/new';

        $this->_requestListDB('DB_AutoPart_Shop_Supplier');

        parent::_actionNew();
    }

    public function action_load_file()
    {
        $this->_sitePageData->url = '/market/shopsupplierpricelist/load_file';

        $integrations = Request_RequestParams::getParamArray('integrations', array(), array());
        $break = Request_RequestParams::getParamArray('break', array(), array());
        $result = Helpers_Excel::loadFileInData(
            $_FILES['file']['tmp_name'],
            Request_RequestParams::getParamInt('first_row'),
            $integrations, $break,
            Request_RequestParams::getParamArray('availability', array(), array()),
            Request_RequestParams::getParamFloat('price_more')
        );

        $this->_requestListDB('DB_AutoPart_Shop_Supplier');

        $data = new MyArray();
        $data->additionDatas['shop_products'] = $result;

        $fields = array();
        foreach ($integrations as $child){
            $field = Arr::path($child, 'field');
            if(!empty($field)){
                $fields[] = $field;
            }
        }
        $data->additionDatas['fields'] = $fields;

        $result = Helpers_View::getView(
            '_shop/supplier/price-list/one/data', $this->_sitePageData, $this->_driverDB, $data
        );

        $this->response->body($result);
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/market/shopsupplierpricelist/save';

        $result = DB_Basic::save($this->dbObject, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB);

        /** @var Model_AutoPart_Shop_Supplier_PriceList $model */
        $model = $result['model'];

        $data = Request_RequestParams::getParamArray('shop_products');
        if(empty($data)){
            $data = Helpers_Excel::loadFileInData(
                $_FILES['file']['tmp_name'],
                $model->getFirstRow(),
                $model->getIntegrationsArray(),
                Request_RequestParams::getParamArray('break', array(), array()),
                Request_RequestParams::getParamArray('availability', array(), array()),
                Request_RequestParams::getParamFloat('price_more')
            );
        }

        $editFields = ['price_cost', 'price'];
        foreach ($model->getIntegrationsArray() as $option){
            if($option['field'] == 'integration'){
                continue;
            }

            if (Request_RequestParams::isBoolean(Arr::path($option, 'is_replace', false))){
                $editFields[] = $option['field'];
            }
        }

        $data = DB_Basic::saveOfExcelObjects(
            DB_AutoPart_Shop_Product::NAME, $data, $editFields,
            ['shop_supplier_id' => $model->getShopSupplierID(),],
            $this->_sitePageData, $this->_driverDB, true
        );

        $model->setIsLoadData($data !== false);

        if($model->getIsLoadData()){
            $model->setOldCount($data['old']);
            $model->setNewCount($data['new']);
        }
        Helpers_DB::saveDBObject($model, $this->_sitePageData, $this->_sitePageData->shopID);

        $this->_redirectSaveResult($result);
    }
}

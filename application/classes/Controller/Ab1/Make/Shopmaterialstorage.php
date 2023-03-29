<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Make_ShopMaterialStorage extends Controller_Ab1_Make_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Material_Storage';
        $this->controllerName = 'shopmaterialstorage';
        $this->tableID = Model_Ab1_Shop_Material_Storage::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Material_Storage::TABLE_NAME;
        $this->objectName = 'materialstorage';

        parent::__construct($request, $response);
    }

    public function action_total() {
        $this->_sitePageData->url = '/make/shopmaterialstorage/total';
        $this->_actionShopMaterialStorageTotal();
    }

}

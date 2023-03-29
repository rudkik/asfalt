<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Control_ShopMaterialStorage extends Controller_Ab1_Control_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Material_Storage';
        $this->controllerName = 'shopmaterialstorage';
        $this->tableID = Model_Ab1_Shop_Material_Storage::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Material_Storage::TABLE_NAME;
        $this->objectName = 'materialstorage';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/control/shopmaterialstorage/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/storage/list/index',
            )
        );

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Material_Storage', $this->_sitePageData->shopID,
            "_shop/material/storage/list/index", "_shop/material/storage/one/index",
            $this->_sitePageData, $this->_driverDB,
            array(
                'limit' => 1000, 'limit_page' => 25,
            )
        );

        $this->_putInMain('/main/_shop/material/storage/index');
    }

    public function action_total() {
        $this->_sitePageData->url = '/control/shopmaterialstorage/total';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/storage/list/total',
            )
        );

        $this->_requestShopMaterials();
        $this->_requestListDB('DB_Ab1_Shop_Material_Storage');

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Material_Storage', $this->_sitePageData->shopID,
            "_shop/material/storage/list/total", "_shop/material/storage/one/total",
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'sort_by' => ['name' => 'asc'],
                ),
                false
            ),
            array(
                'shop_material_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/material/storage/total');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/control/shopmaterialstorage/new';
        $this->_actionShopMaterialStorageNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/control/shopmaterialstorage/edit';
        $this->_actionShopMaterialStorageEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/control/shopmaterialstorage/save';

        $result = Api_Ab1_Shop_Material_Storage::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

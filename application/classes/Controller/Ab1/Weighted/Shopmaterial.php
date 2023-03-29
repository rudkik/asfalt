<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopMaterial extends Controller_Ab1_Weighted_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Material';
        $this->controllerName = 'shopmaterial';
        $this->tableID = Model_Ab1_Shop_Material::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Material::TABLE_NAME;
        $this->objectName = 'material';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shopmaterial/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Material', $this->_sitePageData->shopMainID, "_shop/material/list/index", "_shop/material/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array('shop_client_id' => array('name')));

        $this->_putInMain('/main/_shop/material/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopmaterial/new';
        $this->_actionShopMaterialNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopmaterial/edit';
        $this->_actionShopMaterialEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopmaterial/save';

        $result = Api_Ab1_Shop_Material::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

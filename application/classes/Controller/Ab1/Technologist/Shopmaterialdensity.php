<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Technologist_ShopMaterialDensity extends Controller_Ab1_Technologist_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Material_Density';
        $this->controllerName = 'shopmaterialdensity';
        $this->tableID = Model_Ab1_Shop_Material_Density::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Material_Density::TABLE_NAME;
        $this->objectName = 'materialdensity';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/technologist/shopmaterialdensity/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/density/list/index',
            )
        );

        $this->_requestShopMaterials( NULL, null, null, true);
        $this->_requestShopRaws(NULL, array('is_moisture_and_density' => true));

        $params = Request_RequestParams::setParams(
            array(
                'limit' => 1000, 'limit_page' => 25,
                'sort_by' => array(
                    'date' => 'desc',
                    'quantity' => 'desc',
                )
            ),
            false
        );

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Material_Density', $this->_sitePageData->shopID,
            "_shop/material/density/list/index", "_shop/material/density/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_material_id' => array('name'),
                'shop_raw_id' => array('name'),
                'shop_branch_daughter_id' => array('name'),
                'shop_daughter_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/material/density/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/technologist/shopmaterialdensity/new';
        $this->_actionShopMaterialDensityNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/technologist/shopmaterialdensity/edit';
        $this->_actionShopMaterialDensityEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/technologist/shopmaterialdensity/save';

        $result = Api_Ab1_Shop_Material_Density::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

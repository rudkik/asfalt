<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Crusher_ShopRawMaterial extends Controller_Ab1_Crusher_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Raw_Material';
        $this->controllerName = 'shoprawmaterial';
        $this->tableID = Model_Ab1_Shop_Raw_Material::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Raw_Material::TABLE_NAME;
        $this->objectName = 'rawmaterial';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/crusher/shoprawmaterial/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/material/list/index',
            )
        );

        $shopRawIDs = Arr::path($this->_sitePageData->operation->getAccessArray(), 'shop_raw_ids', NULL);
        $this->_requestShopRaws(
            null, Request_RequestParams::setParams(array('id' => $shopRawIDs))
        );
        $data = $this->_requestShopClients(null, Model_Ab1_ClientType::CLIENT_TYPE_BUY_RAW);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/boxcar/client/list/list', $data);

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'limit' => 1000, 'limit_page' => 25,
                'shop_raw_id' => $shopRawIDs,
                'sort_by' => array(
                    'date' => 'desc',
                ),
            ),
            FALSE
        );

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Raw_Material', $this->_sitePageData->shopID,
            "_shop/raw/material/list/index", "_shop/raw/material/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_raw_id' => array('name'),
                'shop_ballast_crusher_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/raw/material/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/crusher/shoprawmaterial/new';
        $this->_actionShopRawMaterialNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/crusher/shoprawmaterial/edit';
        $this->_actionShopRawMaterialEdit();
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/crusher/shoprawmaterial/del';
        $result = Api_Ab1_Shop_Raw_Material::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/crusher/shoprawmaterial/save';

        $result = Api_Ab1_Shop_Raw_Material::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_add_raws()
    {
        $this->_sitePageData->url = '/ballast/shoprawmaterial/add_raws';

        Api_Ab1_Shop_Register_Raw::addShopRawMaterials($this->_sitePageData, $this->_driverDB);
        echo 'ok'; die;
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Crusher_ShopRawMaterialItem extends Controller_Ab1_Crusher_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Raw_Material_Item';
        $this->controllerName = 'shoprawmaterialitem';
        $this->tableID = Model_Ab1_Shop_Raw_Material_Item::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Raw_Material_Item::TABLE_NAME;
        $this->objectName = 'rawmaterialitem';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/crusher/shoprawmaterialitem/index';

        $date = Request_RequestParams::getParamDate('date');
        if(empty($date)){
            $date = date('Y-m-d');
        }

        $params = Request_RequestParams::setParams(
            array(
                'from_at_to' => $date,
                'to_at_from_equally' => $date,
            ),
            false
        );
        $shopFormulaRaw = Request_Request::findOneModel(
            'DB_Ab1_Shop_Formula_Raw', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params
        );
        if($shopFormulaRaw == null){
            $shopFormulaRawID = 0;
        }else{
            $shopFormulaRawID = $shopFormulaRaw->id;
        }

        // получаем список
        $params = Request_RequestParams::setParams(
            array(
                'shop_formula_raw_id' => $shopFormulaRawID,
                'sort_by' => array('id' => 'asc'),
            )
        );

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $result = View_View::find(
            'DB_Ab1_Shop_Formula_Raw_Item', $this->_sitePageData->shopID,
            "_shop/raw/material/item/list/index", "_shop/raw/material/item/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_raw_id' => array('name'),
                'shop_material_id' => array('name'),
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->response->body($result);
    }
}

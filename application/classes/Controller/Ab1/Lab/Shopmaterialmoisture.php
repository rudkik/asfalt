<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Lab_ShopMaterialMoisture extends Controller_Ab1_Lab_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Material_Moisture';
        $this->controllerName = 'shopmaterialmoisture';
        $this->tableID = Model_Ab1_Shop_Material_Moisture::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Material_Moisture::TABLE_NAME;
        $this->objectName = 'materialmoisture';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/lab/shopmaterialmoisture/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/moisture/list/index',
            )
        );

        $this->_requestShopMaterials( NULL, null, null, true);
        $this->_requestShopRaws(NULL, array('is_moisture_and_density' => true));

        $params = Request_RequestParams::setParams(
            array(
                'limit' => 1000, 'limit_page' => 25,
                'quantity_from' => 0,
                'sort_by' => array(
                    'date' => 'desc',
                    'quantity' => 'desc',
                )
            ),
            false
        );

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Material_Moisture', $this->_sitePageData->shopID,
            "_shop/material/moisture/list/index", "_shop/material/moisture/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_material_id' => array('name'),
                'shop_raw_id' => array('name'),
                'shop_branch_daughter_id' => array('name'),
                'shop_daughter_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/material/moisture/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/lab/shopmaterialmoisture/new';
        $this->_actionShopMaterialMoistureNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/lab/shopmaterialmoisture/edit';
        $this->_actionShopMaterialMoistureEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/lab/shopmaterialmoisture/save';

        $result = Api_Ab1_Shop_Material_Moisture::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_calc_quantity()
    {
        $this->_sitePageData->url = '/lab/shopmaterialmoisture/calc_quantity';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Material_Moisture();
        if (! $this->getDBObject($model, $id, $this->_sitePageData->shopID)) {
            throw new HTTP_Exception_404('Material moisture not is found!');
        }

        if($model->getShopMaterialID() > 0){
            $quantity = Api_Ab1_Shop_Car_To_Material::calcImportQuantity(
                $model->getDate().' 06:00:00', Helpers_DateTime::plusDays($model->getDate().' 06:00:00', 1),
                $model->getShopBranchDaughterID(), $model->getShopDaughterID(), $model->getShopMaterialID(),
                $this->_sitePageData, $this->_driverDB
            );
        }elseif($model->getShopRawID() > 0){
            $quantity = Api_Ab1_Shop_Raw_Material::calcImportQuantity(
                $model->getDate(), Helpers_DateTime::plusDays($model->getDate(), 1),
                $model->getShopBranchDaughterID(), $model->getShopRawID(),
                $this->_sitePageData, $this->_driverDB
            );
        }else{
            $quantity = 0;
        }

        $model->setQuantity($quantity);
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        $this->response->body(Json::json_encode($model->getValues()));
    }
}

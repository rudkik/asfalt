<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Lab_ShopAnalysis extends Controller_Ab1_Lab_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Analysis';
        $this->controllerName = 'shopanalysis';
        $this->tableID = Model_Ab1_Shop_Analysis::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Analysis::TABLE_NAME;
        $this->objectName = 'analysis';

        parent::__construct($request, $response);

    }

    public function action_index() {
        $this->_sitePageData->url = '/lab/shopanalysis/index';

        $this->_requestListDB('DB_Ab1_Shop_Analysis_Type');
        $this->_requestListDB('DB_Ab1_Shop_Analysis_Place');
        $this->_requestListDB('DB_Ab1_Shop_Raw');
        $this->_requestListDB('DB_Ab1_Shop_Material');
        $this->_requestListDB('DB_Ab1_Shop_Product');
        $this->_requestListDB('DB_Ab1_Shop_Worker');

        $id = Request_RequestParams::getParamInt('shop_analysis_type_id');
        $data = View_View::findOne('DB_Ab1_Shop_Analysis_Type', $this->_sitePageData->shopID, "_shop/analysis/type/one/thead",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        parent::_actionIndex(
            array(
                'shop_analysis_type_id' => array('name'),
                'shop_analysis_place_id' => array('name'),
                'shop_raw_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_worker_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/lab/shopanalysis/new';

        $this->_requestListDB('DB_Ab1_Shop_Analysis_Type');
        $this->_requestListDB('DB_Ab1_Shop_Analysis_Place');
        $this->_requestListDB('DB_Ab1_Shop_Raw');
        $this->_requestListDB('DB_Ab1_Shop_Material');
        $this->_requestListDB('DB_Ab1_Shop_Product');
        $this->_requestListDB('DB_Ab1_Shop_Worker');

        $this->_requestListDB(DB_Basic::getDBByTableID(1));

        $id = Request_RequestParams::getParamInt('shop_analysis_type_id');
        $model = new Model_Ab1_Shop_Analysis_Type();
        $model->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)){
            throw new HTTP_Exception_404('Analysis type "' . $id. '" not is found!');
        }

        $data = new MyArray();
        $data->additionDatas['fields'] = Arr::path($model->getOptionsArray(), 'fields', array());
        Helpers_View::getView(
            '_shop/analysis/one/new', $this->_sitePageData, $this->_driverDB, $data
        );

        $this->_putInMain('/main/_shop/analysis/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/lab/shopanalysis/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Analysis();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Worker', $model->getShopWorkerID());
        $this->_requestListDB('DB_Ab1_Shop_Analysis_Type', $model->getShopAnalysisTypeID());
        $this->_requestListDB('DB_Ab1_Shop_Analysis_Place', $model->getShopAnalysisPlaceID());
        $this->_requestListDB('DB_Ab1_Shop_Raw', $model->getShopRawID());
        $this->_requestListDB('DB_Ab1_Shop_Material', $model->getShopMaterialID());
        $this->_requestListDB('DB_Ab1_Shop_Product', $model->getShopProductID());


        $modelType = new Model_Ab1_Shop_Analysis_Type();
        $modelType->setDBDriver($this->_driverDB);
        if(!Helpers_DB::getDBObject($modelType, $model->getShopAnalysisTypeID(), $this->_sitePageData)){
            throw new HTTP_Exception_404('Analysis type "' . $model->getShopAnalysisTypeID(). '" not is found!');
        }

        // получаем данные
        $ids = new MyArray();
        $ids->setValues($model, $this->_sitePageData);
        $ids->additionDatas['fields'] = Arr::path($modelType->getOptionsArray(), 'fields', array());

        $result = Helpers_View::getViewObject(
            $ids, $model, '_shop/analysis/one/edit', $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/analysis/one/edit',  $result);

        $this->_putInMain('/main/_shop/analysis/edit');
    }
}


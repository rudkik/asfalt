<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Lab_ShopAnalysisAct extends Controller_Ab1_Lab_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Analysis_Act';
        $this->controllerName = 'shopanalysisact';
        $this->tableID = Model_Ab1_Shop_Analysis_Act::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Analysis_Act::TABLE_NAME;
        $this->objectName = 'analysisact';

        parent::__construct($request, $response);

    }

    public function action_index() {
        $this->_sitePageData->url = '/lab/shopanalysisact/index';

        $this->_requestListDB('DB_Ab1_Shop_Analysis');
        $this->_requestListDB('DB_Ab1_Shop_Raw');
        $this->_requestListDB('DB_Ab1_Shop_Material');
        $this->_requestListDB('DB_Ab1_Shop_Product');
        $this->_requestListDB('DB_Ab1_Shop_Worker');

        parent::_actionIndex(
            array(
                'shop_analysis_id' => array('name'),
                'shop_raw_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_worker_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/lab/shopanalysisact/new';

        $this->_requestListDB('DB_Ab1_Shop_Analysis');
        $this->_requestListDB('DB_Ab1_Shop_Raw');
        $this->_requestListDB('DB_Ab1_Shop_Material');
        $this->_requestListDB('DB_Ab1_Shop_Product');
        $this->_requestListDB('DB_Ab1_Shop_Worker');
        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/lab/shopanalysisact/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Analysis_Act();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Worker', $model->getShopWorkerID());
        $this->_requestListDB('DB_Ab1_Shop_Analysis', $model->getShopAnalysisID());
        $this->_requestListDB('DB_Ab1_Shop_Raw', $model->getShopRawID());
        $this->_requestListDB('DB_Ab1_Shop_Material', $model->getShopMaterialID());
        $this->_requestListDB('DB_Ab1_Shop_Product', $model->getShopProductID());

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }
}


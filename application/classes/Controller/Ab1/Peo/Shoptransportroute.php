<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopTransportRoute extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Route';
        $this->controllerName = 'shoptransportroute';
        $this->tableID = Model_Ab1_Shop_Transport_Route::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Route::TABLE_NAME;
        $this->objectName = 'transportroute';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/peo/shoptransportroute/index';

        $this->_requestShopDaughters();
        $this->_requestShopBranches(null, true);

        parent::_actionIndex(
            array(
                'shop_branch_from_id' => array('name'),
                'shop_daughter_from_id' => array('name'),
                'shop_branch_to_id' => array('name'),
                'shop_daughter_to_id' => array('name'),
                'shop_product_rubric_id' => array('name'),
                'shop_ballast_distance_id' => array('name'),
                'shop_storage_id' => array('name'),
            )
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/peo/shoptransportwaybill/new';

        $this->_requestShopDaughters();
        $this->_requestShopBranches(null, true);
        $this->_requestShopProductRubrics(null, 0);
        $this->_requestShopBallastDistances();
        $this->_requestShopStorages();
        $this->_requestListDB(DB_Ab1_Shop_Transportation_Place::NAME, null, $this->_sitePageData->shopID);
        $this->_requestListDB(
            'DB_Table', null, 0,
            Request_RequestParams::setParams(
                array(
                    'id' => [
                        Model_Ab1_Shop_Car::TABLE_ID,
                        Model_Ab1_Shop_Piece::TABLE_ID,
                        Model_Ab1_Shop_Move_Car::TABLE_ID,
                        Model_Ab1_Shop_Lessee_Car::TABLE_ID,
                        Model_Ab1_Shop_Move_Other::TABLE_ID,
                        Model_Ab1_Shop_Car_To_Material::TABLE_ID,
                        Model_Ab1_Shop_Ballast::TABLE_ID,
                        Model_Ab1_Shop_Transportation::TABLE_ID,
                        Model_Ab1_Shop_Product_Storage::TABLE_ID,
                    ]
                )
            ),
            null, 'list', 'title'
        );

        parent::action_new();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/peo/shoptransportroute/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Route();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestShopDaughters();
        $this->_requestShopBranches(null, true);
        $this->_requestShopProductRubrics($model->getShopProductRubricID(), 0);
        $this->_requestShopStorages($model->getShopStorageID());
        $this->_requestListDB(DB_Ab1_Shop_Ballast_Distance::NAME, $model->getShopBallastDistanceID(), $model->shopID);
        $this->_requestListDB(DB_Ab1_Shop_Transportation_Place::NAME, $model->getShopTransportationPlaceID(), $model->shopID);
        $this->_requestListDB(
            'DB_Table', $model->getTableID(), 0,
            Request_RequestParams::setParams(
                array(
                    'id' => [
                        Model_Ab1_Shop_Car::TABLE_ID,
                        Model_Ab1_Shop_Piece::TABLE_ID,
                        Model_Ab1_Shop_Move_Car::TABLE_ID,
                        Model_Ab1_Shop_Lessee_Car::TABLE_ID,
                        Model_Ab1_Shop_Move_Other::TABLE_ID,
                        Model_Ab1_Shop_Car_To_Material::TABLE_ID,
                        Model_Ab1_Shop_Ballast::TABLE_ID,
                        Model_Ab1_Shop_Transportation::TABLE_ID,
                        Model_Ab1_Shop_Product_Storage::TABLE_ID,
                    ]
                )
            ),
            null, 'list', 'title'
        );

        $this->shopID = $model->shopID;
        $this->_actionEdit($model, $model->shopID);
    }

    public function action_calc()
    {
        $this->_sitePageData->url = '/peo/shoptransportroute/calc';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $modelRoute = new Model_Ab1_Shop_Transport_Route();
        if (! $this->dublicateObjectLanguage($modelRoute, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $dateFrom = Request_RequestParams::getParamDate('date_from');

        $params = Request_RequestParams::setParams(
            [
                'date_from_equally' => $dateFrom,
                'shop_transport_route_id' => $id,
            ]
        );
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Car::NAME, 0, $this->_sitePageData, $this->_driverDB,
            $params, 0
        );

        $model = new Model_Ab1_Shop_Transport_Waybill_Car();
        $model->setDBDriver($this->_driverDB);

        foreach ($ids->childs as $child){
            $child->setModel($model);

            $model->setWage(
                Api_Ab1_Shop_Transport_Route::getWageByFormula(
                    $modelRoute->getFormula(),
                    $modelRoute->getAmount(),
                    $model
                )
            );

            Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
        }

        $this->response->body(json_encode(['count' => count($ids->childs)]));
    }
}


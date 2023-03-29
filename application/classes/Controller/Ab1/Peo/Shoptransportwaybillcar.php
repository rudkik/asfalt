<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopTransportWaybillCar extends Controller_Ab1_Peo_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Waybill_Car';
        $this->controllerName = 'shoptransportwaybillcar';
        $this->tableID = Model_Ab1_Shop_Transport_Waybill_Car::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Waybill_Car::TABLE_NAME;
        $this->objectName = 'transportwaybillcar';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/peo/shoptransportwaybillcar/index';

        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver');
        $this->_requestShopTransports();

        View_View::find(
            'DB_Ab1_Shop_Transport_Waybill_Car', $this->_sitePageData->shopID,
            '_shop/transport/waybill/car/list/total', '_shop/transport/waybill/car/one/total',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array_merge(
                    $_GET,
                    $_POST,
                    [
                        'sum_count_trip' => true,
                        'sum_distance' => true,
                        'sum_quantity' => true,
                        'sum_wage' => true,
                        'sort_by' => null,
                    ]
                )
            )
        );

        parent::_actionIndex(
            array(
                'shop_client_to_id' => array('name'),
                'shop_daughter_from_id' => array('name'),
                'shop_branch_to_id' => array('name'),
                'shop_branch_from_id' => array('name'),
                'shop_ballast_crusher_to_id' => array('name'),
                'shop_ballast_crusher_from_id' => array('name'),
                'shop_transportation_place_to_id' => array('name'),
                'shop_transport_route_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_raw_id' => array('name'),
                'shop_product_id' => array('name'),
                'shop_material_other_id' => array('name'),
                'shop_move_place_to_id' => array('name'),
                'shop_move_client_to_id' => array('name'),

                'shop_transport_waybill_id' => array('number', 'date'),
                'shop_transport_id' => array('name', 'number'),
                'shop_transport_driver_id' => array('name'),
            ),
            array(
                'sort_by' => array(
                    'date' => 'asc',
                )
            )
        );
    }


    public function action_save_coefficient()
    {
        $this->_sitePageData->url = '/peo/shoptransportwaybillcar/save_coefficient';

        $coefficient = Request_RequestParams::getParamFloat('coefficient');
        if ($coefficient == 0) {
            throw new HTTP_Exception_404('Coefficient not correct!');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Waybill_Car();
        if (!$this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" id="' . $id . '" not is found!');
        }

        $model->setCoefficient($coefficient);
        $model->setWage(Api_Ab1_Shop_Transport_Route::getWageCar($model, $this->_sitePageData, $this->_driverDB));
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        $this->response->body(Json::json_encode($model->getValues(false, true)));
    }
}


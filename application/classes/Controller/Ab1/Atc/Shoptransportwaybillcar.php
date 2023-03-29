<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopTransportWaybillCar extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Waybill_Car';
        $this->controllerName = 'shoptransportwaybillcar';
        $this->tableID = Model_Ab1_Shop_Transport_Waybill_Car::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Waybill_Car::TABLE_NAME;
        $this->objectName = 'transportwaybillcar';

        parent::__construct($request, $response);
    }

    public function action_save_coefficient()
    {
        $this->_sitePageData->url = '/atc/shoptransportwaybillcar/save_coefficient';

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

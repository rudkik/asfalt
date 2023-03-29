<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopMoveEmpty extends Controller_Ab1_Weighted_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Move_Empty';
        $this->controllerName = 'shopmoveempty';
        $this->tableID = Model_Ab1_Shop_Move_Empty::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Move_Empty::TABLE_NAME;
        $this->objectName = 'moveempty';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/weighted/shopmoveempty/index';

        $this->_requestShopMovePlaces();
        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);

        parent::_actionIndex(
            array(
                'shop_move_place_id' => array('name'),
                'shop_driver_id' => array('name'),
                'weighted_exit_operation_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopmoveempty/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/empty/one/new',
            )
        );

        $this->_requestShopMovePlaces();
        $this->_requestShopTransportCompanies();
        $this->_requestShopCarTares(null, [Model_Ab1_TareType::TARE_TYPE_OUR, Model_Ab1_TareType::TARE_TYPE_OTHER]);

        parent::action_new();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopmoveempty/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Move_Empty();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        $this->_requestShopMovePlaces($model->getShopMovePlaceID());
        $this->_requestShopTransportCompanies($model->getShopTransportCompanyID());
        $this->_requestShopCarTares($model->getShopCarTareID(), [Model_Ab1_TareType::TARE_TYPE_OUR, Model_Ab1_TareType::TARE_TYPE_OTHER]);

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

    public function action_get_images()
    {
        $this->_sitePageData->url = '/weighted/shopmoveempty/get_images';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Move_Empty();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        // получаем данные
        $result = View_View::findOne(
            'DB_Ab1_Shop_Move_Empty', $this->_sitePageData->shopID, "_shop/move/empty/one/images",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopmoveempty/save';

        $result = DB_Basic::save($this->dbObject, $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB);

        /** @var Model_Ab1_Shop_Move_Empty $model */
        $model = $result['model'];
        $model->setDBDriver($this->_driverDB);

        // меняем тару машины
        if ($model->isEditValue('shop_car_tare_id', false) || Func::_empty($model->getName()) || $model->getShopTransportID() == 0) {
            $modelCarTare = new Model_Ab1_Shop_Car_Tare();
            $modelCarTare->setDBDriver($this->_driverDB);
            Helpers_DB::getDBObject($modelCarTare, $model->getShopCarTareID(), $this->_sitePageData, $this->_sitePageData->shopMainID);
            $model->setShopTransportID($modelCarTare->getShopTransportID());

            $model->setTarra($modelCarTare->getWeight());
            $model->setName($modelCarTare->getName());
        }

        // добавляем id водителя
        $driverName = Request_RequestParams::getParamStr('shop_driver_name');
        if($driverName !== NULL) {
            $model->setShopDriverID(
                Api_Ab1_Shop_Driver::getShopDriverIDByName(
                    $driverName, $model->getShopMovePlaceID(), $this->_sitePageData, $this->_driverDB
                )
            );
        }

        // производим первое взвешивание
        if(Request_RequestParams::getParamInt('id') < 1) {
            $model->setWeightedExitOperationID($this->_sitePageData->operationID);
            $model->setWeightedExitAt(date('Y-m-d H:i:s'));

            $brutto = Request_RequestParams::getParamFloat('brutto');
            if($brutto >= $model->getTarra()){
                $model->setQuantity($brutto - $model->getTarra());
            }
        }

        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        $this->_redirectSaveResult($result);
    }

    public function action_send_tarra()
    {
        $this->_sitePageData->url = '/weighted/shopmoveempty/send_tarra';

        // id записи
        if (Request_RequestParams::getParamFloat('is_save')) {
            $result = Api_Ab1_Shop_Move_Empty::save($this->_sitePageData, $this->_driverDB);
            $shopCarID = $result['id'];
        } else {
            $shopCarID = Request_RequestParams::getParamInt('id');
        }

        $model = new Model_Ab1_Shop_Move_Empty();
        if (!$this->dublicateObjectLanguage($model, $shopCarID, -1, FALSE)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        $isError = FALSE;

        $tarra = Request_RequestParams::getParamFloat('tarra');
        if ($tarra <= 0.01) {
            $this->response->body(
                Json::json_encode(
                    array(
                        'error' => 2,
                        'msg' => 'Вес тары "' . (floatval($tarra)) . '" задан не верно.',
                    )
                )
            );
            $isError = TRUE;
        }

        if (!$isError) {
            Request_RequestParams::setParamStr('name', $model);
            Request_RequestParams::setParamFloat('tarra', $model);
            if (!$model->getIsTest()) {
                Request_RequestParams::setParamBoolean('is_test', $model);
            }

            $result = array();
            if ($model->validationFields($result)) {
                $file = new Model_File($this->_sitePageData);

                $data = Controller_Ab1_Weighted_Data::getDataFiles();
                $files = array(
                    0 => array(
                        'title' => 'Тара - передняя камера',
                        'url' => Arr::path($data, 'front', ''),
                        'type' => Model_ImageType::IMAGE_TYPE_IMAGE,
                    ),
                    1 => array(
                        'title' => 'Тара - задняя камера',
                        'url' => Arr::path($data, 'backside', ''),
                        'type' => Model_ImageType::IMAGE_TYPE_IMAGE,
                    ),
                );
                $file->saveFiles($files, $model, $this->_sitePageData, $this->_driverDB, TRUE);

                $this->saveDBObject($model);
            }

            $this->response->body(
                Json::json_encode(
                    array(
                        'error' => 0,
                        'result' => $result,
                    )
                )
            );
        }
    }
}

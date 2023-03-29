<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopMoveOther extends Controller_Ab1_Weighted_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Move_Other';
        $this->controllerName = 'shopmoveother';
        $this->tableID = Model_Ab1_Shop_Move_Other::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Move_Other::TABLE_NAME;
        $this->objectName = 'moveother';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/weighted/shopmoveother/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/other/list/index',
            )
        );

        $this->_requestShopMaterialOthers();
        $this->_requestShopMovePlaces();
        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);

        // получаем список
        View_View::find('DB_Ab1_Shop_Move_Other', $this->_sitePageData->shopID, "_shop/move/other/list/index", "_shop/move/other/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25, 'is_exit' => 1),
            array(
                'shop_move_place_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_material_other_id' => array('name'),
                'shop_driver_id' => array('name'),
                'weighted_exit_operation_id' => array('name'),
                'shop_transport_waybill_id' => array('number'),
            )
        );

        $this->_putInMain('/main/_shop/move/other/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopmoveother/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/other/one/new',
            )
        );

        $this->_requestShopMaterials(NULL, null, true);
        $this->_requestShopMaterialOthers();
        $this->_requestShopMovePlaces();
        $this->_requestShopTransportCompanies();
        $this->_requestShopCarTares(null, [Model_Ab1_TareType::TARE_TYPE_OUR, Model_Ab1_TareType::TARE_TYPE_OTHER]);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/move/other/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Move_Place(), '_shop/move/other/one/new', $this->_sitePageData, $this->_driverDB
        );

        $this->_putInMain('/main/_shop/move/other/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopmoveother/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/other/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Move_Other();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        $this->_requestShopMaterials($model->getShopMaterialID(), null, true);
        $this->_requestShopMaterialOthers($model->getShopMaterialOtherID());
        $this->_requestShopMovePlaces($model->getShopMovePlaceID());
        $this->_requestShopTransportCompanies($model->getShopTransportCompanyID());
        $this->_requestShopCarTares($model->getShopCarTareID(), [Model_Ab1_TareType::TARE_TYPE_OUR, Model_Ab1_TareType::TARE_TYPE_OTHER]);

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Move_Other', $this->_sitePageData->shopID, "_shop/move/other/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        $this->_putInMain('/main/_shop/move/other/edit');
    }

    public function action_get_images()
    {
        $this->_sitePageData->url = '/weighted/shopmoveother/get_images';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/move/other/one/images',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Move_Other();
        if (!$this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Car not is found!');
        }

        // получаем данные
        $result = View_View::findOne('DB_Ab1_Shop_Move_Other', $this->_sitePageData->shopID, "_shop/move/other/one/images",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));

        $this->response->body($this->_sitePageData->replaceStaticDatas($result));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopmoveother/save';
        $result = Api_Ab1_Shop_Move_Other::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_send_tarra()
    {
        $this->_sitePageData->url = '/weighted/shopmoveother/send_tarra';

        // id записи
        if (Request_RequestParams::getParamFloat('is_save')) {
            $result = Api_Ab1_Shop_Move_Other::save($this->_sitePageData, $this->_driverDB);
            $shopCarID = $result['id'];
        } else {
            $shopCarID = Request_RequestParams::getParamInt('id');
        }

        $model = new Model_Ab1_Shop_Move_Other();
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

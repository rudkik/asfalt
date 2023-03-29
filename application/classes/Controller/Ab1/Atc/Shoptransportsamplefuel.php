<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopTransportSampleFuel extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport_Sample_Fuel';
        $this->controllerName = 'shoptransportsamplefuel';
        $this->tableID = Model_Ab1_Shop_Transport_Sample_Fuel::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport_Sample_Fuel::TABLE_NAME;
        $this->objectName = 'transportsamplefuel';

        parent::__construct($request, $response);

    }

    public function action_index() {
        $this->_sitePageData->url = '/atc/shoptransportsamplefuel/index';

        $this->_requestListDB('DB_Ab1_Shop_Transport_Mark');

        parent::_actionIndex(
            array(
                'shop_transport_mark_id' => array('name'),
                'shop_worker_responsible_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/atc/shoptransportsamplefuel/new';

        $this->_requestListDB('DB_Ab1_Shop_Transport_Mark');
        $this->_requestListDB('DB_Ab1_Fuel');
        $this->_requestListDB('DB_Ab1_Shop_Worker');

        parent::_actionNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/atc/shoptransportsamplefuel/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Sample_Fuel();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Worker', $model->getShopWorkerResponsibleID());
        $this->_requestListDB('DB_Ab1_Shop_Transport_Mark', $model->getShopTransportMarkID());
        $this->_requestListDB('DB_Ab1_Fuel');

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/atc/shoptransportsamplefuel/save';

        $shopID = $this->shopID;
        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        $result = DB_Basic::save($this->dbObject, $shopID, $this->_sitePageData, $this->_driverDB);

        // меняем остатки в багах машины + пробег, если задан
        $id = Request_RequestParams::getParamInt('id');
        if($id < 1){
            /** @var Model_Ab1_Shop_Transport_Sample_Fuel $model */
            $model = $result['model'];

            $modelTransport = new Model_Ab1_Shop_Transport_Mark();
            $modelTransport->setDBDriver($this->_driverDB);
            if(Helpers_DB::getDBObject($modelTransport, $model->getShopTransportMarkID(), $this->_sitePageData, $this->_sitePageData->shopMainID)){
                $modelTransport->setFuelQuantity($model->getQuantity());
                if($model->getMilage() > 0){
                    $modelTransport->setMilage($model->getMilage());
                }

                Helpers_DB::saveDBObject($modelTransport, $this->_sitePageData, $this->_sitePageData->shopMainID);

                $shopTransportIDs = Request_Request::find(
                    'DB_Ab1_Shop_Transport', $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                    Request_RequestParams::setParams(
                        array(
                            'shop_transport_mark_id' => $model->getShopTransportMarkID(),
                        )
                    ),
                    0, TRUE
                );

                $this->_driverDB->updateObjects(
                    Model_Ab1_Shop_Transport::TABLE_NAME, $shopTransportIDs->getChildArrayID(),
                    array(
                        'milage' => $modelTransport->getMilage(),
                        'fuel_quantity' => $modelTransport->getFuelQuantity(),
                    )
                );
            }
        }

        $this->_redirectSaveResult($result);
    }
}


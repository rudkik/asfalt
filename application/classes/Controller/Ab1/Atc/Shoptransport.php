<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_ShopTransport extends Controller_Ab1_Atc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transport';
        $this->controllerName = 'shoptransport';
        $this->tableID = Model_Ab1_Shop_Transport::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transport::TABLE_NAME;
        $this->objectName = 'transport';

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopMainID;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/atc/shoptransport/index';

        $this->_requestListDB('DB_Ab1_Shop_Transport_Mark');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Fuel_Storage');
        $this->_requestShopBranches(null, true);
        $this->_requestShopBranches(null, true);

        parent::_actionIndex(
            array(
                'shop_transport_mark_id' => array('name'),
                'shop_transport_driver_id' => array('name'),
                'shop_transport_fuel_storage_id' => array('name'),
                'shop_branch_storage_id' => array('name'),
            ),
            array(
                'sort_by' => array(
                    'shop_transport_mark_id.name' => 'asc',
                )
            )
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/atc/shoptransport/new';

        $this->_requestListDB('DB_Ab1_Shop_Transport_Mark');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Fuel_Storage');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Work');
        $this->_requestListDB('DB_Ab1_Fuel_Type');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Indicator');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Indicator_Formula');
        $this->_requestShopBranches($this->_sitePageData->shopID, true);

        // получаем список показателей расчета заполняемые в документе транспорта
        // параметр  Отображать показатель в документе расчета
        // получаем список сезонов
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array(
                    'name' => 'asc'
                )
            )
        );
        $seasons = Request_Request::findResultFields(
            array('id', 'name'), 'DB_Ab1_Season', 0, $this->_sitePageData, $this->_driverDB, $params
        );

        $data = new MyArray();
        $data->additionDatas['seasons'] = $seasons;

        $this->_sitePageData->newShopShablonPath($this->editAndNewBasicTemplate);
        Helpers_View::getViews(
            '_shop/transport/to/indicator/season/list/index', '_shop/transport/to/indicator/season/one/index',
            $this->_sitePageData, $this->_driverDB, $data
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_actionNew();
    }

    /**
     * Получаем список индикаторов топлива
     * @param $id
     * @return MyArray
     */
    private function _getIndicatorSeasons($id, $formula = '') {
        // получаем список сезонов
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array(
                    'name' => 'asc'
                )
            )
        );
        $seasonList = Request_Request::findResultFields(
            array('id', 'name'), 'DB_Ab1_Season', 0, $this->_sitePageData, $this->_driverDB, $params
        );
        $seasons = array();
        foreach ($seasonList as $season){
            $seasons[$season['id']] = $season;
        }

        // получаем список показателей расчета заполняемые в документе транспорта
        // параметр  Отображать показатель в документе расчета

        if(empty($formula)) {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_transport_id' => $id,
                    'group_by' => array(
                        'shop_transport_indicator_formula_id.formula',
                    ),
                )
            );
            $shopTransportToFuelIDs = Request_Request::find(
                'DB_Ab1_Shop_Transport_To_Fuel', $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                $params, 0, true,
                array(
                    'shop_transport_indicator_formula_id' => array('formula')
                )
            );

            $formula = '';
            foreach ($shopTransportToFuelIDs->childs as $child){
                $formula .= ' '. $child->getElementValue('shop_transport_indicator_formula_id', 'formula');
            }
        }

        if(!empty($formula)) {
            $params = Request_RequestParams::setParams(
                array(
                    'formula' => $formula,
                    'sort_by' => array(
                        'name' => 'asc'
                    )
                )
            );
            $data = Request_Request::find(
                'DB_Ab1_Shop_Transport_Indicator', $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                $params, 0, true
            );
        }else{
            $data = new MyArray();
        }
        $data->addAdditionDataChilds(array('seasons' => $seasons));

        // получаем список показателей расчета заполненные ранее
        if($id > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_transport_id' => $id,
                    'sort_by' => array(
                        'id' => 'asc'
                    )
                )
            );
            $shopTransportToIndicatorIDs = Request_Request::find(
                'DB_Ab1_Shop_Transport_To_Indicator_Season', $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
                $params, 0, true
            );

            foreach ($data->childs as $child){
                $indicator = $child->values['id'];
                foreach ($shopTransportToIndicatorIDs->childs as $shopTransportToIndicatorID){
                    if($shopTransportToIndicatorID->values['shop_transport_indicator_id'] != $indicator){
                        continue;
                    }

                    $season = $shopTransportToIndicatorID->values['season_id'];
                    if(!key_exists($season, $seasons)){
                        continue;
                    }

                    $child->additionDatas['seasons'][$season]['quantity'] = $shopTransportToIndicatorID->values['quantity'];
                }
            }
        }

        $data->additionDatas['seasons'] = $seasons;
        return $data;
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/atc/shoptransport/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, false)) {
            throw new HTTP_Exception_404('Object id="' . $id . '" "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_Ab1_Shop_Transport_Mark', $model->getShopTransportMarkID());
        $this->_requestListDB('DB_Ab1_Shop_Transport_Driver', $model->getShopTransportDriverID());
        $this->_requestListDB('DB_Ab1_Shop_Transport_Fuel_Storage', $model->getShopTransportFuelStorageID());
        $this->_requestListDB('DB_Ab1_Shop_Transport_Work');
        $this->_requestListDB('DB_Ab1_Fuel_Type');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Indicator');
        $this->_requestListDB('DB_Ab1_Shop_Transport_Indicator_Formula');
        $this->_requestShopBranches($model->getShopBranchStorageID(), true);

        // получаем список показателей расчета заполняемые в документе транспорта
        $data = $this->_getIndicatorSeasons($id);

        $this->_sitePageData->newShopShablonPath($this->editAndNewBasicTemplate);
        Helpers_View::getViews(
            '_shop/transport/to/indicator/season/list/index', '_shop/transport/to/indicator/season/one/index',
            $this->_sitePageData, $this->_driverDB, $data
        );
        $this->_sitePageData->previousShopShablonPath();


        $this->_actionEdit($model, $this->_sitePageData->shopMainID);
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/atc/shoptransport/save';

        $result = DB_Basic::save($this->dbObject, $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB);

        /** @var Model_Ab1_Shop_Transport $model */
        $model = $result['model'];

        // сохраняем название автотранспорта
        if($model->getShopTransportMarkID() != $model->getOriginalValue('shop_transport_mark_id')){
            $modelMark = new Model_Ab1_Shop_Transport_Mark();
            $modelMark->setDBDriver($this->_driverDB);
            Helpers_DB::getDBObject($modelMark, $model->getShopTransportMarkID(), $this->_sitePageData, $this->_sitePageData->shopMainID);

            $model->setName($modelMark->getName() . '(' . $model->getNumber() . ')');
            $model->setTransportWageID($modelMark->getTransportWageID());
            Helpers_DB::saveDBObject($model, $this->_sitePageData, $this->_sitePageData->shopMainID);
        }

        // сохраняем показатели расчета
        $shopTransportToIndicators = Request_RequestParams::getParamArray('shop_transport_to_indicator_seasons');
        if($shopTransportToIndicators !== null){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_transport_id' => $model->id
                )
            );
            /** @var MyArray $shopActReviseItemIDs */
            $shopTransportToIndicatorIDs = Request_Request::find(
                'DB_Ab1_Shop_Transport_To_Indicator_Season', $this->_sitePageData->shopMainID,
                $this->_sitePageData, $this->_driverDB, $params, 0, TRUE
            );

            $modelIndicator = new Model_Ab1_Shop_Transport_To_Indicator_Season();
            $modelIndicator->setDBDriver($this->_driverDB);

            foreach($shopTransportToIndicators as $indicator => $shopTransportToIndicator){
                foreach($shopTransportToIndicator as $season => $quantity) {
                    $quantity = Arr::path($quantity, 'quantity', '');
                    if($quantity == ''){
                        continue;
                    }

                    $shopTransportToIndicatorIDs->childShiftSetModel($modelIndicator);

                    $modelIndicator->setShopTransportID($model->id);
                    $modelIndicator->setShopTransportIndicatorID($indicator);
                    $modelIndicator->setSeasonID($season);
                    $modelIndicator->setQuantity($quantity);

                    Helpers_DB::saveDBObject($modelIndicator, $this->_sitePageData, $this->_sitePageData->shopMainID);
                }
            }

            // удаляем лишние
            $this->_driverDB->deleteObjectIDs(
                $shopTransportToIndicatorIDs->getChildArrayID(), $this->_sitePageData->userID,
                Model_Ab1_Shop_Transport_To_Indicator_Season::TABLE_NAME, array(), $this->_sitePageData->shopMainID
            );
        }

        $this->_redirectSaveResult($result);
    }

    public function action_indicators() {
        $this->_sitePageData->url = '/atc/shoptransport/indicators';

        // id записи
        $id = Request_RequestParams::getParamInt('shop_transport_id');

        // получаем список сезонов
        $params = Request_RequestParams::setParams(
            array(
                'sort_by' => array(
                    'name' => 'asc'
                )
            )
        );
        $seasonList = Request_Request::findResultFields(
            array('id', 'name'), 'DB_Ab1_Season', $this->_sitePageData->shopMainID,
            $this->_sitePageData, $this->_driverDB, $params
        );
        $seasons = array();
        foreach ($seasonList as $season){
            $seasons[$season['id']] = $season;
        }

        // получаем список показателей расчета заполняемые в документе транспорта
        // параметр  Отображать показатель в документе расчета
        $params = Request_RequestParams::setParams(
            array(
                'formula' => Request_RequestParams::getParamStr('formula'),
                'sort_by' => array(
                    'name' => 'asc'
                )
            )
        );
        $data = Request_Request::find(
            'DB_Ab1_Shop_Transport_Indicator', $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            $params, 0, true
        );
        $data->addAdditionDataChilds(array('seasons' => $seasons));

        // получаем список показателей расчета заполненные ранее
        if($id > 0) {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_transport_id' => $id,
                    'sort_by' => array(
                        'id' => 'asc'
                    )
                )
            );
            $shopTransportToIndicatorIDs = Request_Request::find(
                'DB_Ab1_Shop_Transport_To_Indicator_Season', $this->_sitePageData->shopMainID,
                $this->_sitePageData, $this->_driverDB, $params, 0, true
            );

            foreach ($data->childs as $child){
                $indicator = $child->values['id'];
                foreach ($shopTransportToIndicatorIDs->childs as $shopTransportToIndicatorID){
                    if($shopTransportToIndicatorID->values['shop_transport_indicator_id'] != $indicator){
                        continue;
                    }

                    $season = $shopTransportToIndicatorID->values['season_id'];
                    if(!key_exists($season, $seasons)){
                        continue;
                    }

                    $child->additionDatas['seasons'][$season]['quantity'] = $shopTransportToIndicatorID->values['quantity'];
                }
            }
        }

        $this->_sitePageData->newShopShablonPath($this->editAndNewBasicTemplate);
        $result = Helpers_View::getViews(
            '_shop/transport/to/indicator/season/list/index-not-table', '_shop/transport/to/indicator/season/one/index',
            $this->_sitePageData, $this->_driverDB, $data
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->response->body($result);
    }

    public function action_fuels(){
        $this->_sitePageData->url = '/atc/shoptransport/fuels';

        $shopTransportID = Request_RequestParams::getParamInt('id');
        if($shopTransportID < 1){
            throw new HTTP_Exception_404('Transport id="' . $shopTransportID . '" not is found!');
        }

        $result = array();

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_id' => $shopTransportID,
                'group_by' => array(
                    'fuel_id', 'fuel_id.name',
                    'fuel_issue_id',
                )
            )
        );

        $issueIDs = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Issue::NAME, 0, $this->_sitePageData, $this->_driverDB,
            $params, 0, true,
            array(
                'fuel_id' => array('name'),
            )
        );
        foreach ($issueIDs->childs as $child){
            $result[] = array(
                'fuel_name' => $child->getElementValue('fuel_id'),
                'fuel_id' => $child->values['fuel_id'],
                'fuel_issue_id' => $child->values['fuel_issue_id'],
            );
        }

        if(empty($result)){
            $shopTransportMarkID = Request_Request::findOneByIDResultField(
                DB_Ab1_Shop_Transport::NAME, $shopTransportID, 'shop_transport_mark_id', 0,
                $this->_sitePageData, $this->_driverDB
            );

            $params = Request_RequestParams::setParams(
                array(
                    'shop_transport_mark_id' => $shopTransportMarkID,
                    'group_by' => array(
                        'fuel_id', 'fuel_id.name',
                    )
                )
            );
            $issueIDs = Request_Request::find(
                DB_Ab1_Shop_Transport_Sample_Fuel_Item::NAME, 0, $this->_sitePageData, $this->_driverDB,
                $params, 0, true,
                array(
                    'fuel_id' => array('name'),
                )
            );
            foreach ($issueIDs->childs as $child){
                $result[] = array(
                    'fuel_name' => $child->getElementValue('fuel_id'),
                    'fuel_id' => $child->values['fuel_id'],
                    'fuel_issue_id' => 0,
                );
            }
        }

        $this->response->body(Json::json_encode($result));
    }

    public function action_get_milage_fuel(){
        $this->_sitePageData->url = '/atc/shoptransport/get_milage_fuel';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, false)) {
            throw new HTTP_Exception_404('Object id="' . $id . '" "' . $this->dbObject . '" not is found!');
        }
        $date = Request_RequestParams::getParamDateTime('date');

        $result = array(
            'fuel_quantity' => 0,
            'milage' => 0,
            'shop_transport_driver_id' => $model->getShopTransportDriverID(),
        );

        // остатки топлива
        $balanceFuels = Api_Ab1_Shop_Transport::getTransportMarkBalanceFuels(
            $model->getShopTransportMarkID(), $this->_sitePageData, $this->_driverDB,  false, $date
        );
        foreach ($balanceFuels as $balanceFuel){
            $result['fuel_quantity'] += $balanceFuel['quantity'];
        }

        // пробег
        $result['milage'] = Api_Ab1_Shop_Transport::getTransportMarkMilage(
            $model->getShopTransportMarkID(), $this->_sitePageData, $this->_driverDB,  $date
        );

        $this->response->body(Json::json_encode($result));
    }

    public function action_calc_coefficient(){
        $this->_sitePageData->url = '/atc/shoptransport/calc_coefficient';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transport_Driver_Tariff();
        if (! $this->getDBObject($model, $id, $this->_sitePageData->shopMainID)) {
            throw new HTTP_Exception_404('Tariff id="' . $id . '" "' . $this->dbObject . '" not is found!');
        }

        $waybills = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill::NAME, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams([
                    'from_at_from_equally' => $model->getDateFrom(),
                    'from_at_to' => Helpers_DateTime::getDateFormatPHP($model->getDateTo()) . ' 23:59:59',
                ]
            ),
            0, true
        );

        $modelWaybill = new Model_Ab1_Shop_Transport_Waybill();
        $modelWaybill->setDBDriver($this->_driverDB);

        foreach ($waybills->childs as $child){
            $child->setModel($modelWaybill);

            // марка прицепа
            $trailer = Api_Ab1_Shop_Transport_Waybill::getTrailerByWaybill(
                $modelWaybill->id, $this->_sitePageData, $this->_driverDB
            );
            $trailerShopTransportID = $trailer['transport'];

            if($trailerShopTransportID != $model->getShopTransportID()
                && $modelWaybill->getShopTransportID() != $model->getShopTransportID()){
                continue;
            }

            Api_Ab1_Shop_Transport_Waybill::refreshCars(
                $modelWaybill->id, $modelWaybill->getShopTransportID(), $trailerShopTransportID, $modelWaybill->getShopTransportDriverID(),
                $modelWaybill->getFromAt(), $modelWaybill->getToAt(), $this->_sitePageData, $this->_driverDB
            );

            // Считаем выработки водителя зависящие от перевозок
            Api_Ab1_Shop_Transport_Waybill::calcDriverWorks(
                $modelWaybill, $this->_sitePageData, $this->_driverDB
            );
        }

        self::redirect('/atc/shoptransportwaybill/index' .
            URL::query(
                [
                    'from_at_from_equally' => $model->getDateFrom(),
                    'from_at_to' => Helpers_DateTime::getDateFormatPHP($model->getDateTo()) . ' 23:59:59',
                ],
                false
            )
        );
    }

    public function action_director_index() {
        $this->_sitePageData->url = '/atc/shoptransport/director_index';

        $this->_requestListDB('DB_Ab1_Transport_View');
        $this->_requestListDB('DB_Ab1_Transport_Work');
        $this->_requestShopBranches($this->_sitePageData->shopID, true);

        // получаем список
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::find(
            'DB_Ab1_Shop_Transport', $this->_sitePageData->shopID,
            '_shop/transport/list/director-index', '_shop/transport/one/director-index',
            $this->_sitePageData, $this->_driverDB,
            array('limit_page' => 25, 'shop_branch_storage_id' => $this->_sitePageData->shopID),
            array(
                'shop_transport_mark_id' => array('name'),
                'shop_transport_driver_id' => array('name'),
                'shop_transport_fuel_storage_id' => array('name'),
                'shop_branch_storage_id' => array('name'),
                'shop_transport_mark_id.transport_work_id' => array('name'),
                'shop_transport_mark_id.transport_view_id' => array('name'),
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/transport/director-index', 'ab1/_all');
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/atc/shoptransport/statistics';

        $this->_actionShopTransportStatistics();
    }
}


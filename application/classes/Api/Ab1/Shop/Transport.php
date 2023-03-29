<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Transport {

    /**
     * Получаем пробег основного транспорта
     * @param $shopTransportMarkID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $date
     * @return int
     */
    public static function getTransportMarkMilage($shopTransportMarkID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                  $date = null)
    {
        $result = 0;
        $dateFrom = null;

        // получаем последний акт замера гсм
        $params = Request_RequestParams::setParams(
            array(
                'created_at_to' => $date,
                'shop_transport_mark_id' => $shopTransportMarkID,
                'sort_by' => array(
                    'created_at' => 'desc',
                )
            )
        );
        $sampleFuel = Request_Request::findOne(
            DB_Ab1_Shop_Transport_Sample_Fuel::NAME, 0, $sitePageData, $driver,
            $params
        );

        if($sampleFuel != null){
            $result = $sampleFuel->values['milage'];
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_id.shop_transport_mark_id' => $shopTransportMarkID,
                'sum_milage' => true,
                'to_at_from' => $dateFrom,
                'to_at_to' => $date
            )
        );

        // выдача топлива
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill::NAME, 0, $sitePageData, $driver, $params
        );
        foreach ($ids->childs as $child){
            $result += $child->values['milage'];
        }

        return $result;
    }

    /**
     * Получаем остатки топлива по основному транспорту
     * @param $shopTransportMarkID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isGroupFuelType
     * @param null $date
     * @return array
     */
    public static function getTransportMarkBalanceFuels($shopTransportMarkID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                        $isGroupFuelType = false, $date = null)
    {
        $result = array();
        $dateFrom = null;

        // получаем последний акт замера гсм
        $params = Request_RequestParams::setParams(
            array(
                'created_at_to' => $date,
                'shop_transport_mark_id' => $shopTransportMarkID,
                'sort_by' => array(
                    'created_at' => 'desc',
                )
            )
        );
        $sampleFuel = Request_Request::findOne(
            DB_Ab1_Shop_Transport_Sample_Fuel::NAME, 0, $sitePageData, $driver,
            $params
        );

        if($sampleFuel != null){
            $dateFrom = $sampleFuel->values['created_at'];

            $params = Request_RequestParams::setParams(
                array(
                    'shop_transport_sample_fuel_id' => $sampleFuel->id,
                )
            );

            // получаем первоначальные значения гсм акта замера
            $ids = Request_Request::find(
                DB_Ab1_Shop_Transport_Sample_Fuel_Item::NAME, 0, $sitePageData, $driver,
                $params, 0, true,
                array(
                    'fuel_id' => array('fuel_type_id'),
                )
            );
            foreach ($ids->childs as $child){
                $fuel = $child->values['fuel_id'];
                if($isGroupFuelType){
                    $fuel .= '_' . $child->getElementValue('fuel_id', 'fuel_type_id');
                }

                if(!key_exists($fuel, $result)){
                    $result[$fuel] = array(
                        'quantity' => 0,
                        'fuel_id' => $child->values['fuel_id'],
                        'fuel_type_id' => $child->getElementValue('fuel_id', 'fuel_type_id'),
                    );
                }

                $result[$fuel]['quantity'] += $child->values['quantity'];
            }
        }

        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_id.shop_transport_mark_id' => $shopTransportMarkID,
                'sum_quantity' => true,
                'shop_transport_waybill_id.to_at_from' => $dateFrom,
                'shop_transport_waybill_id.to_at_to' => $date,
                'group_by' => array(
                    'fuel_id', 'fuel_id.fuel_type_id',
                )
            )
        );

        // выдача топлива
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Issue::NAME, 0, $sitePageData, $driver,
            $params, 0, true,
            array(
                'fuel_id' => array('fuel_type_id'),
            )
        );
        foreach ($ids->childs as $child){
            $fuel = $child->values['fuel_id'];
            if($isGroupFuelType){
                $fuel .= '_' . $child->getElementValue('fuel_id', 'fuel_type_id');
            }

            if(!key_exists($fuel, $result)){
                $result[$fuel] = array(
                    'quantity' => 0,
                    'fuel_id' => $child->values['fuel_id'],
                    'fuel_type_id' => $child->getElementValue('fuel_id', 'fuel_type_id'),
                );
            }

            $result[$fuel]['quantity'] += $child->values['quantity'];
        }

        // расход топлива
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Fuel_Expense::NAME, 0, $sitePageData, $driver,
            $params, 0, true,
            array(
                'fuel_id' => array('fuel_type_id'),
            )
        );
        foreach ($ids->childs as $child){
            $fuel = $child->values['fuel_id'];
            if($isGroupFuelType){
                $fuel .= '_' . $child->getElementValue('fuel_id', 'fuel_type_id');
            }

            if(!key_exists($fuel, $result)){
                $result[$fuel] = array(
                    'quantity' => 0,
                    'fuel_id' => $child->values['fuel_id'],
                    'fuel_type_id' => $child->getElementValue('fuel_id', 'fuel_type_id'),
                );
            }

            $result[$fuel]['quantity'] -= $child->values['quantity'];
        }

        return $result;
    }

    /**
     * Получаем остатки топлива по транспорту
     * @param $shopTransportID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isGroupFuelType
     * @param null $date
     * @return array
     * @throws HTTP_Exception_404
     */
    public static function getTransportBalanceFuels($shopTransportID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                    $isGroupFuelType = false, $date = null)
    {
        $model = new Model_Ab1_Shop_Transport();
        $model->setDBDriver($driver);

        if (! Helpers_DB::getDBObject($model, $shopTransportID, $sitePageData, 0)) {
            throw new HTTP_Exception_404('Transport id="' . $shopTransportID . '" not is found!');
        }

        return self::getTransportMarkBalanceFuels(
            $model->getShopTransportMarkID(), $sitePageData, $driver, $isGroupFuelType, $date
        );
    }

    /**
     * Вычислаяем формулу показателя путевого листа
     * @param $shopTransportWaybillID
     * @param $formula
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int|mixed
     * @throws HTTP_Exception_404
     */
    public static function calcFormulaWaybillFuels($shopTransportWaybillID, $formula,
                                                   SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Transport_Waybill();
        $model->setDBDriver($driver);

        if (! Helpers_DB::getDBObject($model, $shopTransportWaybillID)) {
            throw new HTTP_Exception_404('Waybill id="' . $shopTransportWaybillID . '" not is found!');
        }

        return self::calcFormulaFuels(
            $model->getDate(), $shopTransportWaybillID, $model->getShopTransportID(), $formula, $sitePageData, $driver
        );
    }

    /**
     * Вычислаяем формулу показателя
     * @param $date
     * @param $shopTransportWaybillID
     * @param $shopTransportID
     * @param $formula
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int|mixed
     */
    public static function calcFormulaFuels($date, $shopTransportWaybillID, $shopTransportID, $formula,
                                            SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        // получаем список индикаторов выработки путевого листа
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_waybill_id' => $shopTransportWaybillID,
            )
        );
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_Waybill_Work_Car::NAME, 0, $sitePageData, $driver,
            $params, 0, true,
            array(
                'shop_transport_work_id' => array('name')
            )
        );

        foreach ($ids->childs as $child){
            $identifier = $child->getElementValue('shop_transport_work_id');
            if(empty($identifier)){
                break;
            }

            $formula = str_replace($identifier, $child->values['quantity'], $formula);
        }

        // получаем сезон
        $params = Request_RequestParams::setParams(
            array(
                'from_at_to' => $date,
                'to_at_from_equally' => $date,
            )
        );
        $season = Request_Request::findOne(
            DB_Ab1_Season_Time::NAME, 0, $sitePageData, $driver, $params, 0, true
        );
        if($season == null){
            $seasonID = 0;
        }else{
            $seasonID = $season->values['season_id'];
        }

        // получаем список индикаторов выработки транспорта
        $params = Request_RequestParams::setParams(
            array(
                'shop_transport_id' => $shopTransportID,
                'season_id' => $seasonID,
            )
        );
        $ids = Request_Request::find(
            DB_Ab1_Shop_Transport_To_Indicator_Season::NAME, 0, $sitePageData, $driver,
            $params, 0, true,
            array(
                'shop_transport_indicator_id' => array('identifier', 'name')
            )
        );

        foreach ($ids->childs as $child){
            $identifier = $child->getElementValue('shop_transport_indicator_id', 'identifier');
            if(!empty($identifier)){
                $formula = str_replace($identifier, $child->values['quantity'], $formula);
            }

            $identifier = $child->getElementValue('shop_transport_indicator_id');
            if(!empty($identifier)){
                $formula = str_replace($identifier, $child->values['quantity'], $formula);
            }
        }

        $formula = str_replace('Результат =', '', str_replace('Результат=', '', $formula));
        try{
            $result = eval("return $formula;");
        }catch (Exception $e){
            $result = 0;
        }

        return $result;
    }
}

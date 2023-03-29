<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Transport_Route {

    /**
     * Считаем зарплату по формуле
     * @param $formula
     * @param $tariff
     * @param Model_Ab1_Shop_Transport_Waybill_Car $model
     * @return int|float
     */
    public static function getWageByFormula($formula, $tariff, Model_Ab1_Shop_Transport_Waybill_Car $model)
    {
        $formula = Func::mb_str_replace(
            'Рейсы', $model->getCountTrip(), Func::mb_str_replace(
                'Расстояние', $model->getDistance(), Func::mb_str_replace(
                    'Масса', $model->getQuantity(), Func::mb_str_replace(
                        'Коэффициент', $model->getCoefficient(), Func::mb_str_replace(
                            'Расценка', $tariff, $formula
                        )
                    )
                )
            )
        );

        try{
            $result = eval("return $formula;");
        }catch (Exception $e){
            $result = 0;
        }

        return $result;
    }

    /**
     * Считаем зарплату по формуле марширута
     * @param Model_Ab1_Shop_Transport_Waybill_Car $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float|int
     * @throws HTTP_Exception_404
     */
    public static function getWageCar(Model_Ab1_Shop_Transport_Waybill_Car $model, SitePageData $sitePageData,
                                      Model_Driver_DBBasicDriver $driver)
    {
        if($model->getShopTransportRouteID() < 1){
            return 0;
        }

        $modelRoute = new Model_Ab1_Shop_Transport_Route();
        $modelRoute->setDBDriver($driver);
        if(!Helpers_DB::getDBObject($modelRoute, $model->getShopTransportRouteID(), $sitePageData, 0)){
            throw new HTTP_Exception_404('Route not found.');
        }

        return self::getWageByFormula(
            $modelRoute->getFormula(),
            $modelRoute->getAmount(),
            $model
        );
    }
}

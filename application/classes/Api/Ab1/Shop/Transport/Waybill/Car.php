<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Transport_Waybill_Car {
    /**
     * Сохранение путевого листа из визуальной формы
     * @param Model_Ab1_Shop_Transport_Waybill_Car $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_404
     */
    public static function saveModel(Model_Ab1_Shop_Transport_Waybill_Car $model, SitePageData $sitePageData,
                                     Model_Driver_DBBasicDriver $driver)
    {
        // пересчитываем общую сумму зарплаты
        Api_Ab1_Shop_Transport_Waybill::recalcWageTransportCar($model->getShopTransportWaybillID(), $sitePageData, $driver);
    }
}
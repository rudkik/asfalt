<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Transport_Waybill_Work_Driver {
    /**
     * Сохранение для 1С через JSON
     * @param Model_Ab1_Shop_Transport_Waybill_Work_Driver $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function get1CJSON(Model_Ab1_Shop_Transport_Waybill_Work_Driver $model, SitePageData $sitePageData,
                                     Model_Driver_DBBasicDriver $driver)
    {
        /** @var Model_Ab1_Shop_Transport_Waybill $modelWaybill */
        $modelWaybill = Request_Request::findOneModelByID(
            'DB_Ab1_Shop_Transport_Waybill', $model->getShopTransportWaybillID(), 0, $sitePageData, $driver
        );
        if ($modelWaybill == false) {
            return [];
        }

        $result = [];

        $result[] = [
            'date' => $modelWaybill->getDate(),
            'value' => $model->getQuantity(),
        ];

        return $result;
    }
}
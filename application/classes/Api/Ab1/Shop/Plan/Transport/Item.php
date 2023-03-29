<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Plan_Transport_Item  {

    /**
     * Сохранение список продуrции плана
     * @param $shopPlanTransportID
     * @param $date
     * @param array $shopPlanTransportItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function save($shopPlanTransportID, $date, array $shopPlanTransportItems,
                                SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Plan_Transport_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_plan_transport_id' => $shopPlanTransportID,
            )
        );
        $shopPlanTransportItemIDs = Request_Request::find('DB_Ab1_Shop_Plan_Transport_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        $countAll = 0;
        foreach($shopPlanTransportItems as $shopPlanTransportItem){
            $shopSpecialTransportID = intval(Arr::path($shopPlanTransportItem, 'shop_special_transport_id', 0));
            if($shopSpecialTransportID < 1){
                continue;
            }

            $count = intval(Arr::path($shopPlanTransportItem, 'count', 0));
            if($count <= 0){
                continue;
            }
            $workingShift = intval(Arr::path($shopPlanTransportItem, 'working_shift', 0));
            if($workingShift <= 0){
                continue;
            }

            $shopPlanTransportItemID = array_shift($shopPlanTransportItemIDs->childs);
            if($shopPlanTransportItemID !== NULL){
                $shopPlanTransportItemID->setModel($model);
            }else{
                $model->clear();
            }

            $model->setIsBSU(Arr::path($shopPlanTransportItem, 'is_bsu', FALSE));
            $model->setShopSpecialTransportID($shopSpecialTransportID);
            $model->setCount($count);
            $model->setDate($date);
            $model->setWorkingShift($workingShift);
            $model->setShopPlanTransportID($shopPlanTransportID);
            Helpers_DB::saveDBObject($model, $sitePageData);

            $countAll += $count;
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopPlanTransportItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Plan_Transport_Item::TABLE_NAME,
            array(), $sitePageData->shopID
        );

        return $countAll;
    }
}

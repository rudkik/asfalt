<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Act_Revise_Item  {

    /**
     * Сохранение список продукции доверенности
     * @param Model_Ab1_Shop_Act_Revise $modelActRevise
     * @param array $shopActReviseItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save(Model_Ab1_Shop_Act_Revise $modelActRevise, array $shopActReviseItems, SitePageData $sitePageData,
                                Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Act_Revise_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_act_revise_id' => $modelActRevise->id
            )
        );
        /** @var MyArray $shopActReviseItemIDs */
        $shopActReviseItemIDs = Request_Request::find('DB_Ab1_Shop_Act_Revise_Item',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );
        $shopActReviseItemIDs->runIndexFields(array('old_id', 'shop_client_id'));

        $total = 0;
        foreach($shopActReviseItems as $shopActReviseItem){
            $shopClientID = intval(Arr::path($shopActReviseItem, 'shop_client_id', 0));
            if($shopClientID < 1){
                continue;
            }

            $amount = floatval(Request_RequestParams::strToFloat(Arr::path($shopActReviseItem, 'amount', 0)));
            $isCache = Request_RequestParams::isBoolean(Arr::path($shopActReviseItem, 'is_cache', false));
            $isReceive = Request_RequestParams::isBoolean(Arr::path($shopActReviseItem, 'is_receive', false));

            $key = $modelActRevise->getOldID().'_'.$shopClientID;
            if(key_exists($key, $shopActReviseItemIDs->childs)){
                $shopActReviseItemID = $shopActReviseItemIDs->childs[$key];
                $shopActReviseItemID->setModel($model);

                unset($shopActReviseItemIDs->childs[$key]);
            }else{
                $model->clear();
            }

            $model->setShopClientID($shopClientID);
            $model->setAmount($amount);
            $model->setIsCache($isCache);
            $model->setIsReceive($isReceive);
            $model->setShopActReviseID($modelActRevise->id);
            $model->setActReviseTypeID($modelActRevise->getActReviseTypeID());
            $model->setOldID($modelActRevise->getOldID());
            $model->setDate($modelActRevise->getDate());

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

            $total += $model->getAmount();
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopActReviseItemIDs->getChildArrayID(), $sitePageData->userID,
            Model_Ab1_Shop_Act_Revise_Item::TABLE_NAME, array(), $sitePageData->shopMainID
        );

        return $total;
    }
}

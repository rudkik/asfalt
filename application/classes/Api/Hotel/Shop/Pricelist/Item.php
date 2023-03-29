<?php defined('SYSPATH') or die('No direct script access.');

class Api_Hotel_Shop_Pricelist_Item  {

    /**
     * Сохранение список цен комнат комнат
     * @param $shopPricelistID
     * @param $dateFrom
     * @param $dateTo
     * @param array $shopPricelistItems
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function save($shopPricelistID, $dateFrom, $dateTo, array $shopPricelistItems, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Pricelist_Item();
        $model->setDBDriver($driver);

        $params = Request_RequestParams::setParams(
            array(
                'shop_pricelist_id' => $shopPricelistID,
                'sort_by' => array('id' => 'asc'),
            )
        );
        $shopPricelistItemIDs = Request_Request::find('DB_Hotel_Shop_Pricelist_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        $modelRoom = new Model_Hotel_Shop_Room();
        $modelRoom->setDBDriver($driver);

        foreach($shopPricelistItems as $shopPricelistItem){
            $shopRoomID = intval(Arr::path($shopPricelistItem, 'shop_room_id', 0));
            if($shopRoomID < 1){
                continue;
            }

            $model->clear();
            $shopPricelistItemID = array_shift($shopPricelistItemIDs->childs);
            if($shopPricelistItemID !== NULL){
                $model->__setArray(array('values' => $shopPricelistItemID->values));
            }

            $model->setDateFrom($dateFrom);
            $model->setDateTo($dateTo);
            $model->setShopRoomID($shopRoomID);
            $model->setPrice(Arr::path($shopPricelistItem, 'price', 0));
            $model->setPriceExtra(Arr::path($shopPricelistItem, 'price_extra', 0));
            $model->setPriceChild(Arr::path($shopPricelistItem, 'price_child', 0));
            $model->setPriceFeast(Arr::path($shopPricelistItem, 'price_feast', 0));

            $model->setShopPricelistID($shopPricelistID);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        // удаляем лишние
        $driver->deleteObjectIDs($shopPricelistItemIDs->getChildArrayID(), $sitePageData->userID, Model_Hotel_Shop_Pricelist_Item::TABLE_NAME);

        return TRUE;
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Turn_Type  {

    /**
     * По ID продукции получаем тип очереди
     * @param $shopProductID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $shopTurnTypeID
     * @return Model_Ab1_Shop_Turn_Type|null
     */
    public static function getByModelShopProduct($shopProductID, SitePageData $sitePageData,
                                                 Model_Driver_DBBasicDriver $driver, $shopTurnTypeID = null)
    {
        // проверяем необходимо ли пропустить АСУ
        $shopProductTurnID = Request_Request::findOne(
            'DB_Ab1_Shop_Product_Turn', $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_product_id' => $shopProductID,
                    'shop_turn_type_id' => $shopTurnTypeID,
                    'group' => 1
                )
            )
        );

        if ($shopProductTurnID != null){
            $modelTurnType = new Model_Ab1_Shop_Turn_Type();
            $modelTurnType->setDBDriver($driver);
            if (Helpers_DB::getDBObject($modelTurnType, $shopProductTurnID->values['shop_turn_type_id'], $sitePageData, $sitePageData->shopID)){
                return $modelTurnType;
            }
        }

        return null;
    }

    /**
     * По ID места погрузки и продукции получаем тип очереди
     * @param $shopTurnPlaceID
     * @param $shopProductID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return Model_Ab1_Shop_Turn_Type|null
     */
    public static function getByModelShopTurnPlace($shopTurnPlaceID, $shopProductID, SitePageData $sitePageData,
                                                   Model_Driver_DBBasicDriver $driver)
    {
        $modelTurnPlace = new Model_Ab1_Shop_Turn_Place();
        $modelTurnPlace->setDBDriver($driver);
        if (Helpers_DB::getDBObject($modelTurnPlace, $shopTurnPlaceID, $sitePageData, $sitePageData->shopID)) {
            return self::getByModelShopProduct($shopProductID, $sitePageData, $driver, $modelTurnPlace->getShopTurnTypeID());
        }

        return null;
    }


    /**
     * Сохранение
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Ab1_Shop_Turn_Type();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Turn type not found.');
            }
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);

        Request_RequestParams::setParamBoolean('is_skip_weighted', $model);
        Request_RequestParams::setParamBoolean('is_skip_asu', $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $result = array();
        if ($model->validationFields($result)) {

            $turnTypeID = Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();

            $shopProductTurns = Request_RequestParams::getParamArray('shop_product_turns');
            if ($shopProductTurns !== NULL) {
                $products = Request_Request::find('DB_Ab1_Shop_Product_Turn',
                    $sitePageData->shopID, $sitePageData, $driver,
                    array(
                        'shop_turn_type_id' => $turnTypeID,
                        'is_delete_public_ignore' => TRUE,
                        Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE, 0, TRUE)
                );

                $modelProductTurn = new Model_Ab1_Shop_Product_Turn();
                $modelProductTurn->setDBDriver($driver);
                foreach($shopProductTurns as $id => $group){
                    $group = intval($group);
                    if($group < 1){
                        continue;
                    }

                    $id = intval($id);
                    if($id < 1){
                        continue;
                    }
                    $product = $products->findChildValue('shop_product_id', $id);

                    $modelProductTurn->clear();
                    if($product !== FALSE){
                        $modelProductTurn->__setArray(array('values' => $product->values));
                        $product->id = 0;
                    }else{
                        $modelProductTurn->setShopTurnTypeID($turnTypeID);
                        $modelProductTurn->setShopProductID($id);
                    }
                    $modelProductTurn->setGroup($group);
                    $modelProductTurn->setIsDelete(FALSE);

                    Helpers_DB::saveDBObject($modelProductTurn, $sitePageData);
                }

                $driver->deleteObjectIDs($products->getChildArrayID(TRUE), $sitePageData->userID,
                    Model_Ab1_Shop_Product_Turn::TABLE_NAME, array(), $sitePageData->shopID);
            }
        }else{
            $turnTypeID = 0;
        }

        return array(
            'id' => $turnTypeID,
            'result' => $result,
        );
    }
}

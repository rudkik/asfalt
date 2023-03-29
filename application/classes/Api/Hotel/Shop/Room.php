<?php defined('SYSPATH') or die('No direct script access.');

class Api_Hotel_Shop_Room  {
    const IS_DAY_OFF = FALSE; // в выходные день делать празничные цены

    /**
     * Стоимость номера на заданный день
     * @param array $detailedPriceDays - текущие настройки цены по комнате за все зафиксированные дни
     * @param $shopRoomID
     * @param $date
     * @param $isFeastDay
     * @param $adults
     * @param $childs
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isDetailed
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function getAmountRoomOfDay(array $detailedPriceDays, $shopRoomID, $date, $isFeastDay, $adults, $childs,
       SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isDetailed = FALSE)
    {
        if(key_exists($date, $detailedPriceDays)) {
            $prices = $detailedPriceDays[$date];
        }else {
            $prices = array(
                'price' => 0,
                'price_feast' => 0,
                'price_extra' => 0,
                'price_child' => 0,
            );
        }

        if(($prices['price'] == 0) || ($prices['price_feast'] == 0) || ($prices['price'] > $prices['price_feast'])){
            $params = Request_RequestParams::setParams(
                array(
                    'date' => $date,
                    'shop_room_id' => $shopRoomID,
                )
            );

            $shopPricelistItemIDs = Request_Request::find('DB_Hotel_Shop_Pricelist_Item',
                $sitePageData->shopID, $sitePageData, $driver,
                $params, 1, TRUE
            );

            if ((count($shopPricelistItemIDs->childs) == 0) && ($sitePageData->dataLanguageID != Model_Language::LANGUAGE_RUSSIAN)) {
                $tmp = $sitePageData->dataLanguageID;
                $sitePageData->dataLanguageID = Model_Language::LANGUAGE_RUSSIAN;
                $shopPricelistItemIDs = Request_Request::find('DB_Hotel_Shop_Pricelist_Item',
                    $sitePageData->shopID, $sitePageData, $driver,
                    $params, 1, TRUE
                );
                $sitePageData->dataLanguageID = $tmp;
            }
            if (count($shopPricelistItemIDs->childs) == 0) {
                throw new HTTP_Exception_500('Pricelist not found!');
            }
            $prices = $shopPricelistItemIDs->childs[0]->values;
        }

        $weekDay = strftime('%u', strtotime($date));
        if((self::IS_DAY_OFF && (($weekDay == 6) || ($weekDay == 7))) || $isFeastDay){
            $price = $prices['price_feast'];
        }else {
            $price = $prices['price'];
        }

        $price += ($prices['price_extra'] * $adults) + ($prices['price_child'] * $childs);

        if($isDetailed){
            return array(
                'price' => $price,
                'detailed' => array(
                    'price' => $prices['price'],
                    'price_feast' => $prices['price_feast'],
                    'price_extra' => $prices['price_extra'],
                    'price_child' => $prices['price_child'],
                ),
            );
        }else {
            return $price;
        }
    }

    /**
     * Стоимость номера на заданный период
     * @param $shopRoomID
     * @param $adults
     * @param $childs
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isDetailed
     * @return int|mixed
     */
    public static function getAmountRoom($shopRoomID, $adults, $childs, $dateFrom, $dateTo, SitePageData $sitePageData,
                                         Model_Driver_DBBasicDriver $driver, $isDetailed = FALSE)
    {
        $model = new Model_Hotel_Shop_Room();
        $model->setDBDriver($driver);
        if(! Helpers_DB::getDBObject($model, $shopRoomID, $sitePageData)){
            return 0;
        }

        $detailedPriceDays = array();
        return self::getAmountRoomOfValues($shopRoomID, $detailedPriceDays,
            $adults, $childs, $dateFrom, $dateTo, $sitePageData, $driver, $isDetailed);
    }

    /**
     * Стоимость номера на заданный период
     * @param $shopRoomID
     * @param array $detailedPriceDays - текущие настройки цены по комнате за все зафиксированные дни
     * @param $adults
     * @param $childs
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isDetailed
     * @return array|int|mixed
     */
    public static function getAmountRoomOfValues($shopRoomID, array $detailedPriceDays, $adults, $childs, $dateFrom, $dateTo, SitePageData $sitePageData,
                                         Model_Driver_DBBasicDriver $driver, $isDetailed = FALSE)
    {
        $tmp = $sitePageData->dataLanguageID;
        $sitePageData->dataLanguageID = Model_Language::LANGUAGE_RUSSIAN;
        $feastDayIDs = Request_Request::find('DB_Hotel_Shop_Feast_Day',
            $sitePageData->shopID, $sitePageData, $driver,
            array('period_from' => $dateFrom, 'period_to' => $dateTo, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE
        );
        $feastDays = array();
        foreach ($feastDayIDs->childs as $feastDayID){
            $feastDays[str_replace(' 00:00:00', '', $feastDayID->values['date'])] = 1;
        }

        $dateFrom = strtotime($dateFrom);
        $dateTo = strtotime($dateTo);

        $amount = 0;
        while ($dateFrom <= $dateTo){
            $date = date('Y-m-d', $dateFrom);

            $weekDay = strftime('%u', $dateFrom);
            $isFeastDay = (self::IS_DAY_OFF && (($weekDay == 6) || ($weekDay == 7))) || (key_exists($date, $feastDays));

            $data = self::getAmountRoomOfDay($detailedPriceDays, $shopRoomID, $date,
                $isFeastDay, $adults, $childs, $sitePageData, $driver, $isDetailed);

            if($isDetailed){
                $amount += $data['price'];
                $detailedPriceDays[$date] = $data['detailed'];
            }else{
                $amount += $data;
            }

            $dateFrom = $dateFrom + 60 * 60 * 24;
        }
        $sitePageData->dataLanguageID = $tmp;

        if($isDetailed){
            return array(
                'amount' => $amount,
                'detailed' => $detailedPriceDays,
            );
        }else {
            return $amount;
        }
    }

    /**
     * Показывает занятость номеров
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isOnlyFree
     * @param array $roomParams
     * @return MyArray
     */
    public static function getFreeRooms($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                       $isOnlyFree = FALSE, array $roomParams = array())
    {
        if (empty($roomParams)){
            $roomParams[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = TRUE;
        }
        // получаем список
        $data = Request_Request::find( 'DB_Hotel_Shop_Room',
            $sitePageData->shopID, $sitePageData, $driver, $roomParams, 0, TRUE
        );

        $isNotFree = array();
        if (count($data->childs) > 0) {
            // находим занятые номера
            $isNotFreeID = Request_Request::find('DB_Hotel_Shop_Bill_Item',
                $sitePageData->shopID, $sitePageData, $driver,
                array('shop_room_id' => array('value' => $data->getChildArrayID()), 'period_from' => $dateFrom, 'period_to' => $dateTo,
                    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
                0, TRUE);

            foreach ($isNotFreeID->childs as $child) {
                $isNotFree[$child->values['shop_room_id']] = TRUE;
            }
        }

        if ($isOnlyFree){
           $result = new MyArray();
            foreach ($data->childs as $child) {
                if (!key_exists($child->id, $isNotFree)){
                    $result->addChildObject($child);
                }
            }
            $data = $result;
        }else {
            // проставляем занятость номеров
            foreach ($data->childs as $child) {
                $child->additionDatas['is_free'] = !key_exists($child->id, $isNotFree);
            }
        }

        return $data;
    }


    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Room();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Room not found.');
            }

            $type = $model->getShopTableCatalogID();
        }else{
            $type = Request_RequestParams::getParamInt('type');
            $model->setShopTableCatalogID($type);
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamBoolean('is_close', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);
        Request_RequestParams::setParamInt("shop_building_id", $model);
        Request_RequestParams::setParamInt("shop_floor_id", $model);
        Request_RequestParams::setParamInt("shop_room_type_id", $model);
        Request_RequestParams::setParamInt("human", $model);
        Request_RequestParams::setParamInt("human_extra", $model);
        Request_RequestParams::setParamFloat("price", $model);
        Request_RequestParams::setParamFloat("price_child", $model);
        Request_RequestParams::setParamFloat("price_extra", $model);
        Request_RequestParams::setParamFloat("price_feast", $model);

        Request_RequestParams::setParamInt("two_bedroom", $model);
        Request_RequestParams::setParamInt("bedroom", $model);
        Request_RequestParams::setParamInt("sofa", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        // при создании нового здания
        if(Request_RequestParams::getParamBoolean('is_add_building')){
            $shopBuilding = Request_RequestParams::getParamArray('shop_building');
            if ($shopBuilding !== NULL){
                $shopBuilding = Api_Hotel_Shop_Building::saveOfArray($shopBuilding, $sitePageData, $driver);
                $model->setShopBuildingID($shopBuilding['id']);
            }
        }

        // при создании нового здания
        if(Request_RequestParams::getParamBoolean('is_add_floor')){
            $shopBuilding = Request_RequestParams::getParamArray('shop_building');
            if ($shopBuilding !== NULL){
                $shopBuilding = Api_Hotel_Shop_Building::saveOfArray($shopBuilding, $sitePageData, $driver);
                $model->setShopBuildingID($shopBuilding['id']);
            }
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            if($type > 0) {
                $modelType = new Model_Shop_Table_Catalog();
                $modelType->setDBDriver($driver);
                Helpers_DB::dublicateObjectLanguage($modelType, $type, $sitePageData);

                // сохраняем список хэштегов
                $hashtags = Request_RequestParams::getParamArray('shop_table_hashtags');
                if ($hashtags !== NULL) {
                    $model->setShopTableHashtagIDsArray(Api_Shop_Table_ObjectToObject::saveToHashtags(
                        Model_Hotel_Shop_Room::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                        $hashtags, $modelType->getChildShopTableCatalogID('hashtag', $sitePageData->dataLanguageID),
                        $sitePageData, $driver));
                }
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'type' => $type,
            'result' => $result,
        );
    }

    /**
     * Сохранение товары
     * @param array $data
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function saveOfArray(array $data, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Room();
        $model->setDBDriver($driver);

        $id = intval(Arr::path($data, 'id', 0));
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Room not found.');
            }

            $type = $model->getShopTableCatalogID();
        }else{
            $type = floatval(Arr::path($data, 'type', 0));
            $model->setShopTableCatalogID($type);
        }

        if (key_exists('shop_table_rubric_id', $data)) {
            $model->setShopTableRubricID($data['shop_table_rubric_id']);
        }
        if (key_exists('is_public', $data)) {
            $model->setIsPublic($data['is_public']);
        }
        if (key_exists('text', $data)) {
            $model->setText($data['text']);
        }
        if (key_exists('name', $data)) {
            $model->setName($data['name']);
        }
        if (key_exists('old_id', $data)) {
            $model->setOldID($data['old_id']);
        }
        if (key_exists('shop_table_select_id', $data)) {
            $model->setShopTableSelectID($data['shop_table_select_id']);
        }
        if (key_exists('shop_table_unit_id', $data)) {
            $model->setShopTableUnitID($data['shop_table_unit_id']);
        }
        if (key_exists('shop_table_brand_id', $data)) {
            $model->setShopTableBrandID($data['shop_table_brand_id']);
        }

        if (key_exists('options', $data)) {
            $options = $data['options'];
            if (is_array($options)) {
                $model->addOptionsArray($options);
            }
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'type' => $type,
            'result' => $result,
        );
    }

    /**
     * Сохраняем список комнат в XML
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveXML(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список оплат
        $shopRoomIDs = Request_Request::find(
            'DB_Hotel_Shop_Room', $sitePageData->shopID, $sitePageData, $driver,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_room_type_id' => array('old_id'))
        );

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($shopRoomIDs->childs as $shopRoomID){
            $data .= '<room>'
                .'<id>'.$shopRoomID->values['id'].'</id>'
                .'<id_1c>'.$shopRoomID->values['old_id'].'</id_1c>'
                .'<name>'.htmlspecialchars($shopRoomID->values['name'], ENT_XML1).'</name>'
                .'<room_type_id>'.$shopRoomID->values['shop_room_type_id'].'</room_type_id>'
                .'<room_type_id_1c>'.Arr::path($shopRoomID->values['options'], 'shop_room_type_id.old_id', '').'</room_type_id_1c>';
            $data .= '</room>';
        }
        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="rooms.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }
}

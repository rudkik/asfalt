<?php defined('SYSPATH') or die('No direct script access.');

class Api_Hotel_Shop_Room_Type  {

    /**
     * Стоимость номера на заданный период
     * @param $shopRoomTypeID
     * @param $adults
     * @param $childs
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return MyArray
     */
    public static function getAmountRoomType($shopRoomTypeID, $adults, $childs, $dateFrom, $dateTo, SitePageData $sitePageData,
                                         Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_room_type_id' => $shopRoomTypeID,
                'period_to' => Helpers_DateTime::plusDays($dateTo, 1),
            )
        );
        $ids = Request_Request::find( 'DB_Hotel_Shop_Room',
            $sitePageData->shopID, $sitePageData, $driver,
            $params, 1, TRUE
        );

        if(count($ids->childs) == 0){
            return 0;
        }

        return Api_Hotel_Shop_Room::getAmountRoom(
            $ids->childs[0]->id, $adults, $childs, $dateFrom, $dateTo, $sitePageData, $driver
        );
    }

    /**
     * Стоимость номера на заданный период
     * @param array $shopRoomTypeValues
     * @param $adults
     * @param $childs
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return int|mixed
     */
    public static function getAmountRoomTypeOfValues(array &$shopRoomTypeValues, $adults, $childs, $dateFrom, $dateTo, SitePageData $sitePageData,
                                                 Model_Driver_DBBasicDriver $driver)
    {
        $feastDayIDs = Request_Request::find('DB_Hotel_Shop_Feast_Day', $sitePageData->shopID, $sitePageData, $driver,
            array('period_from' => $dateFrom, 'period_to' => Helpers_DateTime::plusDays($dateTo, 1), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            0, TRUE);
        $feastDays = array();
        foreach ($feastDayIDs->childs as $feastDayID){
            $feastDays[str_replace(' 00:00:00', '', $feastDayID->values['date'])] = 1;
        }

        $dateFrom = strtotime($dateFrom);
        $dateTo = strtotime($dateTo);

        $amount = 0;
        while ($dateFrom <= $dateTo){
            $weekDay = strftime('%u', $dateFrom);
            if((Api_Hotel_Shop_Room::IS_DAY_OFF && (($weekDay == 6) || ($weekDay == 7)))  || (key_exists(date('Y-m-d', $dateFrom), $feastDays))){
                $price = $shopRoomTypeValues['price_feast'];
            }else {
                $price = $shopRoomTypeValues['price'];
            }

            $amount += $price + ($shopRoomTypeValues['price_extra'] * $adults) + ($shopRoomTypeValues['price_child'] * $childs);

            $dateFrom = $dateFrom + 60 * 60 * 24;
        }
        return $amount;
    }

    /**
     * Создаем рекурсивно дерево вариантов номеров
     * @param $adults
     * @param $childs
     * @param array $result
     * @param MyArray $freeRoomTypeIDs
     */
    private static function setTreeFreeRoom($adults, $childs, array &$result, MyArray $freeRoomTypeIDs, $level = 1){
        foreach ($result['childs'] as &$child) {
            if($child['count'] >= $adults + $childs){
                continue;
            }

            $index = $child['index'];
            if($child['index_count'] < $freeRoomTypeIDs->childs[$index]->additionDatas['count']){
                $freeRoomTypeID = $freeRoomTypeIDs->childs[$index];

                $child['childs'][] = array(
                    'index' => $index,
                    'index_count' => $child['index_count'] + 1,
                    'human' => $freeRoomTypeID->values['all'],
                    'count' => $freeRoomTypeID->values['all'] + $child['count'],
                    'childs' => array(),
                    'rooms' => array_merge($child['rooms'], array($freeRoomTypeID->id)),
                );
            }
            $index++;

            for ($i = $index; $i < count($freeRoomTypeIDs->childs); $i++){
                $freeRoomTypeID = $freeRoomTypeIDs->childs[$i];

                $child['childs'][] = array(
                    'index' => $i,
                    'index_count' => 1,
                    'human' => $freeRoomTypeID->values['all'],
                    'count' => $freeRoomTypeID->values['all'] + $child['count'],
                    'childs' => array(),
                    'rooms' => array_merge($child['rooms'], array($freeRoomTypeID->id)),
                );
            }
            if ($level < 100) {
                self::setTreeFreeRoom($adults, $childs, $child, $freeRoomTypeIDs, $level + 1);
            }
        }
    }

    /**
     * Находим те верки, которые подходят нам по количеству мест
     * @param $adults
     * @param $childs
     * @param array $result
     * @param MyArray $freeRoomTypeIDs
     * @param array $list
     */
    private static function getListFreeRoom($adults, $childs, array $result, MyArray $freeRoomTypeIDs, array &$list){
        foreach ($result['childs'] as $child) {
            if ($child['count'] >= $adults + $childs) {
                // считаем количество человек и стоимость номеров, без дополнительных мест
                $human = 0;
                $amount = 0;
                foreach ($child['rooms'] as $room){
                    $freeRoomTypeID = $freeRoomTypeIDs->childs[$room];

                    $human += $freeRoomTypeID->values['human'];
                    $amount += $freeRoomTypeID->values['price'];
                }

                $list[] = array(
                    'amount' => $amount,
                    'human' => $human,
                    'rooms' => $child['rooms'],
                );
            } else {
                self::getListFreeRoom($adults, $childs, $child, $freeRoomTypeIDs, $list);
            }
        }
    }

    /**
     * Подходящих номеров свободных номеров
     * @param $adults
     * @param $childs
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     */
    public static function selectionFreeRoomTypes($adults, $childs, $dateFrom, $dateTo, SitePageData $sitePageData,
                                              Model_Driver_DBBasicDriver $driver)
    {
        $freeRoomIDs = Api_Hotel_Shop_Room::getFreeRooms($dateFrom, $dateTo, $sitePageData, $driver, TRUE);
        if (count($freeRoomIDs->childs) == 0){
            return array();
        }

        $model = new Model_Hotel_Shop_Room_Type();
        $model->setDBDriver($driver);

        // объединяем свободные номера в группы по типу комнат
        $freeRoomTypeIDs = new MyArray();
        foreach ($freeRoomIDs->childs as $key => $freeRoomID){
            $shopRoomTypeID = $freeRoomID->values['shop_room_type_id'];
            if (key_exists($shopRoomTypeID, $freeRoomTypeIDs->childs)){
                $freeRoomTypeIDs->childs[$shopRoomTypeID]->additionDatas['count']++;
                continue;
            }

            if (!Helpers_DB::getDBObject($model, $shopRoomTypeID, $sitePageData)){
                continue;
            }

            $freeRoomTypeID = $freeRoomTypeIDs->addUniqueChild($shopRoomTypeID, TRUE);
            $freeRoomTypeID->values = $model->getValues(TRUE, TRUE, $sitePageData->shopMainID);
            $freeRoomTypeID->additionDatas['count'] = 1;
            $freeRoomTypeID->isFindDB = TRUE;

            if (($freeRoomTypeID->values['human'] > 0)) {
                $freeRoomTypeID->values['all'] = $freeRoomTypeID->values['human'] + $freeRoomTypeID->values['human_extra'];
            }else{
                unset($freeRoomTypeID->childs[$key]);
            }
        }
        // сортируем комнаты по количеству мест от большего к меньшему
        $freeRoomTypeIDs->childsSortBy(array('all' => 'desc', 'price_extra' => 'asc', 'price_child' => 'asc'), TRUE, TRUE);
        $freeRoomTypeIDs->runIndex(FALSE);

        // создаем дерево результатов первого уровня
        $result = array(
            'count' => 0,
            'childs' => array(),
        );
        foreach ($freeRoomTypeIDs->childs as $index => $freeRoomTypeID){
            $result['childs'][] = array(
                'index' => $index,
                'index_count' => 1,
                'human' => $freeRoomTypeID->values['all'],
                'count' => $freeRoomTypeID->values['all'],
                'childs' => array(),
                'rooms' => array($freeRoomTypeID->id),
            );
        }
        // создаем дерево результатов от 2 уровня до n уровня
        self::setTreeFreeRoom($adults, $childs, $result, $freeRoomTypeIDs);

        // находим варианты, которые нам подходят по количеству мест
        $list = array();
        $freeRoomTypeIDs->runIndex();
        self::getListFreeRoom($adults, $childs, $result, $freeRoomTypeIDs, $list);

        // считаем итоговую стоимость номеров
        foreach ($list as $key => &$rooms){
            // если не нужно считать дополнительные места
            if($rooms['human'] >= $adults + $childs){
                $arr = array();
                foreach ($rooms['rooms'] as $room) {
                    $arr[] = array(
                        'id' => $room,
                        'human_extra' => 0,
                        'child_extra' => 0,
                    );
                }
                $rooms['rooms'] = $arr;
                continue;
            }

            $shiftAdults = $adults - $rooms['human'];
            $shiftChilds = $childs;
            if($shiftAdults < 0){
                $shiftChilds += $shiftAdults;
                $shiftAdults = 0;
            }

            $amount = 0;
            $arr = array();
            foreach ($rooms['rooms'] as $room){
                $freeRoomTypeID = $freeRoomTypeIDs->childs[$room];
                $valArr = array('id' => $room);

                $extra = $freeRoomTypeID->values['human_extra'];
                if($shiftAdults > 0){
                    $tmp = $extra;
                    if($tmp > $shiftAdults){
                        $tmp = $shiftAdults;
                    }
                    $amount += $freeRoomTypeID->values['price_extra'] * $tmp;
                    $extra = $extra - $tmp;

                    $shiftAdults -= $tmp;
                    $valArr['human_extra'] = $tmp;
                }else{
                    $valArr['human_extra'] = 0;
                }

                if($shiftChilds > 0){
                    $tmp = $extra;
                    if($tmp > $shiftChilds){
                        $tmp = $shiftChilds;
                    }
                    $amount += $freeRoomTypeID->values['price_child'] * $tmp;

                    $shiftChilds -= $tmp;
                    $valArr['child_extra'] = $tmp;
                }else{
                    $valArr['child_extra'] = 0;
                }
                $arr[] = $valArr;
            }
            $rooms['rooms'] = $arr;
            $rooms['amount'] += $amount;
        }

        /** Минимальная стоимость номера **/
        $minAmount = array(
            'amount' => 0,
            'rooms' => array(),
        );
        $isFirst = TRUE;
        foreach ($list as $rooms1){
            if (($isFirst) || ($minAmount['amount'] > $rooms1['amount'])){
                $minAmount = array(
                    'amount' => $rooms1['amount'],
                    'rooms' => $rooms1['rooms'],
                );

                $isFirst = FALSE;
            }
        }
        // удаляем вариант из выбора
        $strRooms = '';
        foreach ($minAmount['rooms'] as $room){
            $strRooms .= $room['id'].',';
        }
        foreach ($list as $key => $rooms){
            $s = '';
            foreach ($rooms['rooms']  as $room){
                $s .= $room['id'].',';
            }

            if($s == $strRooms) {
                unset($list[$key]);
            }
        }

        /** Минимальное кол-во номеров **/
        $minRoom = array(
            'amount' => 0,
            'room' => 0,
            'rooms' => array(),
        );
        $isFirst = TRUE;
        foreach ($list as $rooms1){
            if (($isFirst) || ($minRoom['room'] > count($rooms1['rooms']))){
                $minRoom = array(
                    'amount' => $rooms1['amount'],
                    'room' => count($rooms1['rooms']),
                    'rooms' => $rooms1['rooms'],
                );

                $isFirst = FALSE;
            }elseif(($minRoom['room'] == count($rooms1['rooms'])) && ($minRoom['amount'] > $rooms1['amount'])){
                $minRoom = array(
                    'amount' => $rooms1['amount'],
                    'room' => count($rooms1['rooms']),
                    'rooms' => $rooms1['rooms'],
                );
            }
        }

        $result = array(
            'min_amount' => $minAmount,
            'min_room' => $minRoom,
        );

        // считаем стоимость
        foreach ($result as &$minRoom) {
            $amount = 0;
            foreach ($minRoom['rooms'] as &$room) {
                $freeRoomTypeID = new MyArray();
                $freeRoomTypeID->cloneObj($freeRoomTypeIDs->childs[$room['id']]);

                $freeRoomTypeID->additionDatas['human_extra'] = $room['human_extra'];
                $freeRoomTypeID->additionDatas['child_extra'] = $room['child_extra'];

                $params = Request_RequestParams::setParams(
                    array(
                        'shop_room_type_id' => $freeRoomTypeID->id,
                    )
                );
                $shopRoomID = Request_Request::find(
                    'DB_Hotel_Shop_Room', $sitePageData->shopID, $sitePageData, $driver, $params, 1
                );

                $freeRoomTypeID->additionDatas['amount'] = Api_Hotel_Shop_Room::getAmountRoomOfValues($shopRoomID->childs[0]->id, array(),
                    $room['human_extra'], $room['child_extra'], $dateFrom, $dateTo, $sitePageData, $driver);
                $room = $freeRoomTypeID;

                $amount += $freeRoomTypeID->additionDatas['amount'];
            }
            $minRoom['amount'] = $amount;
        }

        return $result;
    }

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Hotel_Shop_Room_Type();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('RoomType not found.');
            }

            $type = $model->getShopTableCatalogID();
        }else{
            $type = Request_RequestParams::getParamInt('type');
            $model->setShopTableCatalogID($type);
        }

        Request_RequestParams::setParamInt("shop_table_rubric_id", $model);
        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamBoolean("is_public", $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_table_select_id", $model);
        Request_RequestParams::setParamInt("shop_table_unit_id", $model);
        Request_RequestParams::setParamInt("shop_table_brand_id", $model);
        Request_RequestParams::setParamInt("human", $model);
        Request_RequestParams::setParamInt("human_extra", $model);
        Request_RequestParams::setParamFloat("price", $model);
        Request_RequestParams::setParamFloat("price_extra", $model);
        Request_RequestParams::setParamFloat("price_child", $model);
        Request_RequestParams::setParamFloat("price_feast", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
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
                        Model_Hotel_Shop_Room_Type::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
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
        $model = new Model_Hotel_Shop_Room_Type();
        $model->setDBDriver($driver);

        $id = intval(Arr::path($data, 'id', 0));
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('RoomType not found.');
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
        $shopRoomTypeIDs = Request_Request::find('DB_Hotel_Shop_Room_Type', $sitePageData->shopID, $sitePageData, $driver,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE);

        $data = '<?xml version="1.0" encoding="UTF-8"?><Data1C>';
        foreach($shopRoomTypeIDs->childs as $shopRoomTypeID){
            $data .= '<room_type>'
                .'<id>'.$shopRoomTypeID->values['id'].'</id>'
                .'<id_1c>'.$shopRoomTypeID->values['old_id'].'</id_1c>'
                .'<price>'.$shopRoomTypeID->values['price'].'</price>'
                .'<human>'.$shopRoomTypeID->values['human'].'</human>'
                .'<name>'.htmlspecialchars($shopRoomTypeID->values['name'], ENT_XML1).'</name>';
            $data .= '</room_type>';
        }
        $data .= '</Data1C>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="room_types.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }
}

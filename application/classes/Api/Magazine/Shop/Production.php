<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Production  {

    /**
     * Считаем остатки продукции на заданную дату
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | null $shopProductionID
     * @return array
     */
    public static function stockDate($date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                     $shopProductionID = null)
    {
        return self::stockPeriod(NULL, $date, $sitePageData, $driver, $shopProductionID);
    }

    /**
     * Остатки на заданный период
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array | null $findShopProductionIDs
     * @return array
     */
    public static function stockPeriod($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                       $findShopProductionIDs = null)
    {
        $shopProductionIDs = array();

        /** Считаем приход продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_production_id' => $findShopProductionIDs,
                'shop_production_id.shop_product_id' => 0,
                'group_by' => array(
                    'shop_production_id'
                ),
            )
        );

        // расход
        $ids = Request_Request::find(
            'DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        foreach ($ids->childs as $child){
            $shopProductionIDs[$child->values['shop_production_id']] = -$child->values['quantity'];
        }

        /** Считаем возврат реализации продуктов **/
        // приход
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        foreach ($ids->childs as $child) {
            $shopProductionID = $child->values['shop_production_id'];
            if (!key_exists($shopProductionID, $shopProductionIDs)) {
                $shopProductionIDs[$shopProductionID] = 0;
            }

            $shopProductionIDs[$shopProductionID] += $child->values['quantity'];
        }

        /** Считаем перемещение продукции **/
        $ids = Request_Request::find(
            'DB_Magazine_Shop_Move_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        foreach ($ids->childs as $child) {
            $shopProductionID = $child->values['shop_production_id'];
            if (!key_exists($shopProductionID, $shopProductionIDs)) {
                $shopProductionIDs[$shopProductionID] = 0;
            }

            $shopProductionIDs[$shopProductionID] -= $child->values['quantity'];
        }

        /** Считаем перемещение продукции **/
        $params['branch_move_id'] = $sitePageData->shopID;

        // приход
        $ids = Request_Request::findBranch(
            'DB_Magazine_Shop_Move_Item', array(), $sitePageData, $driver, $params
        );

        foreach ($ids->childs as $child) {
            $shopProductionID = $child->values['shop_production_id'];
            if (!key_exists($shopProductionID, $shopProductionIDs)) {
                $shopProductionIDs[$shopProductionID] = 0;
            }

            $shopProductionIDs[$shopProductionID] += $child->values['quantity'];
        }

        return $shopProductionIDs;
    }

    /**
     * Считаем оставки всей продукции
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcStockAll(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $params = Request_RequestParams::setParams(
            array(
                'shop_product_id' => 0,
            )
        );
        $ids = Request_Request::find(
            'DB_Magazine_Shop_Production', $sitePageData->shopMainID, $sitePageData, $driver, $params
        );

        foreach ($ids->childs as $child){
            self::calcComing($child->id, $sitePageData, $driver);
            self::calcExpense($child->id, $sitePageData, $driver);
        }
    }

    /**
     * Считаем расход продукции
     * @param $shopProductionID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveQuantity
     * @return bool|int
     * @throws HTTP_Exception_500
     */
    public static function calcExpense($shopProductionID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                       $isSaveQuantity = TRUE)
    {
        if($shopProductionID < 1){
            return FALSE;
        }

        $quantity = 0;

        /** Считаем реализации продукции **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'shop_production_id' => $shopProductionID,
                'shop_product_id' => 0,
            )
        );
        // расход
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        if(count($ids->childs) > 0){
            $ids = $ids->childs[0];
            $quantity += $ids->values['quantity'];
        }

        /** Считаем перемещение продукции **/
        $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        if(count($ids->childs) > 0){
            $ids = $ids->childs[0];
            $quantity += $ids->values['quantity'];
        }

        if($isSaveQuantity) {
            $model = Request_Request::findOneModel('DB_Magazine_Shop_Production_Stock',
                $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_production_id' => $shopProductionID,
                    )
                )
            );

            if($model === FALSE) {
                $model = new Model_Magazine_Shop_Production_Stock();
                $model->setDBDriver($driver);
                $model->setShopProductionID($shopProductionID);
            }

            $model->setQuantityExpense($quantity);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        return $quantity;
    }

    /**
     * Считаем приход продукции
     * @param $shopProductionID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveQuantity
     * @return bool|int
     * @throws HTTP_Exception_500
     */
    public static function calcComing($shopProductionID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                      $isSaveQuantity = TRUE)
    {
        if($shopProductionID < 1){
            return FALSE;
        }

        $quantity = 0;

        /** Считаем перемещение продукции **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'shop_production_id' => $shopProductionID,
                'branch_move_id' => $sitePageData->shopID,
            )
        );
        // приход
        $ids = Request_Request::findBranch(
            'DB_Magazine_Shop_Move_Item', array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $quantity += $ids->childs[0]->values['quantity'];
        }

        /** Считаем возврат реализации продукции **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'shop_production_id' => $shopProductionID,
                'shop_product_id' => 0,
            )
        );
        // приход
        $ids = Request_Request::find(
            'DB_Magazine_Shop_Realization_Return_Item', $sitePageData->shopID, $sitePageData, $driver, $params,
            0, TRUE
        );
        if(count($ids->childs) > 0){
            $ids = $ids->childs[0];
            $quantity += $ids->values['quantity'];
        }

        if($isSaveQuantity) {
            $model = Request_Request::findOneModel('DB_Magazine_Shop_Production_Stock',
                $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_production_id' => $shopProductionID,
                    )
                )
            );

            if($model === FALSE) {
                $model = new Model_Magazine_Shop_Production_Stock();
                $model->setDBDriver($driver);
                $model->setShopProductionID($shopProductionID);
            }

            $model->setQuantityComing($quantity);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        return $quantity;
    }

    /**
     * Наценка на продукцию
     * @param SitePageData $sitePageData
     * @return mixed
     */
    private static function getProductionMarkup(SitePageData $sitePageData){
        return Arr::path($sitePageData->shopMain->getOptionsArray(), 'production_markup', 5);
    }

    /**
     * Округление цены
     * @param $price
     * @return float|int
     */
    private static function roundPrice($price){
        return round($price, 0);
    }

    /**
     * Считаем цену с надбавкой
     * @param $price
     * @param float $markup
     * @param bool $isMarkupPercent
     * @param int $coefficient
     * @return float|int
     */
    private static function calcPriceMarkup($price, $markup = 5, $isMarkupPercent = true, $coefficient = 1){
        if($coefficient <= 0){
            $coefficient = 0;
        }

        if($isMarkupPercent){
            $price = $price / 100 * (100 + $markup);
        }else{
            $price += $markup;
        }

        return self::roundPrice($price / $coefficient);
    }

    /**
     * Создаем / изменяем продукцию напрямую связанные с продуктом
     * @param Model_Magazine_Shop_Product $modelProduct
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function editProduction(Model_Magazine_Shop_Product $modelProduct, SitePageData $sitePageData,
                                          Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Magazine_Shop_Production();
        $model->setDBDriver($driver);

        $isAdd = $modelProduct->id < 1;
        if(!$isAdd){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_product_id' => $modelProduct->id,
                )
            );
            $shopProductionIDs = Request_Request::find('DB_Magazine_Shop_Production',
                $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
            );
            $isAdd = count($shopProductionIDs->childs) == 0;

            // изменяем значение если у продукции один продукт
            foreach ($shopProductionIDs->childs as $child){
                $child->setModel($model);
                if(Func::_empty($model->getBarcode())) {
                    $model->setBarcode($modelProduct->getBarcode());
                }

                if($child->values['name'] == $modelProduct->getOriginalValue('name')){
                    $model->setName($modelProduct->getName());
                }

                if($child->values['name_1c'] == $modelProduct->getOriginalValue('name_1c')){
                    $model->setName1C($modelProduct->getName1C());
                    if($model->getUnitID() < 1) {
                        $model->setUnitID($modelProduct->getUnitID());
                    }
                    $model->setOldID($modelProduct->getOldID());
                }

                if($child->values['name_esf'] == $modelProduct->getOriginalValue('name_esf')){
                    $model->setNameESF($modelProduct->getNameESF());
                }

                if($child->values['is_price_cost']){
                    $model->setPrice($modelProduct->getPriceCost());
                }else {
                    $model->setPrice(
                        self::calcPriceMarkup(
                            $modelProduct->getPriceCost(), $modelProduct->getMarkup(), $modelProduct->getIsMarkupPercent(), $model->getCoefficient()
                        )
                    );
                }
                $model->setPriceCost($modelProduct->getPriceCost());

                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            }
        }

        // если новый добавляем продукцию с параметрами продукта
        if($isAdd){
            $model->setName($modelProduct->getName());
            $model->setName1C($modelProduct->getName1C());
            $model->setBarcode($modelProduct->getBarcode());
            $model->setUnitID($modelProduct->getUnitID());
            $model->setPrice(
                self::calcPriceMarkup(
                    $modelProduct->getPriceCost(), $modelProduct->getMarkup(), $modelProduct->getIsMarkupPercent()
                )
            );
            $model->setCoefficient(1);
            $model->setShopProductID($modelProduct->id);
            $model->setOldID($modelProduct->getOldID());
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

            $modelItem = new Model_Magazine_Shop_Production_Item();
            $modelItem->setDBDriver($driver);
            $modelItem->setShopProductID($modelProduct->id);
            $modelItem->setRootID($model->id);
            $modelItem->setCoefficient(1);
            Helpers_DB::saveDBObject($modelItem, $sitePageData, $sitePageData->shopMainID);
        }
    }

    /**
     * Получаем массив ID продукции по рубрики (включая подрубрики)
     * @param $shopProductionRubricID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array|null
     * @throws HTTP_Exception_404
     */
    public static function findAllByMainRubric($shopProductionRubricID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if ($shopProductionRubricID > 0) {
            $modelRubric = new Model_Magazine_Shop_Production_Rubric();
            $modelRubric->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($modelRubric, $shopProductionRubricID, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Rubric not found.');
            }

            // считываем детвору
            $params = Request_RequestParams::setParams(
                array(
                    'root_id' => $shopProductionRubricID,
                    'sort_by' => array('name' => 'asc'),
                )
            );
            $shopProductionRubricIDs = Request_Request::find('DB_Magazine_Shop_Production_Rubric',
                $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
            );

            $rubricIDs = $shopProductionRubricIDs->getChildArrayID();
            $rubricIDs[] = $shopProductionRubricID;

            $params = Request_RequestParams::setParams(
                array(
                    'shop_production_rubric_id' => $rubricIDs,
                    'group' => 1,
                )
            );
            $shopProductionIDs = Request_Request::find('DB_Magazine_Shop_Production',
                $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
            )->getChildArrayID();

            if (count($shopProductionIDs) == 0) {
                throw new HTTP_Exception_404('Productions rubric not found.');
            }
        }else{
            $shopProductionIDs = NULL;
        }

        return $shopProductionIDs;
    }

    /**
     * удаление товара
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function delete(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $id = Request_RequestParams::getParamInt('id');
        if($id < 0){
            return FALSE;
        }

        $model = new Model_Magazine_Shop_Production();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Production not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }
    }

    /**
     * Сохранение продукции
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Magazine_Shop_Production();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Production not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamBoolean('is_special', $model);
        Request_RequestParams::setParamBoolean('is_price_cost', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_production_rubric_id", $model);
        Request_RequestParams::setParamFloat("coefficient_rubric", $model);
        Request_RequestParams::setParamFloat("weight_kg", $model);

        Request_RequestParams::setParamInt("shop_product_id", $model);
        Request_RequestParams::setParamInt("unit_id", $model);
        Request_RequestParams::setParamFloat('price', $model);
        Request_RequestParams::setParamFloat('price_cost', $model);

        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr('name_1c', $model);
        $model->setNames($model->getName());

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $barcode = $model->getBarcode();
        Request_RequestParams::setParamStr('barcode', $model);

        // проверяю на уникальность штрих-кода
        if($barcode != $model->getBarcode()) {
            $tmp = Request_Magazine_Shop_Production::checkUniqueBarcode(
                $sitePageData->shopMainID, $model->getBarcode(), $model->id, $sitePageData, $driver
            );
            if ($tmp !== TRUE) {
                return array(
                    'id' => $tmp->id,
                    'result' => array(
                        'error' => FALSE,
                    ),
                );
            }
        }

        //  Подбираем уникальный штрихкод
        if(Func::_empty($model->getBarcode())){
            $isOne = FALSE;
            while (!$isOne){
                $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'sp_barcode\') as id;')->as_array(NULL, 'id')[0];
                $model->setBarcode(Helpers_Barcode::generateEAN($n));

                $isOne = Request_Magazine_Shop_Production::checkUniqueBarcode(
                    $sitePageData->shopMainID, $model->getBarcode(), $model->id, $sitePageData, $driver, FALSE
                );
            }
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            $shopProductionItems = Request_RequestParams::getParamArray('shop_production_items');
            if($shopProductionItems !== NULL) {
                $arr = Api_Magazine_Shop_Production_Item::save(
                    $model->id, $shopProductionItems, $sitePageData, $driver
                );
                $model->setShopProductID($arr['id']);
                $model->setCoefficient($arr['coefficient']);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Сохраняем коэффициент продукции
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function saveCoefficient(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Magazine_Shop_Production();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Production not found.');
            }
        }

        $params = Request_RequestParams::setParams(
            array(
                'root_id' => $id,
            )
        );
        $shopProductionItemIDs = Request_Request::find('DB_Magazine_Shop_Production_Item',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );

        if(count($shopProductionItemIDs->childs) != 1){
            throw new HTTP_Exception_500('Count production item not equal one.');
        }

        $modelItem = new Model_Magazine_Shop_Production_Item();
        $modelItem->setDBDriver($driver);
        $shopProductionItemIDs->childs[0]->setModel($modelItem);

        $value = Request_RequestParams::getParamFloat('coefficient');
        if($value != null){
            $model->setCoefficient($value);
            $modelItem->setCoefficient($value);
        }

        $value = Request_RequestParams::getParamFloat('coefficient_rubric');
        if($value != null){
            $model->setCoefficientRubric($value);
        }

        $value = Request_RequestParams::getParamFloat('weight_kg');
        if($value != null){
            $model->setWeightKG($value);
        }

        $value = Request_RequestParams::getParamInt('unit_id');
        if($value != null){
            $model->setUnitID($value);
        }

        $value = Request_RequestParams::getParamInt('shop_production_rubric_id');
        if($value != null){
            $model->setShopProductionRubricID($value);
        }

        Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
        Helpers_DB::saveDBObject($modelItem, $sitePageData, $sitePageData->shopMainID);
    }
}

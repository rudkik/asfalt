<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Product  {
    /**
     * Считаем средную цену продукта
     * @param $shopProductID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return float|int
     */
    public static function calcPriceAverage($shopProductID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $days = array();
        $basicList = array(
            'receive' => array(),
            'return' => 0,
            'move_plus' => 0,
            'move_minus' => 0,
            'realization' => 0,
            'realization_return' => 0,
        );

        /** Считаем приход продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'shop_product_id' => $shopProductID,
                'group_by' => array(
                    'shop_product_id',
                    'created_at_date',
                    'price',
                    'nds_percent',
                    'is_nds',
                ),
            )
        );
        // приход
        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params
        );

        foreach ($ids->childs as $child){
            $date = $child->values['created_at_date'];
            if(!key_exists($date, $days)){
                $days[$date] = $basicList;
            }

            $days[$date]['receive'][] = array(
                'price' => Api_Tax_NDS::getAmountWithoutNDS($child->values['price'], $child->values['is_nds'], $child->values['nds_percent']),
                'quantity' => $child->values['quantity'],
            );
        }

        /** Считаем перемещение продукции **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'branch_move_id' => $sitePageData->shopID,
                'shop_product_id' => $shopProductID,
                'group_by' => array(
                    'shop_production_id.shop_product_id',
                    'shop_production_id.coefficient',
                    'created_at_date',
                ),
            )
        );
        // приход
        $ids = Request_Request::findBranch('DB_Magazine_Shop_Move_Item',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('coefficient', 'shop_product_id'))
        );
        foreach ($ids->childs as $child){
            $date = $child->values['created_at_date'];
            if(!key_exists($date, $days)){
                $days[$date] = $basicList;
            }

            $coefficient = $child->getElementValue('shop_production_id', 'coefficient', 1);
            if($coefficient == 0){
                $coefficient = 1;
            }

            $days[$date]['move_plus'] += $child->values['quantity'] / $coefficient;
        }

        /** Считаем реализации продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'shop_product_id' => $shopProductID,
                'group_by' => array(
                    'shop_production_id.shop_product_id',
                    'shop_production_id.coefficient',
                    'created_at_date',
                ),
            )
        );
        // расход
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('coefficient', 'shop_product_id'))
        );
        foreach ($ids->childs as $child){
            $date = $child->values['created_at_date'];
            if(!key_exists($date, $days)){
                $days[$date] = $basicList;
            }

            $coefficient = $child->getElementValue('shop_production_id', 'coefficient', 1);
            if($coefficient == 0){
                $coefficient = 1;
            }

            $days[$date]['realization'] -= $child->values['quantity'] / $coefficient;
        }

        /** Считаем возврат реализации продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'shop_product_id' => $shopProductID,
                'group_by' => array(
                    'shop_production_id.shop_product_id',
                    'shop_production_id.coefficient',
                    'created_at_date',
                ),
            )
        );
        // приход
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('coefficient', 'shop_product_id'))
        );
        foreach ($ids->childs as $child){
            $date = $child->values['created_at_date'];
            if(!key_exists($date, $days)){
                $days[$date] = $basicList;
            }

            $coefficient = $child->getElementValue('shop_production_id', 'coefficient', 1);
            if($coefficient == 0){
                $coefficient = 1;
            }

            $days[$date]['realization_return'] += $child->values['quantity'] / $coefficient;
        }

        /** Считаем перемещение продуктов **/
        $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('coefficient', 'shop_product_id'))
        );
        foreach ($ids->childs as $child){
            $date = $child->values['created_at_date'];
            if(!key_exists($date, $days)){
                $days[$date] = $basicList;
            }

            $coefficient = $child->getElementValue('shop_production_id', 'coefficient', 1);
            if($coefficient == 0){
                $coefficient = 1;
            }

            $days[$date]['move_minus'] -= $child->values['quantity'] / $coefficient;
        }

        /** Считаем возврат продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'shop_product_id' => $shopProductID,
                'group_by' => array(
                    'shop_product_id',
                    'created_at_date',
                ),
            )
        );
        // возврат
        $ids = Request_Request::find('DB_Magazine_Shop_Return_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        foreach ($ids->childs as $child){
            $date = $child->values['created_at_date'];
            if(!key_exists($date, $days)){
                $days[$date] = $basicList;
            }

            $days[$date]['return'] -= $child->values['quantity'];
        }

        ksort($days);

        $price = 0;
        $quantity = 0;
        foreach ($days as &$day){
            $amountReceive = 0;
            $quantityReceive = 0;
            foreach ($day['receive'] as $receive) {
                $quantityReceive += $receive['quantity'];
                $amountReceive += $receive['quantity'] * $receive['price'];
            }

            if($quantityReceive + $quantity != 0){
                $price = ($quantity * $price + $amountReceive) / ($quantityReceive + $quantity);
            }

            $quantity = $quantity + $quantityReceive + $day['return'] + $day['move_plus'] + $day['move_minus'] + $day['realization'] + $day['realization_return'];

            $day['quantity'] = $quantity;
        }

        return $price;
    }

    /**
     * Считаем средную цену всех продуктов
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcPriceAverageAll(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $ids = Request_Request::findAll('DB_Magazine_Shop_Product',
            $sitePageData->shopMainID, $sitePageData, $driver, 0
        );

        foreach ($ids->childs as $child){
            $model = Request_Request::findOneModel('DB_Magazine_Shop_Product',
                $sitePageData->shopMainID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'id' => $child->id,
                    )
                )
            );

            if($model !== FALSE) {
                $model->setPriceAverage(self::calcPriceAverage($child->id, $sitePageData, $driver));
                echo Helpers_DB::saveDBObject($model, $sitePageData).'<br>';
            }

        }
    }

    /**
     * Считаем остатки продукции на заданную дату
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | null $shopProductID
     * @return array
     */
    public static function stockDate($date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                     $shopProductID = null)
    {
        return self::stockPeriod(NULL, $date, $sitePageData, $driver, $shopProductID);
    }

    /**
     * Остатки на заданный период
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array | null $findShopProductIDs
     * @return array
     */
    public static function stockPeriod($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                       $findShopProductIDs = null)
    {
        $shopProductIDs = array();

        /** Считаем приход продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_product_id' => $findShopProductIDs,
                'group_by' => array(
                    'shop_product_id'
                ),
            )
        );
        // приход
        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params
        );
        foreach ($ids->childs as $child){
            $shopProductIDs[$child->values['shop_product_id']] = $child->values['quantity'];
        }

        /** Считаем перемещение продукции **/
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'sum_quantity' => TRUE,
                'branch_move_id' => $sitePageData->shopID,
                'shop_product_id' => $findShopProductIDs,
                'group_by' => array(
                    'shop_production_id.shop_product_id',
                    'shop_production_id.coefficient'
                ),
            )
        );
        // приход
        $ids = Request_Request::findBranch('DB_Magazine_Shop_Move_Item',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('coefficient', 'shop_product_id'))
        );
        foreach ($ids->childs as $child){
            $shopProductID = $child->getElementValue('shop_production_id', 'shop_product_id', 0);
            if(!key_exists($shopProductID, $shopProductIDs)){
                $shopProductIDs[$shopProductID] = 0;
            }

            $coefficient = $child->getElementValue('shop_production_id', 'coefficient', 1);
            if($coefficient == 0){
                $coefficient = 1;
            }

            $shopProductIDs[$shopProductID] += $child->values['quantity'] / $coefficient;
        }

        /** Считаем реализации продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_production_id.shop_product_id' => $findShopProductIDs,
                'shop_production_id.shop_product_id_from' => 0,
                'group_by' => array(
                    'shop_production_id.shop_product_id',
                    'shop_production_id.coefficient',
                ),
            )
        );
        // расход
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('coefficient', 'shop_product_id'))
        );
        foreach ($ids->childs as $child){
            $shopProductID = $child->getElementValue('shop_production_id', 'shop_product_id', 0);
            if(!key_exists($shopProductID, $shopProductIDs)){
                $shopProductIDs[$shopProductID] = 0;
            }

            $coefficient = $child->getElementValue('shop_production_id', 'coefficient', 1);
            if($coefficient == 0){
                $coefficient = 1;
            }

            $shopProductIDs[$shopProductID] -= $child->values['quantity'] / $coefficient;
        }

        /** Считаем возврат реализации продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_production_id.shop_product_id' => $findShopProductIDs,
                'shop_production_id.shop_product_id_from' => 0,
                'group_by' => array(
                    'shop_production_id.shop_product_id',
                    'shop_production_id.coefficient',
                ),
            )
        );
        // приход
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('coefficient', 'shop_product_id'))
        );
        foreach ($ids->childs as $child){
            $shopProductID = $child->getElementValue('shop_production_id', 'shop_product_id', 0);
            if(!key_exists($shopProductID, $shopProductIDs)){
                $shopProductIDs[$shopProductID] = 0;
            }

            $coefficient = $child->getElementValue('shop_production_id', 'coefficient', 1);
            if($coefficient == 0){
                $coefficient = 1;
            }

            $shopProductIDs[$shopProductID] += $child->values['quantity'] / $coefficient;
        }

        /** Считаем перемещение продуктов **/
        $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('coefficient', 'shop_product_id'))
        );
        foreach ($ids->childs as $child){
            $shopProductID = $child->getElementValue('shop_production_id', 'shop_product_id', 0);
            if(!key_exists($shopProductID, $shopProductIDs)){
                $shopProductIDs[$shopProductID] = 0;
            }

            $coefficient = $child->getElementValue('shop_production_id', 'coefficient', 1);
            if($coefficient == 0){
                $coefficient = 1;
            }

            $shopProductIDs[$shopProductID] -= $child->values['quantity'] / $coefficient;
        }

        /** Считаем возврат продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_product_id' => $findShopProductIDs,
                'group_by' => array(
                    'shop_product_id'
                ),
            )
        );
        // возврат
        $ids = Request_Request::find('DB_Magazine_Shop_Return_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        foreach ($ids->childs as $child){
            $shopProductID = $child->values['shop_product_id'];
            if(!key_exists($shopProductID, $shopProductIDs)){
                $shopProductIDs[$shopProductID] = 0;
            }
            $shopProductIDs[$shopProductID] -= $child->values['quantity'];
        }

        return $shopProductIDs;
    }

    /**
     * Считаем оставки всей продукции
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function calcStockAll(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $ids = Request_Request::findAll('DB_Magazine_Shop_Product',
            $sitePageData->shopMainID, $sitePageData, $driver, 0
        );

        foreach ($ids->childs as $child){
            self::calcComing($child->id, $sitePageData, $driver);
            self::calcExpense($child->id, $sitePageData, $driver);
        }
    }

    /**
     * Считаем расход продуктов
     * @param $shopProductID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveQuantity
     * @return bool|int
     * @throws HTTP_Exception_500
     */
    public static function calcExpense($shopProductID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                      $isSaveQuantity = TRUE)
    {
        if($shopProductID < 1){
            return FALSE;
        }

        $quantity = 0;

        /** Считаем реализации продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'shop_product_id' => $shopProductID,
                'group_by' => array(
                    'shop_production_id.coefficient'
                ),
            )
        );
        // расход
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('coefficient'))
        );
        if(count($ids->childs) > 0){
            $ids = $ids->childs[0];

            $coefficient = $ids->getElementValue('shop_production_id', 'coefficient', 1);
            if($coefficient == 0){
                $coefficient = 1;
            }

            $quantity += $ids->values['quantity'] / $coefficient;
        }

        /** Считаем перемещение продуктов **/
        $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('coefficient'))
        );
        if(count($ids->childs) > 0){
            $ids = $ids->childs[0];

            $coefficient = $ids->getElementValue('shop_production_id', 'coefficient', 1);
            if($coefficient == 0){
                $coefficient = 1;
            }

            $quantity += $ids->values['quantity'] / $coefficient;
        }

        /** Считаем возврат продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'shop_product_id' => $shopProductID,
            )
        );
        // возврат
        $ids = Request_Request::find('DB_Magazine_Shop_Return_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        if(count($ids->childs) > 0){
            $ids = $ids->childs[0];
            $quantity += $ids->values['quantity'];
        }

        if($isSaveQuantity) {
            $model = Request_Request::findOneModel('DB_Magazine_Shop_Product_Stock',
                $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_product_id' => $shopProductID,
                    )
                )
            );

            if($model === FALSE) {
                $model = new Model_Magazine_Shop_Product_Stock();
                $model->setDBDriver($driver);
                $model->setShopProductID($shopProductID);
            }

            $model->setQuantityExpense($quantity);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        return $quantity;
    }

    /**
     * Считаем приход продуктов
     * @param $shopProductID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveQuantity
     * @return bool|int
     * @throws HTTP_Exception_500
     */
    public static function calcComing($shopProductID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                      $isSaveQuantity = TRUE)
    {
        if($shopProductID < 1){
            return FALSE;
        }

        $quantity = 0;

        /** Считаем приход продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'shop_product_id' => $shopProductID,
            )
        );
        // приход
        $ids = Request_Request::find('DB_Magazine_Shop_Receive_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $quantity += $ids->childs[0]->values['quantity'];
        }

        /** Считаем перемещение продукции **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'branch_move_id' => $sitePageData->shopID,
                'shop_product_id' => $shopProductID,
                'group_by' => array(
                    'shop_production_id.coefficient'
                ),
            )
        );
        // приход
        $ids = Request_Request::findBranch('DB_Magazine_Shop_Move_Item',
            array(), $sitePageData, $driver, $params
        );
        if(count($ids->childs) > 0){
            $ids = $ids->childs[0];

            $coefficient = $ids->getElementValue('shop_production_id', 'coefficient', 1);
            if($coefficient == 0){
                $coefficient = 1;
            }

            $quantity += $ids->values['quantity'] / $coefficient;
        }

        /** Считаем возврат реализации продукции **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'shop_product_id' => $shopProductID,
                'group_by' => array(
                    'shop_production_id.coefficient'
                ),
            )
        );
        // возврат реализации
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Return_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            ['shop_production_id' => ['coefficient']]
        );
        if(count($ids->childs) > 0){
            $ids = $ids->childs[0];

            $coefficient = $ids->getElementValue('shop_production_id', 'coefficient', 1);
            if($coefficient == 0){
                $coefficient = 1;
            }

            $quantity += $ids->values['quantity'] / $coefficient;
        }

        if($isSaveQuantity) {
            $model = Request_Request::findOneModel('DB_Magazine_Shop_Product_Stock',
                $sitePageData->shopID, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_product_id' => $shopProductID,
                    )
                )
            );

            if($model === FALSE) {
                $model = new Model_Magazine_Shop_Product_Stock();
                $model->setDBDriver($driver);
                $model->setShopProductID($shopProductID);
            }

            $model->setQuantityComing($quantity);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        return $quantity;
    }

    /**
     * Получаем массив ID продукции по рубрики (включая подрубрики)
     * @param $shopProductRubricID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array|null
     * @throws HTTP_Exception_404
     */
    public static function findAllByMainRubric($shopProductRubricID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if ($shopProductRubricID > 0) {
            $modelRubric = new Model_Magazine_Shop_Product_Rubric();
            $modelRubric->setDBDriver($driver);
            if (!Helpers_DB::getDBObject($modelRubric, $shopProductRubricID, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Rubric not found.');
            }

            // считываем детвору
            $params = Request_RequestParams::setParams(
                array(
                    'root_id' => $shopProductRubricID,
                    'sort_by' => array('name' => 'asc'),
                )
            );
            $shopProductRubricIDs = Request_Request::find('DB_Magazine_Shop_Product_Rubric',
                $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
            );

            $rubricIDs = $shopProductRubricIDs->getChildArrayID();
            $rubricIDs[] = $shopProductRubricID;

            $params = Request_RequestParams::setParams(
                array(
                    'shop_product_rubric_id' => $rubricIDs,
                    'group' => 1,
                )
            );
            $shopProductIDs = Request_Request::find('DB_Magazine_Shop_Product',
                $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
            )->getChildArrayID();

            if (count($shopProductIDs) == 0) {
                throw new HTTP_Exception_404('Products rubric not found.');
            }
        }else{
            $shopProductIDs = NULL;
        }

        return $shopProductIDs;
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

        $model = new Model_Magazine_Shop_Product();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
            throw new HTTP_Exception_500('Product not found.');
        }

        if(Request_RequestParams::getParamBoolean("is_undel") === TRUE){
            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }else {
            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopMainID);
        }
    }

    /**
     * Сохранение товары
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function save(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Magazine_Shop_Product();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, $sitePageData->shopMainID)) {
                throw new HTTP_Exception_500('Product not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("shop_product_rubric_id", $model);
        Request_RequestParams::setParamInt("unit_id", $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr('name_1c', $model);
        Request_RequestParams::setParamFloat('price_cost', $model);
        Request_RequestParams::setParamFloat('coefficient_revise', $model);

        Request_RequestParams::setParamBoolean('is_markup_percent', $model);
        Request_RequestParams::setParamFloat('markup', $model);
        if($model->getCoefficientRevise() == 0){
            $model->setCoefficientRevise(1);
        }
        $model->setNames($model->getName());

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }

        $barcode = $model->getBarcode();
        Request_RequestParams::setParamStr('barcode', $model);

        // проверяю на уникальность штрих-кода
        if($barcode != $model->getBarcode() && !empty($barcode)) {
            $tmp = Request_Magazine_Shop_Product::checkUniqueBarcode(
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

                $isOne = Request_Magazine_Shop_Product::checkUniqueBarcode(
                    $sitePageData->shopMainID, $model->getBarcode(), $model->id, $sitePageData, $driver, FALSE
                );
            }
        }

        $result = array();
        if ($model->validationFields($result)) {
            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // редактируем продукцию, которая напрямую связана с продуктом
            Api_Magazine_Shop_Production::editProduction($model, $sitePageData, $driver);

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
     * Загружаем продукты из ЭСФ
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function loadESF($fileName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $xml = simplexml_load_file($fileName);
        $xml = Helpers_XML::xmlToArray($xml);

        $xml = Arr::path($xml, 'invoiceInfoContainer.invoiceSet.invoiceInfo', '');
        if(!is_array($xml)){
            return FALSE;
        }

        $shopProductIDs = Request_Request::findAll('DB_Magazine_Shop_Product', $sitePageData->shopMainID, $sitePageData, $driver, 0, TRUE);
        $products = array();
        foreach ($shopProductIDs->childs as $child){
            $products[str_replace('.', '',
                str_replace(',', '',
                    str_replace(' ', '', $child->values['name_1c'])
                )
            )] = $child;
        }

        $model = new Model_Magazine_Shop_Product();
        $model->setDBDriver($driver);
        $params = Request_RequestParams::setParams();
        $paramsUnit = Request_RequestParams::setParams();

        foreach ($xml as $key => $child){
            if($key == 'invoiceBody'){
                $child = Arr::path($child, 'value', '');
            }else{
                $child = Arr::path($child, 'invoiceBody.value', '');
            }
            if(empty($child)){
                continue;
            }

            try {
                $xmlProducts = simplexml_load_string($child);
            }catch (Exception $e){
                continue;
            }
            $xmlProducts = Helpers_XML::xmlToArray($xmlProducts);

            $xmlProducts = Arr::path($xmlProducts, 'invoice.productSet.products.product', '');
            foreach ($xmlProducts as $product){
                $name = trim(Arr::path($product, 'description.value', ''));
                if(empty($name)){
                    continue;
                }

                echo $name.'<br>';
                /*$params['name_1c_full'] = $name;
                $ids = Request_Request::find('DB_Magazine_Shop_Product',
                    $sitePageData->shopID, $sitePageData, $driver, $params, 1
                );*/

                $nameNew = str_replace('.', '',
                    str_replace(',', '',
                        str_replace(' ', '', $name)
                    )
                );
                //if(count($ids->childs) > 0){
                if(key_exists($nameNew, $products)){
                    //$ids->childs[0]->setModel($model);
                    $products[$nameNew]->setModel($model);
                    $model->setPriceCost(Arr::path($product, 'priceWithTax.value', 0) / Arr::path($product, 'quantity.value', 1));
                }else {
                    $model->clear();
                    $model->setName1C($name);
                    $model->setPriceCost(Arr::path($product, 'priceWithTax.value', 0) / Arr::path($product, 'quantity.value', 1));
                }

                $paramsUnit['code_esf_full'] = Arr::path($product, 'unitNomenclature.value', '');
                $ids = Request_Request::find('DB_Magazine_Unit',
                    $sitePageData, $driver, $paramsUnit, 1
                );
                if(count($ids->childs) > 0){
                    $model->setUnitID($ids->childs[0]->id);
                }

                Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

                // редактируем продукцию, которая напрямую связана с продуктом
                Api_Magazine_Shop_Production::editProduction($model, $sitePageData, $driver);
            }
        }
    }

    /**
     * Сохраняем коэффициент продукта
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @throws HTTP_Exception_500
     */
    public static function saveCoefficient(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $model = new Model_Magazine_Shop_Product();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Product not found.');
            }
        }

        $value = Request_RequestParams::getParamFloat('coefficient_revise');
        if($value != null){
            $model->setCoefficientRevise($value);
        }

        $value = Request_RequestParams::getParamInt('unit_id');
        if($value != null){
            $model->setUnitID($value);
        }

        $value = Request_RequestParams::getParamInt('shop_product_rubric_id');
        if($value != null){
            $model->setShopProductRubricID($value);
        }

        Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);

        // редактируем продукцию, которая напрямую связана с продуктом
        Api_Magazine_Shop_Production::editProduction($model, $sitePageData, $driver);
    }
}

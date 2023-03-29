<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Move  {
    /**
     * Перемещение выбытие продуктов на заданный период
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | null $shopProductID
     * @return array
     */
    public static function expenseShopProductPeriod($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                    $shopProductID = null)
    {
        $shopProductIDs = array();

        /** Считаем реализации продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_production_id.shop_product_id' => $shopProductID,
                'shop_production_id.shop_product_id_from' => 0,
                'group_by' => array(
                    'shop_production_id.shop_product_id',
                    'shop_production_id.coefficient',
                ),
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE,
            array('shop_production_id' => array('coefficient', 'shop_product_id'))
        );
        foreach ($ids->childs as $child){
            $shopProductID = $child->getElementValue('shop_production_id', 'shop_product_id', 0);
            if(!key_exists($shopProductID, $shopProductIDs)){
                $shopProductIDs[$shopProductID] = 0;
            }
            $shopProductIDs[$shopProductID] += $child->values['quantity'] / $child->getElementValue('shop_production_id', 'coefficient', 1);
        }

        return $shopProductIDs;
    }
    /**
     * Перемещение выбытие продукции собственного производства на заданный период
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | null $shopProductionID
     * @return array
     */
    public static function expenseShopProductionPeriod($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                       $shopProductionID = null)
    {
        $shopProductionIDs = array();

        /** Считаем реализации продуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'shop_production_id' => $shopProductionID,
                'shop_production_id.shop_product_id' => 0,
                'group_by' => array(
                    'shop_production_id',
                ),
            )
        );

        $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );
        foreach ($ids->childs as $child){
            $shopProductionID = $child->values['shop_production_id'];
            if(!key_exists($shopProductionID, $shopProductionIDs)){
                $shopProductionIDs[$shopProductionID] = 0;
            }

            $shopProductionIDs[$shopProductionID] += $child->values['quantity'];
        }

        return $shopProductionIDs;
    }

    /**
     * Перемещение продуктов на заданный период
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $shopProductID
     * @return array
     */
    public static function receiveShopProductPeriod($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                    $shopProductID = null)
    {
        $shopProductIDs = array();

        /** Считаем перемещение продукции **/
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'sum_quantity' => TRUE,
                'branch_move_id' => $sitePageData->shopID,
                'shop_product_id' => $shopProductID,
                'shop_production_id.shop_product_id_from' => 0,
                'group_by' => array(
                    'shop_production_id.shop_product_id',
                    'shop_production_id.coefficient',
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

        return $shopProductIDs;
    }

    /**
     * Перемещение продукции собственного производства на заданный период
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null $shopProductionID
     * @return array
     */
    public static function receiveShopProductionPeriod($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                       $shopProductionID = null)
    {
        $shopProductionIDs = array();

        /** Считаем перемещение продукции **/
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'sum_quantity' => TRUE,
                'branch_move_id' => $sitePageData->shopID,
                'shop_production_id' => $shopProductionID,
                'shop_production_id.shop_product_id' => 0,
                'group_by' => array(
                    'shop_production_id',
                ),
            )
        );
        // приход
        $ids = Request_Request::findBranch('DB_Magazine_Shop_Move_Item',
            array(), $sitePageData, $driver, $params, 0, TRUE
        );
        foreach ($ids->childs as $child){
            $shopProductionID = $child->values['shop_production_id'];
            if(!key_exists($shopProductionID, $shopProductionIDs)){
                $shopProductionIDs[$shopProductionID] = 0;
            }

            $shopProductionIDs[$shopProductionID] += $child->values['quantity'];
        }

        return $shopProductionIDs;
    }

    /**
     * удаление реализации
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
        $isUnDel = Request_RequestParams::getParamBoolean("is_undel");

        $model = new Model_Magazine_Shop_Move();
        $model->setDBDriver($driver);

        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
            throw new HTTP_Exception_500('Move not found.');
        }

        if (($isUnDel && !$model->getIsDelete()) or (!$isUnDel && $model->getIsDelete())){
            return FALSE;
        }

        if($isUnDel){
            $params = Request_RequestParams::setParams(
                array(
                    'shop_move_id' => $id,
                    'is_delete' => 1,
                    'is_public' => FALSE,
                )
            );
            $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params
            );
            $driver->unDeleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Magazine_Shop_Move_Item::TABLE_NAME,
                array('is_public' => 1), $sitePageData->shopID
            );

            $model->dbUnDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }else {
            $params = Request_RequestParams::setParams(
                array(
                    'shop_move_id' => $id,
                    'is_delete' => 0,
                    'is_public' => TRUE,
                )
            );
            $ids = Request_Request::find('DB_Magazine_Shop_Move_Item',
                $sitePageData->shopID, $sitePageData, $driver, $params
            );
            $driver->deleteObjectIDs(
                $ids->getChildArrayID(), $sitePageData->userID, Model_Magazine_Shop_Move_Item::TABLE_NAME,
                array('is_public' => 0), $sitePageData->shopID
            );

            $model->dbDelete($sitePageData->userID, 0, $sitePageData->shopID);
        }

        return TRUE;
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
        $model = new Model_Magazine_Shop_Move();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData, 0)) {
                throw new HTTP_Exception_500('Move not found.');
            }
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr("old_id", $model);
        Request_RequestParams::setParamInt("branch_move_id", $model);

        $options = Request_RequestParams::getParamArray('options');
        if ($options !== NULL) {
            $model->addOptionsArray($options);
        }
        $result = array();
        if ($model->validationFields($result)) {
            if(Func::_empty($model->getOldID())){
                $n = Database::instance()->query(Database::SELECT, 'SELECT nextval(\'sp_number_move\') as id;')->as_array(NULL, 'id')[0];
                $n = '000000'.$n;
                $n = 'Т'.substr($n, strlen($n) - 8);
                $model->setOldID($n);
            }

            if($model->id < 1) {
                Helpers_DB::saveDBObject($model, $sitePageData);
            }

            // загружаем фотографии
            $file = new Model_File($sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $sitePageData, $driver);

            // сохраняем товары
            $shopMoveItems = Request_RequestParams::getParamArray('shop_move_items');
            if($shopMoveItems !== NULL) {
                $quantity = Api_Magazine_Shop_Move_Item::save(
                    $model->id, $model->getBranchMoveID(), $shopMoveItems, $sitePageData, $driver
                );
                $model->setQuantity($quantity);
            }

            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * Сохраняем перемещение в виде XML / РАСХОД
     * Перемещение из магазина в столовую
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveMoveExpenseXML($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список перемещений из магазина
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
            )
        );
        $shopMoveIDs = Request_Request::find('DB_Magazine_Shop_Move',
            $sitePageData->shopID, $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'branch_move_id' => array('name',  'old_id'),
                'shop_id' => array('name', 'old_id'),
            )
        );

        $model = new Model_Magazine_Shop_Move();
        $modelItem = new Model_Magazine_Shop_Move_Item();

        $data = '<?xml version="1.0" encoding="UTF-8"?><data>';
        foreach($shopMoveIDs->childs as $child){
            $child->setModel($model);

            $data .= '<move>'
                . '<id>'.$child->values['id'].'</id>'
                . '<number>'.$child->values['old_id'].'</number>'
                . '<date>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($child->values['created_at'])).'</date>'
                . '<in>'.$child->getElementValue('branch_move_id', 'old_id').'</in>'
                . '<in_name>'.$child->getElementValue('branch_move_id').'</in_name>'
                . '<out>'.htmlspecialchars($child->getElementValue('shop_id', 'old_id'), ENT_XML1).'</out>'
                . '<out_name>'.htmlspecialchars($child->getElementValue('shop_id'), ENT_XML1).'</out_name>';

            $data .= '<goodsList>';

            // получаем список продуктов приемки
            $params = Request_RequestParams::setParams(
                array(
                    'shop_move_id' => $model->id,
                )
            );
            $shopMoveItemIDs = Request_Request::find('DB_Magazine_Shop_Move_Item',
                $sitePageData->shopID, $sitePageData, $driver,
                $params, 0, TRUE,
                array(
                    'shop_production_id' => array('name', 'old_id', 'shop_product_id', 'weight_kg', 'shop_production_rubric_id'),
                    'unit_id' => array('name', 'old_id'),
                )
            );

            $modelRubric = new Model_Magazine_Shop_Production_Rubric();
            $modelRubric->setDBDriver($driver);
            foreach ($shopMoveItemIDs->childs as $item) {
                $item->setModel($modelItem);

                Helpers_DB::getDBObject($modelRubric, $item->getElementValue('shop_production_id', 'shop_production_rubric_id'), $sitePageData, $sitePageData->shopMainID);

                $data .= '<goods>'
                    . '<idGood>' . $item->getElementValue('shop_production_id', 'shop_product_id') . '</idGood>'
                    . '<name>' . htmlspecialchars($item->getElementValue('shop_production_id'), ENT_XML1) . '</name>'
                    . '<unit>' . htmlspecialchars($item->getElementValue('unit_id', 'old_id'), ENT_XML1) . '</unit>'
                    . '<unit_name>' . htmlspecialchars($item->getElementValue('unit_id'), ENT_XML1) . '</unit_name>'
                    . '<quantityGood>' . $item->values['quantity'] . '</quantityGood>'
                    . '<idRaw>' .$modelRubric->getOldID(). '</idRaw>'
                    . '<idRawName>' .$modelRubric->getName(). '</idRawName>'
                    . '<quantityRaw>' .($item->getElementValue('shop_production_id', 'weight_kg') * $item->values['quantity']). '</quantityRaw>'
                    . '</goods>';
            }

            $data .= '</goodsList>';
            $data .= '</move>';
        }

        $data .= '</data>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="magazine_move_out.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }

    /**
     * Сохраняем перемещение в виде XML / ПРИХОД
     * Перемещение из столовой в магазин
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveMoveComingXML($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список перемещений из магазина
        $params = Request_RequestParams::setParams(
            array(
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
                'branch_move_id' => $sitePageData->shopID,
            )
        );
        $shopMoveIDs = Request_Request::findBranch('DB_Magazine_Shop_Move',
            array(), $sitePageData, $driver,
            $params, 0, TRUE,
            array(
                'branch_move_id' => array('name',  'old_id'),
                'shop_id' => array('name', 'old_id'),
            )
        );

        $model = new Model_Magazine_Shop_Move();
        $modelItem = new Model_Magazine_Shop_Move_Item();

        $data = '<?xml version="1.0" encoding="UTF-8"?><data>';
        foreach($shopMoveIDs->childs as $child){
            $child->setModel($model);

            $data .= '<move>'
                . '<id>'.$child->values['id'].'</id>'
                . '<date>'.strftime('%d.%m.%Y %H:%M:%S', strtotime($child->values['created_at'])).'</date>'
                . '<in>'.$child->getElementValue('branch_move_id', 'old_id').'</in>'
                . '<in_name>'.$child->getElementValue('branch_move_id').'</in_name>'
                . '<out>'.htmlspecialchars($child->getElementValue('shop_id', 'old_id'), ENT_XML1).'</out>'
                . '<out_name>'.htmlspecialchars($child->getElementValue('shop_id'), ENT_XML1).'</out_name>';

            $data .= '<goodsList>';

            // получаем список продуктов приемки
            $params = Request_RequestParams::setParams(
                array(
                    'shop_return_id' => $model->id,
                )
            );
            $shopMoveItemIDs = Request_Request::find('DB_Magazine_Shop_Move_Item',
                $sitePageData->shopID, $sitePageData, $driver,
                $params, 0, TRUE,
                array(
                    'shop_dish_id' => array('name', 'old_id'),
                    'unit_id' => array('name', 'old_id'),
                )
            );

            foreach ($shopMoveItemIDs->childs as $item) {
                $item->setModel($modelItem);

                $data .= '<goods>'
                    . '<id>' . $item->getElementValue('shop_dish_id', 'old_id') . '</id>'
                    . '<name>' . $item->getElementValue('shop_dish_id') . '</name>'
                    . '<quantity>' . $item->values['quantity'] . '</quantity>'
                    . '</goods>';
            }

            $data .= '</goodsList>';
            $data .= '</move>';
        }

        $data .= '</data>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="magazine_move_in.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }
}

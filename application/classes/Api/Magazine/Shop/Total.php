<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Total  {

    /**
     * Свободная ведомость по продуктам
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | null $shopProductID
     * @return MyArray
     */
    public static function getShopProductTotal($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                               $shopProductID = null)
    {
        $dateFrom = Helpers_DateTime::minusSeconds($dateFrom, 1);
        $dateTo = Helpers_DateTime::getDateFormatPHP($dateTo).' 23:59:59';

        // Приход продуктов на заданный период
        $receiveShopProducts = Api_Magazine_Shop_Receive::receiveShopProductPeriod(
            $dateFrom, $dateTo, $sitePageData, $driver, $shopProductID
        );

        // Возврат продуктов на заданный период
        $returnShopProducts = Api_Magazine_Shop_Return::returnShopProductPeriod(
            $dateFrom, $dateTo, $sitePageData, $driver, $shopProductID
        );

        // Перемещение поступление на заданный период
        $moveReceiveShopProducts = Api_Magazine_Shop_Move::receiveShopProductPeriod(
            $dateFrom, $dateTo, $sitePageData, $driver, $shopProductID
        );

        // Реализация продуктов на заданный период
        $realizationShopProducts = Api_Magazine_Shop_Realization::realizationShopProductPeriod(
            $dateFrom, $dateTo,
            [Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC, Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT],
            $sitePageData, $driver,
            [0, Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_REDRESS], // возмещение
            $shopProductID
        );

        // Возврат реализации продуктов на заданный период
        $realizationReturnShopProducts = Api_Magazine_Shop_Realization_Return::returnShopProductPeriod(
            $dateFrom, $dateTo, $sitePageData, $driver, $shopProductID
        );

        // Перемещение выбытие на заданный период
        $moveExpenseShopProducts = Api_Magazine_Shop_Move::expenseShopProductPeriod(
            $dateFrom, $dateTo, $sitePageData, $driver, $shopProductID
        );

        // Списание выбытие на заданный период
        $writeOffShopProducts = Api_Magazine_Shop_Realization::realizationShopProductPeriod(
            $dateFrom, $dateTo, Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF,
            $sitePageData, $driver,
            Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_RECEPTION, // приемная
            $shopProductID
        );

        // Корректировки (нормы/сверхнормы) на заданный период
        $adjustmentShopProducts = Api_Magazine_Shop_Realization::realizationShopProductPeriod(
            $dateFrom, $dateTo, Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF,
            $sitePageData, $driver,
            [
                Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_BY_STANDART, // по нормам
                Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_OVER_THE_NORM, // сверх нормы
            ], $shopProductID
        );

        // Остаток на начало
        $stockDateFrom = Api_Magazine_Shop_Product::stockDate($dateFrom, $sitePageData, $driver, $shopProductID);

        // Остаток на конец
        $stockDateTo = Api_Magazine_Shop_Product::stockDate($dateTo, $sitePageData, $driver, $shopProductID);

        // узнаем массив продуктов
        $shopProducts = array();
        foreach ($stockDateTo as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProducts[$id] = $id;
            }
        }
        foreach ($stockDateFrom as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProducts[$id] = $id;
            }
        }
        foreach ($receiveShopProducts as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProducts[$id] = $id;
            }
        }
        foreach ($returnShopProducts as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProducts[$id] = $id;
            }
        }
        foreach ($moveReceiveShopProducts as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProducts[$id] = $id;
            }
        }
        foreach ($realizationShopProducts as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProducts[$id] = $id;
            }
        }
        foreach ($realizationReturnShopProducts as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProducts[$id] = $id;
            }
        }
        foreach ($moveExpenseShopProducts as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProducts[$id] = $id;
            }
        }
        foreach ($adjustmentShopProducts as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProducts[$id] = $id;
            }
        }

        if(empty($shopProducts)) {
            return new MyArray();
        }

        $params = Request_RequestParams::setParams(
            array(
                'id' => $shopProducts,
                'sort_by' => array(
                    'name' => 'asc',
                )
            ),
            FALSE
        );
        $shopProductIDs = Request_Request::find('DB_Magazine_Shop_Product',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );

        foreach ($shopProductIDs->childs as $child){
            $shopProductID = $child->id;

            // Приход продуктов на заданный период
            if(key_exists($shopProductID, $receiveShopProducts)){
                $child->additionDatas['receive'] = $receiveShopProducts[$shopProductID];
            }

            // Возврат продуктов на заданный период
            if(key_exists($shopProductID, $returnShopProducts)){
                $child->additionDatas['return'] = $returnShopProducts[$shopProductID];
            }

            // Перемещение поступление на заданный период
            if(key_exists($shopProductID, $moveReceiveShopProducts)){
                $child->additionDatas['move_receive'] = $moveReceiveShopProducts[$shopProductID];
            }

            // Реализация продуктов на заданный период
            if(key_exists($shopProductID, $realizationShopProducts)){
                $child->additionDatas['realization'] = $realizationShopProducts[$shopProductID];
            }

            // Возврат реализации продуктов на заданный период
            if(key_exists($shopProductID, $realizationReturnShopProducts)){
                $child->additionDatas['realization_return'] = $realizationReturnShopProducts[$shopProductID];
            }

            // Перемещение выбытие на заданный период
            if(key_exists($shopProductID, $moveExpenseShopProducts)){
                $child->additionDatas['move_expense'] = $moveExpenseShopProducts[$shopProductID];
            }

            // Списание выбытие на заданный период
            if(key_exists($shopProductID, $writeOffShopProducts)){
                $child->additionDatas['write_off'] = $writeOffShopProducts[$shopProductID];
            }

            // Корректировки (нормы/сверхнормы) на заданный период
            if(key_exists($shopProductID, $adjustmentShopProducts)){
                $child->additionDatas['adjustment'] = $adjustmentShopProducts[$shopProductID];
            }

            // Остаток на начало
            if(key_exists($shopProductID, $stockDateFrom)){
                $child->additionDatas['stock_from'] = $stockDateFrom[$shopProductID];
            }

            // Остаток на конец
            if(key_exists($shopProductID, $stockDateTo)){
                $child->additionDatas['stock_to'] = $stockDateTo[$shopProductID];
            }
        }

        return $shopProductIDs;
    }

    /**
     * Свободная ведомость по продукции собственногшо производства
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int | null $shopProductionID
     * @return MyArray
     */
    public static function getShopProductionTotal($dateFrom, $dateTo, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                  $shopProductionID = null)
    {
        $dateFrom = Helpers_DateTime::minusSeconds($dateFrom, 1);
        $dateTo = Helpers_DateTime::getDateFormatPHP($dateTo).' 23:59:59';

        // Перемещение поступление на заданный период
        $moveReceiveShopProducts = Api_Magazine_Shop_Move::receiveShopProductionPeriod(
            $dateFrom, $dateTo, $sitePageData, $driver, $shopProductionID
        );

        // Реализация продуктов на заданный период
        $realizationShopProducts = Api_Magazine_Shop_Realization::realizationShopProductionPeriod(
            $dateFrom, $dateTo,
            [Model_Magazine_Shop_Realization::SPECIAL_TYPE_BASIC, Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT],
            $sitePageData, $driver,
            [0, Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_REDRESS], // возмещение
            $shopProductionID
        );

        // Возврат реализации продуктов на заданный период
        $realizationReturnShopProducts = Api_Magazine_Shop_Realization_Return::returnShopProductionPeriod(
            $dateFrom, $dateTo, $sitePageData, $driver, $shopProductionID
        );

        // Перемещение выбытие на заданный период
        $moveExpenseShopProducts = Api_Magazine_Shop_Move::expenseShopProductionPeriod(
            $dateFrom, $dateTo, $sitePageData, $driver, $shopProductionID
        );

        // Списание выбытие на заданный период
        $writeOffShopProducts = Api_Magazine_Shop_Realization::realizationShopProductionPeriod(
            $dateFrom, $dateTo, Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF,
            $sitePageData, $driver,
            Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_RECEPTION, // приемная
            $shopProductionID
        );

        // Корректировки (нормы/сверхнормы) на заданный период
        $adjustmentShopProducts = Api_Magazine_Shop_Realization::realizationShopProductionPeriod(
            $dateFrom, $dateTo, Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF,
            $sitePageData, $driver,
            [
                Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_BY_STANDART, // по нормам
                Model_Magazine_Shop_WriteOff_Type::WRITE_OFF_TYPE_OVER_THE_NORM, // сверх нормы
            ], $shopProductionID
        );

        // Остаток на начало
        $stockDateFrom = Api_Magazine_Shop_Production::stockDate($dateFrom, $sitePageData, $driver, $shopProductionID);

        // Остаток на конец
        $stockDateTo = Api_Magazine_Shop_Production::stockDate($dateTo, $sitePageData, $driver, $shopProductionID);

        // узнаем массив продуктов
        $shopProductions = array();
        foreach ($stockDateTo as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProductions[$id] = $id;
            }
        }
        foreach ($stockDateFrom as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProductions[$id] = $id;
            }
        }
        foreach ($moveReceiveShopProducts as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProductions[$id] = $id;
            }
        }
        foreach ($realizationShopProducts as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProductions[$id] = $id;
            }
        }
        foreach ($moveExpenseShopProducts as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProductions[$id] = $id;
            }
        }
        foreach ($adjustmentShopProducts as $id => $v){
            if($v > 0.00001 || $v < -0.00001){
                $shopProductions[$id] = $id;
            }
        }

        if(empty($shopProductions)) {
            return new MyArray();
        }

        $params = Request_RequestParams::setParams(
            array(
                'id' => $shopProductions,
                'sort_by' => array(
                    'name' => 'asc',
                )
            ),
            FALSE
        );
        $shopProductionIDs = Request_Request::find('DB_Magazine_Shop_Production',
            $sitePageData->shopMainID, $sitePageData, $driver, $params, 0, TRUE
        );

        foreach ($shopProductionIDs->childs as $child){
            $shopProductionID = $child->id;

            // Перемещение поступление на заданный период
            if(key_exists($shopProductionID, $moveReceiveShopProducts)){
                $child->additionDatas['move_receive'] = $moveReceiveShopProducts[$shopProductionID];
            }

            // Реализация продуктов на заданный период
            if(key_exists($shopProductionID, $realizationShopProducts)){
                $child->additionDatas['realization'] = $realizationShopProducts[$shopProductionID];
            }

            // Возврат реализации продуктов на заданный период
            if(key_exists($shopProductionID, $realizationReturnShopProducts)){
                $child->additionDatas['realization_return'] = $realizationReturnShopProducts[$shopProductionID];
            }

            // Перемещение выбытие на заданный период
            if(key_exists($shopProductionID, $moveExpenseShopProducts)){
                $child->additionDatas['move_expense'] = $moveExpenseShopProducts[$shopProductionID];
            }

            // Списание выбытие на заданный период
            if(key_exists($shopProductionID, $writeOffShopProducts)){
                $child->additionDatas['write_off'] = $writeOffShopProducts[$shopProductionID];
            }

            // Корректировки (нормы/сверхнормы) на заданный период
            if(key_exists($shopProductionID, $adjustmentShopProducts)){
                $child->additionDatas['adjustment'] = $adjustmentShopProducts[$shopProductionID];
            }

            // Остаток на начало
            if(key_exists($shopProductionID, $stockDateFrom)){
                $child->additionDatas['stock_from'] = $stockDateFrom[$shopProductionID];
            }

            // Остаток на конец
            if(key_exists($shopProductionID, $stockDateTo)){
                $child->additionDatas['stock_to'] = $stockDateTo[$shopProductionID];
            }
        }

        return $shopProductionIDs;
    }
}

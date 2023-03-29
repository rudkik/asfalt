<?php defined('SYSPATH') or die('No direct script access.');

class Api_Magazine_Shop_Talon  {
    /**
     * Список талонов сотрудника на заданный день
     * @param $shopWorkerID
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return MyArray
     */
    public static function findWorkerTalons($shopWorkerID, $date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        return Request_Request::find(
            'DB_Magazine_Shop_Talon', 0, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_worker_id' => $shopWorkerID,
                    'validity' => Helpers_DateTime::getDateFormatPHP($date),
                    'sort_by' => array(
                        'id' => 'asc',
                    )
                )
            ), 0, TRUE
        );
    }

    /**
     * Считаем остатки талона за заданный месяц
     * @param $shopWorkerID
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool|int
     */
    public static function calcQuantityTalonDate($shopWorkerID, $date, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        // Список талонов сотрудника на заданный день
        $shopWorkerTalonIDs = self::findWorkerTalons($shopWorkerID, $date, $sitePageData, $driver);
        if(count($shopWorkerTalonIDs->childs) < 1){
            return FALSE;
        }

        // выбираем за какой период нужно искать реализацию
        $from = null;
        $to = null;
        foreach ($shopWorkerTalonIDs->childs as $child){
            if($from == null || date($from) > date($child->values['validity_from'])){
                $from = $child->values['validity_from'];
            }
            if($to == null || date($to) < date($child->values['validity_to'])){
                $to = $child->values['validity_to'];
            }
        }

        /** Считаем реализации спецпродуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'shop_worker_id' => $shopWorkerID,
                'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT,
                'created_at_from_equally' => $from,
                'created_at_to' => $to.' 23:59:59',
            )
        );

        // расход
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        if(count($ids->childs) > 0){
            $quantity = $ids->childs[0]->values['quantity'] * 2;
            $total = $ids->childs[0]->values['quantity'] * 2;
        }else {
            $total = 0;
            $quantity = 0;
        }

        // распределяем по талоном затраты
        $model = new Model_Magazine_Shop_Talon();
        $model->setDBDriver($driver);

        foreach ($shopWorkerTalonIDs->childs as $child){
            $child->setModel($model);

            if($quantity > $model->getQuantity()){
                $model->setQuantitySpent($model->getQuantity());
                $quantity -= $model->getQuantity();
            }else{
                $model->setQuantitySpent($quantity);
                $quantity = 0;
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);
        }

        // если есть лишние остатки
        if($quantity > 0){
            $model->setQuantitySpent($model->getQuantitySpent() + $quantity);
            Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);
        }

        return $total;
    }


    /**
     * Считаем остатки талона за заданный месяц
     * @param $shopWorkerID
     * @param $month
     * @param $year
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isSaveQuantity
     * @return bool|int
     */
    public static function calcQuantityTalonMonth($shopWorkerID, $month, $year, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                  $isSaveQuantity = TRUE)
    {
        if($shopWorkerID < 1 || $month < 1 || $month > 12 || $year < 1){
            return FALSE;
        }

        $ids = Request_Request::find('DB_Magazine_Shop_Talon',
            $sitePageData->shopMainID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_worker_id' => $shopWorkerID,
                    'month' => $month,
                    'year' => $year,
                )
            ), 1, TRUE
        );
        if(count($ids->childs) < 1){
            return FALSE;
        }

        $model = new Model_Magazine_Shop_Talon();
        $model->setDBDriver($driver);
        $ids->childs[0]->setModel($model);

        /** Считаем реализации спецпродуктов **/
        $params = Request_RequestParams::setParams(
            array(
                'sum_quantity' => TRUE,
                'shop_worker_id' => $shopWorkerID,
                'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_PRODUCT,
                'created_at_from_equally' => $model->getValidityFrom(),
                'created_at_to' => $model->getValidityTo().' 23:59:59',
            )
        );

        // расход
        $ids = Request_Request::find('DB_Magazine_Shop_Realization_Item',
            $sitePageData->shopID, $sitePageData, $driver, $params, 0, TRUE
        );

        if(count($ids->childs) > 0){
            $model->setQuantitySpent($ids->childs[0]->values['quantity'] * 2);
        }else{
            $model->setQuantitySpent(0);
        }

        if($isSaveQuantity) {
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopMainID);
        }

        return $model->getQuantitySpent();
    }

    /**
     * Считаем остатки талонов за заданный месяц
     * @param $month
     * @param $year
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function calcQuantityTalonAll($month, $year, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        if($month < 1 || $month > 12 || $year < 1){
            return FALSE;
        }

        $ids = Request_Request::findAll(
            'DB_Ab1_Shop_Worker', $sitePageData->shopID, $sitePageData, $driver, TRUE
        );

        foreach ($ids->childs as $child){
            self::calcQuantityTalonMonth($child->id, $month, $year, $sitePageData, $driver);
        }

        return TRUE;
    }

    /**
     * Загружаем талоны из 1С
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function loadXML($fileName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $xml = simplexml_load_file($fileName);

        $month = $xml->month;
        $year = $xml->year;
        $dateFrom = $xml->FromSale;

        // Опять хрень из 1С
        if(strlen($dateFrom) == 8){
            $dateFrom = substr($dateFrom, 0, 6).'20'.substr($dateFrom, 6);
        }
        $dateTo = $xml->ToSale;
        if(strlen($dateTo) == 8){
            $dateTo = substr($dateTo, 0, 6).'20'.substr($dateTo, 6);
        }

        // находим текущие талоны
        $shopTalonIDs = Request_Request::find('DB_Magazine_Shop_Talon',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'month' => $month,
                    'year' => $year,
                )
            ), 0, TRUE
        );
        $shopTalonIDs->runIndex(TRUE, 'shop_worker_id');

        // получаем список сотрудников
        $shopWorkerIDs = Request_Request::findBranch('DB_Ab1_Shop_Worker',
            array(), $sitePageData, $driver,Request_RequestParams::setParams(), 0, TRUE
        );
        $shopWorkerIDs->runIndex(TRUE, 'old_id');

        $model = new Model_Magazine_Shop_Talon();
        $model->setDBDriver($driver);

        foreach ($xml->Workers->Worker as $child){
            $worker = trim($child->Id);
            if($worker[0] == ''){
                continue;
            }
            if(key_exists($worker, $shopWorkerIDs->childs)){
                $worker = $shopWorkerIDs->childs[$worker]->id;
            }else{
                $modelWorker = new Model_Ab1_Shop_Worker();
                $modelWorker->setDBDriver($driver);
                $modelWorker->setName(trim($child->FIO));
                $modelWorker->setOldID($worker);
                $worker = Helpers_DB::saveDBObject($modelWorker, $sitePageData, $sitePageData->shopMainID);
            }

            // находим талоны данного сотрудника
            if(key_exists($worker, $shopTalonIDs->childs)){
                $shopTalonIDs->childs[$worker]->setModel($model);
                unset($shopTalonIDs->childs[$worker]);
            }else{
                $model->clear();
            }

            $model->setYear($year);
            $model->setMonth($month);
            $model->setValidityFrom($dateFrom);
            $model->setValidityTo($dateTo);
            $model->setMonth($month);
            $model->setShopWorkerID($worker);
            $model->setQuantity(trim($child->Quantity));

            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        // удаляем лишние
        $driver->deleteObjectIDs(
            $shopTalonIDs->getChildArrayID(), $sitePageData->userID,
            Model_Magazine_Shop_Talon::TABLE_NAME, array(), $sitePageData->shopID
        );

    }

    /**
     * Сохранить талоны в 1С
     * @param $month
     * @param $year
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isPHPOutput
     * @return string
     */
    public static function saveXML($month, $year, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isPHPOutput = FALSE)
    {
        // получаем список машина
        $shopTalonIDs = Request_Request::find('DB_Magazine_Shop_Talon',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'month' => $month,
                    'year' => $year,
                )
            ),
            0, true,
            array('shop_worker_id' => array('name', 'old_id'))
        );

        $data = '<?xml version="1.0" encoding="UTF-8"?><data>';
        $data .= '<month>' . $month . '</month>'
            . '<year>' . $year . '</year>';
        $data .= '<Workers>';
        foreach($shopTalonIDs->childs as $child){
            $data .= '<Worker>'
                . '<Id>'.htmlspecialchars($child->getElementValue('shop_worker_id', 'old_id'), ENT_XML1).'</Id>'
                . '<FIO>'.htmlspecialchars($child->getElementValue('shop_worker_id'), ENT_XML1).'</FIO>'
                . '<Quantity>'.$child->values['quantity_spent'].'</Quantity>'
                . '</Worker>';
        }
        $data .= '</Workers>';
        $data .= '</data>';

        if($isPHPOutput) {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment;filename="magazine_talon_spent.xml"');
            header('Cache-Control: max-age=0');

            echo $data;
            exit();
        }

        return $data;
    }

    /**
     * Сохранить талоны в 1С
     * @param $month
     * @param $year
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
    public static function save1СJSON($month, $year, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        // получаем список машина
        $shopTalonIDs = Request_Request::find(
            'DB_Magazine_Shop_Talon',
            0, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'month' => $month,
                    'year' => $year,
                )
            ),
            0, true,
            array('shop_worker_id' => array('name', 'iin'))
        );


        $monthDate = Helpers_DateTime::getMonthBeginStr($month, $year);
        $result = [
            'type' => 'milk_accrual',
            'ver' => 'mag',
            'mode' => 'new',
            'code' => $monthDate,
            'guid' => $monthDate,
            'guid_1c' => '',
            'date' => $monthDate,
            'bin_org' => $sitePageData->shop->getValue('bin'),
            'division_org' => '',
            'user_iin' => '',
            'month' => $monthDate,
            'comment' => 'автоматическая загрузка',
            'rows' => [],
        ];

        foreach($shopTalonIDs->childs as $child){
            $result['rows'][] = [
                'worker_iin' => $child->getElementValue('shop_worker_id', 'iin'),
                'number' => $child->values['quantity_spent'],
            ];
        }

        $integration = new Integration_Ab1_1C_Service();
        $integration->sendData($result);
    }
}
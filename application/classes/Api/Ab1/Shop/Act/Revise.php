<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Shop_Act_Revise  {
    /**
     * Получить акта сверки по реализации
     * @param $shopClientID
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return MyArray
     */
    public static function getVirtualShopActRevises($shopClientID, $dateFrom, $dateTo, SitePageData $sitePageData,
                                                    Model_Driver_DBBasicDriver $driver){
        $dateFrom1C = Api_Ab1_Basic::getDateFromBalance1С();
        if(strtotime($dateFrom) < strtotime($dateFrom1C)){
            $dateFrom = $dateFrom1C;
        }
        $dateFrom = Helpers_DateTime::minusSeconds($dateFrom, 1);

        $ids = new MyArray();

        if($shopClientID < 1){
            $ids->additionDatas = array(
                'receive' => 0,
                'expense' => 0,
                'receive_balance' => 0,
                'expense_balance' => 0,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            );
            return $ids;
        }

        /** Акт сверки из 1С **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            )
        );
        $shopActReviseItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Act_Revise_Item',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_id' => array('name'))
        );

        foreach ($shopActReviseItemIDs->childs as $child){
            $ids->childs[] = $child;
            $child->additionDatas = array(
                'table_id' => Model_Ab1_Shop_Act_Revise_Item::TABLE_ID,
                'receive' => 0,
                'expense' => 0,
                'receive_balance' => 0,
                'expense_balance' => 0,
                '_date' => $child->values['date'],
                '_number' => $child->values['old_id'],
            );

            if($child->values['is_receive'] == 1){
                $child->additionDatas['receive'] = $child->values['amount'];
            }else{
                $child->additionDatas['expense'] = $child->values['amount'];
            }
        }

        /** Оплаты через кассу **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
            )
        );
        $shopPaymentIDs = Request_Request::findBranch('DB_Ab1_Shop_Payment',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_id' => array('name'))
        );

        foreach ($shopPaymentIDs->childs as $child){
            $ids->childs[] = $child;
            $child->additionDatas = array(
                'table_id' => Model_Ab1_Shop_Payment::TABLE_ID,
                'receive' => $child->values['amount'],
                'expense' => 0,
                'receive_balance' => 0,
                'expense_balance' => 0,
                '_date' => $child->values['created_at'],
                '_number' => $child->values['number'],
            );

            $child->values['name'] = 'Приходный кассовый ордер';
            $child->values['old_id'] = $child->values['number'];
            $child->values['date'] = $child->values['created_at'];
        }

        /** Возврат через кассу **/
        $shopPaymentReturnIDs = Request_Request::findBranch('DB_Ab1_Shop_Payment_Return',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_id' => array('name'))
        );

        foreach ($shopPaymentReturnIDs->childs as $child){
            $ids->childs[] = $child;
            $child->additionDatas = array(
                'table_id' => Model_Ab1_Shop_Payment_Return::TABLE_ID,
                'receive' => 0,
                'expense' => $child->values['amount'],
                'receive_balance' => 0,
                'expense_balance' => 0,
                '_date' => $child->values['created_at'],
                '_number' => $child->values['number'],
            );

            $child->values['name'] = 'Возврат наличных';
            $child->values['old_id'] = $child->values['number'];
            $child->values['date'] = $child->values['created_at'];
        }
        $ids->childsSortBy(array('_date', '_number'), TRUE);

        /** Реализация **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'quantity_from' => 0,
                'is_charity' => FALSE,
                'sum_quantity' => true,
                'sum_amount' => true,
                'sum_amount_service' => true,
                'group_by' => array(
                    'exit_at_date',
                    'shop_id', 'shop_id.name',
                ),
            )
        );
        $shopCarIDs = Request_Request::findBranch('DB_Ab1_Shop_Car',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_id' => array('name'))
        );

        foreach ($shopCarIDs->childs as $child){
            if($child->values['amount'] > 0){
                $ids->childs[] = $child;
                $child->additionDatas = array(
                    'table_id' => Model_Ab1_Shop_Car::TABLE_ID,
                    'receive' => 0,
                    'expense' => $child->values['amount'],
                    'receive_balance' => 0,
                    'expense_balance' => 0,
                    '_date' => $child->values['exit_at_date'],
                    '_number' => '',
                );

                $child->values['name'] = 'Реализация ТМЗ';
                $child->values['old_id'] = '';
            }

            if($child->values['amount_service'] > 0){
                $tmp = new MyArray();
                $tmp->cloneObj($child);

                $ids->childs[] = $tmp;
                $child->additionDatas = array(
                    'table_id' => Model_Ab1_Shop_Car::TABLE_ID,
                    'receive' => 0,
                    'expense' => $child->values['amount_service'],
                    'receive_balance' => 0,
                    'expense_balance' => 0,
                    '_date' => $child->values['exit_at_date'],
                    '_number' => '',
                );

                $child->values['name'] = 'Реализация дополнительных услуг';
                $child->values['old_id'] = '';
            }
        }

        /** Реализация штучного товара **/
        $shopPieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_id' => array('name'))
        );

        foreach ($shopPieceIDs->childs as $child){
            if($child->values['amount'] > 0){
                $ids->childs[] = $child;
                $child->additionDatas = array(
                    'table_id' => Model_Ab1_Shop_Piece::TABLE_ID,
                    'receive' => 0,
                    'expense' => $child->values['amount'],
                    'receive_balance' => 0,
                    'expense_balance' => 0,
                    '_date' => $child->values['exit_at_date'],
                    '_number' => '',
                );

                $child->values['name'] = 'Реализация ЖБИ и БС';
                $child->values['old_id'] = '';
            }

            if($child->values['amount_service'] > 0){
                $tmp = new MyArray();
                $tmp->cloneObj($child);

                $ids->childs[] = $tmp;
                $child->additionDatas = array(
                    'table_id' => Model_Ab1_Shop_Piece::TABLE_ID,
                    'receive' => 0,
                    'expense' => $child->values['amount_service'],
                    'receive_balance' => 0,
                    'expense_balance' => 0,
                    '_date' => $child->values['exit_at_date'],
                    '_number' => '',
                );

                $child->values['name'] = 'Реализация дополнительных услуг';
                $child->values['old_id'] = '';
            }
        }

        /** Доставка реализации **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'exit_at_from' => $dateFrom,
                'exit_at_to' => $dateTo,
                'delivery_amount_from' => 0,
                'is_charity' => FALSE,
                'sum_delivery_amount' => true,
                'group_by' => array(
                    'exit_at_date',
                    'shop_id', 'shop_id.name',
                ),
            )
        );
        $shopCarIDs = Request_Request::findBranch('DB_Ab1_Shop_Car',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_id' => array('name'))
        );

        foreach ($shopCarIDs->childs as $child){
            $ids->childs[] = $child;
            $child->additionDatas = array(
                'table_id' => Model_Ab1_Shop_Car::TABLE_ID,
                'receive' => 0,
                'expense' => $child->values['delivery_amount'],
                'receive_balance' => 0,
                'expense_balance' => 0,
                '_date' => $child->values['exit_at_date'],
                '_number' => '',
            );

            $child->values['name'] = 'Доставка ТМЗ';
            $child->values['old_id'] = '';
        }

        /** Реализация штучного товара **/
        $shopPieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_id' => array('name'))
        );

        foreach ($shopPieceIDs->childs as $child){
            $ids->childs[] = $child;
            $child->additionDatas = array(
                'table_id' => Model_Ab1_Shop_Piece::TABLE_ID,
                'receive' => 0,
                'expense' => $child->values['delivery_amount'],
                'receive_balance' => 0,
                'expense_balance' => 0,
                '_date' => $child->values['exit_at_date'],
                '_number' => '',
            );

            $child->values['name'] = 'Доставка ЖБИ и БС';
            $child->values['old_id'] = '';
        }

        /***********************************/
        /** Считаем первоначальные данные **/
        /***********************************/
        $receive = 0;
        $expense = 0;

        // задаем первоначальный балансе клиенту из 1С
        $model = new Model_Ab1_Shop_Client();
        $model->setDBDriver($driver);
        Helpers_DB::getDBObject($model, $shopClientID, $sitePageData, $sitePageData->shopMainID);

        if($model->getAmount1C() >= 0.001){
            $receive = $model->getAmount1C();
        }else{
            $expense = $model->getAmount1C() * (-1);
        }

        /** Акт сверки из 1С **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'date_from' => $dateFrom1C,
                'date_to' => Helpers_DateTime::getDateFormatPHP($dateFrom).' 23:59:59',
                'sum_amount' => TRUE,
                'group_by' => array(
                    'is_receive'
                )
            )
        );
        $shopActReviseItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Act_Revise_Item',
            array(), $sitePageData, $driver, $params, 0, TRUE
        );
        foreach ($shopActReviseItemIDs->childs as $child){
            if($child->values['is_receive'] == 1){
                $receive += $child->values['amount'];
            }else{
                $expense += $child->values['amount'];
            }
        }

        /** Оплаты через кассу **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'created_at_from' => $dateFrom1C,
                'created_at_to' => Helpers_DateTime::getDateFormatPHP($dateFrom).' 23:59:59',
                'sum_amount' => TRUE,
            )
        );
        $shopPaymentIDs = Request_Request::findBranch('DB_Ab1_Shop_Payment',
            array(), $sitePageData, $driver, $params, 0, TRUE
        );

        foreach ($shopPaymentIDs->childs as $child){
            $receive += $child->values['amount'];
        }

        /** Возвраты через кассу **/
        $shopPaymentReturnIDs = Request_Request::findBranch('DB_Ab1_Shop_Payment_Return',
            array(), $sitePageData, $driver, $params, 0, TRUE
        );

        foreach ($shopPaymentReturnIDs->childs as $child){
            $expense += $child->values['amount'];
        }

        /** Реализация = Доставка **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'exit_at_from' => $dateFrom1C,
                'exit_at_to' => Helpers_DateTime::getDateFormatPHP($dateFrom).' 23:59:59',
                'is_charity' => FALSE,
                'sum_amount' => true,
                'sum_amount_service' => true,
                'sum_delivery_amount' => true,
            )
        );
        $shopCarIDs = Request_Request::findBranch('DB_Ab1_Shop_Car',
            array(), $sitePageData, $driver, $params, 0, TRUE
        );

        foreach ($shopCarIDs->childs as $child){
            $expense += $child->values['amount'] + $child->values['amount_service'] + $child->values['delivery_amount'];;
        }

        /** Реализация штучного товара + Доставка **/
        $shopPieceIDs = Request_Request::findBranch('DB_Ab1_Shop_Piece',
            array(), $sitePageData, $driver, $params, 0, TRUE
        );

        foreach ($shopPieceIDs->childs as $child){
            $expense += $child->values['amount'] + $child->values['amount_service'] + $child->values['delivery_amount'];;
        }

        if($receive > $expense){
            $receive -= $expense;
            $expense = 0;
        }else{
            $expense -= $receive;
            $receive = 0;
        }

        $ids->additionDatas = array(
            'receive' => $receive,
            'expense' => $expense,
            'receive_balance' => 0,
            'expense_balance' => 0,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
        );

        uasort($ids->childs, function ($x, $y) {
            $result = strcasecmp($x->additionDatas['_date'], $y->additionDatas['_date']);
            return $result;
        });

        /** Считаем балансы **/
        foreach ($ids->childs as $child){
            $receive = $receive + $child->additionDatas['receive'];
            $child->additionDatas['receive_balance'] = $receive;

            $expense = $expense + $child->additionDatas['expense'];
            $child->additionDatas['expense_balance'] = $expense;
        }

        $ids->additionDatas['receive_balance'] = $receive;
        $ids->additionDatas['expense_balance'] = $expense;

        return $ids;
    }

    /**
     * Получить акт сверки
     * @param $shopClientID
     * @param $dateFrom
     * @param $dateTo
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isAddVirtualInvoice
     * @return MyArray
     */
    public static function getShopActRevises($shopClientID, $dateFrom, $dateTo, SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver, $isAddVirtualInvoice = false){
        $dateFrom1C = Api_Ab1_Basic::getDateFromBalance1С();
        if(strtotime($dateFrom) < strtotime($dateFrom1C)){
            $dateFrom = $dateFrom1C;
        }
        $dateFrom = Helpers_DateTime::minusSeconds($dateFrom, 1);

        $ids = new MyArray();

        if($shopClientID < 1){
            $ids->additionDatas = array(
                'receive' => 0,
                'expense' => 0,
                'receive_balance' => 0,
                'expense_balance' => 0,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            );
            return $ids;
        }

        /** Акт сверки из 1С **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            )
        );
        $shopActReviseItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Act_Revise_Item',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_id' => array('name'))
        );

        foreach ($shopActReviseItemIDs->childs as $child){
            $ids->childs[] = $child;
            $child->additionDatas = array(
                'table_id' => Model_Ab1_Shop_Act_Revise_Item::TABLE_ID,
                'receive' => 0,
                'expense' => 0,
                'receive_balance' => 0,
                'expense_balance' => 0,
                '_date' => Helpers_DateTime::getDateFormatPHP($child->values['date']),
                '_number' => $child->values['old_id'],
                'weight' => 0,
            );

            if($child->values['is_receive'] == 1){
                $child->additionDatas['receive'] = $child->values['amount'];
            }else{
                $child->additionDatas['expense'] = $child->values['amount'];
            }
        }

        /** Накладные **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            )
        );
        $shopInvoiceIDs = Request_Request::findBranch('DB_Ab1_Shop_Invoice',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_id' => array('name'))
        );

        foreach ($shopInvoiceIDs->childs as $child){
            $ids->childs[] = $child;
            $child->additionDatas = array(
                'table_id' => Model_Ab1_Shop_Invoice::TABLE_ID,
                'receive' => 0,
                'expense' => $child->values['amount'],
                'receive_balance' => 0,
                'expense_balance' => 0,
                '_date' => Helpers_DateTime::getDateFormatPHP($child->values['date']),
                '_number' => $child->values['number'],
                'weight' => 8,
            );

            $child->values['name'] = 'Реализация ТМЗ';
            $child->values['old_id'] = $child->values['number'];
        }

        /** Акты выполненных работ **/
        $shopActServiceIDs = Request_Request::findBranch('DB_Ab1_Shop_Act_Service',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_id' => array('name'))
        );

        foreach ($shopActServiceIDs->childs as $child){
            $ids->childs[] = $child;
            $child->additionDatas = array(
                'table_id' => Model_Ab1_Shop_Act_Service::TABLE_ID,
                'receive' => 0,
                'expense' => $child->values['amount'],
                'receive_balance' => 0,
                'expense_balance' => 0,
                '_date' => Helpers_DateTime::getDateFormatPHP($child->values['date']),
                '_number' => $child->values['number'],
                'weight' => 9,
            );

            $child->values['name'] = 'Реализация услуг';
            $child->values['old_id'] = $child->values['number'];
        }

        /** Оплаты через кассу **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'created_at_from' => $dateFrom,
                'created_at_to' => $dateTo,
            )
        );
        $shopPaymentIDs = Request_Request::findBranch('DB_Ab1_Shop_Payment',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_id' => array('name'))
        );

        foreach ($shopPaymentIDs->childs as $child){
            $ids->childs[] = $child;
            $child->additionDatas = array(
                'table_id' => Model_Ab1_Shop_Payment::TABLE_ID,
                'receive' => $child->values['amount'],
                'expense' => 0,
                'receive_balance' => 0,
                'expense_balance' => 0,
                '_date' => Helpers_DateTime::getDateFormatPHP($child->values['created_at']),
                '_number' => $child->values['number'],
                'weight' => 0,
            );

            $child->values['name'] = 'Приходный кассовый ордер';
            $child->values['old_id'] = $child->values['number'];
            $child->values['date'] = $child->values['created_at'];
        }

        /** Возврат через кассу **/
        $shopPaymentReturnIDs = Request_Request::findBranch('DB_Ab1_Shop_Payment_Return',
            array(), $sitePageData, $driver, $params, 0, TRUE,
            array('shop_id' => array('name'))
        );

        foreach ($shopPaymentReturnIDs->childs as $child){
            $ids->childs[] = $child;
            $child->additionDatas = array(
                'table_id' => Model_Ab1_Shop_Payment_Return::TABLE_ID,
                'receive' => 0,
                'expense' => $child->values['amount'],
                'receive_balance' => 0,
                'expense_balance' => 0,
                '_date' => Helpers_DateTime::getDateFormatPHP($child->values['created_at']),
                '_number' => $child->values['number'],
                'weight' => 0,
            );

            $child->values['name'] = 'Возврат наличных';
            $child->values['old_id'] = $child->values['number'];
            $child->values['date'] = $child->values['created_at'];
        }

        // виртуальные накладные
        if($isAddVirtualInvoice){
            $virtualInvoices = Api_Ab1_Shop_Invoice::getVirtualInvoices(
                $dateFrom, $dateTo, $sitePageData, $driver,
                Request_RequestParams::setParams(
                    array(
                        'shop_client_id' => $shopClientID,
                    )
                )
            );

            foreach ($virtualInvoices->childs as $child){
                $ids->childs[] = $child;
                $date = Helpers_DateTime::getDateFormatPHP($child->values['date']);
                $child->additionDatas = array(
                    'table_id' => 'virtual_'.Model_Ab1_Shop_Invoice::TABLE_ID,
                    'receive' => 0,
                    'expense' => $child->values['total'],
                    'receive_balance' => 0,
                    'expense_balance' => 0,
                    '_date' => $date,
                    '_number' => $child->values['date'],
                    'weight' => 0,
                    'params' => array(
                        'date_from' => $date . ' 06:00:00',
                        'date_to' => Helpers_DateTime::plusDays($date . ' 06:00:00', 1),
                        'is_delivery' => $child->values['is_delivery'],
                        'product_type_id' => $child->values['product_type_id'],
                        'shop_client_attorney_id' => $child->values['shop_client_attorney_id'],
                        'shop_client_contract_id' => $child->values['shop_client_contract_id'],
                        'shop_client_id' => $child->values['shop_client_id'],
                        'shop_branch_id' => $child->values['shop_id'],
                    ),
                );

                $child->values['name'] = 'Исходная';
                $child->values['old_id'] = 'накладная';
                $child->values['created_at'] = $child->values['date'];
            }

            // Получение виртуальные актов выполненных работ
            $params = Request_RequestParams::setParams(
                array(
                    'shop_client_id' => Request_RequestParams::getParam('shop_client_id'),
                )
            );
            $virtualActServices = Api_Ab1_Shop_Act_Service::getVirtualActServices(
                $dateFrom, $dateTo, $sitePageData, $driver, $params, $params
            );

            foreach ($virtualActServices->childs as $child){
                $ids->childs[] = $child;
                $date = Helpers_DateTime::getDateFormatPHP($child->values['date']);
                $child->additionDatas = array(
                    'table_id' => 'virtual_'.Model_Ab1_Shop_Act_Service::TABLE_ID,
                    'receive' => 0,
                    'expense' => $child->values['amount'],
                    'receive_balance' => 0,
                    'expense_balance' => 0,
                    '_date' => $date,
                    '_number' => $child->values['date'],
                    'weight' => 0,
                    'params' => array(
                        'date_from' => $date . ' 06:00:00',
                        'date_to' => Helpers_DateTime::plusDays($date . ' 06:00:00', 1),
                        'shop_client_attorney_id' => $child->values['shop_client_attorney_id'],
                        'shop_client_contract_id' => $child->values['shop_client_contract_id'],
                        'shop_client_id' => $child->values['shop_client_id'],
                        'shop_branch_id' => $child->values['shop_id'],
                    )
                );

                $child->values['name'] = 'Исходный';
                $child->values['old_id'] = 'акт выполненных работ';
                $child->values['created_at'] = $child->values['date'];
            }
        }

        /***********************************/
        /** Считаем первоначальные данные **/
        /***********************************/
        $receive = 0;
        $expense = 0;

        // задаем первоначальный балансе клиенту из 1С
        $model = new Model_Ab1_Shop_Client();
        $model->setDBDriver($driver);
        Helpers_DB::getDBObject($model, $shopClientID, $sitePageData, $sitePageData->shopMainID);

        if($model->getAmount1C() >= 0.001){
            $receive = $model->getAmount1C();
        }else{
            $expense = $model->getAmount1C() * (-1);
        }

        /** Акт сверки из 1С **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'date_from' => $dateFrom1C,
                'date_to' => Helpers_DateTime::getDateFormatPHP($dateFrom).' 23:59:59',
                'sum_amount' => TRUE,
                'group_by' => array(
                    'is_receive'
                )
            )
        );
        $shopActReviseItemIDs = Request_Request::findBranch('DB_Ab1_Shop_Act_Revise_Item',
            array(), $sitePageData, $driver, $params, 0, TRUE
        );
        foreach ($shopActReviseItemIDs->childs as $child){
            if($child->values['is_receive'] == 1){
                $receive += $child->values['amount'];
            }else{
                $expense += $child->values['amount'];
            }
        }

        /** Накладные **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'date_from' => $dateFrom1C,
                'date_to' => Helpers_DateTime::getDateFormatPHP($dateFrom).' 23:59:59',
                'sum_amount' => TRUE,
            )
        );
        $shopInvoiceIDs = Request_Request::findBranch('DB_Ab1_Shop_Invoice',
            array(), $sitePageData, $driver, $params, 0, TRUE
        );

        foreach ($shopInvoiceIDs->childs as $child){
            $expense += $child->values['amount'];
        }

        /** Акты выполненных работ **/
        $shopActServiceIDs = Request_Request::findBranch('DB_Ab1_Shop_Act_Service',
            array(), $sitePageData, $driver, $params, 0, TRUE
        );

        foreach ($shopActServiceIDs->childs as $child){
            $expense += $child->values['amount'];
        }

        /** Оплаты через кассу **/
        $params = Request_RequestParams::setParams(
            array(
                'shop_client_id' => $shopClientID,
                'created_at_from' => $dateFrom1C,
                'created_at_to' => Helpers_DateTime::getDateFormatPHP($dateFrom).' 23:59:59',
                'sum_amount' => TRUE,
            )
        );
        $shopPaymentIDs = Request_Request::findBranch('DB_Ab1_Shop_Payment',
            array(), $sitePageData, $driver, $params, 0, TRUE
        );

        foreach ($shopPaymentIDs->childs as $child){
            $receive += $child->values['amount'];
        }

        /** Возвраты через кассу **/
        $shopPaymentReturnIDs = Request_Request::findBranch('DB_Ab1_Shop_Payment_Return',
            array(), $sitePageData, $driver, $params, 0, TRUE
        );

        foreach ($shopPaymentReturnIDs->childs as $child){
            $expense += $child->values['amount'];
        }

        if($receive > $expense){
            $receive -= $expense;
            $expense = 0;
        }else{
            $expense -= $receive;
            $receive = 0;
        }

        $ids->additionDatas = array(
            'receive' => $receive,
            'expense' => $expense,
            'receive_balance' => 0,
            'expense_balance' => 0,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
        );

        uasort($ids->childs, function ($x, $y) {
            $result = strcasecmp($x->additionDatas['_date'], $y->additionDatas['_date']);
            if($result == 0){
                $result = strcasecmp($x->additionDatas['weight'], $y->additionDatas['weight']);
                if($result == 0){
                    $result = strcasecmp($x->values['created_at'], $y->values['created_at']);
                }
            }
            return $result;
        });

        /** Считаем балансы **/
        foreach ($ids->childs as $child){
            $receive = $receive + $child->additionDatas['receive'];
            $child->additionDatas['receive_balance'] = $receive;

            $expense = $expense + $child->additionDatas['expense'];
            $child->additionDatas['expense_balance'] = $expense;
        }

        $ids->additionDatas['receive_balance'] = $receive;
        $ids->additionDatas['expense_balance'] = $expense;

        return $ids;
    }

    /**
     * Загрузить актов сверок из XML
     * @param $fileName
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function loadXML($fileName, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopID = $sitePageData->shopRootID;
        if($shopID < 1){
            $shopID = $sitePageData->shopMainID;
        }

        $xml = simplexml_load_file($fileName);

        $model = new Model_Ab1_Shop_Act_Revise();
        $model->setDBDriver($driver);

        $modelItem = new Model_Ab1_Shop_Act_Revise_Item();
        $modelItem->setDBDriver($driver);

        $modelClient = new Model_Ab1_Shop_Client();
        $modelClient->setDBDriver($driver);

        $clients = array();
        foreach($xml->document as $document) {
            // Опять хрень из 1С
            $date = $document->date;
            if(strlen($date) == 8){
                $date = substr($date, 0, 6).'20'.substr($date, 6);
            }

            // находим акта сверки по номеру c 1C
            $params = Request_RequestParams::setParams(
                array(
                    'is_public_ignore' => TRUE,
                    'is_delete_ignore' => TRUE,
                    'old_id_full' => trim($document->number),
                    'name_full' => trim($document->name),
                    'date#year' => Helpers_DateTime::getYear($date),
                )
            );
            $shopActReviseIDs = Request_Request::find('DB_Ab1_Shop_Act_Revise',
                0, $sitePageData, $driver, $params, 1, TRUE
            );

            if(count($shopActReviseIDs->childs) < 1){
                $model->clear();
                $shopActReviseItemIDs = new MyArray();
            }else{
                $shopActReviseIDs->childs[0]->setModel($model);

                // находим акта сверки по номеру c 1C
                $params = Request_RequestParams::setParams(
                    array(
                        'shop_act_revise_id' => $model->id,
                        'is_public_ignore' => TRUE,
                        'is_delete_ignore' => TRUE,
                        'sort_by' => array('id' => 'asc')
                    )
                );
                $shopActReviseItemIDs = Request_Request::find('DB_Ab1_Shop_Act_Revise_Item',
                    0, $sitePageData, $driver, $params, 0, TRUE
                );
            }

            $model->setName(trim($document->name));
            $model->setActReviseTypeID(trim($document->type));
            $model->setOldID(trim($document->number));

            $model->setIsDelete(trim($document->isDelete));
            if($modelItem->getIsDelete()){
                $modelItem->setDeleteUserID($sitePageData->userID);
                $modelItem->setDeletedAt(date('Y-m-d H:i:s'));
            }

            $model->setDate($date);

            Helpers_DB::saveDBObject($model, $sitePageData, $shopID);

            $records = $document->records->record;
            if(!empty($records)) {
                $total = 0;
                foreach ($records as $item) {
                    // находим клиентов в этим ID c 1C
                    $params = Request_RequestParams::setParams(
                        array(
                            'is_public_ignore' => TRUE,
                            'old_id_full' => $item->contractorId,
                        )
                    );
                    $shopClientIDs = Request_Request::find('DB_Ab1_Shop_Client',
                        0, $sitePageData, $driver, $params, 1, TRUE
                    );

                    if (count($shopClientIDs->childs) < 1) {
                        $modelClient->clear();

                        $modelClient->setName1C(trim($item->Company));
                        $modelClient->setAddress($item->address);
                        $modelClient->setBIN($item->BIN);
                        //$modelClient->setAccount($item->account);
                        $modelClient->setOldID($item->contractorId);
                        Helpers_DB::saveDBObject($modelClient, $sitePageData, $shopID);
                    } else {
                        $shopClientIDs->childs[0]->setModel($modelClient);
                    }

                    $shopActReviseItemIDs->childShiftSetModel(
                        $modelItem, 0, 0, false,
                        array('shop_client_id' => $modelClient->id, 'is_revise' => Func::boolToInt($item->isReceive))
                    );
                    $modelItem->setShopActReviseID($model->id);

                    $modelItem->setName($model->getName());
                    $modelItem->setActReviseTypeID($model->getActReviseTypeID());
                    $modelItem->setOldID($model->getOldID());
                    $modelItem->setDate($model->getDate());

                    $modelItem->setAmount(trim($item->amount));
                    $modelItem->setIsReceive($item->isReceive);
                    $modelItem->setIsCache($item->isCash);

                    $modelItem->setIsDelete($document->isDelete);
                    if ($modelItem->getIsDelete()) {
                        $modelItem->setDeleteUserID($sitePageData->userID);
                        $modelItem->setDeletedAt(date('Y-m-d H:i:s'));
                    }
                    $modelItem->setShopClientID($modelClient->id);

                    if(strtotime($modelItem->getDate()) >= strtotime('2020-12-31')) {
                        // Добавляем фиксации цены продукции на баланс
                        if ($modelItem->getShopClientBalanceDayID() < 1 && $modelItem->getIsReceive()) {
                            $modelItem->setShopClientBalanceDayID(
                                Api_Ab1_Shop_Client_Balance_Day::setClientBalanceDay(
                                    $modelItem->getShopClientID(), $modelItem->getDate(), $sitePageData, $driver
                                )
                            );
                        }

                        if (!$modelItem->getIsReceive()) {
                            if($modelItem->id < 1) {
                                Helpers_DB::saveDBObject($modelItem, $sitePageData, $shopID);
                            }

                            // Удаляем списывания фиксированных балансов
                            if ($modelItem->getIsDelete()) {
                                Api_Ab1_Shop_Client_Balance_Day::deleteBlockActReviseClientBalanceDay(
                                    $modelItem->id, $sitePageData, $driver
                                );
                            } else {
                                // Списываем сумму с баланса фиксированных цен
                                Api_Ab1_Shop_Client_Balance_Day::blockActReviseClientBalanceDay(
                                    $modelItem->getShopClientID(), $modelItem->id, $modelItem->getAmount(), $sitePageData, $driver
                                );
                            }
                        }
                    }

                    Helpers_DB::saveDBObject($modelItem, $sitePageData, $shopID);

                    $total += $modelItem->getAmount();

                    $clients[$modelItem->getShopClientID()] = $modelItem->getShopClientID();
                }
                $model->setAmount($total);
            }

            // удаляем лишние
            $driver->deleteObjectIDs(
                $shopActReviseItemIDs->getChildArrayID(), $sitePageData->userID,
                Model_Ab1_Shop_Act_Revise_Item::TABLE_NAME, array(), 0
            );

            // Удаляем списывания фиксированных балансов
            foreach ($shopActReviseItemIDs->childs as $child){
                Api_Ab1_Shop_Client_Balance_Day::deleteBlockActReviseClientBalanceDay($child->id, $sitePageData, $driver);
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $shopID);
        }

        // пересчитываем актов сверок клиентов
        Api_Ab1_Shop_Client::calcBalancesActRevive($clients, $sitePageData, $driver);
    }
}

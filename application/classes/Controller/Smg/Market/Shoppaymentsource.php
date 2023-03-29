<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopPaymentSource extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Payment_Source';
        $this->controllerName = 'shoppaymentsource';
        $this->tableID = Model_AutoPart_Shop_Payment_Source::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Payment_Source::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }
    
    public function action_index()
    {
        $this->_sitePageData->url = '/market/shoppaymentsource/index';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Company');
        $this->_requestListDB('DB_AutoPart_Shop_Bank_Account', NULL, 0, [], ['shop_company_id' => ['name']]);
    
        parent::_actionIndex(
            array(
                'shop_source_id' => ['name'],
                'shop_company_id' => ['name'],
                'shop_bank_account_id' => ['name'],
            )
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shoppaymentsource/new';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Company');
        $this->_requestListDB('DB_AutoPart_Shop_Bank_Account', NULL, 0, [], ['shop_company_id' => ['name']]);

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shoppaymentsource/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Payment_Source();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Source', $model->getShopSourceID());
        $this->_requestListDB('DB_AutoPart_Shop_Company', $model->getShopCompanyID());
        $this->_requestListDB('DB_AutoPart_Shop_Bank_Account', $model->getShopBankAccountID(), 0, [], ['shop_company_id' => ['name']]);

        View_View::find(
            DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
            '_shop/bill/item/list/payment-source', '_shop/bill/item/one/payment-source',
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_payment_source_id' => $id,
                ]
            ),
            [
                'shop_bill_id' => ['old_id'],
                'shop_product_id' => array('image_path', 'options', 'integrations',),
            ]
        );

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

    public function action_load_kaspi()
    {
        $this->_sitePageData->url = '/market/shoppaymentsource/load_kaspi';

        if(!key_exists('file', $_FILES)){
            throw new HTTP_Exception_500('File not load.');
        }

        $shopBankAccountID = Request_RequestParams::getParamInt('shop_bank_account_id');
        if($shopBankAccountID < 1){
            throw new HTTP_Exception_500('Bank account not found.');
        }

        $shopCompanyID = Request_RequestParams::getParamInt('shop_company_id');
        if($shopCompanyID < 1){
            throw new HTTP_Exception_500('Company not found.');
        }

        $firstRow = Request_RequestParams::getParamInt('first_row');
        $data = Helpers_Excel::loadFileInArray($_FILES['file']['tmp_name'], $firstRow);

        $params = Request_RequestParams::setParams(
            [
                'shop_company_id' => $shopCompanyID,
                'shop_bank_account_id' => $shopBankAccountID,
                'shop_source_id' => Model_AutoPart_Shop_Source::SHOP_SOURCE_KASPI_KZ,
            ]
        );
        $params2 = $params;

        $model = new Model_AutoPart_Shop_Payment_Source();
        $model->setDBDriver($this->_driverDB);

        foreach ($data as $child){
            if(mb_strpos($child[9], 'Продажи с Kaspi.kz за') !== false){
                $amount = Request_RequestParams::strToFloat($child[4]);
            }elseif(mb_strpos($child[9], 'Возврат продаж с Kaspi.kz за') !== false){
                $amount = Request_RequestParams::strToFloat($child[3]) * -1;
            }else{
                continue;
            }

            // проверяем есть ли уже такой документ
            $params['number_full'] = $child[1];
            $payment = Request_Request::findOne(
                DB_AutoPart_Shop_Payment_Source::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB, $params
            );
            if($payment != null){
                $payment->setModel($model);
                $model->setAmount($amount);
                Helpers_DB::saveDBObject($model, $this->_sitePageData);

                continue;
            }

            $date = Helpers_DateTime::getDateFormatPHP(
                trim(Func::mb_str_replace('/', '.', Func::mb_str_replace('Продажи с Kaspi.kz за', '', $child[9])))
            );

            // проверяем есть ли такой документ загруженный вручную
            $params2['date'] = $date;
            $params2['amount'] = $amount;
            $payment = Request_Request::findOne(
                DB_AutoPart_Shop_Payment_Source::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB, $params2
            );

            if($payment != null){
                $payment->setModel($model);
            }else{
                $model->clear();

                $model->setShopCompanyID($shopCompanyID);
                $model->setShopSourceID(Model_AutoPart_Shop_Source::SHOP_SOURCE_KASPI_KZ);
                $model->setShopBankAccountID($shopBankAccountID);
                $model->setDate($date);
            }
            $model->setIsLoadFile(true);

            $model->setNumber($child[1]);
            $model->setCreatedAt($child[2]);
            $model->setAmount($amount);
            $model->setName($child[5]);
            $model->setIIK($child[6]);
            $model->setKPN($child[8]);
            $model->setText($child[9]);

            Helpers_DB::saveDBObject($model, $this->_sitePageData);
        }

        $this->redirect('/market/shoppaymentsource/index');
    }

    public function action_check()
    {
        $this->_sitePageData->url = '/market/shoppaymentsource/check';

        $shopPaymentSourceID = Request_RequestParams::getParamInt('shop_payment_source_id');
        if($shopPaymentSourceID < 1){
            $isCheck = false;
        }else{
            $isCheck = null;
        }

        $ids = Request_Request::find(
            DB_AutoPart_Shop_Payment_Source::NAME, $this->_sitePageData->shopID,
            $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'shop_source_id' => Model_AutoPart_Shop_Source::SHOP_SOURCE_KASPI_KZ,
                    'id' => $shopPaymentSourceID,
                    'is_check' => $isCheck,
                    'amount_from' => 0,
                ]
            ),
            0, true
        );

        $model = new Model_AutoPart_Shop_Payment_Source();
        $model->setDBDriver($this->_driverDB);

        foreach ($ids->childs as $child){
            $child->setModel($model);

            $billItems = Request_Request::find(
                DB_AutoPart_Shop_Bill_Item::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    [
                        'shop_bill_id.shop_bill_status_source_id' => [
                            Model_AutoPart_Shop_Bill_Status_Source::STATUS_COMPLETED,
                            Model_AutoPart_Shop_Bill_Status_Source::STATUS_RETURN,
                        ],
                        'bank_date' => $model->getDate(),
                    ]
                ),
                0, true
            );

            $this->_driverDB->updateObjects(
                Model_AutoPart_Shop_Bill_Item::TABLE_NAME, $billItems->getChildArrayID(), ['shop_payment_source_id' => $model->id]
            );

            $amount = 0;
            $quantity = 0;
            $commission = 0;
            foreach ($billItems->childs as $billItem){
                $amount += $billItem->values['amount'];
                $quantity += $billItem->values['quantity'];
                $commission += round($billItem->values['amount'] / 100 * $billItem->values['commission_source'], 2);
            }

            $model->setAmountBillItems($amount);
            $model->setQuantityBillItems($quantity);
            $model->setCommissionSource($commission);
            $model->setIsCheck($model->getAmount() == $model->getAmountBillItems());
            Helpers_DB::saveDBObject($model, $this->_sitePageData);
        }

        $this->redirect('/market/shoppaymentsource/index');
    }
}

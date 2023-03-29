<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopExpense extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Expense';
        $this->controllerName = 'shopexpense';
        $this->tableID = Model_AutoPart_Shop_Expense::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Expense::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/market/shopexpense/index';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Company');
        $this->_requestListDB('DB_AutoPart_Shop_Bank_Account', NULL, 0, [], ['shop_company_id' => ['name']]);
        $this->_requestListDB('DB_AutoPart_Shop_Expense_Type');

        parent::_actionIndex(
            array(
                'shop_source_id' => ['name'],
                'shop_company_id' => ['name'],
                'shop_bank_account_id' => ['name'],
                'shop_expense_type_id' => ['name'],
            )
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shopexpense/new';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Company');
        $this->_requestListDB('DB_AutoPart_Shop_Bank_Account', NULL, 0, [], ['shop_company_id' => ['name']]);
        $this->_requestListDB('DB_AutoPart_Shop_Expense_Type');

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shopexpense/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Expense();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Source', $model->getShopSourceID());
        $this->_requestListDB('DB_AutoPart_Shop_Company', $model->getShopCompanyID());
        $this->_requestListDB('DB_AutoPart_Shop_Bank_Account', $model->getShopBankAccountID(), 0, [], ['shop_company_id' => ['name']]);
        $this->_requestListDB('DB_AutoPart_Shop_Expense_Type', $model->getShopExpenseTypeID());

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

    public function action_load_kaspi()
    {
        $this->_sitePageData->url = '/market/shopexpense/load_kaspi';

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

        $model = new Model_AutoPart_Shop_Expense();
        $model->setDBDriver($this->_driverDB);

        foreach ($data as $child){
            // коммисия источника
            if((mb_strpos($child[5], 'ТОО "Kaspi Магазин"') !== false
                    || mb_strpos($child[5], 'ТОО Kaspi Pay') !== false)
                && (mb_strpos($child[9], 'Оплата за информационно-технологические услуги. Без НДС за') !== false
                    || mb_strpos($child[9], 'Оплата услуги по обработке данных. В том числе НДС за') !== false
                    || mb_strpos($child[9], 'Возврат оплаты за информационно-технологические услуги. Без НДС за') !== false
                    || mb_strpos($child[9], 'Возврат оплаты за услуги по обработке данных. В том числе НДС за') !== false)){
                continue;
            }

            // Плата за продажи
            if(mb_strpos($child[9], 'Продажи с Kaspi.kz за') !== false
                || mb_strpos($child[9], 'Возврат продаж с Kaspi.kz за') !== false){
                continue;
            }

            // переводы денег курьером на оплату товара
            if(mb_strpos($child[9], 'Прочие безвозмездные переводы денег на карту Kaspi Gold') !== false){
                $n = mb_strpos($child[5], 'ИИН/БИН');
                if($n !== false) {
                    $iin = trim(mb_substr($child[5], $n + mb_strlen('ИИН/БИН')));
                    if (strlen($iin) == 12) {
                        $courier = Request_Request::findOneByField(
                            DB_AutoPart_Shop_Courier::NAME, 'iin_full', $iin, $this->_sitePageData->shopID,
                            $this->_sitePageData, $this->_driverDB
                        );
                        if ($courier != null) {
                            continue;
                        }
                    }
                }
            }

            // убираем весь приход
            $amount = Request_RequestParams::strToFloat($child[3]);
            if($amount < 0.001){
                $amount = Request_RequestParams::strToFloat($child[4]) * -1;
            }

            // проверяем есть ли уже такой документ
            $params['number_full'] = $child[1];
            $payment = Request_Request::findOne(
                DB_AutoPart_Shop_Expense::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB, $params
            );
            if($payment != null){
                $payment->setModel($model);
                $model->setAmount($amount);
                Helpers_DB::saveDBObject($model, $this->_sitePageData);

                continue;
            }

            $date = Helpers_DateTime::getDateFormatPHP($amount);

            // вид расхода
            $expenseType = Request_Request::findIDByField(
                DB_AutoPart_Shop_Expense_Type::NAME, 'kpn_full',  $child[8], $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB
            );

            // проверяем есть ли такой документ загруженный вручную
            if($expenseType > 0) {
                $params2['date'] = $date;
                $params2['amount'] = $child[3];
                $params2['shop_expense_type_id'] = $expenseType;
                $payment = Request_Request::findOne(
                    DB_AutoPart_Shop_Expense::NAME, $this->_sitePageData->shopID,
                    $this->_sitePageData, $this->_driverDB, $params2
                );
            }else{
                $payment = null;
            }

            if($payment != null){
                $payment->setModel($model);
            }else{
                $model->clear();

                $model->setShopExpenseTypeID($expenseType);
                $model->setShopCompanyID($shopCompanyID);
                $model->setShopSourceID(Model_AutoPart_Shop_Source::SHOP_SOURCE_KASPI_KZ);
                $model->setShopBankAccountID($shopBankAccountID);
                $model->setDate($date);
            }
            $model->setIsLoadFile(true);

            $model->setNumber($child[1]);
            $model->setCreatedAt($child[2]);
            $model->setAmount($child[3]);
            $model->setName($child[5]);
            $model->setIIK($child[6]);
            $model->setKPN($child[8]);
            $model->setText($child[9]);

            Helpers_DB::saveDBObject($model, $this->_sitePageData);
        }

        $this->redirect('/market/shopexpense/index');
    }
}
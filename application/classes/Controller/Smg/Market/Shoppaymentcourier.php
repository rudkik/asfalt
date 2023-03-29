<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_ShopPaymentCourier extends Controller_Smg_Market_Basic {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_AutoPart_Shop_Payment_Courier';
        $this->controllerName = 'shoppaymentcourier';
        $this->tableID = Model_AutoPart_Shop_Payment_Courier::TABLE_ID;
        $this->tableName = Model_AutoPart_Shop_Payment_Courier::TABLE_NAME;

        parent::__construct($request, $response);

        $this->shopID = $this->_sitePageData->shopID;
        $this->editAndNewBasicTemplate = '';
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/market/shoppaymentcourier/index';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Courier');
        $this->_requestListDB('DB_AutoPart_Shop_Company');
        $this->_requestListDB('DB_AutoPart_Shop_Bank_Account', NULL, 0, [], ['shop_company_id' => ['name']]);

        parent::_actionIndex(
            array(
                'shop_source_id' => ['name'],
                'shop_courier_id' => ['name'],
                'shop_company_id' => ['name'],
                'shop_bank_account_id' => ['name'],
            )
        );
    }

    public function action_new(){
        $this->_sitePageData->url = '/market/shoppaymentcourier/new';

        $this->_requestListDB('DB_AutoPart_Shop_Source');
        $this->_requestListDB('DB_AutoPart_Shop_Courier');
        $this->_requestListDB('DB_AutoPart_Shop_Company');
        $this->_requestListDB('DB_AutoPart_Shop_Bank_Account', NULL, 0, [], ['shop_company_id' => ['name']]);

        parent::action_new();
    }

    public function action_edit(){
        $this->_sitePageData->url = '/market/shoppaymentcourier/edit';

        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_AutoPart_Shop_Payment_Courier();
        if (! $this->dublicateObjectLanguage($model, $id, 0, false)) {
            throw new HTTP_Exception_404('Object "' . $this->dbObject . '" not is found!');
        }

        $this->_requestListDB('DB_AutoPart_Shop_Source', $model->getShopSourceID());
        $this->_requestListDB('DB_AutoPart_Shop_Courier', $model->getShopCourierID());
        $this->_requestListDB('DB_AutoPart_Shop_Company', $model->getShopCompanyID());
        $this->_requestListDB('DB_AutoPart_Shop_Bank_Account', $model->getShopBankAccountID(), 0, [], ['shop_company_id' => ['name']]);

        $this->_actionEdit($model, $this->_sitePageData->shopID);
    }

    public function action_load_kaspi()
    {
        $this->_sitePageData->url = '/market/shoppaymentcourier/load_kaspi';

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

        $model = new Model_AutoPart_Shop_Payment_Courier();
        $model->setDBDriver($this->_driverDB);

        foreach ($data as $child){
            if(mb_strpos($child[9], 'Прочие безвозмездные переводы денег на карту Kaspi Gold') === false){
                continue;
            }

            $child[3] = Request_RequestParams::strToFloat($child[3]);
            if($child[3] < 0.001){
                continue;
            }

            $n = mb_strpos($child[5], 'ИИН/БИН');
            if($n === false){
                continue;
            }
            $iin = trim(mb_substr($child[5], $n + mb_strlen('ИИН/БИН')));
            if(strlen($iin) != 12){
                continue;
            }

            $courier = Request_Request::findOneByField(
                DB_AutoPart_Shop_Courier::NAME, 'iin_full',  $iin, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB
            );
            if($courier == null){
                continue;
            }

            // проверяем есть ли уже такой документ
            $params['number_full'] = $child[1];
            $payment = Request_Request::findOne(
                DB_AutoPart_Shop_Payment_Courier::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB, $params
            );
            if($payment != null){
                continue;
            }

            $date = Helpers_DateTime::getDateFormatPHP($child[2]);

            // проверяем есть ли такой документ загруженный вручную
            $params2['date'] = $date;
            $params2['shop_courier_id'] = $courier->id;
            $params2['amount'] = $child[3];
            $payment = Request_Request::findOne(
                DB_AutoPart_Shop_Payment_Courier::NAME, $this->_sitePageData->shopID,
                $this->_sitePageData, $this->_driverDB, $params2
            );

            if($payment != null){
                $payment->setModel($model);
            }else{
                $model->clear();

                $model->setShopCourierID($courier->id);
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

        $this->redirect('/market/shoppaymentcourier/index');
    }

}

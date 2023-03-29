<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopExcel extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopreport';
        $this->objectName = 'report';

        parent::__construct($request, $response);
    }

    public function action_act_revise() {
        $this->_sitePageData->url = '/tax/shopexcel/act_revise';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'tax' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . 'act_revise.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Tax_Shop_Act_Revise();
        $model->setDBDriver($this->_driverDB);
        if (!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Act revise not is found!');
        }

        $model->dbGetElements($this->_sitePageData->shopID, array('shop_contractor_id', 'shop_contract_id'),
            $this->_sitePageData->languageIDDefault);

        $actRevise = $model->getValues(TRUE, TRUE);
        $actRevise['date_to'] = strftime('%d.%m.%Y', strtotime($model->getDateTo()));
        $actRevise['date_to_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getDateTo(), TRUE);
        $actRevise['date_from'] = strftime('%d.%m.%Y', strtotime($model->getDateFrom()));
        $actRevise['date_from_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getDateFrom(), TRUE);

        if ($model->getShopContractID() > 0){
            $actRevise['contract_str'] = 'Договор № '.Arr::path($actRevise, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.number', '')
                .' от ' . Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($actRevise, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from', ''), TRUE);
        }else{
            $actRevise['contract_str'] = 'без договора';
        }

        // получаем предыдущие записи для сальдо
        $itemsIDsOld = Api_Tax_Shop_Act_Revise::newItems(
            $model->getShopContractorID(),
            $model->getShopContractID(),
            NULL,
            $model->getDateFrom(),
            $this->_sitePageData, $this->_driverDB);

        $debitFrom = 0;
        $creditFrom = 0;

        $tmpDate = strtotime($model->getDateFrom(), NULL);
        foreach ($itemsIDsOld->childs as $itemsID) {
            if ($tmpDate == strtotime($itemsID->values['date'], NULL)){
                continue;
            }
            $debitFrom += $itemsID->values['debit'];
            $creditFrom += $itemsID->values['credit'];
        }

        if ($debitFrom > $creditFrom){
            $actRevise['debit_from'] = $debitFrom - $creditFrom;
            $actRevise['credit_from'] = '';
        }else{
            $actRevise['credit_from'] = $creditFrom - $debitFrom;
            $actRevise['debit_from'] = '';
        }

        // получаем список документов
        $itemsIDs = Api_Tax_Shop_Act_Revise::getItems($model, $this->_sitePageData, $this->_driverDB);

        $debit = 0;
        $credit = 0;
        $shopActReviseItems = array();
        foreach ($itemsIDs->childs as $itemsID) {
            $itemsID->values['date'] = Helpers_DateTime::getDateFormatRus($itemsID->values['date']);
            $shopActReviseItems[] = $itemsID->values;

            $debit += $itemsID->values['debit'];
            $credit += $itemsID->values['credit'];
        }

        $actRevise['debit'] = $debit;
        $actRevise['credit'] = $credit;

        if ($debitFrom + $debit > $creditFrom + $credit){
            $actRevise['debit_to'] = ($debitFrom + $debit) - ($creditFrom + $credit);
            $actRevise['credit_to'] = '';
        }else{
            $actRevise['credit_to'] = ($creditFrom + $credit) - ($debitFrom + $debit);
            $actRevise['debit_to'] = '';
        }

        if ($debitFrom + $debit < $creditFrom + $credit){
            $tmp = ($creditFrom + $credit) - ($debitFrom + $debit);
            $actRevise['debt_company'] = 'в пользу '
                . Arr::path($actRevise, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contractor_id.name', '')
                . ' ' . Func::getNumberStr($tmp)
                .' KZT ('
                . Func::numberToStr($tmp, TRUE, $this->_sitePageData->currency)
                . ')';
        }elseif ($debitFrom + $debit > $creditFrom + $credit){
            $tmp = ($debitFrom + $debit) - ($creditFrom + $credit);
            $actRevise['debt_company'] = 'в пользу '
                . Arr::path($this->_sitePageData->shop->getRequisitesArray(), 'company_name', '')
                . ' ' . Func::getNumberStr($tmp)
                .' KZT ('
                . Func::numberToStr($tmp, TRUE, $this->_sitePageData->currency)
                . ')';
        }else {
            $actRevise['debt_company'] = 'отсутствует.';
        }

        Helpers_Excel::saleInFile($filePath,
            array(
                'act_revise' => $actRevise,
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array('act_revise_items' => $shopActReviseItems),
            'php://output',
            'Акт сверки №'.$model->getNumber().'.xls'
        );

        exit();
    }

    public function action_attorney() {
        $this->_sitePageData->url = '/tax/shopexcel/attorney';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'tax' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . 'attorney.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Tax_Shop_My_Attorney();
        $model->setDBDriver($this->_driverDB);
        if (!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Attorney not is found!');
        }

        $model->dbGetElements(
            $this->_sitePageData->shopID,
            array('shop_contractor_id', 'shop_worker_id', 'shop_bank_account_id'),
            $this->_sitePageData->languageIDDefault
        );

        $tmp = $model->getElement('shop_bank_account_id');
        if($tmp !== NULL) {
            $tmp->dbGetElements($this->_sitePageData->shopID, array('bank_id'),
                $this->_sitePageData->languageIDDefault);
        }

        $attorney = $model->getValues(TRUE, TRUE);
        $attorney['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $attorney['date_to'] = strftime('%d.%m.%Y', strtotime($model->getDateTo()));
        $attorney['date_to_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getDateTo(), TRUE);
        $attorney['date_from'] = strftime('%d.%m.%Y', strtotime($model->getDateFrom()));
        $attorney['date_from_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getDateFrom(), TRUE);

        Arr::set_path($attorney, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_worker_id.date_from_str',
            strftime('%d.%m.%Y', strtotime(Arr::path($attorney, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_worker_id.date_from', ''))));

        $shopAttorneyItemIDs = Request_Tax_Shop_My_Attorney_Item::findShopMyAttorneyItemIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_my_attorney_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_product_id' => array('name', 'number', 'is_service'), 'unit_id' => array('name')));

        $quantity = $model->getAmount();
        $shopAttorneyItems = array();
        if (count($shopAttorneyItemIDs->childs) > 0) {
            $quantity = 0;
            foreach ($shopAttorneyItemIDs->childs as $shopAttorneyItemID) {
                if ($shopAttorneyItemID->values['unit_id'] > 0) {
                    $shopAttorneyItemID->values['unit_name'] = Arr::path($attorney, Model_Basic_BasicObject::FIELD_ELEMENTS . '.unit_id.name', $shopAttorneyItemID->values['unit_name']);
                }
                $shopAttorneyItemID->values['quantity'] = floatval($shopAttorneyItemID->values['quantity']);
                $shopAttorneyItems[] = array_merge(
                    $shopAttorneyItemID->values,
                    array('quantity_str' => Func::numberToStr($shopAttorneyItemID->values['quantity']))
                );

                $quantity += $shopAttorneyItemID->values['quantity'];
            }
        }else {
            $shopAttorneyItems[] = array(
                '$elements$' => array(
                    'shop_product_id' => array(
                        'name' => 'ТМЦ на сумму',
                    ),
                ),
                'unit_name' => 'тенге',
                'quantity' => $model->getAmount(),
                'quantity_str' => Func::numberToStr($model->getAmount()),
            );
        }

        $attorney['quantity'] = $quantity;
        $attorney['quantity_str'] = Func::numberToStr($quantity);

        Helpers_Excel::saleInFile($filePath,
            array(
                'attorney' => $attorney,
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array('attorney_items' => $shopAttorneyItems),
            'php://output',
            'Доверенность №'.$model->getNumber().'.xls'
        );

        exit();
    }

    public function action_invoice_proforma() {
        $this->_sitePageData->url = '/tax/shopexcel/invoice_proforma';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'tax' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . 'invoice_proforma.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Tax_Shop_Invoice_Proforma();
        $model->setDBDriver($this->_driverDB);
        if (!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $model->dbGetElements(
            $this->_sitePageData->shopID,
            array('knp_id', 'shop_contract_id', 'shop_contractor_id', 'shop_bank_account_id'),
            $this->_sitePageData->languageIDDefault
        );

        $tmp = $model->getElement('shop_contractor_id');
        if($tmp !== NULL) {
            $tmp->dbGetElements($this->_sitePageData->shopID, array('bank_id'),
                $this->_sitePageData->languageIDDefault);
        }

        $tmp = $model->getElement('shop_bank_account_id');
        if($tmp !== NULL) {
            $tmp->dbGetElements($this->_sitePageData->shopID, array('bank_id'),
                $this->_sitePageData->languageIDDefault);
        }

        $invoice = $model->getValues(TRUE, TRUE);
        $invoice['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $invoice['created_at'] = strftime('%d.%m.%Y', strtotime($model->getCreatedAt()));
        $invoice['created_at_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getCreatedAt(), TRUE);
        $invoice['date'] = strftime('%d.%m.%Y', strtotime($model->getDate()));
        $invoice['date_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getDate(), TRUE);
        Arr::set_path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from_str',
            Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from', ''), TRUE));

        if ($model->getShopContractID() > 0){
            $invoice['contract_str'] = '№ '.Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.number', '')
                .' от ' . Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from', ''), TRUE);
        }else{
            $invoice['contract_str'] = 'без договора';
        }

        if ($model->getIsNDS()){
            $invoice['nds_title'] = 'В том числе НДС';
            $invoice['amount_nds'] = round($invoice['amount'] / (100 + $model->getNDS()) * $model->getNDS(), 2);
        }else{
            $invoice['nds_title'] = 'Без налога (НДС)';
            $invoice['amount_nds'] = '-';
        }
        $invoice['amount'] = Func::getNumberStr($invoice['amount'], TRUE, 2, FALSE);

        $shopInvoiceItemIDs = Request_Tax_Shop_Invoice_Proforma_Item::find($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_invoice_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_product_id' => array('name', 'number', 'is_service'), 'unit_id' => array('name')));

        $shopInvoiceItems = array();
        foreach($shopInvoiceItemIDs->childs as $shopInvoiceItemID){
            if($shopInvoiceItemID->values['unit_id'] > 0 ){
                $shopInvoiceItemID->values['unit_name'] = Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.unit_id.name', $shopInvoiceItemID->values['unit_name']);
            }
            $shopInvoiceItems[] = $shopInvoiceItemID->values;
        }

        $invoice['line_count'] = count($shopInvoiceItems);

        Helpers_Excel::saleInFile($filePath,
            array(
                'invoice' => $invoice,
                'operation' => array('name' => $this->_sitePageData->operation->getName()),
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array('invoice_items' => $shopInvoiceItems),
            'php://output',
            'Счет на оплату №'.$model->getNumber().'.xls'
        );

        exit();
    }

    public function action_invoice() {
        $this->_sitePageData->url = '/tax/shopexcel/invoice';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'tax' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . 'invoice.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Tax_Shop_Invoice_Commercial();
        $model->setDBDriver($this->_driverDB);
        if (!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $model->dbGetElements(
            $this->_sitePageData->shopID,
            array(
                'shop_contract_id',
                'shop_contractor_id',
                'shop_attorney_id',
                'paid_type_id',
                'shop_bank_account_id',
            ),
            $this->_sitePageData->languageIDDefault
        );

        $tmp = $model->getElement('shop_contractor_id');
        if($tmp !== NULL) {
            $tmp->dbGetElements($this->_sitePageData->shopID, array('bank_id'),
                $this->_sitePageData->languageIDDefault);
        }

        $tmp = $model->getElement('shop_bank_account_id');
        if($tmp !== NULL) {
            $tmp->dbGetElements($this->_sitePageData->shopID, array('bank_id'),
                $this->_sitePageData->languageIDDefault);
        }

        $invoice = $model->getValues(TRUE, TRUE);
        $invoice['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $invoice['created_at'] = strftime('%d.%m.%Y', strtotime($model->getCreatedAt()));
        $invoice['created_at_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getCreatedAt(), TRUE);
        $invoice['date'] = strftime('%d.%m.%Y', strtotime($model->getDate()));
        $invoice['date_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getDate(), TRUE);
        Arr::set_path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from_str',
            Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from', ''), TRUE));

        if ($model->getShopAttorneyID() > 0){
            $invoice['attorney_str'] = '№ '.Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_attorney_id.number', '')
                .' от ' . Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_attorney_id.date_from', ''), TRUE);
        }else{
            $invoice['attorney_str'] = 'без доверенности';
        }

        if ($model->getShopContractID() > 0){
            $invoice['contract_str'] = '№ '.Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.number', '')
                .' от ' . Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from', ''), TRUE);
        }else{
            $invoice['contract_str'] = 'без договора';
        }

        $requisites = $this->_sitePageData->shop->getRequisitesArray();
        if (($model->getNDS() > 0) && (Arr::path($requisites, 'is_nds', '') == 1)){
            $invoice['nds_document'] = 'Свидетельство о поставновке на регистрационный учет по НДС, '
                .'серия '. Arr::path($requisites, 'nds_series', ''). ', '
                .'№'. Arr::path($requisites, 'nds_number', ''). ', '
                .'от ' . Helpers_DateTime::getDateFormatRus(Arr::path($requisites, 'nds_date', ''));
        }else{
            $invoice['nds_document'] = '';
        }

        $shopInvoiceItemIDs = Request_Tax_Shop_Invoice_Commercial_Item::findShopInvoiceCommercialItemIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_invoice_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_product_id' => array('name', 'number', 'is_service'), 'unit_id' => array('name')));

        $shopInvoiceItems = array();
        foreach($shopInvoiceItemIDs->childs as $shopInvoiceItemID){
            $values = $shopInvoiceItemID->values;
            if($values['unit_id'] > 0 ){
                $values['unit_name'] = Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.unit_id.name', $values['unit_name']);
            }

            if ($values['nds'] > 0){
                $values['nds'] .= '%';

                $values['amount_with_nds'] = $values['amount'];
                $values['amount_nds'] = round($values['amount'] / (100 + $values['nds']) * $values['nds'], 2);
                $values['amount'] = round($values['amount'] / (100 + $values['nds']) * 100, 2);

                $values['price_with_nds'] = $values['price'];
                $values['price_nds'] = round($values['price'] / (100 + $values['nds']) * $values['nds'], 2);
                $values['price'] = round($values['price'] / (100 + $values['nds']) * 100, 2);
            }else{
                $values['nds'] = 'Без НДС';

                $values['amount_with_nds'] = $values['amount'];
                $values['amount_nds'] = '';
                $values['amount'] = $values['amount'];

                $values['price_with_nds'] = $values['price'];
                $values['price_nds'] = '';
                $values['price'] = $values['price'];
            }

            $shopInvoiceItems[] = $values;
        }

        $invoice['amount_with_nds'] = $invoice['amount'];
        if ($invoice['nds'] > 0){
            $invoice['amount'] = round($invoice['amount'] / (100 + $invoice['nds']) * 100, 2);
            $invoice['amount_nds'] = round($invoice['amount'] / (100 + $invoice['nds']) * $invoice['nds'], 2);
        }else{
            $invoice['amount_nds'] = '';
        }

        $invoice['line_count'] = count($shopInvoiceItems);

        Helpers_Excel::saleInFile($filePath,
            array(
                'invoice' => $invoice,
                'operation' => array('name' => $this->_sitePageData->operation->getName()),
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array('invoice_items' => $shopInvoiceItems),
            'php://output',
            'Счет-фактура №'.$model->getNumber().'.xls'
        );

        exit();
    }

    public function action_act_service() {
        $this->_sitePageData->url = '/tax/shopexcel/act_service';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'tax' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . 'act_service.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Tax_Shop_Invoice_Commercial();
        $model->setDBDriver($this->_driverDB);
        if (!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $model->dbGetElements($this->_sitePageData->shopID, array('shop_contract_id', 'shop_contractor_id', 'shop_attorney_id', 'paid_type_id'),
            $this->_sitePageData->languageIDDefault);

        $model->getElement('shop_contractor_id')->dbGetElements($this->_sitePageData->shopID, array('bank_id'),
            $this->_sitePageData->languageIDDefault);

        $invoice = $model->getValues(TRUE, TRUE);
        $invoice['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $invoice['created_at'] = strftime('%d.%m.%Y', strtotime($model->getCreatedAt()));
        $invoice['created_at_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getCreatedAt(), TRUE);
        $invoice['date'] = strftime('%d.%m.%Y', strtotime($model->getDate()));
        $invoice['date_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getDate(), TRUE);
        Arr::set_path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from_str',
            Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from', ''), TRUE));

        if ($model->getShopAttorneyID() > 0){
            $invoice['attorney_str'] = '№ '.Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_attorney_id.number', '')
                .' от ' . Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_attorney_id.date_from', ''), TRUE);
        }else{
            $invoice['attorney_str'] = 'без доверенности';
        }

        if ($model->getShopContractID() > 0){
            $invoice['contract_str'] = '№ '.Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.number', '')
                .' от ' . Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from', ''), TRUE);
        }else{
            $invoice['contract_str'] = 'без договора';
        }

        $shopInvoiceItemIDs = Request_Tax_Shop_Invoice_Commercial_Item::findShopInvoiceCommercialItemIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_invoice_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_product_id' => array('name', 'number', 'is_service'), 'unit_id' => array('name')));

        $amount = 0;
        $quantity = 0;
        $shopInvoiceServices = array();
        foreach($shopInvoiceItemIDs->childs as $shopInvoiceItemID){
            $values = $shopInvoiceItemID->values;
            if (Arr::path($values, Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_product_id.is_service', '') == 1) {
                if ($values['unit_id'] > 0) {
                    $values['unit_name'] = Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS . '.unit_id.name', $values['unit_name']);
                }

                if ($values['nds'] > 0){
                    $values['nds'] .= '%';

                    $values['amount_with_nds'] = $values['amount'];
                    $values['amount_nds'] = round($values['amount'] / (100 + $values['nds']) * $values['nds'], 2);
                    $values['amount'] = round($values['amount'] / (100 + $values['nds']) * 100, 2);

                    $values['price_with_nds'] = $values['price'];
                    $values['price_nds'] = round($values['price'] / (100 + $values['nds']) * $values['nds'], 2);
                    $values['price'] = round($values['price'] / (100 + $values['nds']) * 100, 2);
                }else{
                    $values['nds'] = 'Без НДС';

                    $values['amount_with_nds'] = $values['amount'];
                    $values['amount_nds'] = '';
                    $values['amount'] = $values['amount'];

                    $values['price_with_nds'] = $values['price'];
                    $values['price_nds'] = '';
                    $values['price'] = $values['price'];
                }
                $shopInvoiceServices[] = $values;

                $amount = $amount + $shopInvoiceItemID->values['amount'];
                $quantity = $quantity + $shopInvoiceItemID->values['quantity'];
            }
        }

        if ($invoice['nds'] > 0) {
            $invoice['service_amount_with_nds'] = $amount;
            $invoice['service_amount_with_nds_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['service_amount'] = round($amount / (100 + $invoice['nds']) * 100, 2);
            $invoice['service_amount_str'] = Func::numberToStr($invoice['service_amount'], TRUE, $this->_sitePageData->currency);
            $invoice['service_amount_nds'] = round($amount / (100 + $invoice['nds']) * $invoice['nds'], 2);
        }else{
            $invoice['service_amount_with_nds'] = $amount;
            $invoice['service_amount_with_nds_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['service_amount'] = $amount;
            $invoice['service_amount_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['service_amount_nds'] = 'Без НДС';
        }

        $invoice['service_quantity'] = $quantity;
        $invoice['service_count'] = count($shopInvoiceServices);

        Helpers_Excel::saleInFile($filePath,
            array(
                'invoice' => $invoice,
                'operation' => array('name' => $this->_sitePageData->operation->getName()),
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array('invoice_services' => $shopInvoiceServices),
            'php://output',
            'Акт выполненных работ №'.$model->getNumber().'.xls'
        );

        exit();
    }

    public function action_waybill_product() {
        $this->_sitePageData->url = '/tax/shopexcel/waybill_product';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'tax' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . 'waybill_product.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Tax_Shop_Invoice_Commercial();
        $model->setDBDriver($this->_driverDB);
        if (!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $model->dbGetElements($this->_sitePageData->shopID, array('shop_contract_id', 'shop_contractor_id', 'shop_attorney_id', 'paid_type_id'),
            $this->_sitePageData->languageIDDefault);

        $model->getElement('shop_contractor_id')->dbGetElements($this->_sitePageData->shopID, array('bank_id'),
            $this->_sitePageData->languageIDDefault);

        $invoice = $model->getValues(TRUE, TRUE);
        $invoice['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $invoice['created_at'] = strftime('%d.%m.%Y', strtotime($model->getCreatedAt()));
        $invoice['created_at_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getCreatedAt(), TRUE);
        $invoice['date'] = strftime('%d.%m.%Y', strtotime($model->getDate()));
        $invoice['date_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getDate(), TRUE);
        Arr::set_path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from_str',
            Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from', ''), TRUE));

        if ($model->getShopAttorneyID() > 0){
            $invoice['attorney_str'] = '№ '.Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_attorney_id.number', '')
                .' от ' . Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_attorney_id.date_from', ''), TRUE);
        }else{
            $invoice['attorney_str'] = 'без доверенности';
        }

        $shopInvoiceItemIDs = Request_Tax_Shop_Invoice_Commercial_Item::findShopInvoiceCommercialItemIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_invoice_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_product_id' => array('name', 'number', 'is_service'), 'unit_id' => array('name')));

        $amount = 0;
        $quantity = 0;
        $shopInvoiceProducts = array();
        foreach($shopInvoiceItemIDs->childs as $shopInvoiceItemID){
            $values = $shopInvoiceItemID->values;
            if (Arr::path($values, Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_product_id.is_service', '') != 1) {
                if ($values['unit_id'] > 0) {
                    $values['unit_name'] = Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS . '.unit_id.name', $values['unit_name']);
                }

                if ($values['nds'] > 0){
                    $values['nds'] .= '%';

                    $values['amount_with_nds_s'] = $values['amount'];
                    $values['amount_with_nds'] = $values['amount'];
                    $values['amount_nds'] = round($values['amount'] / (100 + $values['nds']) * $values['nds'], 2);
                    $values['amount'] = round($values['amount'] / (100 + $values['nds']) * 100, 2);

                    $values['price_with_nds'] = $values['price'];
                    $values['price_nds'] = round($values['price'] / (100 + $values['nds']) * $values['nds'], 2);
                    $values['price'] = round($values['price'] / (100 + $values['nds']) * 100, 2);
                }else{
                    $values['nds'] = 'Без НДС';

                    $values['amount_with_nds_s'] = 'Без НДС';
                    $values['amount_with_nds'] = $values['amount'];
                    $values['amount_nds'] = 'Без НДС';
                    $values['amount'] = $values['amount'];

                    $values['price_with_nds'] = $values['price'];
                    $values['price_nds'] = '';
                    $values['price'] = $values['price'];
                }
                $shopInvoiceProducts[] = $values;

                $amount = $amount + $shopInvoiceItemID->values['amount'];
                $quantity = $quantity + $shopInvoiceItemID->values['quantity'];
            }
        }

        if ($invoice['nds'] > 0) {
            $invoice['product_amount_with_nds'] = $amount;
            $invoice['product_amount_with_nds_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['product_amount'] = round($amount / (100 + $invoice['nds']) * 100, 2);
            $invoice['product_amount_str'] = Func::numberToStr($invoice['product_amount'], TRUE, $this->_sitePageData->currency);
            $invoice['product_amount_nds'] = round($amount / (100 + $invoice['nds']) * $invoice['nds'], 2);
            $invoice['amount_title'] = 'Сумма с НДС, в тенге';
        }else{
            $invoice['product_amount_with_nds'] = $amount;
            $invoice['product_amount_with_nds_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['product_amount'] = $amount;
            $invoice['product_amount_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['product_amount_nds'] = 'Без НДС';
            $invoice['amount_title'] = 'Сумма без НДС, в тенге';
        }

        $invoice['product_quantity'] = $quantity;
        $invoice['product_quantity_str'] = Func::numberToStr($quantity);
        $invoice['product_count'] = count($shopInvoiceProducts);

        Helpers_Excel::saleInFile($filePath,
            array(
                'invoice' => $invoice,
                'operation' => array('name' => $this->_sitePageData->operation->getName()),
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array('invoice_products' => $shopInvoiceProducts),
            'php://output',
            'Накладная на отпуск товаров №'.$model->getNumber().'.xls'
        );

        exit();
    }

    public function action_act_product() {
        $this->_sitePageData->url = '/tax/shopexcel/act_product';

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'tax' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . 'act_product.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Tax_Shop_Invoice_Commercial();
        $model->setDBDriver($this->_driverDB);
        if (!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $model->dbGetElements($this->_sitePageData->shopID, array('shop_contract_id', 'shop_contractor_id', 'shop_attorney_id', 'paid_type_id'),
            $this->_sitePageData->languageIDDefault);

        $model->getElement('shop_contractor_id')->dbGetElements($this->_sitePageData->shopID, array('bank_id'),
            $this->_sitePageData->languageIDDefault);

        $invoice = $model->getValues(TRUE, TRUE);
        $invoice['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $invoice['created_at'] = strftime('%d.%m.%Y', strtotime($model->getCreatedAt()));
        $invoice['created_at_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getCreatedAt(), TRUE);
        $invoice['date'] = strftime('%d.%m.%Y', strtotime($model->getDate()));
        $invoice['date_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getDate(), TRUE);
        Arr::set_path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from_str',
            Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from', ''), TRUE));

        if ($model->getShopAttorneyID() > 0){
            $invoice['attorney_str'] = '№ '.Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_attorney_id.number', '')
                .' от ' . Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_attorney_id.date_from', ''), TRUE);
        }else{
            $invoice['attorney_str'] = 'без доверенности';
        }

        $shopInvoiceItemIDs = Request_Tax_Shop_Invoice_Commercial_Item::findShopInvoiceCommercialItemIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_invoice_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_product_id' => array('name', 'number', 'is_service'), 'unit_id' => array('name')));

        $amount = 0;
        $quantity = 0;
        $shopInvoiceProducts = array();
        foreach($shopInvoiceItemIDs->childs as $shopInvoiceItemID){
            $values = $shopInvoiceItemID->values;
            if (Arr::path($values, Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_product_id.is_service', '') != 1) {
                if ($values['unit_id'] > 0) {
                    $values['unit_name'] = Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS . '.unit_id.name', $values['unit_name']);
                }

                if ($values['nds'] > 0){
                    $values['nds'] .= '%';

                    $values['amount_with_nds_s'] = $values['amount'];
                    $values['amount_with_nds'] = $values['amount'];
                    $values['amount_nds'] = round($values['amount'] / (100 + $values['nds']) * $values['nds'], 2);
                    $values['amount'] = round($values['amount'] / (100 + $values['nds']) * 100, 2);

                    $values['price_with_nds'] = $values['price'];
                    $values['price_nds'] = round($values['price'] / (100 + $values['nds']) * $values['nds'], 2);
                    $values['price'] = round($values['price'] / (100 + $values['nds']) * 100, 2);
                }else{
                    $values['nds'] = 'Без НДС';

                    $values['amount_with_nds_s'] = 'Без НДС';
                    $values['amount_with_nds'] = $values['amount'];
                    $values['amount_nds'] = 'Без НДС';
                    $values['amount'] = $values['amount'];

                    $values['price_with_nds'] = $values['price'];
                    $values['price_nds'] = '';
                    $values['price'] = $values['price'];
                }
                $shopInvoiceProducts[] = $values;

                $amount = $amount + $shopInvoiceItemID->values['amount'];
                $quantity = $quantity + $shopInvoiceItemID->values['quantity'];
            }
        }

        if ($invoice['nds'] > 0) {
            $invoice['product_amount_with_nds'] = $amount;
            $invoice['product_amount_with_nds_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['product_amount'] = round($amount / (100 + $invoice['nds']) * 100, 2);
            $invoice['product_amount_str'] = Func::numberToStr($invoice['product_amount'], TRUE, $this->_sitePageData->currency);
            $invoice['product_amount_nds'] = round($amount / (100 + $invoice['nds']) * $invoice['nds'], 2);
        }else{
            $invoice['product_amount_with_nds'] = 'Без НДС';
            $invoice['product_amount_with_nds_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['product_amount'] = $amount;
            $invoice['product_amount_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['product_amount_nds'] = 'Без НДС';
        }

        $invoice['product_quantity'] = $quantity;
        $invoice['product_quantity_str'] = Func::numberToStr($quantity);
        $invoice['product_count'] = count($shopInvoiceProducts);

        Helpers_Excel::saleInFile($filePath,
            array(
                'invoice' => $invoice,
                'operation' => array('name' => $this->_sitePageData->operation->getName()),
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array('invoice_products' => $shopInvoiceProducts),
            'php://output',
            'Акт приема-передачи товаров №'.$model->getNumber().'.xls'
        );

        exit();
    }

    public function action_invoice_all() {
        $this->_sitePageData->url = '/tax/shopexcel/invoice_all';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Tax_Shop_Invoice_Commercial();
        $model->setDBDriver($this->_driverDB);
        if (!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        $model->dbGetElements(
            $this->_sitePageData->shopID,
            array('shop_contract_id', 'shop_contractor_id', 'shop_attorney_id', 'paid_type_id', 'shop_bank_account_id'),
            $this->_sitePageData->languageIDDefault
        );

        $tmp = $model->getElement('shop_contractor_id');
        if($tmp !== NULL) {
            $tmp->dbGetElements($this->_sitePageData->shopID, array('bank_id'),
                $this->_sitePageData->languageIDDefault);
        }

        $tmp = $model->getElement('shop_bank_account_id');
        if($tmp !== NULL) {
            $tmp->dbGetElements($this->_sitePageData->shopID, array('bank_id'),
                $this->_sitePageData->languageIDDefault);
        }

        $invoice = $model->getValues(TRUE, TRUE);
        $invoice['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $invoice['created_at'] = strftime('%d.%m.%Y', strtotime($model->getCreatedAt()));
        $invoice['created_at_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getCreatedAt(), TRUE);
        $invoice['date'] = strftime('%d.%m.%Y', strtotime($model->getDate()));
        $invoice['date_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getDate(), TRUE);
        Arr::set_path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from_str',
            Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_contract_id.date_from', ''), TRUE));

        if ($model->getShopAttorneyID() > 0){
            $invoice['attorney_str'] = '№ '.Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_attorney_id.number', '')
                .' от ' . Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_attorney_id.date_from', ''), TRUE);
        }else{
            $invoice['attorney_str'] = 'без доверенности';
        }

        $requisites = $this->_sitePageData->shop->getRequisitesArray();
        if (($model->getNDS() > 0) && (Arr::path($requisites, 'is_nds', '') == 1)){
            $invoice['nds_document'] = 'Свидетельство о поставновке на регистрационный учет по НДС, '
                .'серия '. Arr::path($requisites, 'nds_series', ''). ', '
                .'№'. Arr::path($requisites, 'nds_number', ''). ', '
                .'от ' . Helpers_DateTime::getDateFormatRus(Arr::path($requisites, 'nds_date', ''));
        }else{
            $invoice['nds_document'] = '';
        }

        $shopInvoiceItemIDs = Request_Tax_Shop_Invoice_Commercial_Item::findShopInvoiceCommercialItemIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_invoice_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_product_id' => array('name', 'number', 'is_service'), 'unit_id' => array('name')));

        $shopInvoiceItems = array();
        foreach($shopInvoiceItemIDs->childs as $shopInvoiceItemID){
            $values = $shopInvoiceItemID->values;
            if($values['unit_id'] > 0 ){
                $values['unit_name'] = Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS.'.unit_id.name', $values['unit_name']);
            }

            if ($values['nds'] > 0){
                $values['nds'] .= '%';

                $values['amount_with_nds'] = $values['amount'];
                $values['amount_nds'] = round($values['amount'] / (100 + $values['nds']) * $values['nds'], 2);
                $values['amount'] = round($values['amount'] / (100 + $values['nds']) * 100, 2);

                $values['price_with_nds'] = $values['price'];
                $values['price_nds'] = round($values['price'] / (100 + $values['nds']) * $values['nds'], 2);
                $values['price'] = round($values['price'] / (100 + $values['nds']) * 100, 2);
            }else{
                $values['nds'] = 'Без НДС';

                $values['amount_with_nds'] = $values['amount'];
                $values['amount_nds'] = '';
                $values['amount'] = $values['amount'];

                $values['price_with_nds'] = $values['price'];
                $values['price_nds'] = '';
                $values['price'] = $values['price'];
            }

            $shopInvoiceItems[] = $values;
        }

        $invoice['amount_with_nds'] = $invoice['amount'];
        if ($invoice['nds'] > 0){
            $invoice['amount'] = round($invoice['amount'] / (100 + $invoice['nds']) * 100, 2);
            $invoice['amount_nds'] = round($invoice['amount'] / (100 + $invoice['nds']) * $invoice['nds'], 2);
        }else{
            $invoice['amount_nds'] = '';
        }

        $invoice['count'] = count($shopInvoiceItems);

        $amount = 0;
        $quantity = 0;
        $shopInvoiceProducts = array();
        foreach($shopInvoiceItemIDs->childs as $shopInvoiceItemID){
            $values = $shopInvoiceItemID->values;
            if (Arr::path($values, Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_product_id.is_service', '') != 1) {
                if ($values['unit_id'] > 0) {
                    $values['unit_name'] = Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS . '.unit_id.name', $values['unit_name']);
                }

                if ($values['nds'] > 0){
                    $values['nds'] .= '%';

                    $values['amount_with_nds_s'] = $values['amount'];
                    $values['amount_with_nds'] = $values['amount'];
                    $values['amount_nds'] = round($values['amount'] / (100 + $values['nds']) * $values['nds'], 2);
                    $values['amount'] = round($values['amount'] / (100 + $values['nds']) * 100, 2);

                    $values['price_with_nds'] = $values['price'];
                    $values['price_nds'] = round($values['price'] / (100 + $values['nds']) * $values['nds'], 2);
                    $values['price'] = round($values['price'] / (100 + $values['nds']) * 100, 2);
                }else{
                    $values['nds'] = 'Без НДС';

                    $values['amount_with_nds_s'] = 'Без НДС';
                    $values['amount_with_nds'] = $values['amount'];
                    $values['amount_nds'] = 'Без НДС';
                    $values['amount'] = $values['amount'];

                    $values['price_with_nds'] = $values['price'];
                    $values['price_nds'] = '';
                    $values['price'] = $values['price'];
                }
                $shopInvoiceProducts[] = $values;

                $amount = $amount + $shopInvoiceItemID->values['amount'];
                $quantity = $quantity + $shopInvoiceItemID->values['quantity'];
            }
        }

        if ($invoice['nds'] > 0) {
            $invoice['product_amount_with_nds'] = $amount;
            $invoice['product_amount_with_nds_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['product_amount'] = round($amount / (100 + $invoice['nds']) * 100, 2);
            $invoice['product_amount_str'] = Func::numberToStr($invoice['product_amount'], TRUE, $this->_sitePageData->currency);
            $invoice['product_amount_nds'] = round($amount / (100 + $invoice['nds']) * $invoice['nds'], 2);
            $invoice['amount_title'] = 'Сумма с НДС, в тенге';
        }else{
            $invoice['product_amount_with_nds'] = $amount;
            $invoice['product_amount_with_nds_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['product_amount'] = $amount;
            $invoice['product_amount_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['product_amount_nds'] = 'Без НДС';
            $invoice['amount_title'] = 'Сумма без НДС, в тенге';
        }

        $invoice['product_quantity'] = $quantity;
        $invoice['product_quantity_str'] = Func::numberToStr($quantity);
        $invoice['product_count'] = count($shopInvoiceProducts);

        $amount = 0;
        $quantity = 0;
        $shopInvoiceServices = array();
        foreach($shopInvoiceItemIDs->childs as $shopInvoiceItemID){
            $values = $shopInvoiceItemID->values;
            if (Arr::path($values, Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_product_id.is_service', '') == 1) {
                if ($values['unit_id'] > 0) {
                    $values['unit_name'] = Arr::path($invoice, Model_Basic_BasicObject::FIELD_ELEMENTS . '.unit_id.name', $values['unit_name']);
                }

                if ($values['nds'] > 0){
                    $values['nds'] .= '%';

                    $values['amount_with_nds'] = $values['amount'];
                    $values['amount_nds'] = round($values['amount'] / (100 + $values['nds']) * $values['nds'], 2);
                    $values['amount'] = round($values['amount'] / (100 + $values['nds']) * 100, 2);

                    $values['price_with_nds'] = $values['price'];
                    $values['price_nds'] = round($values['price'] / (100 + $values['nds']) * $values['nds'], 2);
                    $values['price'] = round($values['price'] / (100 + $values['nds']) * 100, 2);
                }else{
                    $values['nds'] = 'Без НДС';

                    $values['amount_with_nds'] = $values['amount'];
                    $values['amount_nds'] = '';
                    $values['amount'] = $values['amount'];

                    $values['price_with_nds'] = $values['price'];
                    $values['price_nds'] = '';
                    $values['price'] = $values['price'];
                }
                $shopInvoiceServices[] = $values;

                $amount = $amount + $shopInvoiceItemID->values['amount'];
                $quantity = $quantity + $shopInvoiceItemID->values['quantity'];
            }
        }

        if ($invoice['nds'] > 0) {
            $invoice['service_amount_with_nds'] = $amount;
            $invoice['service_amount_with_nds_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['service_amount'] = round($amount / (100 + $invoice['nds']) * 100, 2);
            $invoice['service_amount_str'] = Func::numberToStr($invoice['service_amount'], TRUE, $this->_sitePageData->currency);
            $invoice['service_amount_nds'] = round($amount / (100 + $invoice['nds']) * $invoice['nds'], 2);
        }else{
            $invoice['service_amount_with_nds'] = $amount;
            $invoice['service_amount_with_nds_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['service_amount'] = $amount;
            $invoice['service_amount_str'] = Func::numberToStr($amount, TRUE, $this->_sitePageData->currency);

            $invoice['service_amount_nds'] = 'Без НДС';
        }

        $invoice['service_quantity'] = $quantity;
        $invoice['service_count'] = count($shopInvoiceServices);

        $postfix = '';
        if(count($shopInvoiceServices) > 0){
            $postfix .= '_s';
        }
        if(count($shopInvoiceProducts) > 0){
            $postfix .= '_p';
        }


        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'tax' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR . 'invoice'.$postfix.'.xls';
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }
        Helpers_Excel::saleInFile($filePath,
            array(
                'invoice' => $invoice,
                'operation' => array('name' => $this->_sitePageData->operation->getName()),
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array(
                'invoice_items' => $shopInvoiceItems,
                'invoice_products' => $shopInvoiceProducts,
                'invoice_services' => $shopInvoiceServices,
            ),
            'php://output',
            'Закрывающие документы №'.$model->getNumber().'.xls'
        );

        exit();
    }

    public function action_payment_order() {
        $this->_sitePageData->url = '/tax/shopexcel/payment_order';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Tax_Shop_Payment_Order();
        $model->setDBDriver($this->_driverDB);
        if (!Helpers_DB::getDBObject($model, $id, $this->_sitePageData)) {
            throw new HTTP_Exception_404('Payment order not is found!');
        }

        $model->dbGetElements(
            $this->_sitePageData->shopID,
            array('kbe_id', 'shop_contractor_id', 'knp_id', 'kbk_id', 'authority_id', 'gov_contractor_id', 'shop_bank_account_id'),
            $this->_sitePageData->languageIDDefault
        );

        $tmp = $model->getElement('shop_bank_account_id');
        if($tmp !== NULL) {
            $tmp->dbGetElements($this->_sitePageData->shopID, array('bank_id'),
                $this->_sitePageData->languageIDDefault);
        }

        // если оплата для государства, то меняем контрагента
        if ($model->getGovContractorID() > 0){
            $tmp = $model->getElement('gov_contractor_id');
            if($tmp !== NULL) {
                $model->setElement('shop_contractor_id', $tmp);
            }
        }
        $shopContractor = $model->getElement('shop_contractor_id');
        if ($shopContractor !== NULL){
            $shopContractor->dbGetElements($this->_sitePageData->shopID, array('bank_id'),
                $this->_sitePageData->languageIDDefault);

            // если оплата налогов, то меняем название
            if($model->getAuthorityID() > 0){
                $d = $model->getElement('authority_id');
                if($tmp !== NULL) {
                    $tmp->setName($d->getName());
                }
            }
        }

        $invoice = $model->getValues(TRUE, TRUE);
        $invoice['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);
        $invoice['created_at'] = strftime('%d.%m.%Y', strtotime($model->getCreatedAt()));
        $invoice['created_at_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getCreatedAt(), TRUE);
        $invoice['date'] = strftime('%d.%m.%Y', strtotime($model->getDate()));
        $invoice['date_str'] = Helpers_DateTime::getDateTimeDayMonthRus($model->getDate(), TRUE);
        $invoice['amount_str'] = Func::numberToStr($model->getAmount(), TRUE, $this->_sitePageData->currency);

        $shopPaymentOrderItemIDs = Request_Tax_Shop_Payment_Order_Item::findShopPaymentOrderItemIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array('shop_payment_order_id' => $id, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 0, TRUE,
            array('shop_worker_id' => array('name', 'iin', 'date_of_birth')));

        $shopPaymentOrderItems = array();
        foreach($shopPaymentOrderItemIDs->childs as $shopPaymentOrderItemID){
            $shopPaymentOrderItems[] = $shopPaymentOrderItemID->values;
        }
        $invoice['count'] = count($shopPaymentOrderItems);

        $filePath = APPPATH.'views' . DIRECTORY_SEPARATOR . 'tax' . DIRECTORY_SEPARATOR
            . 'excel' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . DIRECTORY_SEPARATOR;
        if ($model->getIsItems()) {
            $filePath = $filePath . 'payment_order_items.xls';
        }else{
            $filePath = $filePath . 'payment_order.xls';
        }
        if(!file_exists($filePath)){
            throw new HTTP_Exception_500('File shablon not is found.');
        }

        Helpers_Excel::saleInFile($filePath,
            array(
                'payment_order' => $invoice,
                'shop' => $this->_sitePageData->shop->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID),
            ),
            array('payment_order_items' => $shopPaymentOrderItems,),
            'php://output',
            'Платежное поручение №'.$model->getNumber().'.xls'
        );

        exit();
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopInvoiceCommercial extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopinvoicecommercial';
        $this->tableID = Model_Tax_Shop_Invoice_Commercial::TABLE_ID;
        $this->tableName = Model_Tax_Shop_Invoice_Commercial::TABLE_NAME;
        $this->objectName = 'invoice';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shopinvoicecommercial/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/commercial/list/index',
                'view::_shop/invoice/commercial/item/list/index',
            )
        );

        // получаем данные
        $this->_sitePageData->replaceDatas['view::_shop/invoice/commercial/item/list/index'] =
            Helpers_View::getViewObjects(new MyArray(), new Model_Tax_Shop_Invoice_Commercial_Item(),
                '_shop/invoice/commercial/item/list/index', '_shop/invoice/commercial/item/one/index',
                $this->_sitePageData, $this->_driverDB);

        // получаем список
        View_View::find('DB_Tax_Shop_Invoice_Commercial', $this->_sitePageData->shopID, "_shop/invoice/commercial/list/index",
            "_shop/invoice/commercial/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array('bank_id' => array('name')), TRUE, TRUE);

        $this->_putInMain('/main/_shop/invoice/commercial/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/tax/shopinvoicecommercial/json';

        $this->_actionJSON(
            'Request_Tax_Shop_Invoice_Commercial',
            'findShopInvoiceCommercialIDs',
            array(
                'shop_contractor_id' => array('name'),
                'shop_contract_id' => array('number', 'date_from'),
            ),
            new Model_Tax_Shop_Invoice_Commercial()
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tax/shopinvoicecommercial/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/commercial/one/new',
                'view::_shop/invoice/commercial/item/list/index',
            )
        );

        $this->_requestShopContractors();
        $this->_requestPaidTypes();
        $this->_requestShopBankAccounts(Arr::path($this->_sitePageData->shop->getRequisitesArray(), 'shop_bank_account_id', 0));

        // получаем данные
        $this->_sitePageData->replaceDatas['view::_shop/invoice/commercial/item/list/index'] =
            Helpers_View::getViewObjects(new MyArray(), new Model_Tax_Shop_Invoice_Commercial_Item(),
            '_shop/invoice/commercial/item/list/index', '_shop/invoice/commercial/item/one/index',
            $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/invoice/commercial/one/new'] = Helpers_View::getViewObject($dataID, new Model_Tax_Shop_Invoice_Commercial(),
            '_shop/invoice/commercial/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tax/shopinvoicecommercial/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/commercial/one/edit',
                'view::_shop/invoice/commercial/item/list/index',
            )
        );

        // id записи
        $shopInvoiceCommercialID = Request_RequestParams::getParamInt('id');
        if ($shopInvoiceCommercialID === NULL) {
            throw new HTTP_Exception_404('Invoice commercial not is found!');
        }else {
            $model = new Model_Tax_Shop_Invoice_Commercial();
            if (! $this->dublicateObjectLanguage($model, $shopInvoiceCommercialID)) {
                throw new HTTP_Exception_404('Invoice commercial not is found!');
            }
        }

        $this->_requestShopContractors($model->getShopContractorID());
        $this->_requestPaidTypes($model->getPaidTypeID());
        $this->_requestShopContracts($model->getShopContractorID(), $model->getShopContractID());
        $this->_requestShopAttorneys($model->getShopContractorID(), $model->getShopAttorneyID());
        $this->_requestShopBankAccounts($model->getShopBankAccountID());

        View_View::find('DB_Tax_Shop_Invoice_Commercial_Item', $this->_sitePageData->shopID,
            '_shop/invoice/commercial/item/list/index', '_shop/invoice/commercial/item/one/index',
            $this->_sitePageData, $this->_driverDB, array('shop_invoice_id' => $shopInvoiceCommercialID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE),
            array('shop_product_id' => array('name', 'is_service'), 'unit_id' => array('name')));

        // получаем данные
        $data = View_View::findOne('DB_Tax_Shop_Invoice_Commercial', $this->_sitePageData->shopID, "_shop/invoice/commercial/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopInvoiceCommercialID), array('bank_id'));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shopinvoicecommercial/save';

        $result = Api_Tax_Shop_Invoice_Commercial::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];

            $result['values']['shop_contractor_name'] = '';
            $tmp = $result['values']['shop_contractor_id'];
            if ($tmp > 0){
                $model = new Model_Tax_Shop_Contractor();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['shop_contractor_name'] = $model->getName();
                }
            }

            $result['values']['shop_contract_number'] = '';
            $result['values']['shop_contract_date'] = '';
            $tmp = $result['values']['shop_contract_id'];
            if ($tmp > 0){
                $model = new Model_Tax_Shop_Contract();
                if($this->getDBObject($model, $tmp)){
                    $result['values']['shop_contract_number'] = $model->getNumber();
                    $result['values']['shop_contract_date'] = $model->getDateFrom();
                }
            }

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tax/shopinvoicecommercial/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tax/shopinvoicecommercial/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }
        }
    }

    public function action_get_amount() {
        $this->_sitePageData->url = '/tax/shopinvoicecommercial/get_amount';

        $amount = Request_Tax_Shop_Invoice_Commercial::findShopInvoiceCommercialIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                                           floatval(array('sum_amount' => TRUE))->childs[0]->values['amount']);

        $this->response->body($amount);
    }
}

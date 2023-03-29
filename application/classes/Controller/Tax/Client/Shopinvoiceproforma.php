<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopInvoiceProforma extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopinvoiceproforma';
        $this->tableID = Model_Tax_Shop_Invoice_Proforma::TABLE_ID;
        $this->tableName = Model_Tax_Shop_Invoice_Proforma::TABLE_NAME;
        $this->objectName = 'invoice';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shopinvoiceproforma/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/proforma/list/index',
                'view::_shop/invoice/proforma/item/list/index',
            )
        );

        // получаем данные
        $this->_sitePageData->replaceDatas['view::_shop/invoice/proforma/item/list/index'] =
            Helpers_View::getViewObjects(new MyArray(), new Model_Tax_Shop_Invoice_Proforma_Item(),
                '_shop/invoice/proforma/item/list/index', '_shop/invoice/proforma/item/one/index',
                $this->_sitePageData, $this->_driverDB);

        // получаем список
        View_View::find('DB_Tax_Shop_Invoice_Proforma', $this->_sitePageData->shopID, "_shop/invoice/proforma/list/index",
            "_shop/invoice/proforma/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array('bank_id' => array('name')), TRUE, TRUE);

        $this->_putInMain('/main/_shop/invoice/proforma/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/tax/shopinvoiceproforma/json';

        $this->_actionJSON(
            'Request_Tax_Shop_Invoice_Proforma',
            'find',
            array(
                'shop_contractor_id' => array('name'),
                'shop_contract_id' => array('number', 'date_from'),
            ),
            new Model_Tax_Shop_Invoice_Proforma()
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tax/shopinvoiceproforma/new';
        $this->_actionShopInvoiceProformaNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tax/shopinvoiceproforma/edit';
        $this->_actionShopInvoiceProformaEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shopinvoiceproforma/save';

        $result = Api_Tax_Shop_Invoice_Proforma::save($this->_sitePageData, $this->_driverDB);

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
                $this->redirect('/tax/shopinvoiceproforma/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tax/shopinvoiceproforma/index'
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

    public function action_invoice_commercial()
    {
        $this->_sitePageData->url = '/tax/shopinvoiceproforma/invoice_commercial';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/commercial/one/edit',
                'view::_shop/invoice/commercial/item/list/index',
                'view::_shop/invoice/proforma/one/to-tie',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Tax_Shop_Invoice_Proforma();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }
        $this->_sitePageData->urlParams['shop_invoice_proforma_id'] = $id;

        $this->_requestShopContractors($model->getShopContractorID());
        $this->_requestPaidTypes();
        $this->_requestShopContracts($model->getShopContractorID(), $model->getShopContractID());
        $this->_requestShopAttorneys($model->getShopContractorID(), 0);
        $this->_requestShopBankAccounts($model->getShopBankAccountID());

        $dataID = new MyArray();
        $dataID->id = $model->id;
        $dataID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopMainID);
        $dataID->setIsFind(TRUE);
        $this->_sitePageData->replaceDatas['view::_shop/invoice/proforma/one/to-tie'] =  Helpers_View::getViewObject(
            $dataID, new Model_Tax_Shop_Invoice_Proforma(),
            '_shop/invoice/proforma/one/to-tie', $this->_sitePageData, $this->_driverDB
        );


        $params = Request_RequestParams::setParams(
            array(
                'shop_invoice_id' => $id
            )
        );
        View_View::find('DB_Tax_Shop_Invoice_Proforma_Item', $this->_sitePageData->shopID,
            '_shop/invoice/commercial/item/list/index', '_shop/invoice/commercial/item/one/index',
            $this->_sitePageData, $this->_driverDB, $params,
            array('shop_product_id' => array('name', 'is_service'), 'unit_id' => array('name')));

        // получаем данные
        $data = View_View::findOne('DB_Tax_Shop_Invoice_Proforma', $this->_sitePageData->shopID, "_shop/invoice/commercial/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array('bank_id'));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_get_amount() {
        $this->_sitePageData->url = '/tax/shopinvoiceproforma/get_amount';

        $amount = Request_Tax_Shop_Invoice_Proforma::find($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
                                           floatval(array('sum_amount' => TRUE))->childs[0]->values['amount']);

        $this->response->body($amount);
    }

}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cashbox_ShopInvoiceProforma extends Controller_Ab1_Cashbox_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Invoice_Proforma';
        $this->controllerName = 'shopinvoiceproforma';
        $this->tableID = Model_Ab1_Shop_Invoice_Proforma::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Invoice_Proforma::TABLE_NAME;
        $this->objectName = 'invoice';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/cashbox/shopinvoiceproforma/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/invoice/proforma/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Invoice_Proforma',
            0,
            "_shop/invoice/proforma/list/index", "_shop/invoice/proforma/one/index",
            $this->_sitePageData, $this->_driverDB, array(),
            array(
                'shop_client_id' => array('name'),
                'shop_client_contract_id' => array('number', 'from_at'),
            )
        );

        $this->_putInMain('/main/_shop/invoice/proforma/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cashbox/shopinvoiceproforma/new';
        $this->_actionShopInvoiceProformaNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cashbox/shopinvoiceproforma/edit';
        $this->_actionShopInvoiceProformaEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cashbox/shopinvoiceproforma/save';

        $result = Api_Ab1_Shop_Invoice_Proforma::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/cashbox/shopinvoiceproforma/del';
        $result = Api_Ab1_Shop_Invoice_Proforma::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_add_payment()
    {
        $this->_sitePageData->url = '/cashbox/shopinvoiceproforma/add_payment';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/one/edit',
                '_shop/payment/item/list/index',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Invoice_Proforma();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Invoice not is found!');
        }

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestPaymentTypes(Model_Ab1_PaymentType::PAYMENT_TYPE_CASH);
        $this->_requestOrganizationTypes();
        $this->_requestKatos();

        $this->_requestShopClientContract(
            $model->getShopClientID(), $model->getShopClientContractID(), 'list', null,
            Model_Ab1_ClientContract_Status::CLIENT_CONTRACT_STATUS_WORK
        );


        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::find('DB_Ab1_Shop_Invoice_Proforma_Item',
            $this->_sitePageData->shopID,
            '_shop/payment/item/list/index', '_shop/payment/item/one/index',
            $this->_sitePageData, $this->_driverDB,
            array(
                'shop_invoice_proforma_id' => $id,
                'sort_by'=>array('value'=>array('id'=>'asc')),
                Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        // получаем данные
        $dataID = new MyArray();
        $dataID->id = 0;

        $model->setNumber('');
        $model->getElement('shop_client_id', TRUE, $this->_sitePageData->shopMainID);
        $dataID->setValues($model, $this->_sitePageData);
        $dataID->setIsFind(TRUE);
        $this->_sitePageData->replaceDatas['view::_shop/payment/one/edit'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Cashbox(),
            '_shop/payment/one/edit', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_putInMain('/main/_shop/payment/edit');
    }
}
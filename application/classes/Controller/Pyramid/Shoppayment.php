<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pyramid_ShopPayment extends Controller_Pyramid_BasicPyramid {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shoppayment';
        $this->tableID = Model_Pyramid_Shop_Payment::TABLE_ID;
        $this->tableName = Model_Pyramid_Shop_Payment::TABLE_NAME;
        $this->objectName = 'payment';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/pyramid/shoppayment/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Pyramid_Shop_Payment', $this->_sitePageData->shopID, "_shop/payment/list/index",
            "_shop/payment/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/payment/index');
    }

    public function action_json() {
        $this->_actionJSON(
            'Request_Pyramid_Shop_Payment',
            'find',
            array(
                'currency_id' => array('symbol'),
                'shop_product_id' => array('name'),
            ),
            array(
                'shop_client_id' => $this->_sitePageData->operationID,
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/pyramid/shoppayment/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/one/new',
            )
        );

        $this->_requestShopClients();
        $this->_requestShopPaidTypes();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/payment/one/new'] = Helpers_View::getViewObject($dataID, new Model_Pyramid_Shop_Payment(),
            '_shop/payment/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/pyramid/shoppayment/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/one/edit',
            )
        );

        // id записи
        $shopPaymentID = Request_RequestParams::getParamInt('id');
        if ($shopPaymentID === NULL) {
            throw new HTTP_Exception_404('Payment order not is found!');
        }else {
            $model = new Model_Pyramid_Shop_Payment();
            if (! $this->dublicateObjectLanguage($model, $shopPaymentID)) {
                throw new HTTP_Exception_404('Payment order not is found!');
            }
        }
        $this->_requestShopClients($model->getShopClientID());
        $this->_requestShopPaidTypes($model->getShopPaidTypeID());

        // получаем данные
        $data = View_View::findOne('DB_Pyramid_Shop_Payment', $this->_sitePageData->shopID, "_shop/payment/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopPaymentID), array('gov_client_id' => array('name')));

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_add() {
        $this->_sitePageData->url = '/pyramid/shoppayment/add';

        $result = Api_Pyramid_Shop_Payment::addByBill(
            Request_RequestParams::getParamFloat('amount'),
            Request_RequestParams::getParamInt('shop_bill_id'),
            Request_RequestParams::getParamBoolean('is_paid'),
            Request_RequestParams::getParamInt('shop_paid_type_id'),
            $this->_sitePageData, $this->_driverDB);

        $this->response->body(json_encode($result));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/pyramid/shoppayment/save';

        $result = Api_Pyramid_Shop_Payment::save($this->_sitePageData, $this->_driverDB);

        $this->_redirectSaveResult(
            $result,
            array(
                'shop_client_name' => array(
                    'id' => 'shop_client_id',
                    'model' => new Model_Pyramid_Shop_Client(),
                ),
                'update_user_name' => array(
                    'id' => 'update_user_id',
                    'model' => new Model_User(),
                ),
                'shop_paid_type_name' => array(
                    'id' => 'shop_paid_type_id',
                    'model' => new Model_Shop_PaidType(),
                ),
            )
        );
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/pyramid/shoppayment/del';

        Api_Pyramid_Shop_Payment::delete($this->_sitePageData, $this->_driverDB);

        $this->response->body(Json::json_encode(array('error' => TRUE)));
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cash_ShopPaymentReturn extends Controller_Ab1_Cash_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Payment_Return';
        $this->controllerName = 'shoppaymentreturn';
        $this->tableID = Model_Ab1_Shop_Payment_Return::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Payment_Return::TABLE_NAME;
        $this->objectName = 'paymentreturn';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/cash/shoppaymentreturn/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/return/list/index',
            )
        );

        $shopTableRubricID = $this->_sitePageData->operation->getShopTableRubricID();
        if($shopTableRubricID < 1){
            $shopTableRubricID = Model_Ab1_Shop_Operation::RUBRIC_CASH;
        }
        // получаем список
        View_View::find('DB_Ab1_Shop_Payment_Return', $this->_sitePageData->shopID, "_shop/payment/return/list/index", "_shop/payment/return/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25, 'shop_table_rubric_id' => $shopTableRubricID),
            array(
                'shop_client_id' => array('name'),
                'shop_client_contract_id' => array('name'),
            )
        );


        $this->_putInMain('/main/_shop/payment/return/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/cash/shoppaymentreturn/list';

        // получаем список
        $this->response->body(View_View::find('DB_Ab1_Shop_Payment_Return', $this->_sitePageData->shopID,
            "_shop/payment/return/list/list", "_shop/payment/return/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cash/shoppaymentreturn/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/return/one/new',
                '_shop/payment/return/item/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );
        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/payment/return/item/list/index'] = Helpers_View::getViewObjects($dataID,
            new Model_Ab1_Shop_Payment_Return_Item(), '_shop/payment/return/item/list/index',
            '_shop/payment/return/item/one/index', $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/payment/return/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Payment_Return(),
            '_shop/payment/return/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/payment/return/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cash/shoppaymentreturn/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/return/one/edit',
                '_shop/payment/return/item/list/index',
            )
        );

        // id записи
        $shopPaymentID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Payment_Return();
            if (!$this->dublicateObjectLanguage($model, $shopPaymentID, -1, FALSE)) {
                throw new HTTP_Exception_404('Payment not is found!');
            }


        $this->_requestShopClientContract($shopPaymentID);

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        View_View::find('DB_Ab1_Shop_Payment_Return_Item', $this->_sitePageData->shopID, '_shop/payment/return/item/list/index',
            '_shop/payment/return/item/one/index', $this->_sitePageData, $this->_driverDB, array('shop_payment_return_id' => $shopPaymentID,
                'sort_by'=>array('value'=>array('id'=>'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Payment_Return', $this->_sitePageData->shopID, "_shop/payment/return/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopPaymentID), array('shop_client_id'));

        $this->_putInMain('/main/_shop/payment/return/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cash/shoppaymentreturn/save';

        $result = Api_Ab1_Shop_Payment_Return::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/cash/shoppaymentreturn/del';
        $result = Api_Ab1_Shop_Payment_Return::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}

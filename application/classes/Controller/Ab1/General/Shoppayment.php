<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_General_ShopPayment extends Controller_Ab1_General_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Payment';
        $this->controllerName = 'shoppayment';
        $this->tableID = Model_Ab1_Shop_Payment::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Payment::TABLE_NAME;
        $this->objectName = 'payment';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/general/shoppayment/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Payment', $this->_sitePageData->shopID, "_shop/payment/list/index", "_shop/payment/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array('shop_client_id' => array('name')));

        $this->_putInMain('/main/_shop/payment/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/general/shoppayment/list';

        // получаем список
        $this->response->body(View_View::find('DB_Ab1_Shop_Payment', $this->_sitePageData->shopID,
            "_shop/payment/list/list", "_shop/payment/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/general/shoppayment/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/one/new',
                '_shop/payment/item/list/index',
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
        $this->_sitePageData->replaceDatas['view::_shop/payment/item/list/index'] = Helpers_View::getViewObjects($dataID,
            new Model_Ab1_Shop_Payment_Item(), '_shop/payment/item/list/index',
            '_shop/payment/item/one/index', $this->_sitePageData, $this->_driverDB);

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/payment/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Payment(),
            '_shop/payment/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/payment/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/general/shoppayment/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/one/edit',
                '_shop/payment/item/list/index',
            )
        );

        // id записи
        $shopPaymentID = Request_RequestParams::getParamInt('id');
        if ($shopPaymentID === NULL) {
            throw new HTTP_Exception_404('Payment not is found!');
        } else {
            $model = new Model_Ab1_Shop_Payment();
            if (!$this->dublicateObjectLanguage($model, $shopPaymentID)) {
                throw new HTTP_Exception_404('Payment not is found!');
            }
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

        View_View::find('DB_Ab1_Shop_Payment_Item', $this->_sitePageData->shopID, '_shop/payment/item/list/index',
            '_shop/payment/item/one/index', $this->_sitePageData, $this->_driverDB, array('shop_payment_id' => $shopPaymentID,
                'sort_by'=>array('value'=>array('id'=>'asc')), Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Payment', $this->_sitePageData->shopID, "_shop/payment/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopPaymentID), array('shop_client_id'));

        $this->_putInMain('/main/_shop/payment/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/general/shoppayment/save';

        $result = Api_Ab1_Shop_Payment::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $model = new Model_Ab1_Shop_Client();
            $this->getDBObject($model, $result['result']['values']['shop_client_id'], $this->_sitePageData->shopMainID);
            $result['result']['shop_client'] = $model->getValues(TRUE, TRUE);
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if ($this->_sitePageData->branchID > 0) {
                $branchID = '&shop_branch_id=' . $this->_sitePageData->branchID;
            }

            if (Request_RequestParams::getParamBoolean('is_close') === FALSE) {
                $this->redirect('/general/shoppayment/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    . $branchID
                );
            } else {
                $this->redirect('/general/shoppayment/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    . $branchID
                );
            }
        }
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cashbox_ShopPayment extends Controller_Ab1_Cashbox_BasicAb1
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
        $this->_sitePageData->url = '/cashbox/shoppayment/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/list/index',
            )
        );

        $shopTableRubricID = $this->_sitePageData->operation->getShopTableRubricID();
        if($shopTableRubricID < 1){
            $shopTableRubricID = Model_Ab1_Shop_Operation::RUBRIC_CASHBOX;
        }

        $params = array(
            'limit' => 1000, 'limit_page' => 25,
            'shop_table_rubric_id' => $shopTableRubricID
        );

        if($this->_sitePageData->operation->getShopCashboxID() > 0){
            $params['shop_cashbox_id'] = $this->_sitePageData->operation->getShopCashboxID();
        }

        // получаем список
        View_View::find('DB_Ab1_Shop_Payment',
            0,
            "_shop/payment/list/index", "_shop/payment/one/index",
            $this->_sitePageData, $this->_driverDB, $params,
            array(
                'shop_client_id' => array('name'),
                'shop_client_contract_id' => array('number', 'from_at'),
            )
        );

        $this->_putInMain('/main/_shop/payment/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/cashbox/shoppayment/list';

        // получаем список
        $this->response->body(View_View::find('DB_Ab1_Shop_Payment', $this->_sitePageData->shopID,
            "_shop/payment/list/list", "_shop/payment/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cashbox/shoppayment/new';
        $this->_actionShopPaymentNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cashbox/shoppayment/edit';
        $this->_actionShopPaymentEdit();
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/cashbox/shoppayment/del';
        $result = Api_Ab1_Shop_Payment::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cashbox/shoppayment/save';

        $result = Api_Ab1_Shop_Payment::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_add_piece()
    {
        $this->_sitePageData->url = '/cashbox/shoppayment/add_piece';

        $result = Api_Ab1_Shop_Payment::addPiece($this->_sitePageData, $this->_driverDB);

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
                $this->redirect('/cashbox/shoppayment/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    . $branchID
                );
            } else {
                $this->redirect('/cashbox/shoppayment/index'
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

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cash_ShopPayment extends Controller_Ab1_Cash_BasicAb1
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
        $this->_sitePageData->url = '/cash/shoppayment/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/list/index',
            )
        );

        $shopTableRubricID = $this->_sitePageData->operation->getShopTableRubricID();
        if($shopTableRubricID < 1){
            $shopTableRubricID = Model_Ab1_Shop_Operation::RUBRIC_CASH;
        }

        // получаем список
        View_View::find('DB_Ab1_Shop_Payment',
            $this->_sitePageData->shopID,
            "_shop/payment/list/index", "_shop/payment/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25, 'shop_table_rubric_id' => $shopTableRubricID),
            array('shop_client_id' => array('name'), 'shop_client_contract_id' => array('number'))
        );

        $this->_putInMain('/main/_shop/payment/index');
    }

    public function action_list()
    {
        $this->_sitePageData->url = '/cash/shoppayment/list';

        // получаем список
        $this->response->body(View_View::find('DB_Ab1_Shop_Payment', $this->_sitePageData->shopID,
            "_shop/payment/list/list", "_shop/payment/one/list",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 50)));
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/cash/shoppayment/new';
        $this->_actionShopPaymentNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cash/shoppayment/edit';
        $this->_actionShopPaymentEdit();
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/cash/shoppayment/del';
        $result = Api_Ab1_Shop_Payment::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/cash/shoppayment/save';

        $result = Api_Ab1_Shop_Payment::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_add_car()
    {
        $this->_sitePageData->url = '/cash/shoppayment/add_car';

        $result = Api_Ab1_Shop_Payment::addCar($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_add_piece()
    {
        $this->_sitePageData->url = '/cash/shoppayment/add_piece';

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
                $this->redirect('/cash/shoppayment/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    . $branchID
                );
            } else {
                $this->redirect('/cash/shoppayment/index'
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

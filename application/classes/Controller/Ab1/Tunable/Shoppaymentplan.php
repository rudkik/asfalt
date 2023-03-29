<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Tunable_ShopPaymentPlan extends Controller_Ab1_Tunable_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Payment_Plan';
        $this->controllerName = 'shoppaymentplan';
        $this->tableID = Model_Ab1_Shop_Payment_Plan::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Payment_Plan::TABLE_NAME;
        $this->objectName = 'paymentplan';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tunable/shoppaymentplan/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/plan/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Payment_Plan', $this->_sitePageData->shopID,
            "_shop/payment/plan/list/index", "_shop/payment/plan/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array('shop_client_id' => array('name')));

        $this->_putInMain('/main/_shop/payment/plan/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tunable/shoppaymentplan/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/plan/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/payment/plan/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Payment_Plan(),
            '_shop/payment/plan/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID);

        $this->_putInMain('/main/_shop/payment/plan/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tunable/shoppaymentplan/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/payment/plan/one/edit',
            )
        );

        // id записи
        $shopPaymentPlanID = Request_RequestParams::getParamInt('id');
        if ($shopPaymentPlanID === NULL) {
            throw new HTTP_Exception_404('Payment plan not is found!');
        }else {
            $model = new Model_Ab1_Shop_Payment_Plan();
            if (! $this->dublicateObjectLanguage($model, $shopPaymentPlanID, $this->_sitePageData->shopID)) {
                throw new HTTP_Exception_404('Payment plan not is found!');
            }
        }

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Payment_Plan', $this->_sitePageData->shopID, "_shop/payment/plan/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopPaymentPlanID), array('shop_client_id'));

        $this->_putInMain('/main/_shop/payment/plan/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tunable/shoppaymentplan/save';

        $result = Api_Ab1_Shop_Payment_Plan::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tunable/shoppaymentplan/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tunable/shoppaymentplan/index'
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

    public function action_del()
    {
        $this->_sitePageData->url = '/tunable/shoppaymentplan/del';
        $result = Api_Ab1_Shop_Payment_Plan::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}

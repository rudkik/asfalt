<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_General_ShopClientAttorney extends Controller_Ab1_General_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client_Attorney';
        $this->controllerName = 'shopclientattorney';
        $this->tableID = Model_Ab1_Shop_Client_Attorney::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client_Attorney::TABLE_NAME;
        $this->objectName = 'clientattorney';

        parent::__construct($request, $response);
    }

    public function action_json() {
        $this->_sitePageData->url = '/general/shopclientattorney/json';
        $validity = Request_RequestParams::getParamDate('validity');
        if($validity === null){
            $validity = date('Y-m-d');
        }
        $this->_getJSONList(
            $this->_sitePageData->shopID,
            Request_RequestParams::setParams(
                array(
                    'validity' => $validity,
                    'sort_by' => array(
                        'to_at' => 'desc'
                    )
                )
            )
        );
    }

    public function action_index() {
        $this->_sitePageData->url = '/general/shopclientattorney/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/attorney/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Client_Attorney',
            $this->_sitePageData->shopID,
            "_shop/client/attorney/list/index", "_shop/client/attorney/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_client_id' => array('name', 'balance', 'balance_cache')
            )
        );

        $this->_putInMain('/main/_shop/client/attorney/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/general/shopclientattorney/edit';

        $this->_actionShopClientAttorneyEdit();
    }

    public function action_calc_balance()
    {
        $this->_sitePageData->url = '/general/shopclientattorney/calc_balance';

        $shopClientAttorneyID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Client_Attorney();
        $model->setDBDriver($this->_driverDB);

        if (!Helpers_DB::dublicateObjectLanguage($model, $shopClientAttorneyID, $this->_sitePageData)) {
            throw new HTTP_Exception_500('Client attorney id="' . $shopClientAttorneyID . '" not found. #02022020');
        }

        Api_Ab1_Shop_Client_Attorney::calcBalanceBlock(
            $shopClientAttorneyID, $this->_sitePageData, $this->_driverDB
        );
        Api_Ab1_Shop_Client_Attorney::calcDeliveryBalanceBlock(
            $shopClientAttorneyID, $this->_sitePageData, $this->_driverDB
        );

        Api_Ab1_Shop_Client::calcBalanceBlock(
            $model->getShopClientID(), $this->_sitePageData, $this->_driverDB
        );
        Api_Ab1_Shop_Client::calcBalanceCash(
            $model->getShopClientID(), $this->_sitePageData, $this->_driverDB
        );

        $this->redirect('/general/shopclientattorney/index?id='.$shopClientAttorneyID);
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sbyt_ShopClientBalanceDay extends Controller_Ab1_Sbyt_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client_Balance_Day';
        $this->controllerName = 'shopclientbalanceday';
        $this->tableID = Model_Ab1_Shop_Client_Balance_Day::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client_Balance_Day::TABLE_NAME;
        $this->objectName = 'clientbalanceday';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/sbyt/shopclientbalanceday/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/balance/day/list/index',
            )
        );

        // получаем список
        View_View::findBranch(
            'DB_Ab1_Shop_Client_Balance_Day', array(),
            "_shop/client/balance/day/list/index", "_shop/client/balance/day/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25, 'shop_client_id_not' => 175747, 'shop_client_id.is_buyer' => true,),
            array('shop_client_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/client/balance/day/index');
    }

    public function action_fixed() {
        $this->_sitePageData->url = '/sbyt/shopclientbalanceday/fixed';

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Client', 0, $this->_sitePageData, $this->_driverDB,
            [], 0, true
        );

        $date = Request_RequestParams::getParamDate('date');
        if(empty($date)){
            $date = '2020-12-31';
        }
        $dateNext = Helpers_DateTime::plusDays($date, 1);

        $model = new Model_Ab1_Shop_Client_Balance_Day();
        $model->setDBDriver($this->_driverDB);

        foreach ($ids->childs as $child){
            $balance = Api_Ab1_Shop_Client::calcBalance(
                $child->id, $this->_sitePageData, $this->_driverDB, $date
            );

            if($balance['balance'] < 10000){
                continue;
            }

            $model->clear();
            $model->setBlockBalanceClient($balance['balance'] * -1);
            $model->setShopClientID($child->id);
            $model->setDate($dateNext);

            Helpers_DB::saveDBObject($model, $this->_sitePageData, $this->_sitePageData->shopMainID);
        }

        echo 'finish';
    }

    public function action_fixed_block() {
        $this->_sitePageData->url = '/sbyt/shopclientbalanceday/fixed_block';

        $date = Request_RequestParams::getParamDate('date');
        if(empty($date)){
            $date = '2020-12-31';
        }

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Client_Balance_Day', 0, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'date_from' => $date,
                ]
            ),
            0, true
        );

        $model = new Model_Ab1_Shop_Client_Balance_Day();
        $model->setDBDriver($this->_driverDB);

        foreach ($ids->childs as $child){
            $child->setModel($model);

            $model->setBlockBalanceClient(Api_Ab1_Shop_Client_Balance_Day::getBlockBalance($model, $this->_sitePageData, $this->_driverDB));

            Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
        }


        $ids = Request_Request::find(
            'DB_Ab1_Shop_Act_Revise_Item', 0, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'date_from' => $date,
                    'is_receive' => true,
                ]
            ),
            0, true
        );

        $model = new Model_Ab1_Shop_Act_Revise_Item();
        $model->setDBDriver($this->_driverDB);

        foreach ($ids->childs as $child){
            $child->setModel($model);

            if ($model->getShopClientBalanceDayID() < 1 && $model->getIsReceive()) {
                $model->setShopClientBalanceDayID(
                    Api_Ab1_Shop_Client_Balance_Day::setClientBalanceDay(
                        $model->getShopClientID(), $model->getDate(), $this->_sitePageData, $this->_driverDB
                    )
                );
            }

            Helpers_DB::saveDBObject($model, $this->_sitePageData, $model->shopID);
        }


        $ids = Request_Request::find(
            'DB_Ab1_Shop_Car', 0, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['created_at_from' => $date]), 0, true
        );

        $model = new Model_Ab1_Shop_Car();
        $model->setDBDriver($this->_driverDB);

        foreach ($ids->childs as $child){
            $child->setModel($model);

            Api_Ab1_Shop_Car::setAmount(
                $model->getAmount(), $model, $this->_sitePageData, $this->_driverDB
            );
        }

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Piece', 0, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(['created_at_from' => $date]), 0, true
        );

        $model = new Model_Ab1_Shop_Piece();
        $model->setDBDriver($this->_driverDB);

        foreach ($ids->childs as $child){
            $child->setModel($model);

            Api_Ab1_Shop_Piece::setAmount(
                $model->getAmount(), $model, $this->_sitePageData, $this->_driverDB
            );
        }

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Act_Revise_Item', 0, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'date_from' => $date,
                    'is_receive' => false,
                ]
            ),
            0, true
        );

        $model = new Model_Ab1_Shop_Act_Revise_Item();
        $model->setDBDriver($this->_driverDB);

        foreach ($ids->childs as $child){
            $child->setModel($model);

            Api_Ab1_Shop_Client_Balance_Day::blockActReviseClientBalanceDay(
                $model->getShopClientID(), $model->id, $model->getAmount(), $this->_sitePageData, $this->_driverDB
            );
        }

        echo 'finish';
    }
}

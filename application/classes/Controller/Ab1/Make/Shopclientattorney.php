<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Make_ShopClientAttorney extends Controller_Ab1_Make_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client_Attorney';
        $this->controllerName = 'shopclientattorney';
        $this->tableID = Model_Ab1_Shop_Client_Attorney::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client_Attorney::TABLE_NAME;
        $this->objectName = 'client';

        parent::__construct($request, $response);
    }

    public function action_json() {
        $this->_sitePageData->url = '/make/shopclientattorney/json';

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
        $this->_sitePageData->url = '/make/shopclientattorney/index';

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
            Request_RequestParams::setParams(
                array(
                    'limit' => 1000, 'limit_page' => 25,
                    'sort_by' => array(
                        'attorney_updated_at' => 'desc'
                    )

                ), false
            ),
            array(
                'shop_client_id' => array('name', 'balance', 'balance_cache'),
                'create_user_id' => array('name'),
                'attorney_update_user_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/client/attorney/index');
    }

    public function action_control() {
        $this->_sitePageData->url = '/make/shopclientattorney/control';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/attorney/list/control',
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'validity' => date('Y-m-d'),
                'sort_by' => array(
                    'shop_client_id.name' => 'asc',
                    'number' => 'asc'
                ),
            )
        );

        $shopClientAttorneyIDs = Request_Request::find('DB_Ab1_Shop_Client_Attorney',
            $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            $params,0, true,
            array(
                'shop_client_id' => array('name', 'balance', 'balance_cache'),
                'create_user_id' => array('name')
            )
        );

        foreach ($shopClientAttorneyIDs->childs as $child){
            $balance = $child->getElementValue('shop_client_id', 'balance', 0);
            $balanceCash = $child->getElementValue('shop_client_id', 'balance_cache', 0);
            $balance -= $balanceCash;

            $child->additionDatas['b'] = array(
                'client' => $child->getElementValue('shop_client_id'),
                'client_balance' => $balance,
                'diff' => $balance - $child->values['balance'],
                'balance_cash' => $balanceCash,
            );
        }
        $shopClientAttorneyIDs->childsSortBy(Request_RequestParams::getParamArray('sort_by', array(), array()), true, true);

        $model = new Model_Ab1_Shop_Client_Attorney();
        $model->setDBDriver($this->_driverDB);
        $result = Helpers_View::getViewObjects(
            $shopClientAttorneyIDs, $model,
            "_shop/client/attorney/list/control", "_shop/client/attorney/one/control",
            $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->replaceDatas['view::_shop/client/attorney/list/control'] = $result;

        $this->_putInMain('/main/_shop/client/attorney/control');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/make/shopclientattorney/edit';
        $this->_actionShopClientAttorneyEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/make/shopclientattorney/save';

        $result = Api_Ab1_Shop_Client_Attorney::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

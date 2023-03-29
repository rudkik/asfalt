<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopClientAttorney extends Controller_Ab1_Peo_BasicAb1 {

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
        $this->_sitePageData->url = '/peo/shopclientattorney/json';
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
        $this->_sitePageData->url = '/peo/shopclientattorney/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/attorney/list/index',
            )
        );

        // получаем список
        View_View::find('DBAb1_Shop_Client_Attorney', $this->_sitePageData->shopID, "_shop/client/attorney/list/index", "_shop/client/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25));

        $this->_putInMain('/main/_shop/client/attorney/index');
    }
}

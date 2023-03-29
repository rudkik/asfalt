<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Sales_Shop extends Controller_Ab1_Sales_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Act_Revise';
        $this->controllerName = 'shopactrevise';
        $this->tableID = Model_Ab1_Shop_Act_Revise::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Act_Revise::TABLE_NAME;
        $this->objectName = 'actrevise';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/sales/shopactrevise/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/revise/list/index',
            )
        );

        $this->_requestCheckTypes();

        // получаем список
        View_View::find('DB_Ab1_Shop_Act_Revise',
            $this->_sitePageData->shopID,
            "_shop/act/revise/list/index", "_shop/act/revise/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25), array('shop_client_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/act/revise/index');
    }
}

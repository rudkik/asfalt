<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Bar_ShopTalon extends Controller_Magazine_Bar_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Talon';
        $this->controllerName = 'shoptalon';
        $this->tableID = Model_Magazine_Shop_Talon::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Talon::TABLE_NAME;
        $this->objectName = 'talon';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/bar/shoptalon/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/talon/list/index',
            )
        );

        $this->_requestShopWorkers();

        // получаем список
        View_View::findBranch('DB_Magazine_Shop_Talon',
            $this->_sitePageData->shopMainID, "_shop/talon/list/index", "_shop/talon/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25),
            array('shop_worker_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/talon/index');
    }

    /**
     * Пересчитываем талоны за заданный год
     */
    public function action_calc_stocks()
    {
        $this->_sitePageData->url = '/bar/shopptalon/calc_stocks';

        $year = Request_RequestParams::getParamInt('year');
        if(empty($year)){
            $year = date('Y');
        }

        for ($i = 1; $i < 13; $i++){
            Api_Magazine_Shop_Talon::calcQuantityTalonAll($i, $year, $this->_sitePageData, $this->_driverDB);
        }
        echo 'finish'; die;
    }
}

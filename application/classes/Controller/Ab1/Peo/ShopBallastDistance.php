<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_ShopBallastDistance extends Controller_Ab1_Peo_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Ballast_Distance';
        $this->controllerName = 'shopballastdistance';
        $this->tableID = Model_Ab1_Shop_Ballast_Distance::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Ballast_Distance::TABLE_NAME;
        $this->objectName = 'ballastdistance';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/peo/shopballastdistance/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/distance/list/index',
            )
        );

        // получаем список
        View_View::findBranch('DB_Ab1_Shop_Ballast_Distance',
            $this->_sitePageData->shopMainID,
            "_shop/ballast/distance/list/index", "_shop/ballast/distance/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array('shop_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/ballast/distance/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/peo/shopballastdistance/new';
        $this->_actionShopBallastDistanceNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/peo/shopballastdistance/edit';
        $this->_actionShopBallastDistanceEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/peo/shopballastdistance/save';

        $result = Api_Ab1_Shop_Ballast_Distance::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

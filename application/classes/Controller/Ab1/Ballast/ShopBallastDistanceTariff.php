<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ballast_ShopBallastDistanceTariff extends Controller_Ab1_Ballast_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Ballast_Distance_Tariff';
        $this->controllerName = 'shopballastdistancetariff';
        $this->tableID = Model_Ab1_Shop_Ballast_Distance_Tariff::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Ballast_Distance_Tariff::TABLE_NAME;
        $this->objectName = 'ballastdistancetariff';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/ballast/shopballastdistancetariff/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/distance/tariff/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Ballast_Distance_Tariff', $this->_sitePageData->shopID, "_shop/ballast/distance/tariff/list/index", "_shop/ballast/distance/tariff/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),array('shop_ballast_driver_id' => array('name')));

        $this->_putInMain('/main/_shop/ballast/distance/tariff/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/ballast/shopballastdistancetariff/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/distance/tariff/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;
        $this->_sitePageData->replaceDatas['view::_shop/ballast/distance/tariff/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Ballast_Distance_Tariff(),
            '_shop/ballast/distance/tariff/one/new', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/ballast/distance/tariff/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ballast/shopballastdistancetariff/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ballast/distance/tariff/one/edit',
            )
        );

        // id записи
        $shopDriverID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Ballast_Distance_Tariff();
        if (!$this->dublicateObjectLanguage($model, $shopDriverID, -1, FALSE)) {
            throw new HTTP_Exception_404('Distance tariff not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Ballast_Distance_Tariff', $this->_sitePageData->shopID, "_shop/ballast/distance/tariff/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopDriverID),
            array('shop_ballast_driver_id' => array('name')));

        $this->_putInMain('/main/_shop/ballast/distance/tariff/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ballast/shopballastdistancetariff/save';

        $result = Api_Ab1_Shop_Ballast_Distance_Tariff::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Train_ShopBoxcarDepartureStation extends Controller_Ab1_Train_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Boxcar_Departure_Station';
        $this->controllerName = 'shopboxcardeparturestation';
        $this->tableID = Model_Ab1_Shop_Boxcar_Departure_Station::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Boxcar_Departure_Station::TABLE_NAME;
        $this->objectName = 'boxcardeparturestation';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/train/shopboxcardeparturestation/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/departure/station/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Boxcar_Departure_Station', $this->_sitePageData->shopMainID,
            "_shop/boxcar/departure/station/list/index", "_shop/boxcar/departure/station/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array());

        $this->_putInMain('/main/_shop/boxcar/departure/station/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/train/shopboxcardeparturestation/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/departure/station/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/boxcar/departure/station/one/new'] = Helpers_View::getViewObject($dataID,
            new Model_Ab1_Shop_Boxcar_Departure_Station(), '_shop/boxcar/departure/station/one/new', $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/boxcar/departure/station/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/train/shopboxcardeparturestation/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/boxcar/departure/station/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Boxcar_Departure_Station();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Departure station not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Boxcar_Departure_Station', $this->_sitePageData->shopMainID, "_shop/boxcar/departure/station/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));

        $this->_putInMain('/main/_shop/boxcar/departure/station/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/train/shopboxcar/departure/station/save';

        $result = Api_Ab1_Shop_Boxcar_Departure_Station::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

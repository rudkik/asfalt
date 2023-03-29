<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bid_ShopSpecialTransport extends Controller_Ab1_Bid_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Special_Transport';
        $this->controllerName = 'shopspecialtransport';
        $this->tableID = Model_Ab1_Shop_Special_Transport::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Special_Transport::TABLE_NAME;
        $this->objectName = 'specialtransport';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/bid/shopspecialtransport/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/special/transport/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Special_Transport', $this->_sitePageData->shopMainID,
            "_shop/special/transport/list/index", "_shop/special/transport/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25), array());

        $this->_putInMain('/main/_shop/special/transport/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bid/shopspecialtransport/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/special/transport/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/special/transport/one/new'] = Helpers_View::getViewObject($dataID,
            new Model_Ab1_Shop_Special_Transport(), '_shop/special/transport/one/new', $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/special/transport/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bid/shopspecialtransport/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/special/transport/one/edit',
            )
        );

        // id записи
        $shopRawID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Special_Transport();
        if (! $this->dublicateObjectLanguage($model, $shopRawID, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Raw not is found!');
        }

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Special_Transport', $this->_sitePageData->shopMainID,
            "_shop/special/transport/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopRawID));

        $this->_putInMain('/main/_shop/special/transport/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bid/shopspecialtransport/save';

        $result = Api_Ab1_Shop_Special_Transport::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

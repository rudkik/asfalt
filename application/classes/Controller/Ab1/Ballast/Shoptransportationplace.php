<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Ballast_ShopTransportationPlace extends Controller_Ab1_Ballast_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Transportation_Place';
        $this->controllerName = 'shoptransportationplace';
        $this->tableID = Model_Ab1_Shop_Transportation_Place::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Transportation_Place::TABLE_NAME;
        $this->objectName = 'ballastcrusher';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/ballast/shoptransportationplace/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/transportation/place/list/index',
            )
        );

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Transportation_Place', $this->_sitePageData->shopID,
            "_shop/transportation/place/list/index", "_shop/transportation/place/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25)
        );

        $this->_putInMain('/main/_shop/transportation/place/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/ballast/shoptransportationplace/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/transportation/place/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/transportation/place/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Transportation_Place(),
            '_shop/transportation/place/one/new', $this->_sitePageData, $this->_driverDB
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/transportation/place/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ballast/shoptransportationplace/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/transportation/place/one/edit',
            )
        );

        // id записи
        $shopDriverID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Transportation_Place();
        if (!$this->dublicateObjectLanguage($model, $shopDriverID, -1, FALSE)) {
            throw new HTTP_Exception_404('Transportation place not is found!');
        }

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne(
            'DB_Ab1_Shop_Transportation_Place', $this->_sitePageData->shopID,
            "_shop/transportation/place/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopDriverID)
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/transportation/place/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ballast/shoptransportationplace/save';

        $result = Api_Ab1_Shop_Transportation_Place::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

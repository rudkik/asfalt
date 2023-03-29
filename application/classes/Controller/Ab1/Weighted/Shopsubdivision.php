<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopSubdivision extends Controller_Ab1_Weighted_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Subdivision';
        $this->controllerName = 'shopsubdivision';
        $this->tableID = Model_Ab1_Shop_Subdivision::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Subdivision::TABLE_NAME;
        $this->objectName = 'subdivision';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shopsubdivision/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/subdivision/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Subdivision',
            $this->_sitePageData->shopID,
            "_shop/subdivision/list/index", "_shop/subdivision/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25)
        );

        $this->_putInMain('/main/_shop/subdivision/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopsubdivision/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/subdivision/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        $this->_sitePageData->replaceDatas['view::_shop/subdivision/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Subdivision(),
            '_shop/subdivision/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID);
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/subdivision/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopsubdivision/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/subdivision/one/edit',
            )
        );

        // id записи
        $shopSubdivisionID = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Subdivision();
        if (! $this->dublicateObjectLanguage($model, $shopSubdivisionID, $this->_sitePageData->shopID)) {
            throw new HTTP_Exception_404('Subdivision not is found!');
        }

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_Shop_Subdivision', $this->_sitePageData->shopID, "_shop/subdivision/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopSubdivisionID));
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/subdivision/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopsubdivision/save';

        $result = Api_Ab1_Shop_Subdivision::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Weighted_ShopStorage extends Controller_Ab1_Weighted_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Storage';
        $this->controllerName = 'shopstorage';
        $this->tableID = Model_Ab1_Shop_Storage::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Storage::TABLE_NAME;
        $this->objectName = 'storage';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/weighted/shopstorage/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/storage/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Storage',
            $this->_sitePageData->shopID,
            "_shop/storage/list/index", "_shop/storage/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25),
            array('shop_subdivision_id' => array('name'))
        );

        $this->_putInMain('/main/_shop/storage/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/weighted/shopstorage/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/storage/one/new',
            )
        );

        $this->_requestShopSubdivisions(null, 0, '');
        $this->_requestShopTurnTypes();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/storage/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Storage(),
            '_shop/storage/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID);

        $this->_putInMain('/main/_shop/storage/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/weighted/shopstorage/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/storage/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Storage();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Storage not is found!');
        }

        $this->_requestShopSubdivisions($model->getShopSubdivisionID(), 0, '');
        $this->_requestShopTurnTypes($model->getShopTurnTypeID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Storage', $this->_sitePageData->shopID, "_shop/storage/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));

        $this->_putInMain('/main/_shop/storage/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/weighted/shopstorage/save';

        $result = Api_Ab1_Shop_Storage::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

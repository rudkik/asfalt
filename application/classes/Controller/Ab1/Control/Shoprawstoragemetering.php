<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Control_ShopRawStorageMetering extends Controller_Ab1_Control_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Raw_Storage_Metering';
        $this->controllerName = 'shoprawstoragemetering';
        $this->tableID = Model_Ab1_Shop_Raw_Storage_Metering::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Raw_Storage_Metering::TABLE_NAME;
        $this->objectName = 'rawstoragemetering';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/control/shoprawstoragemetering/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/storage/metering/list/index',
            )
        );

        $this->_requestShopRaws();
        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage');

        $rawType = $this->_sitePageData->operation->getShopRawStorageTypeID();
        if($rawType < 1){
            $rawType = null;
        }

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Raw_Storage_Metering', $this->_sitePageData->shopID,
            "_shop/raw/storage/metering/list/index", "_shop/raw/storage/metering/one/index",
            $this->_sitePageData, $this->_driverDB,
            array(
                'shop_raw_storage_id.shop_raw_storage_type_id' => $rawType,
                'limit' => 1000, 'limit_page' => 25
            ),
            array(
                'shop_raw_id' => array('name'),
                'shop_raw_storage_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/raw/storage/metering/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/control/shoprawstoragemetering/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/storage/metering/one/new',
            )
        );

        $this->_requestShopRaws();
        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/raw/storage/metering/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Raw_Storage_Metering(),
            '_shop/raw/storage/metering/one/new', $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopID
        );

        $this->_putInMain('/main/_shop/raw/storage/metering/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/control/shoprawstoragemetering/edit';
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/storage/metering/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Raw_Storage_Metering();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Raw storage metering not is found!');
        }

        $this->_requestShopRaws($model->getShopRawID());
        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage', $model->getShopRawStorageID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Raw_Storage_Metering',
            $this->_sitePageData->shopID, "_shop/raw/storage/metering/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );

        $this->_putInMain('/main/_shop/raw/storage/metering/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/control/shoprawstoragemetering/save';

        $result = Api_Ab1_Shop_Raw_Storage_Metering::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

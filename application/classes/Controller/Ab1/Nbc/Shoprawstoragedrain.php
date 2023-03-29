<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Nbc_ShopRawStorageDrain extends Controller_Ab1_Nbc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Raw_Storage_Drain';
        $this->controllerName = 'shoprawstoragedrain';
        $this->tableID = Model_Ab1_Shop_Raw_Storage_Drain::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Raw_Storage_Drain::TABLE_NAME;
        $this->objectName = 'rawstoragedrain';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/nbc/shoprawstoragedrain/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/storage/drain/list/index',
            )
        );

        $this->_requestShopRaws();
        $this->_requestShopMaterials();
        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage');
        $this->_requestListDB('DB_Ab1_Shop_Material_Storage');

        $rawType = $this->_sitePageData->operation->getShopRawStorageTypeID();
        if($rawType < 1){
            $rawType = null;
        }

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Raw_Storage_Drain', $this->_sitePageData->shopID,
            "_shop/raw/storage/drain/list/index", "_shop/raw/storage/drain/one/index",
            $this->_sitePageData, $this->_driverDB,
            array(
                'shop_raw_storage_id.shop_raw_storage_type_id' => $rawType,
                'limit' => 1000, 'limit_page' => 25
            ),
            array(
                'shop_raw_drain_chute_id' => array('name'),
                'shop_material_id' => array('name'),
                'shop_material_storage_id' => array('name'),
                'shop_raw_id' => array('name'),
                'shop_raw_storage_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/raw/storage/drain/index');
    }

    public function action_add()
    {
        $this->_sitePageData->url = '/nbc/shoprawstoragedrain/add';

        // id записи
        $id = Request_RequestParams::getParamInt('shop_raw_storage_id');
        $model = new Model_Ab1_Shop_Raw_Storage();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Raw storage not is found!');
        }

        $this->_requestShopRawDrainChutes();
        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage');
        $this->_requestShopMaterials();
        $this->_requestListDB('DB_Ab1_Shop_Material_Storage');

        // получаем данные
        $data = View_View::findOne('DB_Ab1_Shop_Raw_Storage',
            $this->_sitePageData->shopID, "_shop/raw/storage/drain/one/add",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );
        $this->response->body($data);
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/nbc/shoprawstoragedrain/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/storage/drain/one/new',
            )
        );

        $this->_requestShopRaws();
        $this->_requestShopMaterials();
        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage');
        $this->_requestListDB('DB_Ab1_Shop_Material_Storage');
        $this->_requestListDB('DB_Ab1_Shop_Raw_DrainChute');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/raw/storage/drain/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Raw_Storage_Drain(),
            '_shop/raw/storage/drain/one/new', $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopID
        );

        $this->_putInMain('/main/_shop/raw/storage/drain/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/nbc/shoprawstoragedrain/edit';
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/storage/drain/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Raw_Storage_Drain();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Raw storage drain not is found!');
        }

        $this->_requestShopRaws($model->getShopRawID());
        $this->_requestShopMaterials($model->getShopMaterialID());
        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage', $model->getShopRawStorageID());
        $this->_requestListDB('DB_Ab1_Shop_Material_Storage', $model->getShopMaterialStorageID());
        $this->_requestListDB('DB_Ab1_Shop_Raw_DrainChute', $model->getShopRawDrainChuteID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Raw_Storage_Drain',
            $this->_sitePageData->shopID, "_shop/raw/storage/drain/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );

        $this->_putInMain('/main/_shop/raw/storage/drain/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/nbc/shoprawstoragedrain/save';

        $result = Api_Ab1_Shop_Raw_Storage_Drain::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

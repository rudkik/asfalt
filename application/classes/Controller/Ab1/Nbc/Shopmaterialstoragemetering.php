<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Nbc_ShopMaterialStorageMetering extends Controller_Ab1_Nbc_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Material_Storage_Metering';
        $this->controllerName = 'shopmaterialstoragemetering';
        $this->tableID = Model_Ab1_Shop_Material_Storage_Metering::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Material_Storage_Metering::TABLE_NAME;
        $this->objectName = 'materialstoragemetering';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/nbc/shopmaterialstoragemetering/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/storage/metering/list/index',
            )
        );

        $this->_requestShopMaterials();
        $this->_requestListDB('DB_Ab1_Shop_Material_Storage');

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Material_Storage_Metering', $this->_sitePageData->shopID,
            "_shop/material/storage/metering/list/index", "_shop/material/storage/metering/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_material_id' => array('name'),
                'shop_material_storage_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/material/storage/metering/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/nbc/shopmaterialstoragemetering/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/storage/metering/one/new',
            )
        );

        $this->_requestShopMaterials();
        $this->_requestListDB('DB_Ab1_Shop_Material_Storage');

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/material/storage/metering/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Ab1_Shop_Material_Storage_Metering(),
            '_shop/material/storage/metering/one/new', $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopID
        );

        $this->_putInMain('/main/_shop/material/storage/metering/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/nbc/shopmaterialstoragemetering/edit';
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/material/storage/metering/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Material_Storage_Metering();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Material storage metering not is found!');
        }

        $this->_requestShopMaterials($model->getShopMaterialID());
        $this->_requestListDB('DB_Ab1_Shop_Material_Storage', $model->getShopMaterialStorageID());

        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Material_Storage_Metering',
            $this->_sitePageData->shopID, "_shop/material/storage/metering/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );

        $this->_putInMain('/main/_shop/material/storage/metering/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/nbc/shopmaterialstoragemetering/save';

        $result = Api_Ab1_Shop_Material_Storage_Metering::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Control_ShopRawStorage extends Controller_Ab1_Control_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Raw_Storage';
        $this->controllerName = 'shoprawstorage';
        $this->tableID = Model_Ab1_Shop_Raw_Storage::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Raw_Storage::TABLE_NAME;
        $this->objectName = 'rawstorage';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/control/shoprawstorage/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/storage/list/index',
            )
        );
        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage_Type');
        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage_Group');

        $rawType = $this->_sitePageData->operation->getShopRawStorageTypeID();
        if($rawType < 1){
            $rawType = null;
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::find(
            'DB_Ab1_Shop_Raw_Storage', $this->_sitePageData->shopID,
            "_shop/raw/storage/list/index", "_shop/raw/storage/one/index",
            $this->_sitePageData, $this->_driverDB,
            array(
                'shop_raw_storage_type_id' => $rawType,
                'limit' => 1000, 'limit_page' => 25,
            ),
            array(
                'shop_raw_storage_type_id' => array('name'),
                'shop_raw_storage_group_id' => array('name'),
            )
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/raw/storage/index');
    }

    public function action_total() {
        $this->_sitePageData->url = '/control/shoprawstorage/total';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/raw/storage/list/total',
            )
        );

        $this->_requestShopRaws();
        $this->_requestListDB('DB_Ab1_Shop_Raw_Storage');

        $rawType = $this->_sitePageData->operation->getShopRawStorageTypeID();
        if($rawType < 1){
            $rawType = null;
        }

        $ids = Request_Request::find(
            'DB_Ab1_Shop_Raw_Storage', $this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                array(
                    'shop_raw_storage_type_id' => $rawType,
                    'sort_by' => ['name' => 'asc'],
                ),
                false
            ),
            0, true,
            array(
                'shop_raw_id' => array('name'),
                'shop_raw_storage_group_id' => array('name'),
                'shop_boxcar_client_id' => array('name'),
            )
        );

        $groups = new MyArray();
        foreach ($ids->childs as $child){
            $group = $child->values['shop_raw_storage_group_id'];
            if(!key_exists($group, $groups->childs)){
                $groups->childs[$group] = $child;
            }
            $groups->childs[$group]->childs[] = $child;
        }

        $this->_sitePageData->newShopShablonPath('ab1/_all');

        foreach ($groups->childs as $child){
            $child->additionDatas['view::_shop/raw/storage/list/total'] = Helpers_View::getViews(
                "_shop/raw/storage/list/total", "_shop/raw/storage/one/total",
                $this->_sitePageData, $this->_driverDB, $child
            );
        }

        $data = Helpers_View::getViews(
            "_shop/raw/storage/group/list/total", "_shop/raw/storage/group/one/total",
            $this->_sitePageData, $this->_driverDB, $groups
        );

        $this->_sitePageData->addReplaceAndGlobalDatas('view::_shop/raw/storage/group/list/total', $data);

        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/_shop/raw/storage/total');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/control/shoprawstorage/new';
        $this->_actionShopRawStorageNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/control/shoprawstorage/edit';
        $this->_actionShopRawStorageEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/control/shoprawstorage/save';

        $result = Api_Ab1_Shop_Raw_Storage::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

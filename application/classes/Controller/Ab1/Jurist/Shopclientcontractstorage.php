<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Jurist_ShopClientContractStorage extends Controller_Ab1_Jurist_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Client_Contract_Storage';
        $this->controllerName = 'shopclientcontractstorage';
        $this->tableID = Model_Ab1_Shop_Client_Contract_Storage::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Client_Contract_Storage::TABLE_NAME;
        $this->objectName = 'clientcontractstorage';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/jurist/shopclientcontractstorage/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/contract/storage/list/index',
            )
        );

        // получаем список
        View_View::find(
            'DB_Ab1_Shop_Client_Contract_Storage', $this->_sitePageData->shopID,
            "_shop/client/contract/storage/list/index", "_shop/client/contract/storage/one/index",
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25)
        );

        $this->_putInMain('/main/_shop/client/contract/storage/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/jurist/shopclientcontractstorage/new';
        $this->_actionShopClientContractStorageNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/jurist/shopclientcontractstorage/edit';
        $this->_actionShopClientContractStorageEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/jurist/shopclientcontractstorage/save';

        $result = Api_Ab1_Shop_Client_Contract_Storage::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }
}

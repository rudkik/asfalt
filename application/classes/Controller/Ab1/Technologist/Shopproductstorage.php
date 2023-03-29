<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Technologist_ShopProductStorage extends Controller_Ab1_Technologist_BasicAb1{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Product_Storage';
        $this->controllerName = 'shopproductstorage';
        $this->tableID = Model_Ab1_Shop_Product_Storage::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Product_Storage::TABLE_NAME;
        $this->objectName = 'productstorage';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/technologist/shopproductstorage/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/product/storage/list/index',
            )
        );

        // основная продукция
        $this->_requestShopProducts(
            null, 0, NULL, FALSE,
            [
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR,
                Model_Ab1_ProductView::PRODUCT_TYPE_CAR_AND_PIECE,
                Model_Ab1_ProductView::PRODUCT_TYPE_PIECE
            ]
        );

        $this->_requestShopOperations(Model_Ab1_Shop_Operation::RUBRIC_WEIGHT);
        $this->_requestShopStorages();
        $this->_requestShopTurnPlaces();

        // получаем список
        View_View::find('DB_Ab1_Shop_Product_Storage',
            $this->_sitePageData->shopID, "_shop/product/storage/list/index", "_shop/product/storage/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_storage_id' => array('name'),
                'shop_product_id' => array('name'),
                'weighted_operation_id' => array('name'),
                'asu_operation_id' => array('name'),
                'shop_turn_place_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/product/storage/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/technologist/shopproductstorage/edit';
        $this->_actionShopProductStorageEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/technologist/shopproductstorage/save';
        $result = Api_Ab1_Shop_Product_Storage::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_statistics()
    {
        $this->_sitePageData->url = '/technologist/shopproductstorage/statistics';

        $this->_actionShopProductStorageStatistics();
    }
}

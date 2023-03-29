<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_ShopReceiveItemGTD extends Controller_Magazine_Accounting_BasicMagazine {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Magazine_Shop_Receive_Item_GTD';
        $this->controllerName = 'shopreceiveitemgtd';
        $this->tableID = Model_Magazine_Shop_Receive_Item_GTD::TABLE_ID;
        $this->tableName = Model_Magazine_Shop_Receive_Item_GTD::TABLE_NAME;
        $this->objectName = 'receiveitemgtd';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/accounting/shopreceiveitemgtd/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/receive/item/gtd/list/index',
            )
        );

        $this->_requestShopProducts(null, $this->_sitePageData->shopMainID);
        $this->_requestShopSupplier();

        // получаем список
        View_View::find('DB_Magazine_Shop_Receive_Item_GTD',
            $this->_sitePageData->shopID, "_shop/receive/item/gtd/list/index", "_shop/receive/item/gtd/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25),
            array(
                'shop_supplier_id' => array('name', 'bin'),
                'shop_product_id' => array('name', 'barcode'),
            )
        );

        $this->_putInMain('/main/_shop/receive/item/gtd/index');
    }
}

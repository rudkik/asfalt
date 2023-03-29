<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_General_ShopPricelist extends Controller_Ab1_General_BasicAb1  {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Pricelist';
        $this->controllerName = 'shoppricelist';
        $this->tableID = Model_Ab1_Shop_Pricelist::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Pricelist::TABLE_NAME;
        $this->objectName = 'pricelist';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/general/shoppricelist/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/pricelist/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Pricelist',
            $this->_sitePageData->shopMainID,
            "_shop/pricelist/list/index", "_shop/pricelist/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25),
            array(
                'shop_client_id' => array('name'),
            )
        );

        $this->_putInMain('/main/_shop/pricelist/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/general/shoppricelist/edit';
        $this->_actionShopPricelistEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/general/shoppricelist/save';

        $result = Api_Ab1_Shop_Pricelist::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_calc_balance()
    {
        $this->_sitePageData->url = '/general/shoppricelist/calc_balance';

        $id = Request_RequestParams::getParamInt('id');

        $params = Request_RequestParams::setParams(
            array(
                'shop_pricelist_id' => $id,
            )
        );
        $ids = Request_Request::find('DB_Ab1_Shop_Product_Price',
            $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB, $params
        );

        foreach ($ids->childs as $child){
            Api_Ab1_Shop_Product_Price::calcBalanceBlock(
                $child->id, $this->_sitePageData, $this->_driverDB
            );
        }

        $this->redirect('/general/shoppricelist/index?id='.$id);
    }
}

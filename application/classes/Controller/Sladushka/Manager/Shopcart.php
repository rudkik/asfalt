<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Sladushka_Manager_ShopCart extends Controller_Sladushka_Manager_BasicCabinet {

	public function action_add_good(){
		$this->_sitePageData->url = '/manager/shopcart/add_good';

        Api_Shop_Cart::addGood($this->_sitePageData->shopID, Request_RequestParams::getParamInt('id'),
            Request_RequestParams::getParamInt('child_id'),Request_RequestParams::getParamFloat('count'), $this->_sitePageData);

		$this->response->body(json_encode(array('result' => FALSE)));
	}

    public function action_edit_good(){
        $this->_sitePageData->url = '/manager/shopcart/edit_good';

        Api_Shop_Cart::setGoodCount($this->_sitePageData->shopID, Request_RequestParams::getParamInt('id'),
            Request_RequestParams::getParamInt('child_id'),Request_RequestParams::getParamFloat('count'), $this->_sitePageData);

        $this->response->body(json_encode(array('result' => FALSE)));
    }

    public function action_del_good(){
        $this->_sitePageData->url = '/manager/shopcart/del_good';

        Api_Shop_Cart::delGood($this->_sitePageData->shopID, Request_RequestParams::getParamInt('id'),
            Request_RequestParams::getParamInt('child_id'), $this->_sitePageData);

        $this->response->body(json_encode(array('result' => FALSE)));
    }

	public function action_update_goods(){
        $this->_sitePageData->url = '/manager/shopcart/update_goods';

        Api_Shop_Cart::updateGoodsCount($this->_sitePageData->shopID, Request_RequestParams::getParamArray('shopgoods', array(), array()),
            $this->_sitePageData);

        $this->response->body(json_encode(array('result' => FALSE)));
	}

    public function action_set_shop_root_id(){
        $this->_sitePageData->url = '/manager/shopcart/set_shop_root_id';

        Api_Shop_Cart::setBillShopRootID(Request_RequestParams::getParamInt('shop_root_id'), $this->_sitePageData);

        $this->redirect('/manager/shopgood/index?type=51657');
    }

    public function action_save_bill(){
        $this->_sitePageData->url = '/manager/shopcart/save_bill';
        Api_Shop_Cart::setBillData($this->_sitePageData);

        $result = Api_Shop_Cart::saveInBill($this->_sitePageData->shopID,
            Request_RequestParams::getParamInt('shop_bill_status_id'), $this->_sitePageData, $this->_driverDB);

        $result['error'] = FALSE;
        // $this->response->body(json_encode($result));
        $this->redirect('/manager/shopbill/index?type='.intval($result['values']['shop_table_catalog_id']));
    }

    public function action_save_operation_stock(){
        $this->_sitePageData->url = '/manager/shopcart/save_operation_stock';
        Api_Shop_Cart::setBillData($this->_sitePageData);

        $result = Api_Shop_Cart::saveInOperationStock($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB);

        $result['error'] = FALSE;
        // $this->response->body(json_encode($result));
        $this->redirect('/manager/shopoperationstock/index?type='.intval($result['values']['shop_table_catalog_id']));
    }

    public function action_save_return(){
        $this->_sitePageData->url = '/manager/shopcart/save_return';
        Api_Shop_Cart::setBillData($this->_sitePageData);

        $result = Api_Shop_Cart::saveInReturn($this->_sitePageData->shopID,
            Request_RequestParams::getParamInt('shop_bill_status_id'), $this->_sitePageData, $this->_driverDB);

        $result['error'] = FALSE;
        // $this->response->body(json_encode($result));
        $this->redirect('/manager/shopreturn/index?type='.intval($result['values']['shop_table_catalog_id']));
    }

    /**
     * Переносим заказ в куки (повтор заказа)
     */
    public function action_repair_bill(){
        $this->_sitePageData->url = '/manager/shopcart/repair_bill';

        Api_Shop_Cart::repairBill($this->_sitePageData->shopID, Request_RequestParams::getParamInt('id'), $this->_sitePageData,
            $this->_driverDB);

        $this->redirect('/manager/shopcart/index');
    }

    public function action_index(){
        $this->_sitePageData->url = '/manager/shopcart/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/cart/list/index',
                '_shop/branch/one/cart',
            )
        );

        View_Shop_Cart::getCartShopGoods($this->_sitePageData->shopID, '_shop/cart/list/index', '_shop/cart/one/index',
            $this->_sitePageData, $this->_driverDB, array(), array());

        View_Shop_Cart::getShopRoot($this->_sitePageData->shopID, '_shop/branch/one/cart', $this->_sitePageData, $this->_driverDB,
            array('is_error_404' => FALSE, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        $this->_putInMain('/main/_shop/cart/index');
    }

}
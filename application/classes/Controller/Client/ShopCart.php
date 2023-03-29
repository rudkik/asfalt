<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Client_ShopCart extends Controller_Client_BasicClient {
    /**
     * Задаем номер купона
     */
    public function action_set_coupon(){
        $this->_sitePageData->url = '/cart/set_coupon';

        $number = Request_RequestParams::getParamStr('number');
        if(empty($number)){
            $this->response->body(json_encode(['error' => true]));
            return '';
        }

        $current = date('Y-m-d H:i:s');

        /** @var Model_Shop_Coupon $model */
        $model = Request_Request::findOneModel(
            DB_Shop_Coupon::NAME, $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'number_full' => $number,
                    'from_at_to' => $current,
                    'to_at_from' => $current,
                ]
            )
        );

        if($model === false){
            $this->response->body(json_encode(['error' => true]));
            return '';
        }

        Api_Shop_Cart::setShopCouponID($model->id, $this->_sitePageData);

        $this->response->body(json_encode(
            [
                'error' => false,
                'discount' => $model->getDiscount(),
                'is_percent' => $model->getIsPercent()
            ]
        ));
    }

    /**
     * Задаем телефон для персональной скидки
     */
    public function action_set_person_discount(){
        $this->_sitePageData->url = '/cart/set_person_discount';

        $phone = Request_RequestParams::getParamStr('phone');
        if(empty($phone)){
            $this->response->body(json_encode(['error' => true]));
            return '';
        }

        $current = date('Y-m-d H:i:s');

        /** @var Model_Shop_PersonDiscount $model */
        $model = Request_Request::findOneModel(
            DB_Shop_PersonDiscount::NAME, $this->_sitePageData->shopMainID, $this->_sitePageData, $this->_driverDB,
            Request_RequestParams::setParams(
                [
                    'phone_full' => $phone,
                    'from_at_to' => $current,
                    'to_at_from' => $current,
                ]
            )
        );

        if($model === false){
            $this->response->body(json_encode(['error' => true]));
            return '';
        }

        Api_Shop_Cart::setShopPersonDiscountID($model->id, $this->_sitePageData);

        $this->response->body(json_encode(
            [
                'error' => false,
                'discount' => $model->getDiscount(),
                'is_percent' => $model->getIsPercent()
            ]
        ));
    }

    /**
     * Добавляем товар
     */
	public function action_add_good(){
		$this->_sitePageData->url = '/cart/add_good';

		$shopID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
		if($shopID < 1){
			$shopID = $this->_sitePageData->shopID;
		}

		Api_Shop_Cart::addGood(
		    $shopID,
            Request_RequestParams::getParamInt('id'),
			Request_RequestParams::getParamInt('child_id'),
            Request_RequestParams::getParamFloat('count'),
            $this->_sitePageData
        );

        $this->_returnBasket($shopID);
	}

    /**
     * Удаляем товар
     */
    public function action_del_good(){
        $this->_sitePageData->url = '/cart/del_good';

        $shopID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        Api_Shop_Cart::delGood($shopID, Request_RequestParams::getParamInt('id'),
            Request_RequestParams::getParamInt('child_id'), $this->_sitePageData);

        $this->_returnBasket($shopID);
    }

    /**
     * Задаем товару комментарий
     */
    public function action_set_good_comment(){
        $this->_sitePageData->url = '/cart/set_good_comment';

        $shopID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        Api_Shop_Cart::setGoodComment($shopID, Request_RequestParams::getParamInt('id'),
            Request_RequestParams::getParamInt('child_id'), $this->_sitePageData);

        $this->_returnBasket($shopID);
    }

    /**
     * Изменяем данные товара
     */
    public function action_set_good_data(){
        $this->_sitePageData->url = '/cart/set_good_data';

        $shopID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        Api_Shop_Cart::setGoodData($shopID, $this->_sitePageData);

        $this->_returnBasket($shopID);
    }

    /**
     * Измерение количества товаров
     */
    public function action_edit_good(){
        $this->_sitePageData->url = '/manager/shopcart/edit_good';

        Api_Shop_Cart::setGoodCount($this->_sitePageData->shopID, Request_RequestParams::getParamInt('id'),
            Request_RequestParams::getParamInt('child_id'), Request_RequestParams::getParamFloat('count'), $this->_sitePageData);

        $this->response->body(json_encode(array('result' => FALSE)));
    }


    /**
     * Изменяем данные списка товаров
     */
    public function action_set_goods_data(){
        $this->_sitePageData->url = '/cart/set_goods_data';

        $shopID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        Api_Shop_Cart::setGoodsData($shopID, $this->_sitePageData);

        $this->_returnBasket($shopID);
    }

    /**
     * Сохраняем корзину в заказ
     * @throws HTTP_Exception_400
     * @throws HTTP_Exception_500
     */
    public function action_save_bill(){
        $this->_sitePageData->url = '/cart/save_bill';

        $shopID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        Api_Shop_Cart::setGoodsData($shopID, $this->_sitePageData);
        Api_Shop_Cart::setBillData($this->_sitePageData);

        $result = Api_Shop_Cart::saveInBill(
            $shopID, Request_RequestParams::getParamInt('shop_bill_status_id'), $this->_sitePageData, $this->_driverDB
        );

        $url = Request_RequestParams::getParamStr('url');
        if($url !== NULL) {
            if(strpos($url, '?') === FALSE){
                $url = $url.'?';
            }

            $url = $url.'&bill_id='.$result['id'];
            if($shopID != $this->_sitePageData->shopID){
                $url = $url.'&shop_id='.$shopID;
            }
            $this->redirect($url);
        }else{
            $result['error'] = FALSE;
            $this->response->body(json_encode($result));
        }
    }

    /**
     * Переносим заказ в куки (повтор заказа)
     */
    public function action_repair_bill(){

        $this->_sitePageData->url = '/cart/repair_bill';

        $shopID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        Api_Shop_Cart::repairBill($shopID, Request_RequestParams::getParamInt('id'), $this->_sitePageData,
            $this->_driverDB);

        $this->_returnBasket($shopID);
    }

    /**
     * Изменение данных заказа и списка товаров
     */
    public function action_set_bill_data(){
        $this->_sitePageData->url = '/cart/set_bill_data';

        $shopID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        Api_Shop_Cart::setGoodsData($shopID, $this->_sitePageData);
        Api_Shop_Cart::setBillData($this->_sitePageData);

        $this->_returnBasket($shopID);
    }

    /**
     * Очищаем корзину магазина
     */
    public function action_clear_shop(){
        $this->_sitePageData->url = '/cart/clear_shop';

        $shopID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        Api_Shop_Cart::clearShop($shopID, $this->_sitePageData);

        $this->_returnBasket($shopID);
    }

    /**
     * Задаем вид доставки
     */
    public function action_set_delivery(){
        $this->_sitePageData->url = '/cart/set_delivery';


        $shopID = intval(Request_RequestParams::getParamInt('shop_branch_id'));
        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        $shopDeliveryTypeID = Request_RequestParams::getParamInt('shop_delivery_type_id');
        if($shopDeliveryTypeID === NULL){
            $shopDeliveryTypeID = Request_RequestParams::getParamInt('delivery_type_id');
        }

        Api_Shop_Cart::setShopDeliveryTypeID($shopDeliveryTypeID, $this->_sitePageData);

        $this->_returnBasket($shopID);
    }


    /**
     * Отвечаем на запрос
     * @param $shopID
     * @return bool
     * @throws HTTP_Exception_404
     */
    private function _returnBasket($shopID){
        if (!Request_RequestParams::getParamBoolean('is_result')) {
            $this->response->body(
                json_encode(
                    array(
                        'error' => FALSE,
                    )
                )
            );
            return FALSE;
        }

        // проводим редирект или получаем данные, если задана ссылка
        $url = Request_RequestParams::getParamStr('url');
        if (!empty($url)) {
            if (Request_RequestParams::getParamBoolean('is_redirect')) {
                $this->redirect($url);
                return TRUE;
            }

            // получаем данные по ссылки, имметируем запрос ссылки
            if($url[0] != '/') {
                $this->_sitePageData->url = '/' . $url;
            }
            $this->response->body(View_SitePage::loadSitePage($shopID,
                '', $this->_sitePageData, $this->_driverDB, FALSE));
            return TRUE;
        }

        // делаем просчет по скидкам и акциям
        $shopGoods = Api_Shop_Cart::countUpShopGoods($shopID, $this->_sitePageData, $this->_driverDB);

        //  считаем количество, бонусы, сумма товаров
        $count = Func::getGoodsCount($shopGoods);
        $bonus = Func::getGoodsBonus($shopGoods);
        $amount = Func::getGoodsAmount($shopGoods, $this->_sitePageData->currency->getIsRound());

        $this->response->body(
            json_encode(
                array(
                    'error' => FALSE,
                    'count' => $count,
                    'amount' => $amount,
                    'amount_str' => Func::getPriceStr($this->_sitePageData->currency, $amount),
                    'bonus' => $bonus,
                    'bonus_str' => Func::getPriceStr($this->_sitePageData->currency, $bonus),
                )
            )
        );
        return TRUE;
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

class View_Shop_Cart extends View_View {
    /**
     * Смотрим идет ли у заказа оплата через банк
     * @param $shopID
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param $isLoadView
     * @return MyArray|string
     * @throws Exception
     * @throws HTTP_Exception_404
     */
    public static function getIsPaidBank($dbObject, $shopID, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                         array $params = array(), $elements = NULL, $isLoadView = TRUЕ)
    {
        // ищем в мемкеше
        $urlParams = array('bill_id');
        $key = Helpers_DB::getURLParamDatas($urlParams, $params);
        $data = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Shop_Cart::getIsPaidBank', array(Model_Shop_PaidType::TABLE_NAME,
            Model_PaidType::TABLE_NAME, Model_Shop_Bill::TABLE_NAME), $viewObject, $sitePageData, $driver, $key);
        if ($data !== NULL){
            $sitePageData->replaceDatas['view::'.$viewObject] = $data;
            return $data;
        }

        // получаем заказ
        $billID = intval(Request_RequestParams::getParamInt('bill_id'));
        $model = new Model_Shop_Bill();
        $model->setDBDriver($driver);
        if(($billID < 1) || (! Helpers_DB::getDBObject($model, $billID, $sitePageData, $shopID))){
            throw new HTTP_Exception_404('Bill not found!');
        }

        $data = new MyArray();
        $data->isFindDB = TRUE;
        $data->values = $model->getValues(TRUE, TRUE, $sitePageData->shopID);

        $modelPaid = new Model_Shop_PaidType();
        $modelPaid->setDBDriver($driver);
        if (($model->getShopPaidTypeID() == 0) || (!Helpers_DB::getDBObject($modelPaid, $model->getShopPaidTypeID(), $sitePageData, $shopID))) {
            throw new HTTP_Exception_404('Paid type not found!');
        }
        $data->values['paid_type_name'] = $modelPaid->getName();

        switch ($modelPaid->getPaidTypeID()) {
            case Bank_Kazkom_Pay::BANK_PAY_TYPE_ID:
            case Bank_ATF_Pay::BANK_PAY_TYPE_ID:
            case Bank_Wooppay_Pay::BANK_PAY_TYPE_ID:
                $data->values['is_bank'] = 1;
                break;
            default:
                $data->values['is_bank'] = 0;
        }


        $data = Helpers_View::getViewObject($data, $model, $viewObject, $sitePageData, $driver, $shopID, TRUE, $elements);
        $sitePageData->replaceDatas['view::'.$viewObject] = $data;

        // записываем в мемкеш
        Helpers_DB::setMemcacheFunctionView($data, $shopID, 'View_Shop_Cart::getIsPaidBank', array(Model_Shop_PaidType::TABLE_NAME, Model_PaidType::TABLE_NAME, Model_Shop_Bill::TABLE_NAME),
            $viewObject, $sitePageData, $driver, $key);

        return $data;
    }

    /**
     * Получаем список товаров магазина в корзине
     * @param $dbObject
     * @param $shopID
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $params
     * @param null $elements
     * @param bool $isLoadOneView
     * @param bool $isLoadView
     * @return array|bool|mixed|MyArray
     */
	public static function getCartShopGoods($dbObject, $shopID, $viewObjects, $viewObject, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver, array $params = array(), $elements = NULL,
                                            $isLoadOneView = FALSE, $isLoadView = TRUE){

		// ставим дополнительные загрушки, системные вьюшки (чтобы много раз не пересчитывать корзину)
		$sitePageData->globalDatas['view::shopcart_count'] = '^#@view::shopcart_count@#^';
		$sitePageData->globalDatas['view::shopcart_amount'] = '^#@view::shopcart_amount@#^';
		$sitePageData->globalDatas['view::shopcart_amount_str'] = '^#@view::shopcart_amount_str@#^';
        $sitePageData->globalDatas['view::shopcart_bonus'] = '^#@view::shopcart_bonus@#^';
        $sitePageData->globalDatas['view::shopcart_bonus_str'] = '^#@view::shopcart_bonus_str@#^';

		// ищем в мемкеше
        $key =  Api_Shop_Cart::getShopHash($shopID, $sitePageData);
        $data = Helpers_DB::getMemcacheFunctionView($shopID, 'View_Shop_Cart::getCartShopGoods', array(Model_Shop_Good::TABLE_NAME, Model_Shop_Table_Child::TABLE_NAME),
            $viewObjects, $sitePageData, $driver, $key);
		if ($data !== NULL){
			$sitePageData->replaceDatas['view::'.$viewObjects] = $data['shopgoods'];

			$sitePageData->replaceDatas['view::shopcart_amount'] = $data['amount'];
            $sitePageData->replaceDatas['view::shopcart_amount_str'] = Func::getPriceStr($sitePageData->currency, $data['amount']);
            $sitePageData->replaceDatas['view::shopcart_bonus'] = $data['bonus'];
            $sitePageData->replaceDatas['view::shopcart_bonus_str'] = Func::getPriceStr($sitePageData->currency, $data['bonus']);
            $sitePageData->replaceDatas['view::shopcart_count'] = $data['count'];

			return $data;
		}

		// получаем количество товаров
        $shopGoodIDs = Api_Shop_Cart::countUpShopGoods($shopID, $sitePageData, $driver);
        if (!$isLoadView) {
            return $shopGoodIDs;
        }

		// получаем товары
		$model = new Model_Shop_Good();
		$model->setDBDriver($driver);
		$shopGoods = Helpers_View::getViewObjects($shopGoodIDs, $model, $viewObjects, $viewObject, $sitePageData,
			$driver, $shopID, TRUE, $elements);

		$sitePageData->replaceDatas['view::'.$viewObjects] = $shopGoods;

        // количество товаров
        $count = Func::getGoodsCount($shopGoodIDs);
        $amount = FuncPrice::getGoodsAmount($shopGoodIDs, $sitePageData, $driver);
        $bonus = Func::getGoodsBonus($shopGoodIDs);

        $sitePageData->replaceDatas['view::shopcart_amount'] = $amount;
        $sitePageData->replaceDatas['view::shopcart_amount_str'] = Func::getPriceStr($sitePageData->currency, $amount);
        $sitePageData->replaceDatas['view::shopcart_bonus'] = $bonus;
        $sitePageData->replaceDatas['view::shopcart_bonus_str'] = Func::getPriceStr($sitePageData->currency, $bonus);
		$sitePageData->replaceDatas['view::shopcart_count'] = $count;

		$data = array(
			'shopgoods' => $shopGoods,
			'count' => $count,
            'amount' => $amount,
            'bonus' => $bonus,
		);

		// записываем в мемкеш
        Helpers_DB::setMemcacheFunctionView($data, $shopID, 'View_Shop_Cart::getCartShopGoods', array(Model_Shop_Good::TABLE_NAME, Model_Shop_Table_Child::TABLE_NAME),
            $viewObjects, $sitePageData, $driver, $key);

		return $data;
	}
}
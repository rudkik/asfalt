<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Client_BasicClient extends Controller_Client_BasicShop {
	/**
	 * Добавляем на страницу данные пользователя
	 */
	protected function _addUserData($body, $key){
		$memcacheTables = array(Model_User::TABLE_NAME => Model_User::TABLE_NAME);
		$shopUser = $this->_getMemcacheShopPage($memcacheTables, '#$shop-user-data$#', array(), $key);
		if ($shopUser === NULL){
			// получаем данные для пользователя
			$shopUserID = new MyArray();
			$shopUserID->id = $this->_sitePageData->userID;
			if($shopUserID->id > 0){
				$shopUserID->values = $this->_sitePageData->user->getValues(TRUE, TRUE, $this->_sitePageData->shopID);
			}else{
				$this->_sitePageData->user = new Model_User();
			}
			$shopUserID->isFindDB = TRUE;
			

			$shopUser = $this->getViewObject($shopUserID, $this->_sitePageData->user, "shopuser");

			$this->_setMemcacheShopPage($shopUser, $memcacheTables, '#$shop-user-data$#', array(), $key);
		}

		return str_replace('#$shop-user-data$#', $shopUser, $body);
	}

	/**
	 * Добавляем на страницу данные пользователя
	 */
	protected function _addBasketData($body, $key){
		$memcacheTables = array(Model_Shop_Good::TABLE_NAME => Model_Shop_Good::TABLE_NAME);
		$basketHTML = $this->_getMemcacheShopPage($memcacheTables, '#$basket-data$#', array(), $key);
		if($basketHTML === NULL){
			$basketHTML = $this->_getBasketHTML($cartGoodsCount, $cartGoodsAmount);

			$this->_setMemcacheShopPage($basketHTML, $memcacheTables, '#$basket-data$#', array(), $key);
			$this->_setMemcacheShopPage($cartGoodsCount, $memcacheTables, '#$basket-count$#', array(), $key);
			$this->_setMemcacheShopPage($cartGoodsAmount, $memcacheTables, '#$basket-amount$#', array(), $key);
		}else{
			$cartGoodsCount = intval($this->_getMemcacheShopPage($memcacheTables, '#$basket-count$#', array(), $key));
			$cartGoodsAmount = floatval($this->_getMemcacheShopPage($memcacheTables, '#$basket-amount$#', array(), $key));
		}
		
		return str_replace('#$basket-count$#', $cartGoodsCount,
				str_replace('#$basket-amount$#', Func::getPriceStr($this->_sitePageData->currency, $cartGoodsAmount),
				str_replace('#$basket-data$#', $basketHTML, $body)));
	
	}

	/**
	 * Добавляем дополнительные данные для страницы
	 * @param string $body
	 */
	protected function _actionAdditionData($body, $isBasketData = TRUE){
		$key = $this->_sitePageData->userID.md5(Json::json_encode($this->getSession('bill', '')));
		
		$body = $this->_addBasketData($body, $key, $isBasketData);
		return $this->_addUserData($body, $key);
	}

	/**
	 * Добавляем к страницы футер и хедер
	 * @param string $body
	 */
	protected function _actionBody($body){
		// добавляем хидр и футер
		$view = View::factory($this->_sitePageData->shopShablonPath.'/'.$this->_sitePageData->languageID.'/index');
		$view->data = array('view::body' => $body);
		$view->siteData = $this->_sitePageData;

		$result = Helpers_View::viewToStr($view);
		return $result;
	}

	protected function _getBasketGoods(){
		$shopGoodIDs = new MyArray();

		// получаем список все загруженных товаров
		$countAll = 0;
		
		$bill = $this->getSession('bill', '');
		if (is_array($bill)){
			foreach ($bill as $key => $value) {
				$tmp = intval(Arr::path($value, 'count', 0));
				if ($tmp > 0){
					$child = $shopGoodIDs->addChild($key);
					$child->additionDatas['count'] = $tmp;
					$countAll = $countAll + $tmp;
				}
			}
		}

		$shopGoodIDs->additionDatas['count_all'] = $countAll;
		return $shopGoodIDs;
	}

	/**
	 * Получаем данные корзины
	 */
	protected function _getBasketHTML(&$cartGoodsCount, &$cartGoodsAmount){
		$shopGoodIDs = $this->_getBasketGoods();
		
		$this->_sitePageData->globalDatas['cart_goods_amount'] = '#$basket-amount$#';
		$this->_sitePageData->globalDatas['cart_goods_count'] = '#$basket-count$#';

		// получаем товары
		$model = new Model_Shop_Good();
		$model->setDBDriver($this->_driverDB);
		$shopGoods = $this->getViewObjects($shopGoodIDs, $model, "shopgoods/basket", "shopgood/basket");

		$cartGoodsCount = 0;
		$childs = array();
		for ($i = count($shopGoodIDs->childs)-1; $i > -1; $i--) {
			$value = $shopGoodIDs->childs[$i];
			if($value->isFindDB === TRUE){
				$childs[] = $value;
				
				$cartGoodsCount = $cartGoodsCount + Arr::path($value->additionDatas, 'count', 0);
			}
		}
		$shopGoodIDs->childs = $childs;
		
		$cartGoodsAmount = Func::getGoodsAmount($shopGoodIDs, $this->_sitePageData->currency->getIsRound());
		
		return str_replace('#$basket-count$#', $cartGoodsCount,
				str_replace('#$basket-amount$#', $cartGoodsAmount, $shopGoods));
	}

	/**
	 * Получаем массив таблиц с которыми связана верх и низ сайта
	 */
	protected function _getHeaderAndFooterTables(){
		$result = array();
		$result[Model_Language::TABLE_NAME] = Model_Language::TABLE_NAME;
		$result[Model_Shop_InformationData::TABLE_NAME] = Model_Shop_InformationData::TABLE_NAME;
		$result[Model_Shop_SocialNetworkType::TABLE_NAME] = Model_Shop_SocialNetworkType::TABLE_NAME;

		return  $result;
	}

	/**
	 * Получаем массив таблиц с которыми связана внешняя оболочка сайта
	 * @param boolean $isBodyLeft
	 * @param boolean $isBodyRight
	 */
	protected function _getBodyTables($isBodyLeft, $isBodyRight){
		$result = $this->_getHeaderAndFooterTables();

		$result[Model_Shop::TABLE_NAME] = Model_Shop::TABLE_NAME;

		if($isBodyLeft){
			$result[Model_Shop_Table_Rubric::TABLE_NAME] = Model_Shop_Table_Rubric::TABLE_NAME;
			$result[Model_Shop_Table_Attribute::TABLE_NAME] = Model_Shop_Table_Attribute::TABLE_NAME;
			$result[Model_Shop_Table_AttributeCatalog::TABLE_NAME] = Model_Shop_Table_AttributeCatalog::TABLE_NAME;
			$result[Model_Shop_Good::TABLE_NAME] = Model_Shop_Good::TABLE_NAME;
		}

		if($isBodyRight){
			$result[Model_Currency::TABLE_NAME] = Model_Currency::TABLE_NAME;
			$result[Model_Shop_Good::TABLE_NAME] = Model_Shop_Good::TABLE_NAME;
		}

		return $result;
	}
}


<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Client_BasicShop extends Controller_BasicControler {

	protected function _getShopIDByURL(){
		$domain = (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME']));

		$arr = explode('.', $domain);
		if (count($arr) > 2) {
			unset($arr[count($arr) - 1]);
			unset($arr[count($arr) - 1]);
		}
		$subDomain = implode('.', $arr);

		$result = Request_Shop::getShopID($domain, $subDomain, $this->_sitePageData, $this->_driverDB, TRUE);
		if (empty($result)){
			$result = intval($subDomain);
		}

		// получаем объект магазин
		$shop = new Model_Shop();
		$shop->setDBDriver($this->_driverDB);

		// если не найден магазин, то ошибка 505
        if (!$shop->dbGetByGlobalID($result)) {
            if (!$this->getDBObject($shop, $result)) {
                throw new HTTP_Exception_500('Shop not found.');

            }
        }

		// если не найден магазин заблокирован
		if (($shop->getIsBlock()) && (!(Request_RequestParams::getParamBoolean('is_ignore_block') === TRUE))){
			throw new HTTP_Exception_500('Shop blocked.');
		}

		if(! $shop->getIsPublic()){
			throw new HTTP_Exception_404('The site is blocked');
		}

		$this->_sitePageData->shop = $shop;
		$this->_sitePageData->shopID = $shop->id;
		$this->_sitePageData->shopMainID = $shop->getMainShopID();
        if($this->_sitePageData->shopMainID < 1){
            $this->_sitePageData->shopMainID = $this->_sitePageData->shopID ;
        }

		$this->_sitePageData->languageIDDefault = $shop->getDefaultLanguageID();

		return intval($shop->id);

	}

	/**
	 * Определяем магазин интерсейса
	 */
	protected function _readShopInterface()
	{
		// ID магазина
		$this->_getShopIDByURL();
	}

	/**
	 * Определяем пользователя интерсейса
	 */
	protected function _readUserInterface()
	{
		$auth = Auth::instance();
        intval($auth->setKeySession($this->_sitePageData->shopID));
		$auth->driverDB = $this->_driverDB;
		$auth->model = new Model_User();

		// пользователь
		if ($auth->isLoginSession()){
			$this->_sitePageData->user = $auth->user;
			$this->_sitePageData->userID = $auth->user->id;

			$operation = Request_Request::find('DB_Shop_Operation',$this->_sitePageData->shopID, $this->_sitePageData,
				$this->_driverDB, array('shop_user_id' => $this->_sitePageData->userID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => FALSE, 'limit' => 1));

			if(count($operation->childs) == 1){
				$operationModel = new Model_Shop_Operation();
				$this->getDBObject($operationModel, $operation->childs[0]->id);

				$this->_sitePageData->operation = $operationModel;
                $this->_sitePageData->operationID = $operationModel->id;
			}

			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Разрешен ли доступ для изменения этого магазина
	 */
	public function isAccess()
	{
		// данные о магазине
		$this->_readShopInterface();

		// данные о пользователе
		$this->_readUserInterface();

		// данные о шаблоне
		if (!$this->_readSiteShablonInterface($this->_sitePageData->shop->getSiteShablonID())) {
			throw new HTTP_Exception_500('Template not found.');
		}

		// данные о городе
		$this->_readCityInterface();

		// данные о языке
		$this->_readLanguageInterface();

		// данные о валюте
		$this->_readCurrencyInterface();

		return TRUE;
	}

	/**
	 * Проверяем права доступа
	 * @return  void
	 */
	public function before()
	{
		// делаем редиректы для слешей в конце url
		$this->_redirect();

		// проходим функцию авторизации
		$this->isAccess();
	}
}

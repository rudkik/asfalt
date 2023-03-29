<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ads_BasicShop extends Controller_BasicAdmin {
    protected $controllerName = '';
    protected $tableID = 0;
    protected $tableName = '';
    protected $objectName = '';
    protected $actionURLName = '';

    /**
     * Формируем index старинцу
     * @param $body
     * @return mixed
     */
    public function _putInIndex($body)
    {
        $tmp = $this->_sitePageData->dataLanguageID;
        $this->_sitePageData->dataLanguageID = Model_Language::LANGUAGE_RUSSIAN;

        // Получаем индекс страницу
        $index = $this->_driverDB->getMemcache()->getShopPage(
            $this->_sitePageData->shopID,
            $this->_sitePageData->shopShablonPath,
            $this->_sitePageData->languageID,
            $this->_sitePageData->url . $this->_sitePageData->shopMainID
        );
        if ($index === NULL) {

            // генерируем не изменяемую часть
            $view = View::factory($this->_sitePageData->shopShablonPath . '/' . $this->_sitePageData->languageID . '/index');
            $view->data = array(
                'view::main' => '^#@view::main_body@#^',
            );
            $view->siteData = $this->_sitePageData;
            $index = Helpers_View::viewToStr($view);

            // записываем в мемкеш
            $this->_driverDB->getMemcache()->setShopPage(
                $index,
                $this->_sitePageData->shopID,
                $this->_sitePageData->shopShablonPath,
                $this->_sitePageData->languageID,
                $this->_sitePageData->url . $this->_sitePageData->shopMainID
            );
        }

        $result = str_replace('^#@view::main_body@#^', $body, $index);

        $this->_sitePageData->dataLanguageID = $tmp;

        return $result;
    }

    /**
     * Формируем index старинцу
     * @param $file
     * @param bool $isMainNot
     */
    public function _putInMain($file, $isMainNot = FALSE)
    {
        // Получаем индекс страницу
        $key = $file . Helpers_DB::getURLParamDatas(array('system'));
        $index = $this->_driverDB->getMemcache()->getShopMain(
            $this->_sitePageData->shopID,
            $this->_sitePageData->shopShablonPath,
            $this->_sitePageData->languageID,
            $this->_sitePageData->url . $this->_sitePageData->shopMainID,
            $key
        );

        if ($index === NULL) {
            // генерируем не изменяемую часть
            $view = View::factory($this->_sitePageData->shopShablonPath . '/' . $this->_sitePageData->languageID . $file);

            $view->data = $this->_sitePageData->globalDatas;
            $view->siteData = $this->_sitePageData;
            $index = Helpers_View::viewToStr($view);

            // записываем в мемкеш
            $this->_driverDB->getMemcache()->setShopMain(
                $index,
                $this->_sitePageData->shopID,
                $this->_sitePageData->shopShablonPath,
                $this->_sitePageData->languageID,
                $this->_sitePageData->url . $this->_sitePageData->shopMainID,
                $key
            );
        }
        if ($isMainNot){
            $this->response->body($this->_sitePageData->replaceStaticDatas($index));
        }else {
            $this->response->body($this->_sitePageData->replaceStaticDatas($this->_putInIndex($index)));
        }
    }

    /**
     * Определяем пользователя интерсейса
     */
    protected function _readUserInterface()
    {
        $auth = Auth::instance();
        $auth->setKeySession('ads');
        $auth->driverDB = $this->_driverDB;
        $auth->model = new Model_Shop_Operation();

        // пользователь
        if (!($auth->isLoginSessionShop())){
            $email = Arr::path($_POST, 'auth.email', Arr::path($_GET, 'auth.email', ''));
            $password = Arr::path($_POST, 'auth.password', Arr::path($_GET, 'auth.password', ''));

            if((empty($email)) || (empty($password))){
                $this->redirect('/'.$this->actionURLName);
            }else {
                if (!$auth->login($email, $password)) {
                    $this->redirect('/'.$this->actionURLName);
                }else{
                    $auth->isLoginSessionShop();
                }
            }
        }

        $this->_sitePageData->operation = $auth->model;
        $this->_sitePageData->operationID = $auth->model->id;

        $model = new Model_User();
        $model->setDBDriver($this->_driverDB);
        $this->getDBObject($model, $auth->user->getUserID());

        $this->_sitePageData->shopID = $auth->shopID;

        $this->_sitePageData->user = $model;
        $this->_sitePageData->userID = $model->id;

        if ($model->id < 1){
            throw new HTTP_Exception_404('User not found.');
        }
    }

    /**
     * Проверяем права доступа
     * @return  void
     */
    public function before()
    {
        $this->_sitePageData->actionURLName = $this->actionURLName;
        $this->_sitePageData->shopShablonPath = 'ads';

        // проходим функцию авторизации
        $this->isAccess();
    }

	/**
	 * Определяем магазина интерсейса
	 */
	protected function _readShopInterface()
	{
		$shopID = $this->_sitePageData->shopID;
		if ($shopID < 1){
			throw new HTTP_Exception_404('Shop not found.');
		}

		$model = new Model_Shop();
		$model->setDBDriver($this->_driverDB);
		if(! $this->getDBObject($model, $shopID)){
			return FALSE;
		}

		$this->_sitePageData->shopID = $shopID;
		$this->_sitePageData->shop = $model;

		$this->_sitePageData->shopMainID = $shopID;
		$this->_sitePageData->shopMain = $model;

		$tmp = $model->getMainShopID();
		if($tmp > 0){
			$model = new Model_Shop();
			$model->setDBDriver($this->_driverDB);
			if($this->getDBObject($model, $tmp)){
				$this->_sitePageData->shopMainID = $model->id;
				$this->_sitePageData->shopMain = $model;
			}
		}
	}

	/**
	 * Определяем магазина интерсейса
	 */
	protected function _readShopBranchInterface()
	{
		$shopID = Request_RequestParams::getParamInt('shop_branch_id');
		if (($shopID === NULL) || ($shopID < 1)){
            return FALSE;
		}

        if($shopID == $this->_sitePageData->shopID){
            return FALSE;
        }

		$model = new Model_Shop();
		$model->setDBDriver($this->_driverDB);
		if((! $this->getDBObject($model, $shopID)) || (($model->getMainShopID() != $this->_sitePageData->shopMainID) && ($model->id != $this->_sitePageData->shopMainID))){
            throw new HTTP_Exception_404('Branch not found.');
		}

		$model->dbGetElements($this->_sitePageData->shopMain);

        $this->_sitePageData->shopID = $shopID;
        $this->_sitePageData->shop = $model;

		$this->_sitePageData->branchID = $shopID;
		$this->_sitePageData->branch = $model;

		$this->_sitePageData->shopRootID = $model->getShopRootID();
		if($this->_sitePageData->shopRootID > 0){
			$model = new Model_Shop();
			$model->setDBDriver($this->_driverDB);
			if($this->getDBObject($model, $this->_sitePageData->shopRootID)){
				$this->_sitePageData->shopRoot = $model;
			}else{
				$this->_sitePageData->shopRootID = 0;
			}
		}

        return TRUE;
	}

	/**
	 * Определяем курса валюты интерфейса
	 */
	protected function _readCurrencyInterface()
	{
		if($this->_sitePageData->shopID < 1){
			return FALSE;
		}

		$currencyID = $this->_sitePageData->shop->getDefaultCurrencyID();
		if($currencyID < 1){
			$currencyID = Model_Currency::KZT;
		}

		// получаем объект языка
		$currency = new Model_Currency();
		$currency->setDBDriver($this->_driverDB);

		if (! $this->getDBObject($currency, $currencyID)) {
			$currencyID = 18;
			$this->getDBObject($currency, $currencyID);
		}

		$this->_sitePageData->currency = $currency;
		$this->_sitePageData->currencyID = $currencyID;

		return TRUE;
	}

    /**
     * Определяем язык интерсейса
     */
    protected function _readLanguageInterface()
    {
        $languageID = intval($this->getSession('language_id', $this->_sitePageData->languageIDDefault));

        if (!($languageID > 0)) {
            $languageID = Model_Language::LANGUAGE_RUSSIAN;
            $this->setSession('language_id', $languageID);
        }

        // получаем объект языка
        $language = new Model_Language();
        $language->setDBDriver($this->_driverDB);
        if ((!file_exists(APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_sitePageData->shopShablonPath . DIRECTORY_SEPARATOR . $languageID))
            || (! $this->getDBObject($language, $languageID))) {
            $languageID = Model_Language::LANGUAGE_RUSSIAN;
            $this->getDBObject($language, $languageID);

            $this->setSession('language_id', $languageID);
        }

        $this->_sitePageData->language = $language;
        $this->_sitePageData->languageID = $languageID;

        switch ($languageID) {
            case Model_Language::LANGUAGE_RUSSIAN:
                I18n::lang('ru-ru');
                break;

            default:
                ;
                break;
        }

        $languageID = intval(Request_RequestParams::getParamInt('data_language_id'));
        if ($languageID < 1) {
            $languageID = $this->_sitePageData->languageID;
        }

        if ($languageID == $this->_sitePageData->languageID) {
            $this->_sitePageData->dataLanguage = $this->_sitePageData->language;
            $this->_sitePageData->dataLanguageID = $this->_sitePageData->languageID;

            return;
        }

        // получаем объект языка
        $language = new Model_Language();
        $language->setDBDriver($this->_driverDB);

        if (! $this->getDBObject($language, $languageID)) {
            $this->_sitePageData->dataLanguage = $this->_sitePageData->language;
            $this->_sitePageData->dataLanguageID = $this->_sitePageData->languageID;

            return;
        }

        $this->_sitePageData->dataLanguage = $language;
        $this->_sitePageData->dataLanguageID = $languageID;
    }

	/**
	 * Разрешен ли доступ для изменения этого магазина
	 */
	public function isAccess(){
        // данные о языке
        $this->_readLanguageInterface();

		// данные о пользователе
		$this->_readUserInterface();

		// данные о выбранном магазине
		$this->_readShopInterface();

		// данные о выбранном магазине
		$this->_readShopBranchInterface();


		// данные о языке
		$this->_readCurrencyInterface();

		return TRUE;
	}
}

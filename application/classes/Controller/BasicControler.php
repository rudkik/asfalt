<?php defined('SYSPATH') or die('No direct script access.');

class Controller_BasicControler extends Controller
{
	/**
	 * данные для создания страницы сайта
	 * @var null|SitePageData
	 */
	protected $_sitePageData = NULL;

	/**
	 * драйвер подключение к базе данных
	 * @var Model_Driver_DBBasicDriver|null
	 */
	protected $_driverDB = NULL;

	/**
	 * Controller_BasicControler constructor.
	 * @param Request $request
	 * @param Response $response
	 */
	public function __construct(Request $request, Response $response)
	{
		$this->_driverDB = GlobalData::newModelDriverDBSQLMem();
		$this->_sitePageData = GlobalData::newSitePageData();

        // какое действие делается
        if(key_exists('REQUEST_URI', $_SERVER)){
            $url = $_SERVER['REQUEST_URI'];
            $tmp = strpos($url, '?');
            if($tmp > -1){
                $url = substr($url, 0, $tmp);
            }

            $action = '';
            for($i = strlen($url), $i > -1; $i--;){
                if($url[$i] == '/'){
                    if($action != '') {
                        break;
                    }
                }else {
                    $action = $url[$i] . $action;
                }
            }
            $this->_sitePageData->action = strtolower($action);
        }

		parent::__construct($request, $response);
	}

	/**
	 * Считать данные из $_GET и $_POST
	 * @param array $fields
	 */
	protected function _setRequestUrlParams(array $fields)
	{
		foreach ($fields as $value) {
			$tmp = Request_RequestParams::getParamStr($value);
			if ($tmp !== NULL) {
				$this->_sitePageData->urlParams[$value] = $tmp;
			}
		}
	}

	/**
	 * Получаем массив сессии для определенного сайта
	 * @param string $path
	 * @param string $defaut
	 * @return array
	 */
	public function getSession($path = '', $defaut = '')
	{
		return MySession::getSession($this->_sitePageData->shopID, $path, $defaut);
	}

	/**
	 * Записываем данные массив сессии для определенного сайта
	 * @param $path
	 * @param $value
	 */
	public function setSession($path, $value)
	{
		MySession::setSession($this->_sitePageData->shopID, $path, $value);
	}

	/**
	 * Редирект по определенным правилам
	 */
	protected function _redirect()
	{
		$url = $_SERVER['REQUEST_URI'];
		$isRedirect = FALSE;

		$domain = (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME']));
        if (substr($domain, 0, 4) == 'www.') {
			$domain = substr($domain, 4);
			$isRedirect = TRUE;
		}
		$domain = $this->_sitePageData->scheme . $domain;

		if ((strlen($url) > 1) && ($url[strlen($url) - 1] == '/')) {
			for ($i = strlen($url) - 1; $i > -1; $i--) {
				if (substr($url, $i, 1) != '/') {
					break;
				}
				$url = substr($url, 0, strlen($url) - 1);
			}
			$isRedirect = TRUE;
		}

		$page = Request_RequestParams::getParamInt('page');
		if (($page !== NULL) && ($page < 2)) {
			$url = str_replace('page=' . $page, '', $url);
			$url = str_replace('&&' . $page, '&', $url);
			$url = str_replace('?&' . $page, '?', $url);
			if (($url[strlen($url) - 1] == '&') || ($url[strlen($url) - 1] == '?')) {
				$url = substr($url, 0, strlen($url) - 1);
			}

			$isRedirect = TRUE;
		}

		$cityID = Request_RequestParams::getParamInt('city_id');
		if (($cityID !== NULL) && ($cityID < 1)) {

			$url = str_replace('city_id=' . $cityID, '', $url);
			$url = str_replace('&&' . $page, '&', $url);
			$url = str_replace('?&' . $page, '?', $url);
			if (($url[strlen($url) - 1] == '&') || ($url[strlen($url) - 1] == '?')) {
				$url = substr($url, 0, strlen($url) - 1);
			}

			$isRedirect = TRUE;
		}

		$currecnyID = Request_RequestParams::getParamInt('currency_id');
		if (($currecnyID !== NULL)) {
			$url = str_replace('currency_id=' . $currecnyID, '', $url);
			$url = str_replace('&&' . $page, '&', $url);
			$url = str_replace('?&' . $page, '?', $url);
			if (($url[strlen($url) - 1] == '&') || ($url[strlen($url) - 1] == '?')) {
				$url = substr($url, 0, strlen($url) - 1);
			}

			$this->setSession('currency_id', $currecnyID);
			$isRedirect = TRUE;
		}

		$languageID = Request_RequestParams::getParamInt('language_id');
		if (($languageID !== NULL)) {
			$url = str_replace('language_id=' . $languageID, '', $url);
			$url = str_replace('&&' . $page, '&', $url);
			$url = str_replace('?&' . $page, '?', $url);
			if (($url[strlen($url) - 1] == '&') || ($url[strlen($url) - 1] == '?')) {
				$url = substr($url, 0, strlen($url) - 1);
			}
			$this->setSession('language_id', $languageID);
			$isRedirect = TRUE;
		}

		if ($isRedirect) {
			$this->redirect($domain . $url);
		}
	}

    /**
     * Получаем список заполненых шаблонов сайта для массива обьектов.
     * @param MyArray $ObjectIDs
     * @param Model_Basic_LanguageObject $model
     * @param $viewObjects
     * @param $viewObject
     * @param int $shopID
     * @param bool $isLoadMemcashe
     * @return string
     * @throws Exception
     */
	public function getViewObjects(MyArray $ObjectIDs, Model_Basic_LanguageObject $model, $viewObjects, $viewObject,
								   $shopID = 0, $isLoadMemcashe = TRUE)
	{
		if ($shopID < 1) {
			$shopID = $this->_sitePageData->shopID;
		}

		return Helpers_View::getViewObjects($ObjectIDs, $model,
			$viewObjects, $viewObject, $this->_sitePageData, $this->_driverDB,
			$shopID, $isLoadMemcashe);
	}

    /**
     * Получаем список заполненых шаблонов сайта для одного обекта
     * @param MyArray $data
     * @param Model_Basic_LanguageObject $model
     * @param $viewObject
     * @param int $shopID
     * @param bool $isLoadMemcashe
     * @return string
     * @throws Exception
     */
	public function getViewObject(MyArray $data, Model_Basic_LanguageObject $model, $viewObject, $shopID = 0,
								  $isLoadMemcashe = TRUE)
	{
		if ($shopID < 1) {
			$shopID = $this->_sitePageData->shopID;
		}

		return Helpers_View::getViewObject($data, $model,
			$viewObject, $this->_sitePageData, $this->_driverDB,
			$shopID, $isLoadMemcashe);

	}

    /**
     * Получить HTML страницы
     * @param array $tableNames
     * @param $pageName
     * @param array $urlParams
     * @param string $datas
     * @param bool $isBranch
     * @return mixed|null
     */
	protected function _getMemcacheShopPage(array $tableNames, $pageName, array $urlParams = array(), $datas = '', $isBranch = FALSE)
	{
		if ($isBranch === TRUE) {
			$shopID = $this->_sitePageData->branchID;
		} else {
			$shopID = $this->_sitePageData->shopID;
		}
		$urlParams[] = 'city_id';

		return $this->_driverDB->getMemcache()->getShopPage(
			$shopID,
			$tableNames,
			$pageName,
			$this->_sitePageData->languageID,
			$this->_sitePageData->shopShablonPath,
			$this->_sitePageData->currencyID,
			Helpers_DB::getURLParamDatas($urlParams) . $datas);
	}

    /**
     * Задать HTML страницы
     * @param $data
     * @param array $tableNames
     * @param $pageName
     * @param array $urlParams
     * @param string $datas
     * @param bool $isBranch
     */
	protected function _setMemcacheShopPage($data, array $tableNames, $pageName, array $urlParams = array(), $datas = '', $isBranch = FALSE)
	{
		if ($isBranch === TRUE) {
			$shopID = $this->_sitePageData->branchID;
		} else {
			$shopID = $this->_sitePageData->shopID;
		}
		$urlParams[] = 'city_id';

		$this->_driverDB->getMemcache()->setShopPage(
			$data,
			$shopID,
			$tableNames,
			$pageName,
			$this->_sitePageData->languageID,
			$this->_sitePageData->shopShablonPath,
			$this->_sitePageData->currencyID,
			Helpers_DB::getURLParamDatas($urlParams) . $datas);
	}

	/**
	 * Определяем язык интерсейса
	 */
	protected function _readLanguageInterface()
	{
		$languageID = intval($this->getSession('language_id', $this->_sitePageData->languageIDDefault));
		if ($languageID < 1){
            $languageID = Request_RequestParams::getParamInt('language_id');
        }

		if (($languageID < 1)) {
			$languageID = Model_Language::LANGUAGE_RUSSIAN;
			$this->setSession('language_id', $languageID);
		}

		// получаем объект языка
		$language = new Model_Language();
        if (! $this->getDBObject($language, $languageID)) {
            $languageID = Model_Language::LANGUAGE_RUSSIAN;
            $this->getDBObject($language, $languageID);

            $this->setSession('language_id', $languageID);
        }

        $this->_sitePageData->dataLanguage = $language;
        $this->_sitePageData->dataLanguageID = $languageID;

		if (!file_exists(APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_sitePageData->shopShablonPath . DIRECTORY_SEPARATOR . $languageID)) {
            $language = new Model_Language();

            $languageID = Model_Language::LANGUAGE_RUSSIAN;
			$this->getDBObject($language, $languageID);
		}

		$this->_sitePageData->language = $language;
		$this->_sitePageData->languageID = $languageID;

		switch ($languageID) {
            case Model_Language::LANGUAGE_RUSSIAN:
                I18n::lang('ru-ru');
                break;
            case Model_Language::LANGUAGE_ENGLISH:
                I18n::lang('en-en');
                break;
			default:
				break;
		}
	}

	/**
	 * Определяем курса валюты интерсейса
	 */
	protected function _readCurrencyInterface()
	{
		$currencyID = intval($this->getSession('currency_id', 0));
		if ($currencyID < 1) {
            $currencyID = $this->_sitePageData->currencyID;
            if($currencyID < 1) {
                $currencyID = $this->_sitePageData->shop->getDefaultCurrencyID();
            }
		}

		// получаем объект языка
		$currency = new Model_Currency();
		$currency->setDBDriver($this->_driverDB);

		if (! $this->getDBObject($currency, $currencyID)) {
			$currencyID = Model_Currency::KZT;
			$this->getDBObject($currency, $currencyID);
		}

		$this->_sitePageData->currency = $currency;
		$this->_sitePageData->currencyID = $currencyID;

		return TRUE;
	}

	/**
	 * Определяем город интерсейса
	 */
	protected function _readCityInterface()
	{
		// город
		$cityID = Request_RequestParams::getParamInt('city_id');

        // проверяем, чтобы город по умолчанию не было в ссылке
        if($cityID !== NULL) {
            if ($cityID == $this->_sitePageData->shop->getCityID()){
                $url = $_SERVER['REQUEST_URI'];

                $url = str_replace('city_id=' . $cityID, '', $url);
                $url = str_replace('&&' . $cityID, '&', $url);
                $url = str_replace('?&' . $cityID, '?', $url);
                if (($url[strlen($url) - 1] == '&') || ($url[strlen($url) - 1] == '?')) {
                    $url = substr($url, 0, strlen($url) - 1);
                }

                $this->redirect($this->_sitePageData->urlBasic . $url);
            }
        }

		// получаем объект города
		$city = new Model_City();
		$city->setDBDriver($this->_driverDB);
		if (($cityID < 1) || (! $this->getDBObject($city, $cityID))) {
			$cityID = $this->_sitePageData->shop->getCityID();

			if (($cityID < 1) || (! $this->getDBObject($city, $cityID))) {
				$this->_sitePageData->cityID = 0;
				$this->_sitePageData->city = $city;
			}
		}

		$this->_sitePageData->urlParams['city_id'] = $cityID;
		$this->_sitePageData->cityID = $cityID;
		$this->_sitePageData->city = $city;

		$land = new Model_Land();
		if ($this->getDBObject($land, $city->getLandID())) {
			$this->_sitePageData->landID = $city->getLandID();
		}else{
			$this->_sitePageData->landID = 0;
		}
		$this->_sitePageData->land = $land;

		$this->_sitePageData->currencyID = $land->getCurrencyID();

		return TRUE;
	}


	/**
	 * запрос в базу данных языком из настроек от пользователя
	 * @param Model_Basic_DBObject $model
	 * @param $id
	 * @param int $shopID
	 * @param int $dataLanguageID
	 * @return bool
	 */
	public function getDBObject(Model_Basic_DBObject $model, $id, $shopID = -1, $dataLanguageID = -1)
	{
		if($id < 1){
			return FALSE;
		}

		if($model->getDBDriver() === NULL){
			$model->setDBDriver($this->_driverDB);
		}

		return Helpers_DB::getDBObject($model, $id, $this->_sitePageData, $shopID, $dataLanguageID);
	}

	/**
	 * Определяем шаблон интерсейса
	 */
	protected function _readSiteShablonInterface($siteShablonID){
		$shopShablon = new Model_SiteShablon;
		$shopShablon->setDBDriver($this->_driverDB);

		if(! $this->getDBObject($shopShablon, $siteShablonID)){
			return FALSE;
		}

		$this->_sitePageData->shopShablon = $shopShablon;
		$this->_sitePageData->shopShablonPath = $shopShablon->getShablonPath();
		$this->_sitePageData->shopShablonOptions = $shopShablon->getOptionsArray();

		return TRUE;
	}
}
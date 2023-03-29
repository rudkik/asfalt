<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_BasicShop extends Controller_BasicAdmin {
    protected $controllerName = '';
    protected $tableID = 0;
    protected $tableName = '';
    protected $objectName = '';
    protected $actionURLName = '';
    protected $prefixView = '';

    /**
     * Формируем index старинцу
     * @param string $body
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
     */
    public function _putInMain($file)
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
        $this->response->body($this->_sitePageData->replaceStaticDatas($this->_putInIndex($index)));
    }


    /**
     * Определяем пользователя интерсейса
     */
    protected function _readUserInterface()
    {
        $auth = Auth::instance();
        $auth->setKeySession('magazine');
        $auth->driverDB = $this->_driverDB;
        $auth->model = new Model_Magazine_Shop_Operation();

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

        $operationType = $this->_sitePageData->operation->getShopTableRubricID();

        switch ($operationType){
            case Model_Magazine_Shop_Operation::RUBRIC_BAR:
                if(($operationType > 0) && ($this->actionURLName != 'bar')){
                    $this->redirect('/'.$this->actionURLName);
                }
                break;
        }

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
        $this->_sitePageData->shopShablonPath = 'magazine/'.$this->prefixView;

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
		if(! $this->getDBObject($model, $shopID, 0)){
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
			if($this->getDBObject($model, $tmp, 0)){
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
		if((! $this->getDBObject($model, $shopID, 0)) || (($model->getMainShopID() != $this->_sitePageData->shopMainID) && ($model->id != $this->_sitePageData->shopMainID))){
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
			if($this->getDBObject($model, $this->_sitePageData->shopRootID, 0)){
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

		if (! $this->getDBObject($currency, $currencyID, 0)) {
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
            $this->getDBObject($language, $languageID, 0);

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

        if (! $this->getDBObject($language, $languageID, 0)) {
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
    /**
     * Возвращаем результать сохранения
     * @param array $result
     */
    protected function _redirectSaveResult(array $result){
        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $url = Request_RequestParams::getParamStr('url');
            if(!empty($url)){
                $this->redirect($url);
            }

            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            $params = array(
               // 'id' => $result['id'],
                'is_public_ignore' => TRUE,
            );
            foreach($result as $key => $value){
                if($key == 'id'){
                    continue;
                }
                if(!is_array($value)){
                    $params[$key] = $value;
                }
            }
            $params = URL::query($params, FALSE).$branchID;

            if(key_exists('fiscal_result', $result) && Arr::path($result['fiscal_result'], 'error_code', -999) != 0){
                $params = 'edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                            'fiscal_result' => $result['fiscal_result'],
                            'is_special' => Arr::path($result, 'is_special', NULL),
                        ), FALSE
                    );
            }else {
                if (Request_RequestParams::getParamBoolean('is_new')) {
                    $params = 'new' . $params;
                } elseif (Request_RequestParams::getParamBoolean('is_close') === FALSE) {
                    if(empty($params)){
                        $params = '?';
                    }
                    $params = 'edit'.$params.'&id=' . $result['id'];
                } else {
                    $params = 'index' . $params;
                }
            }

            $this->redirect('/'.$this->_sitePageData->actionURLName.'/'.$this->controllerName.'/'.$params);
        }
    }

    /**
     * Получаем JSON списка записей
     * @param $class
     * @param $function
     * @param array $elements
     * @param array $params
     * @param null | Model_Basic_BasicObject $model
     */
    protected function _actionJSON($class, $function, array $elements = array(), array $params = array(), $model = NULL) {
        $this->_sitePageData->url = '/'.$this->_sitePageData->actionURLName.'/' . $this->controllerName . '/json';

        $params = array_merge($_POST, $_GET, $params);
        if ((key_exists('offset', $params)) && (intval($params['offset']) > 0)) {
            $params['page'] =  round($params['offset'] / $params['limit']) + 1;
        }
        if ((key_exists('sort', $params)) ) {
            $params['sort_by'] = array('value' => array($params['sort'] => Arr::path($params, 'order', 'asc')));
        }
        if ((key_exists('limit', $params)) ) {
            $params['limit_page'] = intval($params['limit']);
            unset($params['limit']);
        }else{
            $params['limit_page'] = 25;
        }
        unset($params['order']);
        $params[Request_RequestParams::IS_NOT_READ_REQUEST_NAME] = TRUE;

        // получаем список
        $ids = $class::$function($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB, $params,
            5000, TRUE, $elements);

        $fields = Request_RequestParams::getParam('_fields');
        if(!is_array($fields)){
            if($fields != '*'){
                $fields = array($fields);
            }
        }

        $result = array();
        if($fields == '*'){
            foreach ($ids->childs as $child) {
                $result[] = $child->values;
            }
        }elseif(!empty($fields)) {
            $elementsFields = array();
            foreach ($elements as $key => $values){
                foreach ($values as $value){
                    $elementsFields[substr($key, 0, -2).$value] = array(
                        'id' => $key,
                        'name' => $value,
                    );
                }
            }

            foreach ($ids->childs as $child) {
                if ($model !== NULL){
                    $child->setModel($model);
                    $child->setValues($model, $this->_sitePageData);
                }

                $values = array('id' => $child->id);
                foreach ($fields as $field) {
                    if (key_exists($field, $child->values)) {
                        $values[$field] = $child->values[$field];
                    }elseif (key_exists($field, $elementsFields)){
                        $values[$field] = $child->getElementValue($elementsFields[$field]['id'], $elementsFields[$field]['name']);
                    }else{
                        $values[$field] = Arr::path($child->values, $field, '');
                    }
                }

                $result[] = $values;
            }
        }

        if (Request_RequestParams::getParamBoolean('is_total')) {
            $this->response->body(json_encode(array('total' => $this->_sitePageData->countRecord, 'rows' => $result)));
        }else{
            $this->response->body(json_encode($result));
        }
    }
}

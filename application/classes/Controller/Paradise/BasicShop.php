<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Paradise_BasicShop extends Controller_BasicControler {

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
        if(is_array($result)){
            if (!$shop->dbGetByGlobalID($result)) {
                throw new HTTP_Exception_500('Shop not found.');
            }
        }else {
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
     * Формируем index старинцу
     * @param string $body
     */
    public function _putInIndex($body)
    {
        // Получаем индекс страницу
        $result = $this->_driverDB->getMemcache()->getShopPage(
            $this->_sitePageData->shopID,
            $this->_sitePageData->shopShablonPath,
            $this->_sitePageData->languageID,
            $this->_sitePageData->url . $this->_sitePageData->shopMainID
        );
        if ($result === NULL) {
            // генерируем не изменяемую часть
            $view = View::factory($this->_sitePageData->shopShablonPath . '/' . $this->_sitePageData->languageID . '/index');
            $view->data = array(
                'view::main' => '^#@view::main_body@#^',
            );
            $view->siteData = $this->_sitePageData;
            $result = Helpers_View::viewToStr($view);

            // записываем в мемкеш
            $this->_driverDB->getMemcache()->setShopPage(
                $result,
                $this->_sitePageData->shopID,
                $this->_sitePageData->shopShablonPath,
                $this->_sitePageData->languageID,
                $this->_sitePageData->url . $this->_sitePageData->shopMainID
            );
        }

        $result = str_replace('^#@view::main_body@#^', $body, $result);

        return $result;
    }

    public function _setGlobalDatas(array $keys){
        $this->_sitePageData->addKeysInGlobalDatas($keys);
    }

}

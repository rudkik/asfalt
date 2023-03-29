<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Config_Shopuser extends Controller_Config_Basic {
    public function before() {
        $this->_sitePageData->shopShablonPath = 'config';
        $this->_readLanguageInterface();
    }

    public function action_auth() {
        $this->_sitePageData->url = '/config/shopuser/auth';


        $tmp = Request_RequestParams::getParamInt('s');
        if ($tmp !== NULL) {
            $this->_sitePageData->urlParams['s'] = $tmp;
        }

        // генерируем основную часть
        $view = View::factory($this->_sitePageData->shopShablonPath . '/' . $this->_sitePageData->languageID . '/login');
        $view->data = array();
        $view->siteData = $this->_sitePageData;
        $result = Helpers_View::viewToStr($view);
        $this->response->body($result);
    }

    public function action_login() {
        $this->_sitePageData->url = '/config/shopuser/login';

        $email = Request_RequestParams::getParamStr('email');
        $password = Request_RequestParams::getParamStr('password');

        $auth = Auth::instance();
        $auth->setKeySession('config');
        $auth->driverDB = $this->_driverDB;
        $auth->model = new Model_Shop_Operation();

        if (!$auth->login($email, $password)) {
            $this->redirect('/config/shopuser/auth?is_main='.Request_RequestParams::getParamBoolean('is_main').'&s=1');
        } else {
            $this->redirect('/config/mvc/index');
        }
    }

    public function action_registration() {
        $session = Session::instance();
        $session_data =& $session->as_array();

        $this->_sitePageData->url = '/config/shopuser/registration';

        // считываем нужные параметы
        $this->_setRequestUrlParams(array('number_shop', 'ok', 'user', 'email', 'name'));

        $tmp = Request_RequestParams::getParamInt('error');
        if ($tmp === 1) {
            $this->_sitePageData->urlParams['error'] = Arr::path($session_data, 'error');
        }

        // генерируем основную часть
        $view = View::factory('config/' . $this->_sitePageData->languageID . '/main/shopuser-registration');
        $view->data = array();
        $view->siteData = $this->_sitePageData;
        $result = Helpers_View::viewToStr($view);

        // получаем список ID языков
        $LanguageIDs = Request_Language::getLanguageIDs($this->_sitePageData, $this->_driverDB);

        $model = new Model_Language();
        $model->setDBDriver($this->_driverDB);
        $Languages = $this->getViewObjects($LanguageIDs, $model, "languages", "language");

        // добавляем хидр и футер
        $view = View::factory('config/' . $this->_sitePageData->languageID . '/index');
        $view->data = array();
        $view->data['view::main'] = $result;
        $view->data['view::languages'] = $Languages;
        $view->data['view::phones'] = '';
        $view->data['shop_name'] = '';
        $view->siteData = $this->_sitePageData;
        $view->data['is_not_load_menu'] = TRUE;
        $this->response->body(Helpers_View::viewToStr($view));
    }

    public function action_unlogin() {
        $auth = Auth::instance();
        $auth->setKeySession('config');
        $auth->driverDB = $this->_driverDB;
        $auth->logout();

        $this->redirect($this->_sitePageData->urlBasic . "/config");
    }

    public function action_resetpassword() {
        $this->_sitePageData->url = '/config/shopuser/resetpassword';

        $email = Request_RequestParams::getParamStr('email');

        $model = new Model_User();
        $model->setDBDriver($this->_driverDB);

        if (!$model->getEmail() != $email) {
            throw new HTTP_Exception_404('E-mail is not found.');
        }

        if (mail(!$email, 'Reset password', 'OTO Config')) {
            throw new HTTP_Exception_404('E-mail is not sent!');
        }

        echo 'Новый пароль выслан на Вашу почту';
    }
}

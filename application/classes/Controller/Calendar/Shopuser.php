<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Calendar_Shopuser extends Controller_Calendar_BasicCalendar {
    public function before() {
        $this->_sitePageData->shopShablonPath = 'calendar';
        $this->_readLanguageInterface();
    }

    public function action_auth() {
        $this->_sitePageData->url = '/calendar/shopuser/auth';


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
        $this->_sitePageData->url = '/calendar/shopuser/login';

        $email = Request_RequestParams::getParamStr('email');
        $password = Request_RequestParams::getParamStr('password');

        $auth = Auth::instance();
        $auth->setKeySession('calendar');
        $auth->driverDB = $this->_driverDB;
        $auth->model = new Model_Shop_Operation();

        if (!$auth->login($email, $password)) {
            $this->redirect('/calendar/shopuser/auth?is_main='.Request_RequestParams::getParamBoolean('is_main').'&s=1');
        } else {
            $this->redirect('/calendar/shoptask/index');
        }
    }

    public function action_unlogin() {
        $auth = Auth::instance();
        $auth->setKeySession('calendar');
        $auth->driverDB = $this->_driverDB;
        $auth->logout();

        $this->redirect($this->_sitePageData->urlBasic . "/calendar");
    }
}
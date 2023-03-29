<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Tunable_Shopuser extends Controller_Ab1_Tunable_BasicAb1 {
    public function before() {
        $this->_sitePageData->shopShablonPath = 'ab1/tunable';
        $this->_readLanguageInterface();
    }

    public function action_auth() {
        $this->_sitePageData->url = '/tunable/shopuser/auth';

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
        $this->_sitePageData->url = '/tunable/shopuser/login';

        $email = Request_RequestParams::getParamStr('email');
        $password = Request_RequestParams::getParamStr('password');

        $auth = Auth::instance();
        $auth->setKeySession('ab1');
        $auth->driverDB = $this->_driverDB;
        $auth->model = new Model_Ab1_Shop_Operation();

        if (!$auth->login($email, $password)) {
            $this->redirect('/tunable/shopuser/auth?is_main='.Request_RequestParams::getParamBoolean('is_main').'&s=1');
        } else {
            if($auth->model->getShopTableRubricID() == 0){
                $this->redirect('/tunable/admin/index');
            }else {
                $this->redirect('/tunable/shopcar/entry');
            }
        }
    }

    public function action_unlogin() {
        $auth = Auth::instance();
        $auth->setKeySession('ab1');
        $auth->driverDB = $this->_driverDB;
        $auth->logout();

        $this->redirect($this->_sitePageData->urlBasic . "/tunable");
    }
}

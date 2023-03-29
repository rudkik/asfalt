<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Nur_Bookkeeping_Shopuser extends Controller_Nur_Bookkeeping_BasicNur {
    public function before() {
        $this->_sitePageData->shopShablonPath = 'nur/bookkeeping';
        $this->_readLanguageInterface();
    }

    public function action_auth() {
        $this->_sitePageData->url = '/nur-bookkeeping/shopuser/auth';

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
        $this->_sitePageData->url = '/nur-bookkeeping/shopuser/login';

        $email = Request_RequestParams::getParamStr('email');
        $password = Request_RequestParams::getParamStr('password');

        $auth = Auth::instance();
        $auth->setKeySession($this->sessionKey);
        $auth->driverDB = $this->_driverDB;
        $auth->model = new Model_Shop_Operation();

        if (!$auth->login($email, $password)) {
            $this->redirect('/nur-bookkeeping/shopuser/auth?is_main='.Request_RequestParams::getParamBoolean('is_main').'&s=1');
        } else {
            Helpers_DB::getDBObject($auth->model, $auth->model->id, $this->_sitePageData);
            if($auth->model->getShopTableRubricID() == Model_Nur_Shop_Operation::RUBRIC_BOOKKEEPING) {
                $this->redirect('/nur-bookkeeping/shopbranch/index');
            }else{
                $this->redirect('/nur-bookkeeping');
            }
        }
    }

    public function action_unlogin() {
        $auth = Auth::instance();
        $auth->setKeySession($this->sessionKey);
        $auth->driverDB = $this->_driverDB;
        $auth->logout();

        $this->redirect($this->_sitePageData->urlBasic . "/nur-bookkeeping");
    }
}

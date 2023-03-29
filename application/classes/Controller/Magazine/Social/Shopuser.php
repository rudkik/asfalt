<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Social_Shopuser extends Controller_Magazine_Social_BasicMagazine {
    public function before() {
        $this->_sitePageData->shopShablonPath = 'magazine/social';
        $this->_readLanguageInterface();
    }

    public function action_auth() {
        $this->_sitePageData->url = '/social/shopuser/auth';

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
        $this->_sitePageData->url = '/social/shopuser/login';

        $email = Request_RequestParams::getParamStr('email');
        $password = Request_RequestParams::getParamStr('password');

        $auth = Auth::instance();
        $auth->setKeySession('magazine');
        $auth->driverDB = $this->_driverDB;
        $auth->model = new Model_Magazine_Shop_Operation();
        $auth->model->setDBDriver($this->_driverDB);

        if (!$auth->login($email, $password)) {
            $this->redirect('/social/shopuser/auth?is_main='.Request_RequestParams::getParamBoolean('is_main').'&s=1');
        } else {
            if($auth->model->getShopTableRubricID() == 0){
                $this->redirect('/social/admin/index');
            }else {
                if($auth->model->getShopTableRubricID() == Model_Magazine_Shop_Operation::RUBRIC_SOCIAL) {
                    $this->redirect('/social/shopreceive/statistics');
                }else{
                    $this->redirect('/social');
                }
            }
        }
    }

    public function action_unlogin() {
        $auth = Auth::instance();
        $auth->setKeySession('magazine');
        $auth->driverDB = $this->_driverDB;
        $auth->logout();

        $this->redirect($this->_sitePageData->urlBasic . "/social");
    }
}

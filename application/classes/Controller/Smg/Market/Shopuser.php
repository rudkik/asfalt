<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_Shopuser extends Controller_Smg_Market_Basic {
    public function before() {
        $this->_sitePageData->shopShablonPath = 'smg/market';
        $this->_readLanguageInterface();
    }

    public function action_auth() {
        $this->_sitePageData->url = '/market/shopuser/auth';

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
        $this->_sitePageData->url = '/market/shopuser/login';

        $email = Request_RequestParams::getParamStr('email');
        $password = Request_RequestParams::getParamStr('password');

        $auth = Auth::instance();
        $auth->setKeySession('smg');
        $auth->driverDB = $this->_driverDB;
        $auth->model = new Model_AutoPart_Shop_Operation();

        if (!$auth->login($email, $password)) {
            $this->redirect('/market/shopuser/auth?is_main='.Request_RequestParams::getParamBoolean('is_main').'&s=1');
        } else {
            if($auth->model->getShopPositionID() == Model_AutoPart_Shop_Position::POSITION_COURIER){
                $this->redirect('/market/shopbill/courier');
            }elseif($auth->model->getShopPositionID() == Model_AutoPart_Shop_Position::POSITION_INDETIFY){
                $this->redirect('/market/shopproduct/identify');
            }else {
                $this->redirect('/market/shopproduct/index');
            }
        }
    }

    public function action_unlogin() {
        $auth = Auth::instance();
        $auth->setKeySession('smg');
        $auth->driverDB = $this->_driverDB;
        $auth->logout();

        $this->redirect($this->_sitePageData->urlBasic . "/market");
    }
}

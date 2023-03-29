<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Abc_Shopuser extends Controller_Ab1_Abc_BasicAb1 {
    public function before() {
        $this->_sitePageData->shopShablonPath = 'ab1/abc';
        $this->_readLanguageInterface();
    }

    public function action_auth() {
        $this->_sitePageData->url = '/abc/shopuser/auth';


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
        $this->_sitePageData->url = '/abc/shopuser/login';

        $email = Request_RequestParams::getParamStr('email');
        $password = Request_RequestParams::getParamStr('password');

        $auth = Auth::instance();
        $auth->setKeySession('ab1');
        $auth->driverDB = $this->_driverDB;
        $auth->model = new Model_Ab1_Shop_Operation();

        if (!$auth->login($email, $password)) {
            $this->redirect('/abc/shopuser/auth?is_main='.Request_RequestParams::getParamBoolean('is_main').'&s=1');
        } else {
            if($auth->model->getShopTableRubricID() == 0){
                $this->redirect('/abc/admin/index');
            }else {
                $interfaceIDs = Arr::path($auth->model->getOptionsArray(), 'interface_ids', array());
                if($auth->model->getShopTableRubricID() == Model_Ab1_Shop_Operation::RUBRIC_ABC
                    || array_search(Model_Ab1_Shop_Operation::RUBRIC_ABC, $interfaceIDs) !== false) {
                    $this->redirect('/abc/shopformulaproduct/index');
                }else{
                    $this->redirect('/abc');
                }
            }
        }
    }
    public function action_unlogin() {
        $auth = Auth::instance();
        $auth->setKeySession('ab1');
        $auth->driverDB = $this->_driverDB;
        $auth->logout();

        $this->redirect($this->_sitePageData->urlBasic . "/abc");
    }
}

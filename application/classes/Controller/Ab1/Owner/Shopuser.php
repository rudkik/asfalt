<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Owner_Shopuser extends Controller_Ab1_Owner_BasicAb1 {
    public function before() {
        $this->_sitePageData->shopShablonPath = 'ab1/owner';
        $this->_readLanguageInterface();
    }

    public function action_auth() {
        $this->_sitePageData->url = '/owner/shopuser/auth';

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
        $this->_sitePageData->url = '/owner/shopuser/login';

        $email = Request_RequestParams::getParamStr('email');
        $password = Request_RequestParams::getParamStr('password');

        $auth = Auth::instance();
        $auth->setKeySession('ab1');
        $auth->driverDB = $this->_driverDB;
        $auth->model = new Model_Ab1_Shop_Operation();

        if (!$auth->login($email, $password)) {
            $this->redirect('/owner/shopuser/auth?is_main='.Request_RequestParams::getParamBoolean('is_main').'&s=1');
        } else {
            if($auth->model->getShopTableRubricID() == 0){
                $this->redirect('/owner/admin/index');
            }else {
                $interfaceIDs = Arr::path($auth->model->getOptionsArray(), 'interface_ids', array());
                if($auth->model->getShopTableRubricID() == Model_Ab1_Shop_Operation::RUBRIC_OWNER
                    || array_search(Model_Ab1_Shop_Operation::RUBRIC_OWNER, $interfaceIDs) !== false) {
                    $this->redirect('/owner/shopproductrubric/statistics');
                }else{
                    $this->redirect('/owner');
                }
            }
        }
    }

    public function action_unlogin() {
        $auth = Auth::instance();
        $auth->setKeySession('ab1');
        $auth->driverDB = $this->_driverDB;
        $auth->logout();

        $this->redirect($this->_sitePageData->urlBasic . "/owner");
    }
}

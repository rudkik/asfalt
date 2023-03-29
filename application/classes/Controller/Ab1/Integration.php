<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Integration extends Controller_BasicControler
{
    /**
     * Определяем пользователя интерсейса
     */
    protected function _readUserInterface()
    {
        $auth = Auth::instance();
        $auth->setKeySession('smg');
        $auth->driverDB = $this->_driverDB;
        $auth->model = new Model_AutoPart_Shop_Operation();

        $email = 'ab2@oto.kz';
        $password = 'xye4#LK~nw}fmYdipsSP?m~t';

        if((empty($email)) || (empty($password))){
            $this->redirect('/'.$this->actionURLName);
        }else {
            if (!$auth->login($email, $password)) {
                $this->redirect('/'.$this->actionURLName);
            }else{
                $auth->isLoginSessionShop();
            }
        }

        $this->_sitePageData->operation = $auth->model;
        $this->_sitePageData->operationID = $auth->model->id;

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
     * Загрузка данных из 1С
     */
    public function action_set() {
        //$this->_sitePageData->url = '/ab1-integration-1c/set';

        /* $login = "integration-1c";
         $password = "12345!";
         echo '<pre>';
         print_r($_SERVER);die;
         if(isset($_SERVER['PHP_AUTH_USER']) && ($_SERVER['PHP_AUTH_PW'] == $password) && (strtolower($_SERVER['PHP_AUTH_USER']) == $login)){
         } else {
             header('WWW-Authenticate: Basic realm="Backend"');
             header('HTTP/1.0 401 Unauthorized');
             echo 'Authenticate required!';die;
         }*/

        $this->_readUserInterface();

        $data = Request_RequestParams::getParamStr('data');
        if(empty($data)){
            $data = $this->request->body();
        }

        $tmp = new Integration_Ab1_1C_Service();
        $tmp->updateAb1($data, $this->_sitePageData, $this->_driverDB);
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Trade_Shopuser extends Controller_Smg_Trade_Basic {
    public function before() {
        $this->_sitePageData->shopShablonPath = 'smg/trade';
        $this->_readLanguageInterface();
    }

    public function action_unlogin(){

        $url = Request_RequestParams::getParamStr('url');

        $auth = Auth::instance();

        $auth->setKeySession('smg');
        $auth->driverDB = $this->_driverDB;
        $auth->logout();
        $this->redirect($this->_sitePageData->urlBasic . $url);
    }

    /**
     * Восстановление пароля
     */
    public function action_forgot()
    {
        $this->_sitePageData->url = '/shopuser/forgot';

        $email = Request_RequestParams::getParamStr('email');
        $url = Request_RequestParams::getParamStr('url');

        // находим пользователя по email
        $userID = Request_User::getShopUserIDByEMail($email, $this->_driverDB);

        if ($userID < 1) {
            $this->redirect(Request_RequestParams::getParamStr('error_url') . URL::query(
                    array(
                        'system' =>
                            array(
                                'error' => 1,
                            )
                    ),
                    FALSE
                )
            );
        }

        // генерируем случайный пароль
        $password = Func::generatePassword();


        // сохраняем новый пароль
        $model = new Model_User();
        $model->setDBDriver($this->_driverDB);
        Helpers_DB::getDBObject($model, $userID, $this->_sitePageData);
        $model->setPassword(Auth::instance()->hashPassword($password));
        Helpers_DB::saveDBObject($model, $this->_sitePageData);

        // отправка сообщения о воостановление пароля на почту
        Api_EMail::sendRememberPasswordShopUserByEMail($email, $this->_sitePageData->shopID, $userID,
            $this->_sitePageData, $this->_driverDB, array('password' => $password));

        if($url !== NULL) {
            $this->redirect($url);
        }
    }

    public function action_login()
    {
        $this->_sitePageData->url = '/shopuser/login';

        $email = Request_RequestParams::getParamStr('email');
        $password = Request_RequestParams::getParamStr('password');
        $url = Request_RequestParams::getParamStr('url');
        $auth = Auth::instance();


        $auth->setKeySession('smg');
        $auth->driverDB = $this->_driverDB;
        $auth->model = new Model_User();

        if (!$auth->login($email, $password)) {
            $url = Request_RequestParams::getParamStr('auth') ;
            $this->redirect(
                'trade/shopuser/error' . URL::query(
                    array(
                        'system' =>
                            array(
                                'error' => 1,
                                'user_login' => array(
                                    'values' => array('url' => $url, 'email' => $email)
                                )
                            )
                    ),
                    FALSE
                )
            );
        } else {
            if(empty($url)){
                $url = '/';
            }
            $this->redirect($url);
        }
    }

    private function _getShopUserOptions(array $options){
        if($this->_sitePageData->branchID > 0){
            $shopID = $this->_sitePageData->branchID;
        }else{
            $shopID = $this->_sitePageData->shopID;
        }

        $arr = Request_RequestParams::getParamArray('options');
        if($arr !== NULL) {
            foreach ($arr as $key => $value) {
                $options[$shopID][$key] = $value;
            }
        }

        // добавляем данные
        $arr = Request_RequestParams::getParamArray('options_add');
        if($arr !== NULL) {
            foreach ($arr as $key => $value) {
                Arr::set_path($options, $shopID.'.'.$key, $value);
            }
        }

        return $options;
    }

    public function action_registration()
    {
        $this->_sitePageData->url = '/shopuser/registration';

        $model = new Model_User();
        $model->setDBDriver($this->_driverDB);

        Request_RequestParams::setParamStr('email', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr('password', $model);

        $model->setOptionsArray($this->_getShopUserOptions($model->getOptionsArray()));

        // находим пользователя по email
        $userID = Request_User::getShopUserIDByEMail($model->getEmail(), $this->_driverDB);
        $result = array();
        if (($model->validationFields($result)) && ($userID == 0)){
            $model->setPassword(Auth::instance()->hashPassword($model->getPassword()));
            $model->setEditUserID($this->_sitePageData->userID);
            Helpers_DB::saveDBObject($model, $this->_sitePageData);

            // отправка сообщения о регистрации пользователю на почту
            Api_EMail::sendCreateShopUser($model->getEmail(), $this->_sitePageData->shopID, $model->id, $this->_sitePageData, $this->_driverDB);

            $this->redirect('/trade/shopuser/complete' . URL::query(
                    array(
                        'email' => $model->getEmail(),
                        'password' => Request_RequestParams::getParamStr('password'),
                        'url' => Request_RequestParams::getParamStr('url')
                    ), FALSE));
        } else {
            if($userID > 0){
                $s = str_replace(':field', 'E-mail', I18n::get(':field already exists'));

                $result['fields']['email'] = $s;
                $result['error_msg'] = trim($result['error_msg']."\r\n".$s);
            }

            $this->redirect(
                '/trade/shopuser/errorregistration' . URL::query(
                    array(
                        'system' =>
                            array(
                                'user_registration' => array(
                                    'error' => 1,
                                    'error_data' => $result,
                                    'values' => $model->getValues(TRUE, TRUE, $this->_sitePageData->shopID)
                                )
                            )
                    ),
                    FALSE
                )
            );
        }
    }
    public function action_error()
    {
        $this->_sitePageData->url = '/shopuser/error';

        $this->_putInMain('/main/_shop/error');

    }


    public function action_complete()
    {
        $this->_sitePageData->url = '/shopuser/complete';

        $this->_putInMain('/main/_shop/complete');

    }

    public function action_errorregistration()
    {
        $this->_sitePageData->url = '/shopuser/errorregistration';

        $this->_putInMain('/main/_shop/errorregistration');

    }



    public function action_forgot_message()
    {
        $this->_sitePageData->url = '/shopuser/forgot-message';

        $this->_putInMain('/main/_shop/complete');

    }



}

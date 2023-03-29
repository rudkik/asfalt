<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Trade_Basic extends Controller_Smg_All
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'trade';
        $this->prefixView = 'trade';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'trade';
        $this->_sitePageData->shopID = 20678;
    }


    /**
     * Определяем пользователя интерсейса
     */
    protected function _readUserInterface()
    {
        $auth = Auth::instance();
        $auth->setKeySession('smg');
        $auth->driverDB = $this->_driverDB;
        $auth->model = new Model_User();

        // пользователь
        if (!($auth->isLoginSession())){
            $email = Arr::path($_POST, 'auth.email', Arr::path($_GET, 'auth.email', ''));
            $password = Arr::path($_POST, 'auth.password', Arr::path($_GET, 'auth.password', ''));

            if(!empty($email) && !empty($password)){
                if ($auth->login($email, $password)) {
                    $auth->isLoginSession();
                }
            }
        }

        $this->_sitePageData->user = $auth->model;
        $this->_sitePageData->userID = $auth->model->id;
    }
}
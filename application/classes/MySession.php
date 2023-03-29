<?php defined('SYSPATH') OR die('No direct script access.');

class MySession {
	private static $session = NULL;

	/**
	 * Получаем массив сессии для определенного сайта
	 * @param integer $shopID
	 * @param string $path
	 * @return array
	 */
	public static function getSession($shopID, $path, $default = '') {
        if (self::$session === NULL) {
            self::$session = Session::instance();
        }

        $shopID = 0;
        $result = self::$session->get($shopID, $default);

        if (!is_array($result)) {
            $result = $default;
        } elseif (!empty($path)) {
            $result = Arr::path($result, $path, $default);
        }
        return $result;
	}

	/**
	 * Записываем данные массив сессии для определенного сайта
	 * @param integer $shopID
	 * @param string $path
	 * @param $value
	 */
	public static function setSession($shopID, $path, $value) {
		if (self::$session === NULL){
			self::$session = Session::instance();
		}

		$shopID = 0;
		$data = self::$session->get($shopID, array());
		if (empty($path)){
			self::$session->set($shopID, $value);
		}else{
			Arr::set_path($data, $path, $value);
			self::$session->set($shopID, $data);
		}
	}
}
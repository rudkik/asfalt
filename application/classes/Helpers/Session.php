<?php defined('SYSPATH') OR die('No direct script access.');

class Helpers_Session {
    private static $session = NULL;

    /**
     * Получение данных из массива данных сохраненных в сессии
     * @param $keySession
     * @param $pathArray
     * @param string $default
     * @return mixed|string
     */
    public static function getArrayValue($keySession, $pathArray, $default = '') {
        if (self::$session === NULL){
            self::$session = Session::instance();
        }

        $result = self::$session->get($keySession, $default);

        if (!is_array($result)){
            $result = $default;
        }elseif (!empty($path)){
            $result = Arr::path($result, $path, $default);
        }

        return $result;
    }

    /**
     * Сохранение данных в массив данных сохраненных в сессии
     * @param $keySession
     * @param $pathArray
     * @param $value
     */
    public static function setArrayValue($keySession, $pathArray, $value) {
        if (self::$session === NULL){
            self::$session = Session::instance();
        }

        if (empty($pathArray)){
            self::$session->set($keySession, $value);
        }else{
            $data = self::$session->get($keySession, array());
            if(! is_array($data)){
                $data = array();
            }

            Arr::set_path($data, $pathArray, $value);
            self::$session->set($keySession, $data);
        }
    }

    /**
     * Получение данных сохраненных в сессии
     * @param $keySession
     * @param string $default
     * @return mixed|string
     */
    public static function getValue($keySession, $default = '') {
        if (self::$session === NULL){
            self::$session = Session::instance();
        }

        $result = self::$session->get($keySession, $default);

        return $result;
    }

    /**
     * Сохранение данных в сессии
     * @param $keySession
     * @param $value
     */
    public static function setValue($keySession, $value) {
        if (self::$session === NULL){
            self::$session = Session::instance();
        }

        self::$session->set($keySession, $value);
    }

    /**
     * Удаление данных из сессии
     * @param $keySession
     */
    public static function delete($keySession) {
        if (self::$session !== NULL){
            self::$session = Session::instance();
        }

        self::$session->delete($keySession);
    }
}
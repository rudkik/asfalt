<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_Token {
    private static $SALT = 'token';

    /**
     * Проверяем разрешен ли доступ
     * @param $url
     * @throws HTTP_Exception_500
     */
    public static function checkAccess($url)
    {
        if ((!Request_RequestParams::getParamBoolean('token_not')) && !Helpers_Token::isAccessURL($url)) {
            throw new HTTP_Exception_500('Token not found');
        }
    }

    /**
     * Разрешен ли доступ по токену к данной ссылке
     * @param $url
     * @param bool $isDeleteToken
     * @return bool|null
     */
    public static function isAccessURL($url, $isDeleteToken = TRUE){
        $token = Request_RequestParams::getParamStr('token');
        if(empty($token)){
            return NULL;
        }

        $url = self::deleteActionURL($url);
        $result = Helpers_Session::getValue($token) == $url || Arr::path($_SESSION, $token, null) == $url;
        if($isDeleteToken){
            Helpers_Session::delete($token);
            unset($_SESSION[$token]);
        }

        return $result;
    }

    /**
     * Возвращаем токен, разрешающий изменение
     * @param $url
     * @return string
     */
    public static function getTokenURL($url){
        $url = self::deleteActionURL($url);

        $token = md5(
            DateTime::createFromFormat('U.u', microtime(true))->format('Y-m-d H:i:s.u')
            . $url . self::$SALT
        );

        Helpers_Session::setValue($token, $url);
        $_SESSION[$token] = $url;

        return  $token;
    }

    /**
     * Возращаем input для вывода токена доступа
     * @param $url
     * @return string
     */
    public static function getInputTokenURL($url){
        $token = self::getTokenURL($url);

        return  '<input name="token" value="'.htmlspecialchars($token, ENT_QUOTES).'" style="display: none">'.$url;
    }

    /**
     * Удаляем из URL данные о действии
     * @param $url
     * @return string
     */
    private static function deleteActionURL($url){
        $result = pathinfo($url);

        if(!empty($result['dirname'])){
            $url = $result['dirname'];
        }

        return $url;
    }
}
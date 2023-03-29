<?php

class Request_RequestParams  {
	const READ_REQUEST_TYPE_NAME = 'read_request_type';
    /*
	const READ_REQUEST_TYPE_REAL_ALL_PRIORITY_GET_POST_PARAMS  = 1; // считываем параметры все, приоритет на $_GET $_POST параметры
    const READ_REQUEST_TYPE_REAL_ALL_PRIORITY_POST_GET_PARAMS  = 2; // считываем параметры все, приоритет на $_POST $_GET  параметры
    const READ_REQUEST_TYPE_REAL_ALL_PRIORITY_PARAMS_POST_GET  = 3; // считываем параметры все, приоритет на параметры $_POST $_GET
    const READ_REQUEST_TYPE_REAL_ALL_PRIORITY_PARAMS_GET_POST  = 4; // считываем параметры все, приоритет на параметры $_GET $_POST
    const READ_REQUEST_TYPE_REAL_PARAMS  = 5; // считываем параметры
    const READ_REQUEST_TYPE_REAL_GET_OST  = 6; // считываем параметры все, приоритет на параметры $_GET $_POST
    */

    const IS_NOT_READ_REQUEST_NAME = 'is_not_read_request';

    /**
     * Преобразуем параметры для запроса в правильные данные для БД
     * @param array $params
     * @param bool $isNotReadRequest
     * @param array $result
     * @return array
     */
    public static function setParams(array $params = array(), $isNotReadRequest = TRUE, $result = array()){
        $result[self::IS_NOT_READ_REQUEST_NAME] = $isNotReadRequest;
        foreach ($params as $name => $value){
            $name = str_replace('/', '.', $name);
            if (is_array($value)){
                $result[$name] = array(
                    'value' => $value,
                );
            }else{
                $result[$name] = $value;
            }
        }

        return $result;
    }

    /**
     * задаем параметры из get запроса в объект  $basicObject
     * http://localhost/index.php/city/add?name=Алматы
     * @param $name
     * @param Model_Basic_BasicObject $basicObject
     * @param string $path
     */
	public static function setParamTime($name, Model_Basic_BasicObject $basicObject, $path = '')
	{
		if (!empty($path)) {
			$tmp = Arr::path($_GET, $path, Arr::path($_POST, $path, FALSE));
			if($tmp !== FALSE){
				$tmp = strtotime(trim($tmp));
				if ($tmp !== FALSE) {
					$basicObject->setValue($name, date('H:i:s', $tmp));
				}
			}
		} else {
			if (array_key_exists($name, $_GET)) {
				$tmp = strtotime(trim($_GET[$name]));
				if ($tmp !== FALSE) {
					$basicObject->setValue($name, date('H:i:s', $tmp));
				}
			} elseif (array_key_exists($name, $_POST)) {
				$tmp = strtotime(trim($_POST[$name]));
				if ($tmp !== FALSE) {
					$basicObject->setValue($name, date('H:i:s', $tmp));
				}
			}
		}
	}

    /**
     * задаем параметры из get запроса в объект  $basicObject
     * http://localhost/index.php/city/add?name=Алматы
     * @param $name
     * @param Model_Basic_BasicObject $basicObject
     * @param string $path
     */
    public static function setParamDateTime($name, Model_Basic_BasicObject $basicObject, $path = '')
    {
        $tmp = false;
        if(!empty($path)){
            $tmp = trim(Arr::path($_GET, $path, Arr::path($_POST, $path, FALSE)));            
        }else {
            if (key_exists($name, $_GET)){
                $tmp = $_GET[$name];
            }elseif (key_exists($name, $_POST)) {
                $tmp = $_POST[$name];
            }
        }

        if($tmp !== FALSE){
            if($tmp === '' || $tmp === null) {
                $basicObject->setValue($name, null);
            }else {
                $tmp = strtotime($tmp, NULL);
                if ($tmp !== NULL) {
                    $basicObject->setValue($name, date('Y-m-d H:i:s', $tmp));
                }
            }
        }
    }

    /**
     * задаем параметры из get запроса в объект  $basicObject
     * http://localhost/index.php/city/add?name=Алматы
     * @param $name
     * @param Model_Basic_BasicObject $basicObject
     * @param string $path
     */
    public static function setParamDate($name, Model_Basic_BasicObject $basicObject, $path = '')
    {
        $tmp = false;
        if(!empty($path)){
            $tmp = trim(Arr::path($_GET, $path, Arr::path($_POST, $path, FALSE)));
        }else {
            if (key_exists($name, $_GET)){
                $tmp = $_GET[$name];
            }elseif (key_exists($name, $_POST)) {
                $tmp = $_POST[$name];
            }
        }

        if($tmp !== FALSE){
            if($tmp === '' || $tmp === null) {
                $basicObject->setValue($name, null);
            }else {
                $tmp = strtotime($tmp, NULL);
                if ($tmp !== NULL) {
                    $basicObject->setValue($name, date('Y-m-d', $tmp));
                }
            }
        }
    }

    /**
     * задаем параметры из get запроса в объект  $basicObject
     * http://localhost/index.php/city/add?name=Алматы
     * @param $name
     * @param Model_Basic_BasicObject $basicObject
     * @param string $path
     */
	public static function setParamBoolean($name, Model_Basic_BasicObject $basicObject, $path = '')
	{
        $result = FALSE;
        $tmp = null;
		if(!empty($path)){
			$tmp = Arr::path($_GET, $path, Arr::path($_POST, $path, NULL));
			if($tmp !== NULL){
				$tmp = trim($tmp);
                $result = TRUE;
			}
		}else {
			if (array_key_exists($name, $_GET)) {
				$tmp = trim($_GET[$name]);
                $result = TRUE;
			} elseif (array_key_exists($name, $_POST)) {
				$tmp = trim($_POST[$name]);
                $result = TRUE;
			}
		}

		if ($result){
			if (intval($tmp) === 1 || (is_bool($tmp) && $tmp) || strtolower($tmp) === 'true'){
				$basicObject->setValue($name, 1);
			}else{
				$basicObject->setValue($name, 0);
			}
		}

	}

    /**
     * задаем параметры из get запроса в объект  $basicObject
     * http://localhost/index.php/city/add?name=Алматы
     * @param $name
     * @param Model_Basic_BasicObject $basicObject
     * @param string $path
     */
	public static function setParamInt($name, Model_Basic_BasicObject $basicObject, $path = '')
	{
		if(!empty($path)){
			$tmp = Arr::path($_GET, $path, Arr::path($_POST, $path, FALSE));
			if($tmp !== FALSE){
                $tmp = self::valParamInt($tmp);
                if($tmp !== null) {
                    $basicObject->setValue($name, $tmp);
                }
			}
		}else {
			if (key_exists($name, $_GET)) {
                $tmp = self::valParamInt($_GET[$name]);
                if($tmp !== null) {
                    $basicObject->setValue($name, $tmp);
                }
			} elseif (key_exists($name, $_POST)) {
                $tmp = self::valParamInt($_POST[$name]);
                if($tmp !== null) {
                    $basicObject->setValue($name, $tmp);
                }
			}
		}
	}


    /**
     * задаем параметры из get запроса в объект  $basicObject
     * http://localhost/index.php/city/add?name=Алматы
     * @param $name
     * @param Model_Basic_BasicObject $basicObject
     * @param string $path
     */
	public static  function setParamStr($name, Model_Basic_BasicObject $basicObject, $path = '')
	{
		if(!empty($path)){
			$tmp = Arr::path($_GET, $path, Arr::path($_POST, $path, FALSE));
			if($tmp !== FALSE){
				$basicObject->setValue($name, trim($tmp));
			}
		}else {
			if (array_key_exists($name, $_GET)) {
				$basicObject->setValue($name, trim($_GET[$name]));
			} elseif (array_key_exists($name, $_POST)) {
				$basicObject->setValue($name, trim($_POST[$name]));
			}
		}
	}

    /**
     * задаем параметры из get запроса в объект  $basicObject
     * http://localhost/index.php/city/add?name=Алматы
     * @param $name
     * @param Model_Basic_BasicObject $basicObject
     * @param string $path
     */
	public static function setParamFloat($name, Model_Basic_BasicObject $basicObject, $path = '')
	{
		if(!empty($path)){
            $tmp = Arr::path($_GET, $name, Arr::path($_POST, $name, FALSE));
			if($tmp !== FALSE){
                $tmp = self::valParamFloat($tmp);
                if($tmp !== null) {
                    $basicObject->setValue($name, $tmp);
                }
			}
		}else {
			if (key_exists($name, $_GET)) {
                $tmp = self::valParamFloat($_GET[$name]);
                if($tmp !== null) {
                    $basicObject->setValue($name, $tmp);
                }
			} elseif (key_exists($name, $_POST)) {
                $tmp = self::valParamFloat($_POST[$name]);
                if($tmp !== null) {
                    $basicObject->setValue($name, $tmp);
                }
			}
		}
	}

    /**
     * получаем параметр из запроса и проверяем, чтобы он был массив
     * http://localhost/index.php/city/add?name=Алматы
     * возврашаем значение параметра строка
     * @param $name
     * @param array $params
     * @param null $default
     * @param bool $isNotReadRequest
     * @param null|SitePageData $sitePageData
     * @param bool $isArrayPath
     * @return mixed|null
     */
	public static function getParam($name, array $params = array(), $default = NULL, $isNotReadRequest = FALSE,
                                    $sitePageData = NULL, $isArrayPath = FALSE)
	{
		if(key_exists($name, $params) && is_array($params[$name]) && key_exists('is_public', $params[$name]) && ($params[$name]['is_public'] != 1)){
            return $default;
		}

        $result = NULL;
		if(!$isNotReadRequest) {
			// запрос других данных
			$urlName = Arr::path($params, $name.'.field', '');
			if (empty($urlName)) {
				$urlName = $name;
			}

            if($isArrayPath === TRUE){
                $tmp = Arr::path($_GET, $name, Arr::path($_POST, $name, Arr::path($params, $name, NULL)));
                if($tmp !== NULL){
                    $result = $tmp;

                    if ($sitePageData !== NULL) {
                        Arr::set_path($sitePageData->urlParams, $urlName, $result);
                    }
                }
            }else {
                if (key_exists($urlName, $_GET)) {
                    $result = $_GET[$urlName];

                    if ($sitePageData !== NULL) {
                        $sitePageData->urlParams[$urlName] = $result;
                    }
                } elseif (key_exists($urlName, $_POST)) {
                    $result = $_POST[$urlName];

                    if ($sitePageData !== NULL) {
                        $sitePageData->urlParams[$urlName] = $result;
                    }
                } elseif (key_exists($name, $params)) {
                    $result = $params[$name];
                    if (is_array($result)) {
                        if (key_exists('value', $result)) {
                            $result = $result['value'];
                        } else {
                            if (key_exists('field', $result)) {
                                $result = NULL;
                            }
                        }
                    }
                }
            }
		}else{
            if($isArrayPath === TRUE){
                $result = Arr::path($params, $name, NULL);
            }else {
                if (key_exists($name, $params)) {
                    $result = $params[$name];
                }else{
					$result = NULL;
				}
            }
            if (is_array($result)) {
                if (key_exists('value', $result)) {
                    $result = $result['value'];
                } else {
                    if (key_exists('field', $result)) {
                        $result = NULL;
                    }
                }
            }
        }

		if ($result === NULL){
			return $default;
		}else{
			return $result;
		}
	}

    public static function valParamArray($value, $default = null)
    {
        if ($value === NULL){
            return $default;
        }elseif (is_array($value)){
            return $value;
        }else{
            return $default;
        }
    }

    /**
     * получаем параметр из запроса и проверяем, чтобы он был массив
     * http://localhost/index.php/city/add?name=Алматы
     * возврашаем значение параметра строка
     * @param $name
     * @param array $params
     * @param null $default
     * @param bool $isNotReadRequest
     * @param null $sitePageData
     * @param bool $isArrayPath
     * @return mixed|null
     */
	public static function getParamArray($name, array $params = array(), $default = NULL, $isNotReadRequest = FALSE, $sitePageData = NULL, $isArrayPath = FALSE)
	{
		$result = self::getParam($name, $params, NULL, $isNotReadRequest, $sitePageData, $isArrayPath);

		if ($result === NULL){
			return $default;
		}elseif (is_array($result)){
			return $result;
		}else{
			return $default;
		}
	}

    public static  function valParamStr($value)
    {
        if($value === NULL) {
            return NULL;
        }elseif (!is_array($value)) {
            return strval($value);
        } else {
            return Json::json_encode($value);
        }
    }


    /**
     * получаем параметр из запроса
     * http://localhost/index.php/city/add?name=Алматы
     * возврашаем значение параметра строка
     * @param $name
     * @param array $params
     * @param bool $isNotReadRequest
     * @param null $sitePageData
     * @param bool $isArrayPath
     * @return mixed|null|string
     */
	public static  function getParamStr($name, array $params = array(), $isNotReadRequest = FALSE,
                                        $sitePageData = NULL, $isArrayPath = FALSE)
	{
		$result = self::getParam($name, $params, NULL, $isNotReadRequest, $sitePageData, $isArrayPath);

		if($result === NULL) {
			return NULL;
		}elseif (!is_array($result)) {
			return strval($result);
		} else {
			return Json::json_encode($result);
		}
	}

	public static  function isBoolean($value){
		if(is_string($value)) {
			$value = strtolower($value);
		}
		if (!is_array($value)
            && (intval($value) === 1 || (is_bool($value) && $value) || ($value === 'true') || ($value === 'on'))){
			return TRUE;
		}else{
			return FALSE;
		}
	}

    /**
     * Считываем нужно ли считывать данные из вне
     * @param array $params
     * @return bool
     */
    public static function getIsNotReadRequest(array $params){
        return self::isBoolean(
            Arr::path(
                $params,
                self::IS_NOT_READ_REQUEST_NAME.'.value',
                Arr::path($params, self::IS_NOT_READ_REQUEST_NAME, FALSE)
            )
        );
    }

    public static  function valParamBoolean($value)
    {
        if ($value === NULL || $value === ''){
            return null;
        }
        return self::isBoolean($value);
    }

    /**
     * получаем параметр из запроса
     * http://localhost/index.php/city/add?name=Алматы
     * возврашаем значение параметра строка
     * @param $name
     * @param array $params
     * @param bool $isNotReadRequest
     * @param null $sitePageData
     * @param bool $isArrayPath
     * @return bool|mixed|null|string
     */
	public static  function getParamBoolean($name, array $params = array(), $isNotReadRequest = FALSE, $sitePageData = NULL, $isArrayPath = FALSE)
	{

        $tmp = self::getParam($name, $params, NULL, $isNotReadRequest, $sitePageData, $isArrayPath);
		if ($tmp === NULL || $tmp === ''){
			return null;
		}

		return self::isBoolean($tmp);
	}

    public static function valParamInt($value)
    {
        $value = str_replace(' ', '', $value);
        return intval(preg_replace('/[^0-9\-]/', '', $value));
    }

    /**
     * получаем параметр из запроса
     * http://localhost/index.php/city/add?name=Алматы
     * возврашаем значение параметра строка
     * @param $name
     * @param array $params
     * @param bool $isNotReadRequest
     * @param null $sitePageData
     * @param bool $isArrayPath
     * @return int|mixed|null|string
     */
	public static function getParamInt($name, array $params = array(), $isNotReadRequest = FALSE, $sitePageData = NULL, $isArrayPath = FALSE)
	{
		$result = self::getParamStr($name, $params, $isNotReadRequest, $sitePageData, $isArrayPath);
		if (!empty($result)) {
		    $result = str_replace(' ', '', $result);

			return intval($result);
		}else{
			return $result;
		}
	}

    /**
     * получаем параметр из запроса
     * http://localhost/index.php/city/add?name=Алматы
     * возврашаем значение параметра строка
     * @param $name
     * @param array $params
     * @param bool $isNotReadRequest
     * @param null $sitePageData
     * @param bool $isArrayPath
     * @return int|mixed|null|string
     */
    public static function getParamIntOrArray($name, array $params = array(), $isNotReadRequest = FALSE, $sitePageData = NULL, $isArrayPath = FALSE)
    {
        $result = self::getParamStr($name, $params, $isNotReadRequest, $sitePageData, $isArrayPath);
        if ($result !== NULL) {
            $result = str_replace(' ', '', $result);

            if(strpos($result, ',') === false){
                return intval($result);
            }

            $result = explode(',', $result);
            foreach ($result as $key => $child){
                if(!is_numeric($child) || !is_int(intval($child))){
                    unset($result[$key]);
                }
            }

            return $result;
        }else{
            return $result;
        }
    }

    /**
     * Преобразуем строку в вещественное число
     * @param $value
     * @return float
     */
    public static function strToFloat($value)
    {
        $value = str_replace(' ', '', $value);
        return floatval(preg_replace('/[^0-9,\.\-]/', '', str_replace(',', '.', $value)));
    }

    public static function valParamFloat($value)
    {
        if($value === '' || $value === null){
            return null;
        }

        return self::strToFloat($value);
    }

    /**
     * получаем параметр из запроса
     * http://localhost/index.php/city/add?name=Алматы
     * возврашаем значение параметра строка
     * @param $name
     * @param array $params
     * @param bool $isNotReadRequest
     * @param null $sitePageData
     * @param bool $isArrayPath
     * @return float|mixed|null|string
     */
	public static function getParamFloat($name, array $params = array(), $isNotReadRequest = FALSE, $sitePageData = NULL, $isArrayPath = FALSE)
	{
		$result = self::getParamStr($name, $params, $isNotReadRequest, $sitePageData, $isArrayPath);
		if($result === ''){
            $result = null;
        }
		if ($result !== NULL ) {
			return self::strToFloat($result);
		}else{
			return $result;
		}
	}

    public static  function valParamDateTime($value)
    {
        if (empty($value)){
            return null;
        }

        $value = strtotime($value);
        if ($value !== FALSE){
            return date('Y-m-d H:i:s', $value);
        }

        return NULL;
    }

    /**
     * получаем параметр из запроса
     * http://localhost/index.php/city/add?name=Алматы
     * возврашаем значение параметра строка
     * @param $name
     * @param array $params
     * @param bool $isNotReadRequest
     * @param null $sitePageData
     * @param bool $isArrayPath
     * @return false|int|mixed|null|string
     */
    public static  function getParamDateTime($name, array $params = array(), $isNotReadRequest = FALSE, $sitePageData = NULL, $isArrayPath = FALSE)
    {
        $result = Request_RequestParams::getParamStr($name, $params, $isNotReadRequest, $sitePageData, $isArrayPath);
        if ($result === NULL){
            return $result;
        }

        $result = strtotime($result);
        if ($result !== FALSE){
            return date('Y-m-d H:i:s', $result);
        }

        return NULL;
    }

    public static  function valParamDate($value)
    {
        if (empty($value)){
            return null;
        }

        $value = strtotime($value);
        if ($value !== FALSE){
            return date('Y-m-d', $value);
        }

        return NULL;
    }

    /**
     * получаем параметр из запроса
     * http://localhost/index.php/city/add?name=Алматы
     * возврашаем значение параметра строка
     * @param $name
     * @param array $params
     * @param bool $isNotReadRequest
     * @param null $sitePageData
     * @param bool $isArrayPath
     * @return false|int|mixed|null|string
     */
    public static  function getParamDate($name, array $params = array(), $isNotReadRequest = FALSE, $sitePageData = NULL, $isArrayPath = FALSE)
    {
        $result = Request_RequestParams::getParamStr($name, $params, $isNotReadRequest, $sitePageData, $isArrayPath);
        if ($result === NULL){
            return $result;
        }

        $result = strtotime($result);
        if ($result !== FALSE){
            return date('Y-m-d', $result);
        }

        return NULL;
    }

    public static  function valParamTime($value)
    {
        if (empty($value)){
            return null;
        }

        $value = strtotime($value);
        if ($value !== FALSE){
            return date('H:i:s', $value);
        }

        return NULL;
    }

    /**
     * получаем параметр из запроса
     * http://localhost/index.php/city/add?name=Алматы
     * возврашаем значение параметра время
     * @param $name
     * @param array $params
     * @param bool $isNotReadRequest
     * @param null $sitePageData
     * @param bool $isArrayPath
     * @return false|int|mixed|null|string
     */
    public static  function getParamTime($name, array $params = array(), $isNotReadRequest = FALSE, $sitePageData = NULL, $isArrayPath = FALSE)
    {
        $result = Request_RequestParams::getParamStr($name, $params, $isNotReadRequest, $sitePageData, $isArrayPath);
        if ($result === NULL){
            return $result;
        }

        $result = strtotime($result);
        if ($result !== FALSE){
            return date('H:i:s', $result);
        }

        return NULL;
    }
}
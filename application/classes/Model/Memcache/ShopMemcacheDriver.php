<?php defined('SYSPATH') or die('No direct script access.');

class Model_Memcache_ShopMemcacheDriver extends Model {

	// сохранять в мемкаше
	const IS_SAVE_MEMCACHE = FALSE;

	// количество секунд хранить данные
	const SAVE_DATA_SECONDS = 1209600; // 60 * 60 * 24 * 7 * 2;
    // количество секунд хранящие ключи данных (на один час больше)
    const SAVE_KEY_SECONDS = 1213200; // 60 * 60 * 24 * 7 * 2 + 60 * 60;

	// Мемкеш
	private $_cache = NULL;


	function __construct(){
        if(self::IS_SAVE_MEMCACHE === TRUE) {
            $this->_cache = Cache::instance('memcache');
        }
	}

    /**
     * Преобразование в строку
     * @param $data
     * @return string
     */
	private function _serializeData($data){
        if(self::IS_SAVE_MEMCACHE === TRUE) {
            return serialize($data);
        }else{
            return NULL;
        }
	}

    /**
     * Преобразование из строки
     * @param $data
     * @return
     */
	private function _unserializeData($data){
		if ($data === NULL){
			return NULL;
		}

        if(self::IS_SAVE_MEMCACHE === TRUE) {
            $tmp = unserialize($data);
        }else{
            $tmp = NULL;
        }
		return $tmp;
	}

    /**
     * Сохранение структуры данных
     * @param array $data
     */
	private function _saveKeyInFile(array $data){
        return FALSE;
        $select = '';
        foreach($data as $value){
            $select = $select . $value . "\t";
        }

        try {
            if(!file_exists(APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'memcache-tree.xls')){
                file_put_contents(APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'memcache-tree.xls', iconv('utf-8', 'windows-1251', "Магазин\tТаблица\tID записи\tЯзык данных\tШаблон\tВьюшка\tКурс валют\tДанные\tЯзык\tНазвание функции\tURL\tSQL" . "\r\n"), FILE_APPEND);
            }
        } catch (Exception $e) {
        }


        try {
            file_put_contents(APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'memcache-tree.xls', $select . "\r\n", FILE_APPEND);
        } catch (Exception $e) {
        }
	}

    /**
     * Сохранение структуры данных
     * @param array $data
     */
    private function _saveKeyStrInFile($data, $query){
        return FALSE;
        try {
            if(!file_exists(APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'memcache-finish-tree.xls')){
                file_put_contents(APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'memcache-finish-tree.xls', iconv('utf-8', 'windows-1251', "MD5\tЗапрос\tМагазин\tТаблица\tID записи\tЯзык данных\tШаблон\tВьюшка\tКурс валют\tДанные\tЯзык\tНазвание функции\tURL\tSQL\tСтрока" . "\r\n"), FILE_APPEND);
            }
        } catch (Exception $e) {
        }

        $b = mb_strpos($data, '/*/_sh');
        if($b > -1){
            $e = mb_strpos($data, '/*/_', $b + 1);

            $b = $b + mb_strlen('/*/_sh');
            $shopID = mb_substr($data, $b, $e - $b);
        }else{
            $shopID = '';
        }

        $b = mb_strpos($data, '/*/_sn');
        if($b > -1){
            $e = mb_strpos($data, '/*/_', $b + 1);

            $b = $b + mb_strlen('/*/_sn');
            $shablonName = mb_substr($data, $b, $e - $b);
        }else{
            $shablonName = '';
        }

        $b = mb_strpos($data, '/*/_sel');
        if($b > -1){
            $e = mb_strpos($data, '/*/_', $b + 1);

            $b = $b + mb_strlen('/*/_sel');
            $select = mb_substr($data, $b, $e - $b);
        }else{
            $select = '';
        }

        $b = mb_strpos($data, '/*/_l');
        if($b > -1){
            $e = mb_strpos($data, '/*/_', $b + 1);

            $b = $b + mb_strlen('/*/_l');
            $languageID = mb_substr($data, $b, $e - $b);
        }else{
            $languageID = '';
        }

        $b = mb_strpos($data, '/*/_t');
        if($b > -1){
            $e = mb_strpos($data, '/*/_', $b + 1);

            $b = $b + mb_strlen('/*/_t');
            $tableName = mb_substr($data, $b, $e - $b);
        }else{
            $tableName = '';
        }

        $b = mb_strpos($data, '/*/_v');
        if($b > -1){
            $e = mb_strpos($data, '/*/_', $b + 1);

            $b = $b + mb_strlen('/*/_v');
            $view = mb_substr($data, $b, $e - $b);
        }else{
            $view = '';
        }

        $b = mb_strpos($data, '/*/_i');
        if($b > -1){
            $e = mb_strpos($data, '/*/_', $b + 1);

            $b = $b + mb_strlen('/*/_i');
            $id = mb_substr($data, $b, $e - $b);
        }else{
            $id = '';
        }

        $b = mb_strpos($data, '/*/_dl');
        if($b > -1){
            $e = mb_strpos($data, '/*/_', $b + 1);

            $b = $b + mb_strlen('/*/_dl');
            $dataLanguageID = mb_substr($data, $b, $e - $b);
        }else{
            $dataLanguageID = '';
        }

        $b = mb_strpos($data, '/*/_c');
        if($b > -1){
            $e = mb_strpos($data, '/*/_', $b + 1);

            $b = $b + mb_strlen('/*/_c');
            $currencyID = mb_substr($data, $b, $e - $b);
        }else{
            $currencyID = '';
        }

        $b = mb_strpos($data, '/*/_das');
        if($b > -1){
            $e = mb_strpos($data, '/*/_', $b + 1);

            $b = $b + mb_strlen('/*/_das');
            $datas = mb_substr($data, $b, $e - $b);
        }else{
            $datas = '';
        }

        $b = mb_strpos($data, '/*/_f');
        if($b > -1){
            $e = mb_strpos($data, '/*/_', $b + 1);

            $b = $b + mb_strlen('/*/_f');
            $functionName = mb_substr($data, $b, $e - $b);
        }else{
            $functionName = '';
        }

        $b = mb_strpos($data, '/*/_u');
        if($b > -1){
            $e = mb_strpos($data, '/*/_', $b + 1);

            $b = $b + mb_strlen('/*/_u');
            $url = mb_substr($data, $b, $e - $b);
        }else{
            $url = '';
        }

        $arr = array(
            $shopID,
            $tableName,
            $id,
            $dataLanguageID,
            $shablonName,
            $view,
            $currencyID,
            $datas,
            $languageID,
            $functionName,
            $url,
            $select
        );

        $select = '';
        foreach($arr as $value){
            $select = $select . $value . "\t";
        }

        try {
            file_put_contents(APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'memcache-finish-tree.xls', md5($data)."\t".$query."\t".$select.$data . "\r\n", FILE_APPEND);
        } catch (Exception $e) {
        }
    }


    /**
     * преобразуем в строку для мем кеша
     * @param $shopID
     * @param $tableName
     * @param $id
     * @param int $dataLanguageID
     * @return string
     */
	private function _getKeyShopObject($shopID, $tableName, $id, $dataLanguageID){
        $this->_saveKeyInFile(array(
            intval($shopID),
            $tableName,
            intval($id),
            intval($dataLanguageID),
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ));

		return '!/*/_sh'.intval($shopID).'/*/_t'.$tableName.'/*/_i'.intval($id).'/*/_dl'.intval($dataLanguageID).'/*/_!';
	}

    /**
     * преобразуем в строку для мем кеша
     * @param $shopID
     * @param $shablonName
     * @param $languageID
     * @param $view
     * @param $tableName
     * @param $id
     * @param $dataLanguageID
     * @param $currencyID
     * @param $datas
     * @return string
     */
	private function _getKeyShopView($shopID, $shablonName, $languageID, $view, $tableName, $id, $dataLanguageID,
                                     $currencyID, $datas){
        $this->_saveKeyInFile(array(
            intval($shopID),
            $tableName,
            intval($id),
            intval($dataLanguageID),
            $shablonName,
            $view,
            intval($currencyID),
            $datas,
            intval($languageID),
            '',
            '',
            ''
        ));

		return '@/*/_sh'.intval($shopID)
        .'/*/_sn'.$shablonName
        .'/*/_l'.intval($languageID)
        .'/*/_t'.$tableName
        .'/*/_v'.$view
        .'/*/_i'.intval($id)
        .'/*/_dl'.intval($dataLanguageID)
		.'/*/_c'.intval($currencyID)
        .'/*/_d'.$datas.'/*/_@';
	}

    /**
     * преобразуем в строку для мем кеша
     * @param $shopID
     * @param $shablonName
     * @param $languageID
     * @param $views
     * @param $tableName
     * @param array $ids
     * @param $dataLanguageID
     * @param $currencyID
     * @param $datas
     * @return string
     */
	private function _getKeyShopViews($shopID, $shablonName, $languageID, $views, $tableName, array $ids, $dataLanguageID,
                                      $currencyID, $datas)
	{
        $this->_saveKeyInFile(array(
            intval($shopID),
            $tableName,
            Json::json_encode($ids),
            intval($dataLanguageID),
            $shablonName,
            '',
            intval($currencyID),
            $datas,
            intval($languageID),
            '',
            '',
            ''
        ));

        return '&/*/_sh'.intval($shopID)
        ."/*/_sn".$shablonName
        ."/*/_l".intval($languageID)
        ."/*/_v".$views
        .'/*/_t'.$tableName
        .'/*/_i'.Json::json_encode($ids)
        .'/*/_dl'.intval($dataLanguageID)
        ."/*/_c".intval($currencyID)
        .'/*/_d'.$datas."/*/_&";
	}

    /**
     * преобразуем в строку для мем кеша
     * @param $shopID
     * @param $tableName
     * @param $select
     * @param $dataLanguageID
     * @param bool $isIDs
     * @return string
     */
	private function _getKeyShopSelect($shopID, $tableName, $select, $dataLanguageID, $isIDs = TRUE){

        $this->_saveKeyInFile(array(
            intval($shopID),
            $tableName,
            '',
            intval($dataLanguageID),
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            $select
        ));

		$tmp = '/*/_sh'.intval($shopID).'/*/_t'.$tableName.'/*/_sel'.$select.'/*/_dl'.$dataLanguageID.'/*/_';
		if ($isIDs === TRUE){
			$tmp = '%%'.$tmp."%%";
		}else{
			$tmp = '^^'.$tmp."^^";
		}

		return $tmp;
	}

    /**
     * преобразуем в строку для мем кеша
     * @param $shopID
     * @param array $tableNames
     * @param $select
     * @param $dataLanguageID
     * @param bool $isIDs
     * @return string
     */
	private function _getKeyShopSelectTables($shopID, array $tableNames, $select, $dataLanguageID, $isIDs = TRUE){
        $this->_saveKeyInFile(array(
            intval($shopID),
            Json::json_encode($tableNames),
            '',
            intval($dataLanguageID),
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            $select
        ));

		$tmp = '/*/_sh'.intval($shopID).'/*/_t'.Json::json_encode($tableNames).'/*/_sel'.$select.'/*/_dl'.$dataLanguageID.'/*/_';
		if ($isIDs === TRUE){
			$tmp = '%'.$tmp."%";
		}else{
			$tmp = '^'.$tmp."^";
		}

		return $tmp;
	}

    /**
     * преобразуем в строку для мем кеша
     * @param $shopID
     * @param $tableName
     * @param $id
     * @return string
     */
	private function _getKeyShopObjectInList($shopID, $tableName, $id){
        $this->_saveKeyInFile(array(
            intval($shopID),
            $tableName,
            intval($id),
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ));

		return ')/*/_sh'.intval($shopID).'/*/_t'.$tableName.'/*/_i'.intval($id).'/*/_)';
	}

    /**
     * преобразуем в строку для мем кеша
     * @param $shopID
     * @param $tableName
     * @return string
     */
	private function _getKeyShopTableInList($shopID, $tableName)
	{
        $this->_saveKeyInFile(array(
            intval($shopID),
            $tableName,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ));

		return '-/*/_sh'.intval($shopID).'/*/_t'.$tableName."/*/_-";
	}

    /**
     * преобразуем в строку для мем кеша
     * @param $shopID
     * @return string
     */
    private function _getKeyShopInList($shopID)
    {
        $this->_saveKeyInFile(array(
            intval($shopID),
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ));

        return '|/*/_sh'.intval($shopID)."/*/_|";
    }

    /**
     * преобразуем в строку для мем кеша
     * @param $tableName
     * @return string
     */
    private function _getKeyTableInList($tableName)
    {
        $this->_saveKeyInFile(array(
            '',
            $tableName,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            ''
        ));

        return '#(/*/_t'.$tableName.'/*/_)#';
    }

    /**
     * преобразуем в строку для мем кеша
     * @param $shopID
     * @param $shablonName
     * @param $languageID
     * @param $functionName
     * @param $views
     * @param array $tableNames
     * @param $dataLanguageID
     * @param $currencyID
     * @param $datas
     * @return string
     */
	private function _getKeyShopFunctionView($shopID, $shablonName, $languageID, $functionName, $view, array $tableNames,
                                             $dataLanguageID, $currencyID, $datas){
        $this->_saveKeyInFile(array(
            intval($shopID),
            Json::json_encode($tableNames),
            '',
            intval($dataLanguageID),
            $shablonName,
            $view,
            intval($currencyID),
            $datas,
            intval($languageID),
            $functionName,
            '',
            ''
        ));

		return '//*/_sh'.intval($shopID)
        .'/*/_sn'.$shablonName
        .'/*/_l'.intval($languageID)
        .'/*/_f'.$functionName
        .'/*/_v'.$view
        .'/*/_t'.Json::json_encode($tableNames)
        .'/*/_dl'.intval($dataLanguageID)
        .'/*/_c'.intval($currencyID)
        .'/*/_dat'.$datas.'/*/_/';
	}


    /**
     * преобразуем в строку для мем кеша
     * @param $shopID
     * @param $shablonName
     * @param $languageID
     * @param $url
     * @param $datas
     * @return string
     */
    private function _getKeyShopPage($shopID, $shablonName, $languageID, $url, $datas){
        $this->_saveKeyInFile(array(
            intval($shopID),
            '',
            '',
            '',
            $shablonName,
            '',
            '',
            $datas,
            intval($languageID),
            '',
            $url,
            ''
        ));

        return '//*/_sh'.intval($shopID)
        .'/*/_sn'.$shablonName
        .'/*/_l'.intval($languageID)
        .'/*/_u'.$url
        .'/*/_dat'.$datas.'/*/_/';
    }

    /**
     * преобразуем в строку для мем кеша
     * @param $shopID
     * @param $shablonName
     * @param $languageID
     * @param $url
     * @param $datas
     * @return string
     */
    private function _getKeyShopMain($shopID, $shablonName, $languageID, $url, $datas){
        $this->_saveKeyInFile(array(
            intval($shopID),
            '',
            '',
            '',
            $shablonName,
            '',
            '',
            $datas,
            intval($languageID),
            '',
            $url,
            ''
        ));

        return '///*/_sh'.intval($shopID)
        .'/*/_sn'.$shablonName
        .'/*/_l'.intval($languageID)
        .'/*/_u'.$url
        .'/*/_das'.$datas.'/*/_//';
    }

    /**
     * преобразуем в строку для мем кеша
     * @param $shopID
     * @param $key
     * @return string
     */
	private function _getKeyShopData($shopID, $datas){
        $this->_saveKeyInFile(array(
            intval($shopID),
            '',
            '',
            '',
            '',
            '',
            '',
            $datas,
            '',
            '',
            '',
            ''
        ));

		return '=/*/_sh'.intval($shopID).'/*/_das'.$datas.'/*/_=';
	}


	private function __setMemcache($key, $data, $lifetime = self::SAVE_DATA_SECONDS, $link = ''){
        $this->_saveKeyStrInFile($key, 'set');

        if(self::IS_SAVE_MEMCACHE === TRUE) {
            $this->_cache->set(md5($key) . mb_strlen($key), $data, $lifetime);

            $select = $key;

            try {
                file_put_contents(APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'memcache.txt', 'set: ' . $select . "\r\n", FILE_APPEND);
            } catch (Exception $e) {
            }
        }
	}

	private function __getMemcache($key, $link = ''){
        $this->_saveKeyStrInFile($key, 'get');

        if(self::IS_SAVE_MEMCACHE === TRUE) {
            $result = $this->_cache->get(md5($key) . mb_strlen($key));

            $select = $key;

            try {
                file_put_contents(APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'memcache.txt', 'get: ' . $select . "\r\n", FILE_APPEND);
            } catch (Exception $e) {
            }
        }else{
            $result = NULL;
        }

		return $result;
	}

	private function __delMemcache($key){
        $this->_saveKeyStrInFile($key, 'del');

        if(self::IS_SAVE_MEMCACHE === TRUE) {
            $this->_cache->delete(md5($key) . mb_strlen($key));

            $select = $key;

            try {
                file_put_contents(APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'memcache.txt', 'del: ' . $select . "\r\n", FILE_APPEND);
            } catch (Exception $e) {
            }
        }
	}

    /**
     * Сохраняем еще один ключ для заданного элемента
     * @param $key
     * @param $shopID
     * @param $tableName
     * @param $id
     */
	private function _addObjectInList($key, $shopID, $tableName, $id){
		// собираем список ключей объектов
		$keyObject = $this->_getKeyShopObjectInList($shopID, $tableName, $id);

		// увеличиваем количество со на 1
		$tmp = intval($this->__getMemcache($keyObject)) + 1;
		$this->__setMemcache($keyObject, $tmp, 0);

		$this->__setMemcache($keyObject.'_#'.$tmp, $key, self::SAVE_KEY_SECONDS);

        // добавляем в список таблиц
        $this->_addTableInList($key, $shopID, $tableName);
	}

    /**
     * Добавление ключа в список таблица + магазин
     * @param $key
     * @param $shopID
     * @param $tableName
     */
	private function _addTableInList($key, $shopID, $tableName){
        // добавляем в список магазинов + таблица
        $this->_addShopInListTable($shopID, $tableName);

		// собираем список ключей таблицы
		$keyTable = $this->_getKeyShopTableInList($shopID, $tableName);

		// увеличиваем количество со на 1
		$tmp = intval($this->__getMemcache($keyTable)) + 1;
		$this->__setMemcache($keyTable, $tmp, 0);

		$this->__setMemcache($keyTable.'_#'.$tmp, $key, self::SAVE_KEY_SECONDS);

        // добавляем в список магазина
        $this->_addShopInList($key, $shopID);
	}

    /**
     * Добавление ключа в список магазина
     * @param $key
     * @param $shopID
     */
	private function _addShopInList($key, $shopID){
		// собираем список ключей таблицы
		$keyTable = $this->_getKeyShopInList($shopID);

		// увеличиваем количество со на 1
		$tmp = intval($this->__getMemcache($keyTable)) + 1;
		$this->__setMemcache($keyTable, $tmp, 0);

		$this->__setMemcache($keyTable.'_#'.$tmp, $key, self::SAVE_KEY_SECONDS);
	}

    /**
     * Добавление магазина в список таблицы
     * @param $shopID
     * @param $tableName
     * @return bool
     */
    private function _addShopInListTable($shopID, $tableName){
        // собираем список ключей таблицы
        $keyTable = $this->_getKeyShopTableInList($shopID, $tableName);
        if(intval($this->__getMemcache($keyTable)) > 0){
            return FALSE;
        }

        // собираем список магазинов таблицы
        $keyTable = $this->_getKeyTableInList($tableName);

        // увеличиваем количество со на 1
        $tmp = intval($this->__getMemcache($keyTable)) + 1;
        $this->__setMemcache($keyTable, $tmp, 0);

        $this->__setMemcache($keyTable.'_#'.$tmp, $shopID, self::SAVE_KEY_SECONDS);
    }

	/**
	 * Считываем данные с мемкеша
	 * @param string $key
	 */
	private function _getCache($key, $link = ''){
		$result = $this->__getMemcache($key, $link);
		return $this->_unserializeData($result);
	}

	/**
	 * Записываем данные в мемкеш
	 * @param string $key
	 */
	private function _setCache($key, $data, $lifetime = self::SAVE_DATA_SECONDS, $link = '')
    {
        $this->__setMemcache($key, $this->_serializeData($data), $lifetime, $link);
    }

	/** получаем данные из кэша
	 * $tableName - название таблицы
	 * $id - id записи
	 * $languageID - id языка
	 * @var возврошаем вид товара
	 */
	public function getShopObject($shopID, $tableName, $id, $dataLanguageID, $link = ''){
		//получаем название ключа
		$key = $this->_getKeyShopObject($shopID, $tableName, $id, $dataLanguageID);
		return $this->_getCache($key, $link);
	}

	/** задание данные в кэш
	 * $tableName - название таблицы
	 * $id - id записи
	 * $languageID - id языка
	 * @var возврошаем вид товара
	 */
	public function setShopObject($data, $shopID, $tableName, $id, $dataLanguageID, $link = ''){
		//получаем название ключа
		$key = $this->_getKeyShopObject($shopID, $tableName, $id, $dataLanguageID);
		$this->_setCache($key, $data, $link);

		// добавляем в список объектов
		$this->_addObjectInList($key, $shopID, $tableName, $id);

		return TRUE;
	}

	/**
     * считываем результаты поиска
	 * $tableName - название таблицы
	 * $select - запрос
	 * @var возвращаем массив id
	 */
    private function _getShopIDs($shopID, $tableName, $select, $dataLanguageID, $link = ''){
		$key = $this->_getKeyShopSelect($shopID, $tableName, $select, $dataLanguageID);
		return $this->_getCache($key, $link);
	}

	/**
     * считываем результаты поиска
	 * $tableName - название таблицы
	 * $select - запрос
	 * @var возвращаем массив id
	 */
    private function _setShopIDs(array $data, $shopID, $tableName, $select, $dataLanguageID, $link = ''){
		$key = $this->_getKeyShopSelect($shopID, $tableName, $select, $dataLanguageID);
		$this->_setCache($key, $data, $link);

		// добавляем в список таблицы
		$this->_addTableInList($key, $shopID, $tableName);

		return TRUE;
	}

	/**
     * считываем результаты поиска
	 * $tableName - название таблицы
	 * $select - запрос
	 * @var возвращаем массив id
	 */
    private function _getShopIDsTables($shopID, array $tableNames, $select, $dataLanguageID, $link = ''){
		$key = $this->_getKeyShopSelectTables($shopID, $tableNames, $select, $dataLanguageID);
		return $this->_getCache($key, $link);
	}

	/**
     * считываем результаты поиска
	 * $tableName - название таблицы
	 * $select - запрос
	 * @var возвращаем массив id
	 */
	private function _setShopIDsTables(array $data, $shopID, array $tableNames, $select, $dataLanguageID, $link = ''){

		$key = $this->_getKeyShopSelectTables($shopID, $tableNames, $select, $dataLanguageID);
		$this->_setCache($key, $data, $link);

		// добавляем в список таблицы
		foreach ($tableNames as $value) {
			$this->_addTableInList($key, $shopID, $value);
		}

		return TRUE;
	}

    /**
     * считываем результаты поиска
     * $tableName - название таблицы
     * $select - запрос
     * @var возвращаем массив id
     */
    public function getShopIDs($shopID, $tableName, $select, $dataLanguageID, $link = ''){
        if(is_array($tableName)){
            if(count($tableName) == 1) {
                return $this->_getShopIDs($shopID, $tableName[0], $select, $dataLanguageID, $link);
            }else{
                return $this->_getShopIDsTables($shopID, $tableName, $select, $dataLanguageID, $link);
            }
        }else{
            return $this->_getShopIDs($shopID, $tableName, $select, $dataLanguageID, $link);
        }
    }

    /** считываем результаты поиска
     * $tableName - название таблицы
     * $select - запрос
     * @var возвращаем массив id
     */
    public function setShopIDs(array $data, $shopID, $tableName, $select, $dataLanguageID, $link = ''){
        if(is_array($tableName)){
            if(count($tableName) == 1) {
                return $this->_setShopIDs($data, $shopID, $tableName[0], $select, $dataLanguageID, $link);
            }else{
                return $this->_setShopIDsTables($data, $shopID, $tableName, $select, $dataLanguageID, $link);
            }
        }else{
            return $this->_setShopIDs($data, $shopID, $tableName, $select, $dataLanguageID, $link);
        }
    }

	/**
     * считываем результаты поиска
	 * $tableName - название таблицы
	 * $select - запрос
	 * @var возвращаем массив id
	 */
    private function _getShopFields($shopID, $tableName, $select, $dataLanguageID, $link = ''){
		$key = $this->_getKeyShopSelect($shopID, $tableName, $select, $dataLanguageID, FALSE);
		return $this->_getCache($key, $link);
	}

	/**
     * считываем результаты поиска
	 * $tableName - название таблицы
	 * $select - запрос
	 * @var возвращаем массив id
	 */
    private function _setShopFields(array $data, $shopID, $tableName, $select, $dataLanguageID, $link = ''){
		$key = $this->_getKeyShopSelect($shopID, $tableName, $select, $dataLanguageID, FALSE);
		$this->_setCache($key, $data, $link);

		// добавляем в список таблицы
		$this->_addTableInList($key, $shopID, $tableName);

		return TRUE;
	}

	/** считываем результаты поиска
	 * $tableName - название таблицы
	 * $select - запрос
	 * @var возвращаем массив id
	 */
    private function _getShopFieldsTables($shopID, array $tableNames, $select, $dataLanguageID, $link = ''){
		$key = $this->_getKeyShopSelectTables($shopID, $tableNames, $select, $dataLanguageID, FALSE);
		return $this->_getCache($key, $link);
	}

	/** считываем результаты поиска
	 * $tableName - название таблицы
	 * $select - запрос
	 * @var возвращаем массив id
	 */
	private function _setShopFieldsTables(array $data, $shopID, array $tableNames, $select, $dataLanguageID, $link = ''){
		$shopID = intval($shopID);
		if (($shopID < 0) || (count($tableNames) < 1)){
			return FALSE;
		}

		$key = $this->_getKeyShopSelectTables($shopID, $tableNames, $select, $dataLanguageID, FALSE);
		$this->_setCache($key, $data, $link);

		// добавляем в список таблицы
		foreach ($tableNames as $value) {
			$this->_addTableInList($key, $shopID, $value);
		}

		return TRUE;
	}

    /**
     * считываем результаты поиска
     * $tableName - название таблицы
     * $select - запрос
     * @var возвращаем массив id
     */
    public function getShopFields($shopID, $tableName, $select, $dataLanguageID, $link = ''){
        if(is_array($tableName)){
            if(count($tableName) == 1){
                return $this->_getShopFields($shopID, $tableName[0], $select, $dataLanguageID, $link);
            }else {
                return $this->_getShopFieldsTables($shopID, $tableName, $select, $dataLanguageID, $link);
            }
        }else{
            return $this->_getShopFields($shopID, $tableName, $select, $dataLanguageID, $link);
        }
    }

    /** считываем результаты поиска
     * $tableName - название таблицы
     * $select - запрос
     * @var возвращаем массив id
     */
    public function setShopFields(array $data, $shopID, $tableName, $select, $dataLanguageID, $link = ''){
        if(is_array($tableName)){
			if(count($tableName) == 1){
				return $this->_setShopFields($data, $shopID, $tableName[0], $select, $dataLanguageID, $link);
			}else {
				return $this->_setShopFieldsTables($data, $shopID, $tableName, $select, $dataLanguageID, $link);
			}
        }else{
            return $this->_setShopFields($data, $shopID, $tableName, $select, $dataLanguageID, $link);
        }
    }

    /**
     * считываем результаты поиска
     * $tableName - название таблицы
     * $select - запрос
     * @var возвращаем массив id
     */
    public function getShopSelect($shopID, $tableName, $select, $dataLanguageID, $isIDResult = TRUE, $link = ''){
        if($isIDResult === TRUE){
            return $this->getShopIDs($shopID, $tableName, $select, $dataLanguageID, $link);
        }else{
            return $this->getShopFields($shopID, $tableName, $select, $dataLanguageID, $link);
        }
    }

    /** считываем результаты поиска
     * $tableName - название таблицы
     * $select - запрос
     * @var возвращаем массив id
     */
    public function setShopSelect(array $data, $shopID, $tableName, $select, $dataLanguageID, $isIDResult = TRUE, $link = ''){
        if($isIDResult === TRUE){
            return $this->setShopIDs($data, $shopID, $tableName, $select, $dataLanguageID, $link);
        }else{
            return $this->setShopFields($data, $shopID, $tableName, $select, $dataLanguageID, $link);
        }
    }

    /** получаем данные из кэша
     *  $tableName - название таблицы
     * $id - id записи
     * $idShablon id шаблнома магазина
     * $view - вид отоброжения товара
     * @var возврошаем вид товара
     */
    public function getShopView($shopID, $shablonName, $languageID, $view, $tableName, $id, $dataLanguageID,
                                 $currencyID, $datas = '', $link = ''){
        //получаем название ключа
        $key = $this->_getKeyShopView($shopID, $shablonName, $languageID, $view, $tableName, $id, $dataLanguageID,
            $currencyID, $datas);
        return $this->_getCache($key, $link);
    }

    /**
     * получаем данные из кэша
     *  $tableName - название таблицы
     * $id - id записи
     * $idShablon id шаблнома магазина
     * $view - вид отоброжения товара
     * @var возврашаем вид товара
     */
    public function setShopView($data, $shopID, $shablonName, $languageID, $view, $tableName, $id, $dataLanguageID,
                                 $currencyID, $datas = '', $link = ''){
        //получаем название ключа
        $key = $this->_getKeyShopView($shopID, $shablonName, $languageID, $view, $tableName, $id, $dataLanguageID,
            $currencyID, $datas);
        $this->_setCache($key, $data, $link);

        // добавляем в список объектов
        $this->_addObjectInList($key, $shopID, $tableName, $id);

        return TRUE;
    }

    /**
     * считываем результат в виде строки для массива id
     * @param string $tableName - название таблицы
     * @param array $ids
     * $shablonName название шаблона
     * $view - вид отоброжения товара
     * $languageID - ID языка
     * @return string
     */
    public function getShopViews($shopID, $shablonName, $languageID, $views, $tableName, array $ids, $dataLanguageID,
                                 $currencyID, $datas = '', $link = ''){
        $key = $this->_getKeyShopViews($shopID, $shablonName, $languageID, $views, $tableName, $ids, $dataLanguageID,
            $currencyID, $datas);
        return $this->_getCache($key, $link);
    }

    /**
     * считываем результат в виде строки для массива id
     * @param string $tableName - название таблицы
     * @param array $ids
     * $shablonName название шаблона
     * $view - вид отоброжения товара
     * $languageID - ID языка
     * @return string
     */
    public function setShopViews($data, $shopID, $shablonName, $languageID, $views, $tableName, array $ids, $dataLanguageID,
                                 $currencyID, $datas = '', $link = ''){
        $key = $this->_getKeyShopViews($shopID, $shablonName, $languageID, $views, $tableName, $ids, $dataLanguageID,
            $currencyID, $datas);
        $this->_setCache($key, $data, $link);

        // добавляем в список объектов
        foreach ($ids as $id) {
            $this->_addObjectInList($key, $shopID, $tableName, $id);

            return TRUE;
        }
    }

    /** считываем результаты поиска
     * $tableName - название таблицы
     * $select - запрос
     * @var возвращаем массив id
     */
    public function getShopFunctionView($shopID, $shablonName, $languageID, $functionName, $views, array $tableNames,
                                        $dataLanguageID, $currencyID, $datas = '', $link = ''){
        $key = $this->_getKeyShopFunctionView($shopID, $shablonName, $languageID, $functionName, $views, $tableNames,
            $dataLanguageID, $currencyID, $datas);
        return $this->_getCache($key, $link);
    }

	/** считываем результаты поиска
	 * $tableName - название таблицы
	 * $select - запрос
	 * @var возвращаем массив id
	 */
	public function setShopFunctionView($data, $shopID, $shablonName, $languageID, $functionName, $views, array $tableNames,
                                        $dataLanguageID, $currencyID, $datas = '', $link = ''){
		$key = $this->_getKeyShopFunctionView($shopID, $shablonName, $languageID, $functionName, $views, $tableNames,
            $dataLanguageID, $currencyID, $datas);

		$this->_setCache($key, $data, $link);

		// добавляем в список таблицы
		foreach ($tableNames as $tableName) {
			$this->_addTableInList($key, $shopID, $tableName);
		}

		return TRUE;
	}

    /** считываем результаты поиска
     * $tableName - название таблицы
     * $select - запрос
     * @var возвращаем массив id
     */
    public function getShopMain($shopID, $shablonName, $languageID, $url, $datas = '', $link = ''){
        $key = $this->_getKeyShopMain($shopID, $shablonName, $languageID, $url, $datas);
        return $this->_getCache($key, $link);
    }

    /** считываем результаты поиска
     * $tableName - название таблицы
     * $select - запрос
     * @var возвращаем массив id
     */
    public function setShopMain($data, $shopID, $shablonName, $languageID, $url, $datas = '', $link = ''){
        $key = $this->_getKeyShopMain($shopID, $shablonName, $languageID, $url, $datas );
        $this->_setCache($key, $data, $link);

        // добавляем в список магазина
        $this->_addShopInList($key, $shopID);

        return TRUE;
    }

    /** считываем результаты поиска
     * $tableName - название таблицы
     * $select - запрос
     * @var возвращаем массив id
     */
    public function getShopPage($shopID, $shablonName, $languageID, $url, $datas = '', $link = ''){
        $key = $this->_getKeyShopPage($shopID, $shablonName, $languageID, $url, $datas);
        return $this->_getCache($key, $link);
    }

    /** считываем результаты поиска
     * $tableName - название таблицы
     * $select - запрос
     * @var возвращаем массив id
     */
    public function setShopPage($data, $shopID, $shablonName, $languageID, $url, $datas = '', $link = ''){
        $key = $this->_getKeyShopPage($shopID, $shablonName, $languageID, $url, $datas );
        $this->_setCache($key, $data, $link);

        // добавляем в список магазина
        $this->_addShopInList($key, $shopID);

        return TRUE;
    }

    /**
     * считываем результаты поиска
     * $tableName - название таблицы
     * $select - запрос
     * @var возвращаем массив id
     */
    public function getShopData($shopID, $key, $link = ''){
        $key = $this->_getKeyShopData($shopID, $key);
        return $this->_getCache($key, $link);
    }

	/**
     * считываем результаты поиска
	 * $tableName - название таблицы
	 * $select - запрос
	 * @var возвращаем массив id
	 */
	public function setShopData($data, $shopID, $key, $lifetime, $link = ''){
		$key = $this->_getKeyShopData($shopID, $key);

		$this->_setCache($key, $data, $lifetime, $link);

        // добавляем в список магазина
        $this->_addShopInList($key, $shopID);

		return TRUE;
	}

	/** удаляем данные
	 * $tableName - название таблицы
	 * $id - id записи
	 */
	public function editObjects($shopID, $tableName, array $ids){
		foreach ($ids as $id) {
			$this->editObject($shopID, $tableName, $id);
		}
	}

	/** удаляем данные
	 * $tableName - название таблицы
	 * $id - id записи
	 */
	public function editObject($shopID, $tableName, $id){
		// удаляем все данные связанные с объектом
		$key = $this->_getKeyShopObjectInList($shopID, $tableName, $id);

		$count = intval($this->__getMemcache($key)) + 1;
        $shift = intval($this->__getMemcache($key.'#shift'));
		for ($i = $shift; $i < $count; $i++) {
			$s = $key.'_#'.$i;

			$tmp = $this->__getMemcache($s);
			if ($tmp !== NULL){
				$this->__delMemcache($tmp);
			}
			$this->__delMemcache($s);
		}
        $this->__setMemcache($key.'#shift', $count - 2, 0) * 1;

        // Удаляем данные таблицы магазина
        $this->clearMemcachedShopTable($shopID, $tableName);
	}

    /**
     * Удаляем данные таблицы магазина
     * @param $shopID
     * @param $tableName
     */
    public function clearMemcachedShopTable($shopID, $tableName){
        // удаляем все данные связанные с таблицой
        $key = $this->_getKeyShopTableInList($shopID, $tableName);

        $count = intval($this->__getMemcache($key)) + 1;
        $shift = intval($this->__getMemcache($key.'#shift'));
        for ($i = $shift; $i < $count; $i++) {
            $s = $key.'_#'.$i;

            $tmp = $this->__getMemcache($s);
            if ($tmp !== NULL){
                $this->__delMemcache($tmp);
            }
            $this->__delMemcache($s);
        }
        $this->__setMemcache($key.'#shift', $count - 2, 0) * 1;

        /*
        // если таблица без магазина, тогда удаляем
        // все данные во всех магазинах связанные с ней
        if($shopID < 1){
            $this->clearMemcachedTable($tableName);
        }*/
    }

    /**
     * Удаляем данные магазина
     * @param $shopID
     * @param $tableName
     * @param $id
     */
    public function clearMemcachedShop($shopID){
        // удаляем все данные связанные с объектом
        $key = $this->_getKeyShopInList($shopID);

        $count = intval($this->__getMemcache($key)) + 1;
        $shift = intval($this->__getMemcache($key.'#shift'));
        for ($i = $shift; $i < $count; $i++) {
            $s = $key.'_#'.$i;

            $tmp = $this->__getMemcache($s);
            if ($tmp !== NULL){
                $this->__delMemcache($tmp);
            }
            $this->__delMemcache($s);
        }
        intval($this->__setMemcache($key.'#shift', $count - 2, 0));
    }


    /**
     * Удаляем данные таблицы
     * @param $tableName
     */
    public function clearMemcachedTable($tableName){
        // удаляем все данные связанные с объектом
        $key = $this->_getKeyTableInList($tableName);

        $count = intval($this->__getMemcache($key)) + 1;
        $shift = intval($this->__getMemcache($key.'#shift'));
        for ($i = $shift; $i < $count; $i++) {
            $s = $key.'_#'.$i;

			$tmp = $this->__getMemcache($s);
			if ($tmp !== NULL){
				$this->__delMemcache($tmp);
			}
			$this->__delMemcache($s);
        }
        $this->__setMemcache($key.'#shift', $count - 2, 0) * 1;
    }
}

<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_DB {
    /**
     * Клонируем все языки записи
     * @param Model_Basic_LanguageObject $model
     * @param $id
     * @param SitePageData $sitePageData
     * @param int $shopID
     * @param bool $isIDZeroIgnore
     * @return bool
     */
    public static function cloneObjectLanguages(Model_Basic_LanguageObject $model, $id, SitePageData $sitePageData,
                                                   $shopID = -1)
    {
        if (!self::getDBObject($model, $id, $sitePageData, $shopID)) {
            return 0;
        }

        $model->id = 0;
        $model->globalID = 0;
        $newID = self::saveDBObject($model, $sitePageData, $shopID);

        foreach ($model->getIsTranslatesArray() as $languageID => $isB){
            if($languageID == $sitePageData->dataLanguageID){
                continue;
            }

            if (Helpers_DB::getDBObject($model, $id, $sitePageData, $shopID, $languageID)) {
                $model->id = $newID;
                $model->globalID = 0;

                $model->dbSave($languageID, $sitePageData->userID, $shopID);
            }
        }

        return $newID;
    }

    /**
     * @param Model_Basic_LanguageObject $model
     * @param $id
     * @param SitePageData $sitePageData
     * @param int $shopID
     * @param bool $isIDZeroIgnore
     * @return bool|Model_Basic_DBObject
     */
    public static function dublicateObjectLanguage(Model_Basic_LanguageObject $model, $id, SitePageData $sitePageData,
                                                   $shopID = -1, $isIDZeroIgnore = TRUE)
    {
        $result = TRUE;

        $id = intval($id);
        if(($id > 0) || (!$isIDZeroIgnore)) {
            $result = self::getDBObject($model, $id, $sitePageData, $shopID, -1);
            if(!$result){
                $result = self::getDBObject($model, $id, $sitePageData, $shopID, 0);
            }

            if($result) {
                if ($model->languageID != $sitePageData->dataLanguageID) {
                    $model->languageID = $sitePageData->dataLanguageID;
                    $model->globalID = 0;
                }
            }
        }else{
            $model->clear();
            $model->id = 0;
        }

        return $result;
    }

    /**
     * Получаем данные из ID нужно языка
     * @param Model_Basic_DBObject $model
     * @param $id
     * @param SitePageData $sitePageData
     * @param int $shopID
     * @param int $dataLanguageID
     * @return bool|Model_Basic_DBObject
     */
    public static function getDBObject(Model_Basic_DBObject $model, $id, SitePageData $sitePageData, $shopID = -1,
                                       $dataLanguageID = -1){
        if($shopID === -1){
            $shopID = $sitePageData->shopID;
        }
		if($dataLanguageID == -1){
			$dataLanguageID = $sitePageData->dataLanguageID;
		}

		if ($id < 1){
           $model->clear();
		   return FALSE;
        }

        return $model->dbGet($id, $dataLanguageID, $sitePageData->languageIDDefault, $shopID);
    }

    /**
     * Получаем данные из ID нужно языка возвращаем значение переменной
     * @param string$field
     * @param Model_Basic_DBObject $model
     * @param int $id
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     * @param int $dataLanguageID
     * @param string $default
     * @return string
     */
    public static function getDBObjectValue($field, Model_Basic_DBObject $model, $id, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver, $shopID = -1, $dataLanguageID = -1,
                                            $default = ''){
        $model->setDBDriver($driver);
        if(!self::getDBObject($model, $id, $sitePageData, $shopID, $dataLanguageID)){
            return $default;
        }

        return $model->getValue($field, $default);
    }

    /**
     * Сохрание данные из ID нужно языка
     * @param Model_Basic_DBGlobalObject $model
     * @param SitePageData $sitePageData
     * @param int $shopID
     * @return int
     */
    public static function saveDBObject(Model_Basic_DBGlobalObject $model, SitePageData $sitePageData, $shopID = -1){
        if($shopID === -1){
            $shopID = $sitePageData->shopID;
        }
        return $model->dbSave($sitePageData->dataLanguageID, $sitePageData->userID, $shopID);
    }

    /**
     * Удалить запись по ID
     * @param $dbObject
     * @param $id
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     */
    public static function delDBByID($dbObject, $id, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                     $shopID = -1){
        if($shopID === -1){
            $shopID = $sitePageData->shopID;
        }

        $model = DB_Basic::createModel($dbObject, $driver);
        $model->id = $id;
        return $model->dbDelete($sitePageData->userID, 0, $shopID);
    }

    /**
     * Преобразование значение
     * @param $value
     * @param string $prefix
     * @return string
     */
    public static function htmlspecialchars($value, $prefix = ''){
        if($value === NULL) {
            return 'NULL';
        }else{
            if(empty($prefix)){
                $s = "'";
            }else{
                $s = $prefix;
            }

            if((strpos($value, $s)  === FALSE) && (strpos($value, "'")  === FALSE)){
                return $prefix . $value . $prefix;
            }else {
                return $prefix . pg_escape_string($value) . $prefix;
            }
        }
    }

    /**
     * Преобразование значение со спецификой Postgres
     * @param $value
     * @param string $prefix
     * @return string
     */
    public static function htmlspecialcharsValuePg($value, $prefix = ''){
        if($value === NULL) {
            return 'NULL';
        }else{
            if(empty($prefix)){
                $s = "'";
            }else{
                $s = $prefix;
            }

            if((strpos($value, "'")  !== FALSE)){
                $value = str_replace("'", '&apos;', $value);
            }

            if(strpos($value, $s)  === FALSE){
                return $prefix . $value . $prefix;
            }else{
                return $prefix . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . $prefix;
            }
        }
    }

    /**
     * Декодирование значение
     * @param $value
     * @return string
     */
    public static function htmlspecialchars_decode($value){
        if($value === NULL) {
            return $value;
        }else{
            // return htmlspecialchars_decode(str_replace('&apos;', "'", $value), ENT_QUOTES);
            return str_replace('&apos;', "'", $value);
        }
    }

	/**
	 * Сбор параметров из URL и массива параметров, в одну строку
	 * @param array $urlParams
	 * @param array $params
	 * @return string
	 */
	public static function getURLParamDatas(array $urlParams, array $params = array())
	{
        $urlParams[] = 'system';
        $urlParams[] = 'addition_data';
		$urlParams[] = 'shop_branch_id';

		$result = '';
		foreach ($urlParams as $value) {
			$tmp = Request_RequestParams::getParamStr($value);
			if($tmp === NULL){
				if(key_exists($value, $params)){
					$tmp = $params[$value];
					if(is_array($tmp)){
						$tmp = Json::json_encode($tmp);
					}
				}
			}

			$result = $result . $value . ':';
			if ($tmp !== NULL) {
				$result = $result . $tmp . ',';
			} else {
				$result = $result . '' . ',';
			}
		}

		foreach ($params as $value) {
			if((is_array($value)) && (key_exists('field', $value))){
				$value = $value['field'];

				$tmp = Request_RequestParams::getParamStr($value);
				$result = $result . $value . ':';
				if ($tmp !== NULL) {
					$result = $result . $tmp . ',';
				} else {
					$result = $result . '' . ',';
				}
			}
		}

		return $result;
	}

    /**
     * Получить HTML кусочка страницы
     * @param $shopID
     * @param $functionName
     * @param $tableName
     * @param $viewObjects
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param string $datas
     * @return mixed
     */
	public static function getMemcacheFunctionView($shopID, $functionName, $tableName, $viewObjects,
			SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $datas = '')
    {
        if (!is_array($tableName)) {
            $tableName = array($tableName);
        }

        if (is_array($viewObjects)) {
            $viewObjects = Json::json_encode($viewObjects);
        }

        return $driver->getMemcache()->getShopFunctionView(
            $shopID,
            $sitePageData->shopShablonPath,
            $sitePageData->languageID,
            $functionName,
            $viewObjects,
            $tableName,
            $sitePageData->dataLanguageID,
            $sitePageData->currencyID,
            $datas);
    }

    /**
     * Запоминаем HTML кусочка страницы
     * @param $data
     * @param $shopID
     * @param $functionName
     * @param $tableName
     * @param $viewObjects
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param string $datas
     */
	public static function setMemcacheFunctionView($data, $shopID, $functionName, $tableName, $viewObjects,
                                                   SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $datas = ''){
		if (!is_array($tableName)){
			$tableName = array($tableName);
		}
		
		if (is_array($viewObjects)){
			$viewObjects = Json::json_encode($viewObjects);
		}
	
		$driver->getMemcache()->setShopFunctionView(
            $data,
            $shopID,
            $sitePageData->shopShablonPath,
            $sitePageData->languageID,
            $functionName,
            $viewObjects,
            $tableName,
            $sitePageData->dataLanguageID,
            $sitePageData->currencyID,
            $datas);
	}

    /**
     * Массовое изменение пути в name_url
     * @param $old
     * @param $new
     * @param Model_Driver_DBBasicDriver $driver
     * @param $shopID
     * @param $languageID
     * @return bool
     */
    public static function replaceSubNameURL($old, $new, Model_Driver_DBBasicDriver $driver, $shopID, $languageID)
    {
        if (empty($old)){
            return FALSE;
        }

        $new = $new . '/';
        $old = $old . '/';
        $driver->replaceSubNameURL(Model_Shop_Good::TABLE_NAME, $old, $new, $shopID, $languageID);
        $driver->replaceSubNameURL(Model_Shop_Table_Rubric::TABLE_NAME, $old, $new, $shopID, $languageID);
        $driver->replaceSubNameURL(Model_Shop_Mark::TABLE_NAME, $old, $new, $shopID, $languageID);
        //$driver->replaceSubNameURL(Model_Shop_New::TABLE_NAME, $old, $new, $shopID, $languageID);

        return TRUE;
    }
}
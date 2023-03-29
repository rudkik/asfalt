<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_View {
    const VIEW_TYPE_JSON = 1;

    /**
     * Получаем список заполненых шаблонов сайта для массива объектов.
     * @param MyArray $ObjectIDs
     * @param Model_Basic_LanguageObject $model
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     * @param bool $isLoadMemcache
     * @param null $elements
     * @param bool $isLoadOneView
     * @return string
     */
    public static function getViewObjects(MyArray $ObjectIDs,
                                          Model_Basic_LanguageObject $model, $viewObjects, $viewObject,
                                          SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          $shopID = -1, $isLoadMemcache = TRUE, $elements = NULL, $isLoadOneView = FALSE)
    {
        if($isLoadOneView){
            return self::getViewObjectsOneView($ObjectIDs,  $model, $viewObjects, $viewObject, $sitePageData, $driver,
                                          $shopID, $isLoadMemcache, $elements);
        }else{
            return self::getViewObjectsListView($ObjectIDs,  $model, $viewObjects, $viewObject, $sitePageData, $driver,
                $shopID, $isLoadMemcache, $elements);
        }
    }

    /**
     * Получаем список заполненых шаблонов сайта для массива объектов.
     * @param MyArray $ObjectIDs
     * @param Model_Basic_LanguageObject $model
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     * @param bool $isLoadMemcache
     * @param null $elements
     * @return string
     * @throws Exception
     */
    public static function getViewObjectsListView(MyArray $ObjectIDs,
			Model_Basic_LanguageObject $model, $viewObjects, $viewObject, 
			SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
			$shopID = -1, $isLoadMemcache = TRUE, $elements = NULL)
	{
		$shablonName = $sitePageData->shopShablonPath;
	
		if ($shopID == -1){
			$shopID = $sitePageData->shopID;
		}elseif(is_array($shopID)){
			$shopID = Json::json_encode($shopID);
		}

		$prefix = md5(Json::json_encode($ObjectIDs->getAdditionDataChilds()).Json::json_encode($elements));

        $ids = array();
		if ($isLoadMemcache === TRUE) {
			$ObjectIDs->getArrayID($ids);
			$strView = $driver->getMemcache()->getShopViews(
				$shopID,
				$shablonName,
				$sitePageData->languageID,
                $viewObjects,
				$model->tableName,
				$ids,
                $sitePageData->dataLanguageID,
				$sitePageData->currencyID,
				$prefix);

			if ($strView !== NULL) {
				return $strView;
			}
		}

		// получаем данные во всех вложенных элементах (если это дерево)
        //Путь для вью шаблона
        $tmp = $sitePageData->languageID.'/'.$viewObject;
        if($shablonName !== ''){
            $tmp = $shablonName.'/'.$tmp;
        }
        $tmp = str_replace('\\', '/', $tmp);

        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

		$i = 0;
		foreach ($ObjectIDs->childs as $value){
			$value->additionDatas["#index"] = $i;
			$i++;
			if ($value->str === NULL){
				$value->str = self::_getViewObject($view, $value, $model, $viewObject,
						$sitePageData, $driver, $shopID, $isLoadMemcache, $elements);
			}
		}

		//Путь для вью шаблона
		$tmp = $sitePageData->languageID.'/'.$viewObjects;

		if($shablonName != ""){
			$tmp=$shablonName."/".$tmp;
		}
		$tmp = str_replace('\\', '/', $tmp);
		try {
			$view = View::factory($tmp);
		}catch (Exception $e) {
			throw new Exception('Шаблон "'.$tmp.'" не найден.');
		}
		$view->data = array('view::'.$viewObject => $ObjectIDs);
        $view->additionDatas = $ObjectIDs->additionDatas;
		$view->siteData = $sitePageData;
	
		$strView = self::viewToStr($view);

		if ($isLoadMemcache === TRUE) {
			$driver->getMemcache()->setShopViews(
				$strView,
                $shopID,
                $shablonName,
                $sitePageData->languageID,
                $viewObjects,
                $model->tableName,
                $ids,
                $sitePageData->dataLanguageID,
                $sitePageData->currencyID,
                $prefix);
		}

		return $strView;
	}

    /**
     * Получаем список заполненых шаблонов сайта для 1-го объекта
     * @param $view
     * @param MyArray $data
     * @param Model_Basic_LanguageObject $model
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     * @param bool $isLoadMemcache
     * @param null $elements
     * @return string
     */
	private static function _getViewObject($view, MyArray $data, Model_Basic_LanguageObject $model,
										 $viewObject, SitePageData $sitePageData,
										 Model_Driver_DBBasicDriver $driver, $shopID = -1, $isLoadMemcache = TRUE, $elements = NULL)
	{
		if (($data->isFindDB === FALSE) && ($data->id < 1)) {
			return '';
		}

		$prefix = md5(Json::json_encode($data->getAdditionDataChilds()).Json::json_encode($elements));
		if(count($data->childs) > 0) {
			$ids = array();
			$data->getArrayID($ids);
			$prefix .= Json::json_encode($ids);
		}

		if ($shopID == -1){
			$shopID = $sitePageData->shopID;
		}

		$shablonName = $sitePageData->shopShablonPath;

		if ($isLoadMemcache === TRUE) {
			$strView = $driver->getMemcache()->getShopView(
				$shopID,
				$shablonName,
				$sitePageData->languageID,
				$viewObject,
				$model->tableName,
				$data->id,
				$sitePageData->dataLanguageID,
				$sitePageData->currencyID,
				$prefix);

			if ($strView !== NULL) {
				return $strView;
			}
		}

		if (! self::getDBDataIfNotFind($data, $model, $sitePageData, $shopID, $elements)){
			return '';
		}

		$view->data = $data;
		$view->siteData = $sitePageData;
		$strView = self::viewToStr($view);

		if ($isLoadMemcache === TRUE) {
			$driver->getMemcache()->setShopView(
				$strView,
				$shopID,
				$shablonName,
				$sitePageData->languageID,
				$viewObject,
				$model->tableName,
				$data->id,
				$sitePageData->dataLanguageID,
				$sitePageData->currencyID,
				$prefix);
		}

		return $strView;
	}

    /**
     * Получаем список заполненых шаблонов сайта для 1-го объекта
     * @param MyArray $data
     * @param Model_Basic_LanguageObject $model
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     * @param bool $isLoadMemcache
     * @param null $elements
     * @return string
     * @throws Exception
     */
	public static function getViewObject(MyArray $data, Model_Basic_LanguageObject $model, 
			$viewObject, SitePageData $sitePageData,
			Model_Driver_DBBasicDriver $driver, $shopID = -1, $isLoadMemcache = TRUE, $elements = NULL)
	{
        //Путь для вью шаблона
	    $tmp = self::getViewPath($viewObject, $sitePageData);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        return self::_getViewObject($view, $data, $model, $viewObject, $sitePageData,
										 $driver, $shopID, $isLoadMemcache, $elements);
	}

    /**
     * Получаем список заполненых шаблонов сайта для 1-го объекта
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param MyArray|null $data
     * @param bool $isAddReplaceGlobal
     * @param bool $isLoadMemcache
     * @return string
     * @throws Exception
     */
    public static function getView($viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                   $data = null, $isAddReplaceGlobal = true, $isLoadMemcache = TRUE)
    {
        //Путь для вью шаблона
        $tmp = self::getViewPath($viewObject, $sitePageData);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $shablonName = $sitePageData->shopShablonPath;

        if ($isLoadMemcache === TRUE) {
            $strView = $driver->getMemcache()->getShopView(
                0,
                $shablonName,
                $sitePageData->languageID,
                $viewObject,
                '',
                0,
                $sitePageData->dataLanguageID,
                $sitePageData->currencyID
            );

            if ($strView !== NULL) {
                return $strView;
            }
        }

        $view->data = $data;
        $view->siteData = $sitePageData;
        $strView = self::viewToStr($view);

        if ($isLoadMemcache === TRUE) {
            $driver->getMemcache()->setShopView(
                $strView,
                0,
                $shablonName,
                $sitePageData->languageID,
                $viewObject,
                '',
                0,
                $sitePageData->dataLanguageID,
                $sitePageData->currencyID
            );
        }

        if($isAddReplaceGlobal){
            $sitePageData->addReplaceAndGlobalDatas('view::' . $viewObject, $strView);
        }

        return $strView;
    }

    /**
     * Получаем список заполненых шаблонов сайта для массива объектов.
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param null | MyArray $data
     * @param bool $isAddReplaceGlobal
     * @param bool $isLoadMemcache
     * @return mixed|null|string
     * @throws Exception
     */
    public static function getViews($viewObjects, $viewObject, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                    MyArray $data = null, $isAddReplaceGlobal = true, $isLoadMemcache = TRUE)
    {
        $shablonName = $sitePageData->shopShablonPath;
        if ($isLoadMemcache === TRUE) {
            $strView = $driver->getMemcache()->getShopView(
                0,
                $shablonName,
                $sitePageData->languageID,
                $viewObjects,
                '',
                0,
                $sitePageData->dataLanguageID,
                $sitePageData->currencyID
            );

            if ($strView !== NULL) {
                return $strView;
            }
        }

        if(empty($data)){
            $data = new MyArray();
        }

        foreach ($data->childs as $child){
            $child->str = self::getView($viewObject, $sitePageData, $driver, $child, false, $isLoadMemcache);
        }

        //Путь для вью шаблона
        $tmp = $sitePageData->languageID.'/'.$viewObjects;

        if($shablonName != ""){
            $tmp = $shablonName."/".$tmp;
        }
        $tmp = str_replace('\\', '/', $tmp);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }

        $view->data = array('view::'.$viewObject => $data);
        $view->additionDatas = $data->additionDatas;
        $view->siteData = $sitePageData;

        $strView = self::viewToStr($view);

        if ($isLoadMemcache === TRUE) {
            $driver->getMemcache()->setShopView(
                $strView,
                0,
                $shablonName,
                $sitePageData->languageID,
                $viewObject,
                '',
                0,
                $sitePageData->dataLanguageID,
                $sitePageData->currencyID
            );
        }

        if($isAddReplaceGlobal){
            $sitePageData->addReplaceAndGlobalDatas('view::' . $viewObjects, $strView);
        }

        return $strView;
    }

	/**
	 * Получаем данные из ID нужно языка
	 * @param MyArray $data
	 * @param Model_Basic_DBObject $model
	 * @param SitePageData $sitePageData
	 * @param int $shopID
	 * @param null $elements
	 * @return bool
	 */
	public static function getDBData(MyArray $data, Model_Basic_DBObject $model, SitePageData $sitePageData, $shopID = -1, $elements = NULL){
		if ($data->id < 1){
            $data->isFindDB = FALSE;
			return FALSE;
		}
	
		if($shopID == -1){
			$shopID = $sitePageData->shopID;
		}

		$model->clear();
        if (! Helpers_DB::getDBObject($model, $data->id, $sitePageData, $shopID)){
            $data->isFindDB = FALSE;
            return FALSE;
        }
        $model->dbGetElements($sitePageData->shopMainID, $elements, $sitePageData->languageIDDefault);

		$data->isFindDB = TRUE;
		$data->values = $model->getValues(TRUE, TRUE, $sitePageData->shopID);
        $data->isParseData = FALSE;

		foreach ($data->childs as $value){
			if (! self::getDBData($value, $model, $sitePageData, $shopID)){
                return FALSE;
            }
		}
	
		return $data->isFindDB;
	}

    /**
     * Запрос в базу данных, если запись не считана
     * @param MyArray $data
     * @param Model_Basic_DBObject $model
     * @param SitePageData $sitePageData
     * @param int $shopID
     * @param null $elements
     * @return bool
     */
	public static function getDBDataIfNotFind(MyArray $data, Model_Basic_DBObject $model, SitePageData $sitePageData,
                                              $shopID = -1, $elements = NULL){
		if (!$data->isFindDB) {
			return self::getDBData($data, $model, $sitePageData, $shopID, $elements);
		}else {
			if ((!Model_Memcache_ShopMemcacheDriver::IS_SAVE_MEMCACHE) && ($data->isParseData)) {
                $model->clear();
                $model->__setArray(array('values' => $data->values));
				if($data->isLoadElements === FALSE) {
				    if (is_array($elements)) {
                        $elementsNew = array();
                        foreach ($elements as $key => $value) {
                            if (is_array($value)) {
                                $elementsNew[] = $key;
                            } else {
                                $elementsNew[] = $value;
                            }
                        }
                        $elements = $elementsNew;
                    }
					$model->dbGetElements($sitePageData->shopMainID, $elements, $sitePageData->languageIDDefault);
				}
                $data->values = $model->getValues(TRUE, TRUE, $sitePageData->shopID);
                $data->isParseData = FALSE;
			}
		}

		return TRUE;
	}


    /**
     * Получаем список заполненных шаблонов сайта для массива объектов, используя только один файл
     * Список и детвора обрабатываться  будут в одном файле
     * @param MyArray $ObjectIDs
     * @param Model_Basic_LanguageObject $model
     * @param $viewObjects
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     * @param bool $isLoadMemcache
     * @param null $elements
     * @return string
     * @throws Exception
     */
    public static function getViewObjectsOneView(MyArray $ObjectIDs,
                                          Model_Basic_LanguageObject $model, $viewObjects, $viewObject,
                                          SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                          $shopID = -1, $isLoadMemcache = TRUE, $elements = NULL)
    {
        $shablonName = $sitePageData->shopShablonPath;

        if ($shopID == -1){
            $shopID = $sitePageData->shopID;
        }elseif(is_array($shopID)){
            $shopID = Json::json_encode($shopID);
        }

        $prefix = 'list_'.md5(Json::json_encode($ObjectIDs->getAdditionDataChilds()).Json::json_encode($elements));

        $ids = array();
        if ($isLoadMemcache === TRUE) {
            $ObjectIDs->getArrayID($ids);
            $strView = $driver->getMemcache()->getShopViews(
                $shopID,
                $shablonName,
                $sitePageData->languageID,
                $viewObjects,
                $model->tableName,
                $ids,
                $sitePageData->dataLanguageID,
                $sitePageData->currencyID,
                $prefix);

            if ($strView !== NULL) {
                return $strView;
            }
        }

        //Путь для вью шаблона
        $tmp = $sitePageData->languageID.'/'.$viewObjects;

        if($shablonName != ""){
            $tmp=$shablonName."/".$tmp;
        }
        $tmp = str_replace('\\', '/', $tmp);
        try {
            $view = View::factory($tmp);
        }catch (Exception $e) {
            throw new Exception('Шаблон "'.$tmp.'" не найден.');
        }
        $view->data = array('view::'.$viewObject => $ObjectIDs);
        $view->additionDatas = $ObjectIDs->additionDatas;
        $view->siteData = $sitePageData;

        $strView = self::viewToStr($view);

        if ($isLoadMemcache === TRUE) {
            $driver->getMemcache()->setShopViews(
                $strView,
                $shopID,
                $shablonName,
                $sitePageData->languageID,
                $viewObjects,
                $model->tableName,
                $ids,
                $sitePageData->dataLanguageID,
                $sitePageData->currencyID,
                $prefix);
        }

        return $strView;
    }

    /**
     * Получаем список данных в заданном виде
     * @param MyArray $ObjectIDs
     * @param Model_Basic_LanguageObject $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param int $shopID
     * @param bool $isLoadMemcache
     * @param null $elements
     * @param int $typeView
     * @return string
     * @throws Exception
     */
    public static function getViewsStr(MyArray $ObjectIDs, Model_Basic_LanguageObject $model,
                                      SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                      $shopID = -1, $isLoadMemcache = TRUE, $elements = NULL, $typeView = Helpers_View::VIEW_TYPE_JSON)
    {
        $shablonName = $sitePageData->shopShablonPath;

        if ($shopID == -1){
            $shopID = $sitePageData->shopID;
        }elseif(is_array($shopID)){
            $shopID = Json::json_encode($shopID);
        }

        $prefix = 'list_'.md5(Json::json_encode($ObjectIDs->getAdditionDataChilds()).Json::json_encode($elements));

        $ids = array();
        if ($isLoadMemcache === TRUE) {
            $ObjectIDs->getArrayID($ids);
            $strView = $driver->getMemcache()->getShopViews(
                $shopID,
                $shablonName,
                $sitePageData->languageID,
                $typeView,
                $model->tableName,
                $ids,
                $sitePageData->dataLanguageID,
                $sitePageData->currencyID,
                $prefix);

            if ($strView !== NULL) {
                return $strView;
            }
        }

        $strView = array();
        foreach ($ObjectIDs->childs as $child){
            if (self::getDBDataIfNotFind($child, $model, $sitePageData, $shopID, $elements)){
                $strView[] = $child->values;
            }
        }

        switch ($typeView){
            case Helpers_View::VIEW_TYPE_JSON:
                $strView = json_encode($strView);
                break;
            default:
                $strView = json_encode($strView);
        }


        if ($isLoadMemcache === TRUE) {
            $driver->getMemcache()->setShopViews(
                $strView,
                $shopID,
                $shablonName,
                $sitePageData->languageID,
                $typeView,
                $model->tableName,
                $ids,
                $sitePageData->dataLanguageID,
                $sitePageData->currencyID,
                $prefix);
        }

        return $strView;
    }


    /**
     * Преобразуем вьюшку в строку, если ошибка, то выводим ее
     * @param View $view
     * @return string
     */
    public static function viewToStr(View $view)
    {
        try {
            return $view->render();
        } catch (Exception $e) {
            $error_response = Kohana_Exception::_handler($e);
            echo $error_response->body(); die;
        }
    }

    /**
     * Получаем путь к вьюшки
     * @param $viewObject
     * @param SitePageData $sitePageData
     * @return mixed|string
     */
    public static function getViewPath($viewObject, SitePageData $sitePageData)
    {
        //Путь для вью шаблона
        $shablonName = $sitePageData->shopShablonPath;
        $tmp = $sitePageData->languageID . '/' . $viewObject;
        if ($shablonName !== '') {
            $tmp = $shablonName . '/' . $tmp;
        }
        $tmp = str_replace('\\', '/', $tmp);

        return $tmp;
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

class View_SitePage {
	/**
	 * Выставляем заглушки для данных
	 * @param array $data
	 * @param SitePageData $sitePageData
	 */
	public static function addCap(array $data, SitePageData $sitePageData){
		foreach ($data as $value) {
			if ((key_exists('list', $value)) && (!empty($value['list']))){
				$key = $value['list'];
			}else{
				$key = $value['one'];
			}
			if (is_array($key)){
				foreach ($key as $view) {
					$sitePageData->globalDatas['view::'.$view] = '^#@view::'.$view.'@#^';
				}
			}else{
				$sitePageData->globalDatas['view::'.$key] = '^#@view::'.$key.'@#^';
			}
			
			if ((key_exists('view', $value)) && (!empty($value['view']))){
				$key = $value['view'];
				foreach ($key as $view) {					
					$sitePageData->globalDatas['view::'.$view] = '^#@view::'.$view.'@#^';
				}
			}
		}
	}

	/**
	 * Загружаем view всех необходимых элементов
	 * @param $shopID
	 * @param array $data
	 * @param SitePageData $sitePageData
	 * @param Model_Driver_DBBasicDriver $driver
	 * @throws HTTP_Exception_404
	 */
	public static function loadView($shopID, array $data, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
		foreach ($data as $value) {
            $dbObject = Arr::path($value, 'table', Arr::path($value, 'db_object', ''));

            $view = Arr::path($value, 'class', '');
            if(empty($view)){
                $view = DB_Basic::getViewName($dbObject, 'View_Shop_Table_View');
            }

			$function = $value['function'];

			$viewList = '';
			if (key_exists('list', $value)){
				$viewList = $value['list'];
			}

			$viewOne = '';
			if (key_exists('one', $value)){
				$viewOne = $value['one'];
			}

			$viewGroups = NULL;
			if (key_exists('group', $value)){
				$viewGroups = $value['group'];
			}

            $isLoadOneView = FALSE;
            if (key_exists('is_load_one', $value)){
                $isLoadOneView = $value['is_load_one'];
            }

			$params = array();
			if (key_exists('params', $value)){
				$params = $value['params'];

				if(!is_array($params)){
					$params = array();
				}
			}

			$elements = NULL;
			if (key_exists('elements', $value)){
				$elements = $value['elements'];

				if(!is_array($elements)){
					$elements = NULL;
				}
			}

			if (Request_RequestParams::getParamBoolean('is_branch', $params) === TRUE){
				$tmpShopID = Request_RequestParams::getParamInt('shop_branch_id', $params, FALSE, $sitePageData);
				if(($tmpShopID === NULL) || ($tmpShopID < 1)){
					if(Request_RequestParams::getParamBoolean('is_branch_error', $params) === FALSE) {
						$tmpShopID = $shopID;
					}
				}
				if ($tmpShopID === NULL) {
					throw new HTTP_Exception_404('Shop not found.');

				}
			}else{
				$tmpShopID = $shopID;
			}

			$class = new $view();
            if (empty($viewOne)){
                $class::$function($dbObject, $tmpShopID, $viewList,
                    $sitePageData, $driver, $params, $elements);
            }elseif ($viewGroups !== NULL) {
                $class::$function($dbObject, $tmpShopID, $viewList, $viewOne, $viewGroups,
                    $sitePageData, $driver, $params, $elements, $isLoadOneView);
            }elseif (empty($viewList)){
                $class::$function($dbObject, $tmpShopID, $viewOne,
                    $sitePageData, $driver, $params, $elements);
            }else{
                $class::$function($dbObject, $tmpShopID, $viewList, $viewOne,
                    $sitePageData, $driver, $params, $elements, $isLoadOneView);
            }
		}
	}

	/**
	 * Получаем основную страницу сайта
	 * @param $shopID
	 * @param SitePageData $sitePageData
	 * @param Model_Driver_DBBasicDriver $driver
	 * @return string
	 */
	private static function _getIndexPage($shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
		// ищем в мемкеше
        $data = $driver->getMemcache()->getShopPage($shopID,
            $sitePageData->shopShablonPath,
            $sitePageData->languageID,
            $sitePageData->url
        );
		if ($data !== NULL){
			return $data;
		}

		// генерируем не изменяемую часть
		$view = View::factory($sitePageData->shopShablonPath.'/'.$sitePageData->languageID.'/index');
		$view->data = array('view::body' => '^#@view::main_body@#^');
		$view->siteData = $sitePageData;
		$data = Helpers_View::viewToStr($view);

		// записываем в мемкеш
        $driver->getMemcache()->setShopPage($data, $shopID,
            $sitePageData->shopShablonPath,
            $sitePageData->languageID,
            $sitePageData->url
        );
		return $data;
	}

    /**
     * Получаем тело для страницы
     * @param $shopID
     * @param $mainFile
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $urlParams
     * @return string
     */
	private static function _getMainPage($shopID, $mainFile, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
			array $urlParams){
		// ищем в мемкеше
        $key = $mainFile.Helpers_DB::getURLParamDatas($urlParams);
        $data = $driver->getMemcache()->getShopMain($shopID,
            $sitePageData->shopShablonPath,
            $sitePageData->languageID,
            $sitePageData->url,
            $key
        );
		if ($data !== NULL){
			return $data;
		}

		// генерируем основную часть
		$view = View::factory($sitePageData->shopShablonPath.'/'.$sitePageData->languageID.$mainFile);
		$view->siteData = $sitePageData;
		$data = Helpers_View::viewToStr($view);

		// записываем в мемкеш
        $driver->getMemcache()->setShopMain($data, $shopID,
            $sitePageData->shopShablonPath,
            $sitePageData->languageID,
            $sitePageData->url,
            $key
        );

        return $data;
	}

    /**
     * Формируем старинцу из настроек
     * @param $shopID
     * @param $mainFile
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isWriteIndex
     * @return mixed|string
     * @throws HTTP_Exception_404
     */
	public static function loadSitePage($shopID, $mainFile, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
			$isWriteIndex = TRUE){

        $path = APPPATH.'views'.DIRECTORY_SEPARATOR.$sitePageData->shopShablonPath.DIRECTORY_SEPARATOR;

        // загружаем настройки страниц
        $pathData = $path.'data.php';
        if(file_exists($pathData)){
            $data = include $pathData;

            $sitePageData->favicon = Arr::path($data, 'favicon', '');
        }

		// загружаем настройки страниц
		$pathOptions = $path.'options.php';
		if(!file_exists($pathOptions)){
			throw new HTTP_Exception_404('File options "'.$pathOptions.'" not found.');
		}
		$siteOptions = include $pathOptions;

		if (!key_exists($sitePageData->url, $siteOptions['urls'])){
		    // пытаемся найти пути по СЕО имени
            $url = Helpers_URL::findURL($sitePageData, $driver, $siteOptions);
            if (($url === FALSE) || (!key_exists($url, $siteOptions['urls']))){
                throw new HTTP_Exception_404('URL "' . $sitePageData->url . '" not found.');
            }

            $sitePageData->url = $url;
		}
		$urlOptions = $siteOptions['urls'][$sitePageData->url];
		if (!is_array($urlOptions)){
			throw new HTTP_Exception_404('URL not correct.');
		}

		// функция для проверки редиректа
		$redirect = Arr::path($urlOptions, 'redirect', '');
		if(!empty($redirect)){
            include_once $path.'redirect_function.php';
            $redirect($sitePageData);
        }

        // задаем базовые СЕО заголовки
        Helpers_SEO::setBasicSEOHeads($sitePageData->url, $urlOptions, $sitePageData);

		// получаем базовую страницу
		$tmp = Arr::path($urlOptions, 'main', '');
		if (! empty($tmp)){
			$mainFile = '/'.$tmp; 
		}
		
		if (empty($mainFile)){
			throw new HTTP_Exception_404('URL min not found.');
		}

		if (key_exists('url_param', $urlOptions)){
			$urlParam = $urlOptions['url_param'];
		}else{
			$urlParam = array();
		}

		// получаем настройки
		$urlData = Arr::path($urlOptions, 'data', $urlOptions);

		// базовые данные для всех страниц
		// пробегаемся и добавляем заглушки
		if ($isWriteIndex === TRUE){
			self::addCap($siteOptions['basic'], $sitePageData);
		}

		// уникальные данные для каждой страницы
		// пробегаемся и добавляем заглушки
		self::addCap($urlData, $sitePageData);

		// Загружаем view базовые элементов
		if ($isWriteIndex === TRUE){
			self::loadView($shopID, $siteOptions['basic'], $sitePageData, $driver);
		}

		// Загружаем view уникальные для каждой страницы элементы
		self::loadView($shopID, $urlData, $sitePageData, $driver);

		// генерируем основную часть
		$urlParam[] = 'system';
		$body = self::_getMainPage($shopID, $mainFile, $sitePageData, $driver, $urlParam);

		// генерируем не изменяемую часть
		if ($isWriteIndex === TRUE){
			$index = self::_getIndexPage($shopID, $sitePageData, $driver);
			$result = str_replace('^#@view::main_body@#^', $body, $index);
		}else{
			$result = $body;
		}

		// производим итоговую замену
		$isReplace = TRUE;
		$n = 0;
		while($isReplace && ($n < 3)) {
			$isReplace = FALSE;
			foreach ($sitePageData->replaceDatas as $key => $value) {
			    if(is_array($value)){
			        continue;
                }
				if(! $isReplace && (strpos($result, '^#@' . $key . '@#^'))){
					$isReplace = TRUE;
				}
				$result = str_replace('^#@' . $key . '@#^', $value, $result);
			}

			$n++;
		}

		return $result;
	}

    /**
     * Создаем YML (Yandex Market Language) — это стандарт, разработанный Яндексом для принятия и размещения информации от магазинов.
     * https://yandex.ru/support/webmaster/goods-prices/technical-requirements.html
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
    public static function loadYML($shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $result = $driver->getMemcache()->getShopData($shopID, 'yml');
        if($result !== NULL){
            return $result;
        }
        echo '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
        $result = '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">'."\r\n".'<yml_catalog date="'.date('Y-m-d H:i').'">';

        // название магазина
        $result = $result . '<shop>';
        $result = $result . '<name>'.htmlspecialchars($sitePageData->shop->getName(), ENT_XML1).'</name>';
        $result = $result . '<company>'.htmlspecialchars($sitePageData->shop->getOfficialName(), ENT_XML1).'</company>';
        $result = $result . '<url>'.htmlspecialchars($sitePageData->urlBasic, ENT_XML1).'</url>';

        // курс валюты
        $result = $result . '<currencies>';

        $model = new Model_Currency();
        $model->setDBDriver($driver);

        $currencyIDs = $sitePageData->shop->getCurrencyIDsArray();
        if(empty($currencyIDs)){
            if (Helpers_DB::getDBObject($model, $sitePageData->shop->getDefaultCurrencyID(), $sitePageData)) {
                $result = $result . '<currency id="' . $model->getCode() . '" rate="' . $model->getCurrencyRate() . '"/>';
            }
        }else {
            foreach ($currencyIDs as $currencyID) {
                if (Helpers_DB::getDBObject($model, $currencyID, $sitePageData)) {
                    $result = $result . '<currency id="' . $model->getCode() . '" rate="' . $model->getCurrencyRate() . '"/>';
                }
            }
        }
        $result = $result . '</currencies>';

        // рубрики товаров
        $result = $result . '<delivery-options>';

        $ids = View_Shop_DeliveryType::getShopDeliveryTypes($shopID, '', '', $sitePageData, $driver, array(), NULL, FALSE);

        $maxDeliveryPrice = -1;
        foreach($ids->childs as $id){
            $id->values['price'] = Func::getNumberStr($id->values['price'], FALSE);
            $result = $result.'<option cost="'.$id->values['price'].'" days="1-3"/>';

            if($maxDeliveryPrice < $id->values['price']){
                $maxDeliveryPrice = $id->values['price'];
            }
        }

        $result = $result . '</delivery-options>';

        // загружаем настройки страниц
        $pathOptions = APPPATH.'views'.DIRECTORY_SEPARATOR.$sitePageData->shopShablonPath.DIRECTORY_SEPARATOR.'yml.php';
        if(!file_exists($pathOptions)){
            return $result.'</shop></yml_catalog>';
        }

        $pathOptions = include $pathOptions;

        // рубрики товаров
        $result = $result . '<categories>';

		if(key_exists('shop_good_rubrics', $pathOptions)){
			$pathOption = $pathOptions['shop_good_rubrics'];

			$class = Arr::path($pathOption, 'class', '');
			$function = Arr::path($pathOption, 'function', '');
			$params = Arr::path($pathOption, 'params', array());

			if((!empty($class)) && (!empty($function))) {
				$shopGoodRubricIDs = $class::$function($shopID, '', '', $sitePageData, $driver, $params, NULL, FALSE);

				foreach($shopGoodRubricIDs->childs as $id){
					if($id->values['root_id'] > 0){
						$result = $result.'<category id="'.$id->id.'" parentId="'.$id->values['root_id'].'">'.htmlspecialchars($id->values['name'], ENT_XML1).'</category>';
					}else{
						$result = $result.'<category id="'.$id->id.'">'.htmlspecialchars($id->values['name'], ENT_XML1).'</category>';
					}
				}
			}
		}else{
            $shopGoodRubricIDs = new MyArray();
        }

        $result = $result . '</categories>';

        // список товаров
        $result = $result . '<offers>';

        if(key_exists('shop_goods', $pathOptions)){
            $pathOption = $pathOptions['shop_goods'];

            $class = Arr::path($pathOption, 'class', '');
            $function = Arr::path($pathOption, 'function', '');
            $params = Arr::path($pathOption, 'params', array());
            $elements = Arr::path($pathOption, 'elements', NULL);

            $url = $sitePageData->urlBasic. $pathOption['url'];

            if((!empty($class)) && (!empty($function))) {
                $ids = $class::$function($shopID, '', '', $sitePageData, $driver, $params, $elements, FALSE, TRUE);

                $modelGood = new Model_Shop_Good();
                $modelGood->setDBDriver($driver);

                foreach($ids->childs as $id){
                    // проверяем опубликована ли данная рубрика
                    /*if($shopGoodRubricIDs->findChild($id->values['shop_table_rubric_id']) === NULL){
                        continue;
                    }*/

                   // Helpers_View::getDBDataIfNotFind($id, $modelGood, $sitePageData, $id->values['shop_id'], $elements);

                    $result = $result.'<offer id="'.$id->id.'" available="'.Func::boolToStr($id->values['is_public']).'">';

                    $newURL = $url;
                    foreach($id->values as $key => $value){
                        if($key == Model_Basic_BasicObject::FIELD_ELEMENTS){

                        }else {
                            if (!is_array($value)) {
                                $newURL = str_replace('#' . $key . '#', $value, $newURL);
                            }
                         }
                    }
                    $result = $result.'<url>'.htmlspecialchars($newURL, ENT_XML1).'</url>';

                    $result = $result.'<name>'.htmlspecialchars($id->values['name'], ENT_XML1).'</name>';

                    FuncPrice::getGoodPriceInModel($id, $sitePageData, $driver);
                    $result = $result.'<price>'.Func::getNumberStr($id->values['price'], FALSE).'</price>';

                    $result = $result.'<currencyId>'.$sitePageData->currency->getCode().'</currencyId>';
                    $result = $result.'<categoryId>'.$id->values['shop_table_rubric_id'].'</categoryId>';

                    if($maxDeliveryPrice == -1){
                        $result = $result . '<delivery>false</delivery>';
                    }else {
                        $result = $result . '<delivery>true</delivery>';
                    }

                    if(!empty($id->values['image_path'])) {
                        $result = $result . '<picture>' . htmlspecialchars(Helpers_Image::getPhotoPath($id->values['image_path'], 800, 600), ENT_XML1) . '</picture>';
                    }

                    $result = $result . '<sales_notes>'.'Минимальная сумма заказа: 3000 тг'.'</sales_notes>';

                    //$result = $result.'<typePrefix>Принтер</typePrefix>';
                    $result = $result . '<description>' . htmlspecialchars(Func::trimTextNew($id->values['text'], 250), ENT_XML1) . '</description>';

                    $id->values['options'] = json_decode($id->values['options'], TRUE);
                    if (!empty($id->values['options'])) {
                        $brand = Arr::path($id->values['options'], 'Производитель', Arr::path($id->values['options'], 'brand', ''));
                        if (!empty($brand)) {
                            $result = $result . '<vendor>' . htmlspecialchars($brand, ENT_XML1) . '</vendor>';
                        }

                        $result = $result . '<vendorCode>' . htmlspecialchars(Arr::path($id->values['options'], 'barcode', $id->values['article']), ENT_XML1) . '</vendorCode>';

                        $model = Arr::path($id->values['options'], 'Модель', Arr::path($id->values['options'], 'model', ''));
                        if (!empty($model)) {
                            $result = $result . '<model>' . htmlspecialchars($model, ENT_XML1) . '</model>';
                        }

                        $land = Arr::path($id->values['options'], 'Страна производства', Arr::path($id->values['options'], 'land', ''));
                        if (!empty($land)) {
                            $result = $result . '<country_of_origin>' . htmlspecialchars($land, ENT_XML1) . '</country_of_origin>';
                        }

                        $options = Arr::path($id->values, Model_Basic_BasicObject::FIELD_ELEMENTS . '.shop_table_rubric_id.options', array());
                        foreach ($id->values['options'] as $key => $value) {
                            if (!is_array($value)) {
                                foreach ($options as $option) {
                                    switch ($key) {
                                        case 'markup':
                                        case 'bonus':
                                            continue 2;
                                            break;
                                    }

                                    if ($option['field'] == $key) {
                                        $key = $option['title'];
                                    }

                                }

                                $result = $result . '<param name="' . htmlspecialchars($key, ENT_XML1) . '">' . htmlspecialchars($value, ENT_XML1) . '</param>';
                            }
                        }
                    }

                    $result = $result . '</offer>';
                }
            }
        }

        $result = $result . '</offers>';

        $result = $result.'</shop></yml_catalog>';
        $driver->getMemcache()->setShopData($result, $shopID, 'yml', 24 * 60 * 60);

        return $result;
    }

    /**
     * Формируем старинцу из настроек
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
	public static function loadSiteMap($shopID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
		$result = $driver->getMemcache()->getShopData($shopID, 'sitemap');
		if($result !== NULL){
			return $result;
		}
        echo '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
		$result = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

		// загружаем настройки страниц
		$pathOptions = APPPATH.'views'.DIRECTORY_SEPARATOR.$sitePageData->shopShablonPath.DIRECTORY_SEPARATOR.'sitemap.php';
		if(!file_exists($pathOptions)){
			return $result.'</urlset>';
		}
		$sitemaps = include $pathOptions;

		$date = date('Y-m-d');

		$driver = GlobalData::newModelDriverDBSQLMem();
		foreach($sitemaps as $sitemap){

			$url = $sitePageData->urlBasic. $sitemap['url'];
			$priority = floatval($sitemap['priority']);
			if($priority < 0.1){
				$priority = 1;
			}

			// для получения списка данных
			$class = Arr::path($sitemap, 'class', '');
			$function = Arr::path($sitemap, 'function', '');
			$params = Arr::path($sitemap, 'params', array());
			$elements = Arr::path($sitemap, 'elements', NULL);
            $languageID = Arr::path($sitemap, 'language_id', $sitePageData->dataLanguageID);

            $sitePageData->dataLanguageID = $languageID;
			if((!empty($class)) && (!empty($function))) {
                $ids = $class::$function($shopID, '', '', $sitePageData, $driver, $params, $elements, FALSE);

				foreach($ids->childs as $id){
                    $newURL = $url;
                    foreach($id->values as $key => $value){
						if($key == Model_Basic_BasicObject::FIELD_ELEMENTS){

						}else{
							$newURL = str_replace('#'.$key.'#', $value, $newURL);
						}
					}

					$result = $result.'<url><loc>'.htmlspecialchars($newURL, ENT_XML1).'</loc><changefreq>daily</changefreq><priority>'.$priority.'</priority><lastmod>'.Helpers_DateTime::getDateTimeISO8601(Arr::path($id->values, 'updated_at', $date)).'</lastmod></url>';
				}
			}else{
				$result = $result.'<url><loc>'.htmlspecialchars($url, ENT_XML1).'</loc><changefreq>daily</changefreq><priority>'.$priority.'</priority><lastmod>'.$date.'</lastmod></url>';
			}
		}

		$result = $result.'</urlset>';
		$driver->getMemcache()->setShopData($result, $shopID, 'sitemap', 24 * 60 * 60);

		return $result;
	}
}

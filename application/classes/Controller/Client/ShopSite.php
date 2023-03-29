<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Client_ShopSite extends Controller_Client_BasicClient {

    public function action_action(){
        // каждые 15 минут пересчитываем акции и скидки
        $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'action-time'. DIRECTORY_SEPARATOR;
        try {
            $time = file_get_contents($path.$this->_sitePageData->shopID.'.txt');
        }catch(Exception $e){
            $time = FALSE;
        }
        $newTime = time();
        if((! $time) || ($newTime - strtotime($time) > 15 * 60)){
            Helpers_Path::createPath($path);
            file_put_contents($path.$this->_sitePageData->shopID.'.txt', date('Y-m-d H:i:s', $newTime));

            //Helpers_Discount::runShopDiscounts($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB);
            //Helpers_Action::runShopActions($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB);
         }

        // получаем URL
        $fullURL = str_replace('//', '/', $_SERVER['REQUEST_URI']);

		// удаляем все после ?
        $shortURL = substr($fullURL, 0, strpos($fullURL.'?', '?'));
		$shortURL = str_replace('/index.php', '', $shortURL);
		if($shortURL == '/'){
            $shortURL = '';
		}

		// по префиксу определяем язык сайта
        $isSub = FALSE;
		switch (substr($shortURL, 0, 3)){
            case '/ru':
                $languageID = Model_Language::LANGUAGE_RUSSIAN;
                $isSub = TRUE;
                break;
            case '/en':
                $languageID = Model_Language::LANGUAGE_ENGLISH;
                $isSub = TRUE;
                break;
            case '/kk':
                $languageID = Model_Language::LANGUAGE_KAZAKH;
                $isSub = TRUE;
                break;
            case '/pl':
                $languageID = Model_Language::LANGUAGE_POLISH;
                $isSub = TRUE;
                break;
            case '/ae':
                $languageID = Model_Language::LANGUAGE_ARABIC;
                $isSub = TRUE;
                break;
            default:
                $languageID = $this->_sitePageData->shop->getDefaultLanguageID();
        }
        if ($languageID != $this->_sitePageData->languageID){
            $language = new Model_Language();
            $this->getDBObject($language, $languageID);
            $this->setSession('language_id', $languageID);

            $this->_sitePageData->dataLanguage = $language;
            $this->_sitePageData->dataLanguageID = $languageID;

            $this->_sitePageData->language = $language;
            $this->_sitePageData->languageID = $languageID;
        }

        if ($isSub) {
            $this->_sitePageData->urlBasicLanguage = $this->_sitePageData->urlBasic. substr($shortURL, 0, 3);
            $shortURL = substr($shortURL, 3);
        }

        // настройки сайта
        $this->_setOptions($fullURL, $shortURL);

		$this->_sitePageData->url = strval($shortURL);
		$this->_sitePageData->urlCanonical = $this->_sitePageData->urlBasicLanguage.$this->_sitePageData->url.URL::query();
		$this->_sitePageData->isIndexRobots = TRUE;

		$isWriteIndex = !(Request_RequestParams::getParamBoolean('is_not_index') === TRUE);
		$this->response->headers('Last-Modified', gmdate('D, d M Y H:i:s', time()).' GMT');
		$this->response->body(
				View_SitePage::loadSitePage($this->_sitePageData->shopID,
						'', $this->_sitePageData, $this->_driverDB, $isWriteIndex));
	}

    private function _setOptions($fullURL, $shortURL){

        // проверяем есть ли редиректы
        $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_sitePageData->shopShablonPath . DIRECTORY_SEPARATOR . 'redirects' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . '.php';
        if (file_exists($file)) {
            $redirects = include($file);
            if(key_exists($fullURL, $redirects)){
                $this->redirect($redirects[$fullURL]);
            }
        }

        // добавляем новые метатеги
        $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_sitePageData->shopShablonPath . DIRECTORY_SEPARATOR . 'metas' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . '.php';
        if (file_exists($file)) {
            $metas = include($file);

            foreach($metas as $meta){
                $tmp = Arr::path($meta, 'url', '');
                if(empty($tmp) || ($tmp == $shortURL )){
                    $s = '<meta';

                    $tmp = Arr::path($meta, 'name', '');
                    if(!empty($tmp)){
                        $s = $s . ' name="'.$tmp.'"';
                    }
                    $tmp = Arr::path($meta, 'content', '');
                    if(!empty($tmp)){
                        $s = $s . ' content="'.$tmp.'"';
                    }
                    $tmp = Arr::path($meta, 'itemprop', '');
                    if(!empty($tmp)){
                        $s = $s . ' itemprop="'.$tmp.'"';
                    }
                    $tmp = Arr::path($meta, 'property', '');
                    if(!empty($tmp)){
                        $s = $s . ' property="'.$tmp.'"';
                    }
                    $tmp = Arr::path($meta, 'addition', '');
                    if(!empty($tmp)){
                        $s = $s . ' '. $tmp;
                    }

                    $this->_sitePageData->meta = $this->_sitePageData->meta . $s . '/>' . "\r\n";
                }
            }
        }
    }


	/**
	 * YML (Yandex Market Language) — это стандарт, разработанный Яндексом для принятия и размещения информации от магазинов.
	 */
	public function action_yml(){
		$this->_sitePageData->url = '/yml.xml';
		$this->_sitePageData->urlCanonical = $this->_sitePageData->url;
		$this->_sitePageData->isIndexRobots = TRUE;

		$this->response->body(View_SitePage::loadYML($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB))
			->headers('Content-Type','xml; charset=utf-8"');
	}

	/**
	 * Карта сайта для поисковых машин
	 */
	public function action_sitemap(){
		$this->_sitePageData->url = '/sitemap.xml';
		$this->_sitePageData->urlCanonical = $this->_sitePageData->url;
		$this->_sitePageData->isIndexRobots = TRUE;

		$this->response->body(View_SitePage::loadSiteMap($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB))
			->headers('Content-Type','xml; charset=utf-8"');
	}

	/**
	 * Авторизация сайта Яндекс
	 */
	public function action_auth_yandex(){
		$this->_sitePageData->url = '/yandex_'.$this->request->param('yandex_number').'.html';
		$this->_sitePageData->urlCanonical = $this->_sitePageData->url;
		$this->_sitePageData->isIndexRobots = TRUE;

		$this->response->body(
			'<html>'
			.'	<head>'
			.'		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">'
			.'	</head>'
			.'	<body>Verification: '.$this->request->param('yandex_number').'</body>'
			.'</html>');
	}

	/**
	 * Авторизация сайта Яндекс
	 */
	public function action_auth_google(){
		$this->_sitePageData->url = '/google'.$this->request->param('google_number').'.html';
		$this->_sitePageData->urlCanonical = $this->_sitePageData->url;
		$this->_sitePageData->isIndexRobots = TRUE;

		$this->response->body('google-site-verification: google'.$this->request->param('google_number').'.html');
	}

	public function action_mem(){
		//$this->_driverDB->getMemcache()->

		$m = new Memcached();
		$m->addServer('localhost', 11211);
		/* Очищает все записи через 10 секунд */
		$m->flush();
	}

	/**
	 * Пользовательское соглашение
	 */
	public function action_rules(){
		$this->_sitePageData->url = '/site/rules';
		$this->_sitePageData->urlCanonical = $this->_sitePageData->url;
		$this->_sitePageData->isIndexRobots = TRUE;
		
		$this->response->body(
				View_SitePage::loadSitePage($this->_sitePageData->shopID,
						'/main/shop-rules', $this->_sitePageData, $this->_driverDB));
	}

	/**
	 * Пересчитать количество товаров у рубрик
	 * @param MyArray $shopGoodCatalogs
	 */
	private function _countShopGoodCatalog(MyArray $shopGoodCatalogs, Model_Shop_Table_Rubric $model){
		foreach($shopGoodCatalogs->childs as $shopGoodCatalog){
			$this->_countShopGoodCatalog($shopGoodCatalog, $model);
		}

		$storageCount = Request_Shop_Table_Rubric::getShopGoodStorageCount($this->_sitePageData->shopID, $shopGoodCatalogs->id,
			$this->_sitePageData, $this->_driverDB);

		$model->id = $shopGoodCatalogs->id;
		$model->setStorageCount($storageCount);
        $model->globalID = 1;
		Helpers_DB::saveDBObject($model, $this->_sitePageData);
	}


	/**
	 * Карта сайта для пользователей
	 */
	public function action_maps(){
		$this->_sitePageData->url = '/site/maps';
		$this->_sitePageData->urlCanonical = $this->_sitePageData->url;
		$this->_sitePageData->isIndexRobots = TRUE;
		
		$this->response->body(
				View_SitePage::loadSitePage($this->_sitePageData->shopID,
						'/main/shop-sitemaps', $this->_sitePageData, $this->_driverDB));
	}
}
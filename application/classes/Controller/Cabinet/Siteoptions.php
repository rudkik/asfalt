<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_SiteOptions extends Controller_Cabinet_BasicCabinet
{
    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'siteoptions';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_head()
    {
        $this->_sitePageData->url = '/cabinet/siteoptions/head';

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(), FALSE
            ),
            FALSE
        );
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::site/options/list/head',
            )
        );

        // получаем шаблон магазина
        $modelSiteShablon = new Model_SiteShablon();
        $modelSiteShablon->setDBDriver($this->_driverDB);
        if (!$this->getDBObject($modelSiteShablon, $this->_sitePageData->shop->getSiteShablonID())) {
            throw new HTTP_Exception_500('Template not found.');
        }

        $options = APPPATH . 'views' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . 'options.php';
        if (!file_exists($options)) {
            throw new HTTP_Exception_500('File options "'.$options.'" not found.');
        }
        $options = include $options;

        // получаем список URL
        $heads = array();
        foreach ($options['urls'] as $url => $value) {
            if (empty($url)) {
                $url = '/';
            }
            $heads[$url] = array(
                'url' => $url,
                'site_url' => $this->_sitePageData->urlBasic . $url,
                'title' => Arr::path($value, 'title', ''),
                'site_title' => Arr::path($value, 'site_title.' . $this->_sitePageData->dataLanguageID, ''),
                'site_keywords' => Arr::path($value, 'site_keywords.' . $this->_sitePageData->dataLanguageID, ''),
                'site_description' => Arr::path($value, 'site_description.' . $this->_sitePageData->dataLanguageID, ''),
            );
        }

        // считываем данные из специального файла
        $headsFile = APPPATH . 'views' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . 'heads.php';
        if (file_exists($headsFile)) {
            $headsBasic = include $headsFile;
            if (key_exists($this->_sitePageData->shopID, $headsBasic)) {
                $headsBasic = $headsBasic[$this->_sitePageData->shopID];
                foreach ($headsBasic as $url => $data) {
                    if (!key_exists($url, $heads)) {
                        continue;
                    }

                    $heads[$url]['site_title'] = Arr::path($data, $this->_sitePageData->dataLanguageID . '.site_title', $heads[$url]['site_title']);
                    $heads[$url]['site_keywords'] = Arr::path($data, $this->_sitePageData->dataLanguageID . '.site_keywords', $heads[$url]['site_keywords']);
                    $heads[$url]['site_description'] = Arr::path($data, $this->_sitePageData->dataLanguageID . '.site_title', $heads[$url]['site_description']);
                }
            }
        }

        $urls = new MyArray();
        foreach ($heads as $data) {
            $child = $urls->addChild(0);
            $child->values = $data;
            $child->isFindDB = TRUE;
            $child->isLoadElements= TRUE;
        }

        // получаем список url
        $model = new Model_Basic_LanguageObject(array(), '', 0);
        $model->setDBDriver($this->_driverDB);
        $this->_sitePageData->replaceDatas['view::site/options/list/head'] = $this->getViewObjects($urls, $model,
            'site/options/list/head', 'site/options/one/head', 0, FALSE);


        // добавляем футер и хедер
        $this->_putInMain('/main/site/options/head');
    }

    public function action_save_head()
    {
        $this->_sitePageData->url = '/cabinet/siteoptions/save_head';

        // получаем шаблон магазина
        $modelSiteShablon = new Model_SiteShablon();
        $modelSiteShablon->setDBDriver($this->_driverDB);
        if (!$this->getDBObject($modelSiteShablon, $this->_sitePageData->shop->getSiteShablonID())) {
            throw new HTTP_Exception_500('Template not found.');
        }

        $seo = Request_RequestParams::getParamArray('seo');
        if ($seo === NULL) {
            // возможно старая версия админ панели
            $options = APPPATH . 'views' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . 'options.php';
            if (!file_exists($options)) {
                throw new HTTP_Exception_500('File options "'.$options.'" not found.');
            }
            $siteOptions = include $options;

            $urls = Request_RequestParams::getParamArray('urls');
            $siteTitles = Request_RequestParams::getParamArray('site_titles');
            $siteKeywords = Request_RequestParams::getParamArray('site_keywords');
            $siteDescriptions = Request_RequestParams::getParamArray('site_descriptions');
            if ((count($urls) != count($siteTitles)) || (count($urls) != count($siteKeywords)) || (count($urls) != count($siteDescriptions))) {
                throw new HTTP_Exception_500('Data not correct!');
            }

            $seo = array();
            for ($i = 0; $i < count($urls); $i++) {
                $url = $urls[$i];
                $seo[$url] = array(
                    'site_title' => $siteTitles[$i],
                    'site_keywords' => $siteKeywords[$i],
                    'site_description' => $siteDescriptions[$i],
                );
            }
        }

        $headsFile = APPPATH . 'views' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . 'heads.php';
        if (!file_exists($headsFile)) {
            $heads = array();
        }else {
            $heads = include $headsFile;
        }

        if(!key_exists($this->_sitePageData->shopID, $heads)){
            $heads[$this->_sitePageData->shopID] = array();
        }
        foreach ($seo as $url => $data){
            if(!key_exists($url, $heads[$this->_sitePageData->shopID])){
                $heads[$this->_sitePageData->shopID][$url] = array(
                    $this->_sitePageData->dataLanguageID => array()
                );
            }elseif(!key_exists($this->_sitePageData->dataLanguageID, $heads[$this->_sitePageData->shopID][$url])){
                $heads[$this->_sitePageData->shopID][$url][$this->_sitePageData->dataLanguageID] = array();
            }

            $heads[$this->_sitePageData->shopID][$url][$this->_sitePageData->dataLanguageID] = array_merge(
                $heads[$this->_sitePageData->shopID][$url][$this->_sitePageData->dataLanguageID], $data
            );
        }

        Helpers_Array::saveArrayToStrPHP($heads, $headsFile);

        $this->redirect('/cabinet/siteoptions/head'.URL::query(array_merge($_POST, array('seo' => 1))));
    }













    /** не обработанные */

    public function mySortMethod($a, $b)
    {
        switch ($this->_sitePageData->languageID) {
            case Model_Language::LANGUAGE_RUSSIAN:
                $name = 'ru';
                break;
            case Model_Language::LANGUAGE_ENGLISH:
                $name = 'en';
                break;
            default:
                $name = 'ru';
        }

        return strnatcmp($a['title'][$name], $b['title'][$name]);
    }

    public function action_sitemaps()
    {
        $this->_sitePageData->url = '/cabinet/siteoptions/sitemaps';

        // получаем шаблон магазина
        $modelSiteShablon = new Model_SiteShablon();
        $modelSiteShablon->setDBDriver($this->_driverDB);
        if (!$this->getDBObject($modelSiteShablon, $this->_sitePageData->shop->getSiteShablonID())) {
            throw new HTTP_Exception_500('Template not found.');
        }

        // функции
        $requestAll = include APPPATH . 'classes' . DIRECTORY_SEPARATOR . 'Request' . DIRECTORY_SEPARATOR . 'requests.php';

        uasort($requestAll, array($this, 'mySortMethod'));
        $viewList = new MyArray();
        foreach ($requestAll as $key => $value) {
            $tmp = $viewList->addChild(0);
            $tmp->values['title'] = $value['title'];
            $tmp->values['data'] = $key;
            $tmp->isFindDB = TRUE;
        }

        // получаем список вьюшек
        $model = new Model_Basic_LanguageObject(array(), '', 0);
        $model->setDBDriver($this->_driverDB);
        $viewList = $this->getViewObjects($viewList, $model, "site/combobox-views", "site/combobox-view", 0, FALSE);


        // получаем список URL
        $urls = new MyArray();

        $siteMapFile = APPPATH . 'views' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . 'sitemap.php';
        if (!file_exists($siteMapFile)) {
            $options = APPPATH . 'views' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . 'options.php';
            if (!file_exists($options)) {
                throw new HTTP_Exception_500('File options "'.$options.'" not found.');
            }
            $siteOptions = include $options;
            $urls = $siteOptions['urls'];

            // получаем список URL
            foreach ($urls as $url => $value) {
                $tmp = $urls->addChild(0);
                $tmp->values['url_prefix'] = !empty($url) ? substr($url, 1) : $url;
                $tmp->values['url_param'] = '';
                $tmp->values['url_postfix'] = '';
                $tmp->values['priority'] = '1';
                $tmp->values['function'] = '';
                $tmp->additionDatas['view::site/combobox-views'] = $viewList;
                $tmp->isFindDB = TRUE;
            }
        } else {
            $siteMaps = include $siteMapFile;

            // получаем список URL
            foreach ($siteMaps as $siteMap) {
                $tmp = $urls->addChild(0);
                $tmp->values['url_prefix'] = $siteMap['url_prefix'];
                $tmp->values['url_param'] = $siteMap['url_param'];
                $tmp->values['url_postfix'] = $siteMap['url_postfix'];
                $tmp->values['priority'] = $siteMap['priority'];
                $tmp->values['function'] = $siteMap['class'] . '_' . $siteMap['function'];

                $s = 'data-id="' . $tmp->values['function'] . '"';
                $tmp->additionDatas['view::site/combobox-views'] = str_replace($s, $s . ' selected', $viewList);

                $tmp->isFindDB = TRUE;
            }
        }

        $urls->additionDatas['view::site/combobox-views'] = $viewList;

        // получаем список url
        $model = new Model_Basic_LanguageObject(array(), '', 0);
        $model->setDBDriver($this->_driverDB);
        $urls = $this->getViewObjects($urls, $model, "siteoptions/sitemaps", "siteoptions/sitemap", 0, FALSE);

        // генерируем основную часть
        $view = View::factory('cabinet/' . $this->_sitePageData->languageID . '/main/siteoptions/sitemap');
        $view->data = array();
        $view->data['view::siteoptions/sitemaps'] = $urls;
        $view->siteData = $this->_sitePageData;
        $result = Helpers_View::viewToStr($view);

        // добавляем футер и хедер
        $isMain = Request_RequestParams::getParamBoolean('is_main');
        if ($isMain !== TRUE) {
            $result = $this->_putInIndex($result);
        }

        $this->response->body($result);
    }

    public function action_savesitemaps()
    {
        $this->_sitePageData->url = '/cabinet/siteoptions/savesitemaps';

        // получаем шаблон магазина
        $modelSiteShablon = new Model_SiteShablon();
        $modelSiteShablon->setDBDriver($this->_driverDB);
        if (!$this->getDBObject($modelSiteShablon, $this->_sitePageData->shop->getSiteShablonID())) {
            throw new HTTP_Exception_500('Template not found.');
        }

        $urlPrefixs = Request_RequestParams::getParamArray('url_prefix');
        $urlParams = Request_RequestParams::getParamArray('url_param');
        $urlPostfixs = Request_RequestParams::getParamArray('url_postfix');
        $prioritys = Request_RequestParams::getParamArray('priority');
        $functions = Request_RequestParams::getParamArray('function');
        if ((count($urlPrefixs) != count($urlPostfixs)) || (count($urlPrefixs) != count($prioritys))
            || (count($urlPrefixs) != count($functions)) || (count($urlPrefixs) != count($urlParams))) {
            throw new HTTP_Exception_500('Data not correct!');
        }

        $requestAll = include APPPATH . 'classes' . DIRECTORY_SEPARATOR . 'Request' . DIRECTORY_SEPARATOR . 'requests.php';

        $siteMaps = array();
        for ($i = 0; $i < count($functions); $i++) {

            $tmp = array(
                'url_prefix' => $urlPrefixs[$i],
                'url_param' => $urlParams[$i],
                'url_postfix' => $urlPostfixs[$i],
                'priority' => $prioritys[$i],
                'class' => '',
                'function' => '',
            );

            $function = $functions[$i];
            if ((!empty($function)) && (key_exists($function, $requestAll))) {
                $tmp['class'] = $requestAll[$function]['class'];
                $tmp['function'] = $requestAll[$function]['function'];
            }

            $siteMaps[] = $tmp;
        }

        $s = '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($siteMaps) . ';';

        $options = APPPATH . 'views' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . 'sitemap.php';
        umask(0777);
        $file = fopen($options, 'w');
        fwrite($file, $s);
        fclose($file);
        try {
            chmod($options, 0777);
        } catch (Exception $e) {

        }

        $this->redirect('/cabinet/siteoptions/sitemaps?nocashe=' . rand(0, 10000));
    }

}

<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_Site extends Controller_Cabinet_BasicCabinet {
    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'site';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    /**
     * @var SitePageData
     */
    private $_shopSiteData = NULL;

    public function _putInMain($file)
    {
        // получаем список языков
        $path = APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_shopSiteData->shopShablon->getShablonPath();
        $dir = scandir($path);
        $arr = array();
        foreach ($dir as $value) {
            $value = intval($value);
            if ($value > 0) {
                $arr[$value] = $value;
            }
        }

        $options = $this->_getOptionList();
        $languages = Request_Request::findAllNotShop(DB_Language::NAME, $this->_sitePageData, $this->_driverDB, TRUE);
        foreach($languages->childs as $key => $language){
            if(!key_exists($language->id, $arr)){
                unset($languages->childs[$key]);
            }else{
                $language->additionDatas['urls'] = $options['urls'];
            }
        }
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/language/list/menu',
            $this->getViewObjects($languages, new Model_Language(), "site/language/list/menu", "site/language/one/menu"));

        parent::_putInMain($file);
    }

    /**
     * Удаление папки и подпапки
     * @param $dir
     */
    private function removeDirectory($dir) {
        if ($objs = glob($dir . "/*")) {
            foreach ($objs as $obj) {
                is_dir($obj) ? $this->removeDirectory($obj) : unlink($obj);
            }
        }
        rmdir($dir);
    }

    /**
     * Поиск файлов / папок по пути с детворой
     * @param $dir
     * @param $basicDir
     * @param MyArray|NULL $path
     * @return MyArray
     */
    private function getFilesAndDirectories($dir, $basicDir, MyArray $path = NULL) {
        if (!file_exists($dir)) {
            return new MyArray();
        }

        $dir_list = scandir($dir);
        if ($path === NULL) {
            $path = new MyArray();
        }

        if (empty($dir_list) || !is_array($dir_list)) {
            return $path;
        }

        $dir_list = array_diff_assoc($dir_list, array('.', '..'));
        natsort($dir_list);

        foreach ($dir_list as $file) {
            if(!is_file($dir .$file)){
                continue;
            }

            $child = $path->addChild(0);
            $child->values['path'] = str_replace(DIRECTORY_SEPARATOR, '/', str_replace($basicDir, '', $dir)) . $file;
            $child->values['is_directory'] = false;
            $child->values['name'] = $file;
            $child->isFindDB = true;
        }

        foreach ($dir_list as $directory) {
            if(!is_dir($dir . $directory)){
                continue;
            }

            $child = $path->addChild(0);
            $child->values['path'] = str_replace(DIRECTORY_SEPARATOR, '/', str_replace($basicDir, '', $dir)) . $directory;
            $child->values['is_directory'] = true;
            $child->values['name'] = $directory;
            $child->isFindDB = true;

            $this->getFilesAndDirectories($dir . $directory . DIRECTORY_SEPARATOR, $basicDir, $child);
        }

        return $path;
    }

    /**
     * Определяем магазина интерсейса
     */
    protected function _readShopSiteInterface()
    {
        // получаем магазин
        $shopID = Request_RequestParams::getParamInt('id');
        if ($shopID < 1){
            throw new HTTP_Exception_500('Shop not found.');
        }

        $model = new Model_Shop();
        $model->setDBDriver($this->_driverDB);
        if(! $this->getDBObject($model, $shopID)){
            throw new HTTP_Exception_500('Shop not found.');
        }

        $this->_shopSiteData->shopID = $shopID;
        $this->_shopSiteData->shop = $model;
    }

    /**
     * Определяем шаблон интерсейса
     */
    protected function _readShopSiteShablonInterface()
    {
        // получаем шаблон магазина
        $model = new Model_SiteShablon();
        $model->setDBDriver($this->_driverDB);
        if (! $this->getDBObject($model, $this->_shopSiteData->shop->getSiteShablonID())) {
            throw new HTTP_Exception_500('Shablon not found.');
        }

        $this->_shopSiteData->shopShablon = $model;
    }

    /**
     * Определяем шаблон интерсейса
     */
    protected function _readShopLanguageInterface()
    {
        $language = Request_RequestParams::getParamInt('language');
        $path = APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_shopSiteData->shopShablon->getShablonPath() . DIRECTORY_SEPARATOR . $language;
        if (!file_exists($path)) {
            throw new HTTP_Exception_500('Language not found.');
        }
        $this->_shopSiteData->languageID = $language;
    }

    /**
     * Сортировка
     * @param $a
     * @param $b
     * @return int
     */
    protected function mySortMethod($a, $b) {
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

    /**
     * Список вьюшек
     * @return array
     */
    protected function _getViewList()
    {
        $result = include APPPATH . 'classes' . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . 'views.php';
        uasort($result, array($this, 'mySortMethod'));

        return $result;
    }

    /**
     * Список функций
     */
    protected function _getViewFunctionList()
    {
        $result = include APPPATH . 'classes' . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . 'views-functions.php';
        uasort($result, array($this, 'mySortMethod'));

        return $result;
    }

    /**
     * Список ссылок
     */
    protected function _getOptionList()
    {
        $options = APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_shopSiteData->shopShablon->getShablonPath()
            . DIRECTORY_SEPARATOR . 'options.php';
        if (!file_exists($options)) {
            throw new HTTP_Exception_500('File options "'.$options.'" not found.');
        }

        return include $options;
    }

    /**
     * Список вьюшек в HTML
     */
    protected function _getViews($viewAll = NULL)
    {
        if(!is_array($viewAll)) {
            $viewAll = $this->_getViewList();
        }

        $viewList = new MyArray();
        foreach ($viewAll as $key => $value) {
            $tmp = $viewList->addChild(0);
            $tmp->values['title'] = $value['title'];
            $tmp->values['data'] = $key;

            $tmp->isFindDB = TRUE;
            $tmp->isParseData = FALSE;
        }

        // получаем список вьюшек
        $result =  $this->getViewObjects($viewList, new Model_Basic_LanguageObject(array(), '', 0),
            "site/view/list/list", "site/view/one/list", 0, FALSE);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/view/list/list', $result);
        return $result;
    }

    /**
     * Сохранение options
     */
    protected function _saveOptionList(array $options)
    {
        $path = APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_shopSiteData->shopShablon->getShablonPath()
            . DIRECTORY_SEPARATOR . 'options.php';

        $s = '<?php' . "\r\n" . 'return ' . Helpers_Array::arrayToStrPHP($options) . ';';

        $file = fopen($path, 'w');
        fwrite($file, $s);
        fclose($file);
    }

    /**
     * Список параметров в HTML
     */
    protected function _getParamsViews(array &$params, array &$data)
    {
        $result = new MyArray();

        foreach ($params as $param) {
            if (key_exists($param['name'], $data)) {
                $param = array_merge($param, $data[$param['name']]);
            }

            $tmp = $result->addChild(0);
            $tmp->values = $param;
            $tmp->isFindDB = TRUE;
            $tmp->isParseData = FALSE;
        }

        $result = $this->getViewObjects($result, new Model_Basic_LanguageObject(array(), '', 0), "site/param/list/list", "site/param/one/list", 0, FALSE);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/param/list/list', $result);
        return $result;
    }

    /**
     * Список полей в HTML
     */
    protected function _getFieldsViews(array &$fields)
    {
        $result = new MyArray();
        foreach ($fields as $field) {
            $tmp = $result->addChild(0);
            $tmp->values = $field;
            $tmp->isFindDB = TRUE;
            $tmp->isParseData = FALSE;
        }

        $result = $this->getViewObjects($result, new Model_Basic_LanguageObject(array(), '', 0), "site/field/list/list", "site/field/one/list", 0, FALSE);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/field/list/list', $result);
        return $result;
    }

    /**
     * Список функций в HTML
     */
    protected function _getFunctionsViews(array $functions)
    {
        $result = new MyArray();
        foreach ($functions as $function) {
            $tmp = $result->addChild(0);
            $tmp->values = $function;
            $tmp->isFindDB = TRUE;
            $tmp->isParseData = FALSE;
        }

        $result = $this->getViewObjects($result, new Model_Basic_LanguageObject(array(), '', 0), "site/func/list/list", "site/func/one/list", 0, FALSE);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/func/list/list', $result);
        return $result;
    }

    /**
     * Список типов считывания в HTML
     */
    protected function _getRequestParamTypeViews(array $requestParamType)
    {
        $result = new MyArray();
        $result->values = $requestParamType;
        $result->isFindDB = TRUE;
        $result->isParseData = FALSE;

        $result = $this->getViewObject($result, new Model_Basic_LanguageObject(array(), '', 0), "site/param/type/one/edit", 0, FALSE);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/param/type/one/edit', $result);
        return $result;
    }

    /**
     * Список вьюшек сайта в HTML
     */
    protected function _getViewsSite(array &$views)
    {
        $result = new MyArray();
        foreach ($views as $view) {
            $tmp = $result->addChild(0);
            $tmp->values['title'] = Arr::path($view, 'title', '');

            $s = $view['list'];
            if (empty($s)) {
                $s = $view['one'];
            }

            $tmp->values['data'] = $s;
            $tmp->isFindDB = TRUE;
            $tmp->isParseData = FALSE;
        }
        $result = $this->getViewObjects($result, new Model_Basic_LanguageObject(array(), '', 0), "site/view/list/list", "site/view/one/list", 0, FALSE);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/view/list/list', $result);

        return $result;
    }

    /**
     * Получение вьюшки из файла
     * @param $path
     * @return string
     */
    protected function _getFileHtmlViews($path)
    {
        if(empty($path)){
            return '';
        }
        $tmp = APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_shopSiteData->shopShablon->getShablonPath()
            . DIRECTORY_SEPARATOR . $this->_shopSiteData->languageID;
        if($path[0] == '/'){
            $path = $tmp . $path . '.php';
        }else{
            $path = $tmp . DIRECTORY_SEPARATOR . $path . '.php';
        }
        $path = str_replace('\\', DIRECTORY_SEPARATOR, str_replace('/', DIRECTORY_SEPARATOR, $path));

        if (file_exists($path)) {
            $result = file_get_contents($path);
        } else {
            $result = '';
        }

        return htmlspecialchars($result);
    }

    /**
     * Сохранения вьюшки в файл
     * @param $path
     * @param $html
     * @return bool
     */
    protected function _saveFileHtmlViews($path, $html)
    {
        if(empty($path)){
            return TRUE;
        }

        $tmp = APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_shopSiteData->shopShablon->getShablonPath()
            . DIRECTORY_SEPARATOR . $this->_shopSiteData->languageID;
        if($path[0] == '/'){
            $path = $tmp . $path . '.php';
        }else{
            $path = $tmp . DIRECTORY_SEPARATOR . $path . '.php';
        }
        $path = str_replace('\\', DIRECTORY_SEPARATOR, str_replace('/', DIRECTORY_SEPARATOR, $path));

        $dir = substr($path, 0, strrpos($path, DIRECTORY_SEPARATOR));

        if (!file_exists($dir)) {
            Helpers_Path::createPath($dir);
        }

        $file = fopen($path, 'w');
        fwrite($file, $html);
        fclose($file);

        return TRUE;
    }

    /**
     * Список ссылок в HTML
     * @param array $urls
     * @return MyArray|string
     */
    protected function _getURLsViews(array &$urls)
    {
        // получаем список URL
        $result = new MyArray();
        foreach ($urls as $url => $value) {
            $tmp = $result->addChild(0);
            $tmp->values['url'] =  !empty($url)?substr($url,1):$url;
            $tmp->values['title'] = Arr::path($value, 'title', '');
            $tmp->isFindDB = TRUE;
            $tmp->isParseData = FALSE;
        }

        $result = $this->getViewObjects($result, new Model_Basic_LanguageObject(array(), '', 0), "site/url/list/list", "site/url/one/list", 0, FALSE);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/url/list/list', $result);
        return $result;
    }

    /**
     * Список файлов css сайта в HTML
     * @return string
     */
    protected function _getCSSViews()
    {
        $path = DOCROOT . 'css' . DIRECTORY_SEPARATOR . $this->_shopSiteData->shopShablon->getShablonPath() . DIRECTORY_SEPARATOR;

        $paths = $this->getFilesAndDirectories($path, $path);
        $paths->addAdditionDataChilds(array('path_basic' => 'css' . DIRECTORY_SEPARATOR . $this->_shopSiteData->shopShablon->getShablonPath() . DIRECTORY_SEPARATOR));
        $result = $this->getViewObjects($paths, new Model_Basic_LanguageObject(array(), '', 0), "site/file/list/list", "site/file/one/list", 0, FALSE);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/file/list/list', $result);

        return $result;
    }

    /**
     * Данные ссылки
     * @param $url
     * @param $options
     * @return mixed
     * @throws HTTP_Exception_500
     */
    protected function _getURLData($url, $options)
    {
        if (!key_exists($url, $options['urls'])) {
            throw new HTTP_Exception_500('URL not found.');
        }

        return $options['urls'][$url];
    }

    public function action_view_statics() {
        $this->_sitePageData->url = '/cabinet/site/view_statics';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();

        $options = $this->_getOptionList();

        $viewAll = $this->_getViewList();
        $this->_getViews($viewAll);

        // получаем список вьюшек
        $views = new MyArray();
        foreach ($options['basic'] as $index => $value) {
            $tmp = $views->addChild(0);
            $tmp->values['index'] = $index;
            $tmp->values['title'] = Arr::path($value, 'title', '');
            $tmp->values['name'] = $value['table'] . '_' . $value['function'];
            $tmp->values['index_title'] = $viewAll[$tmp->values['name']]['title'];
            $tmp->isFindDB = TRUE;
            $tmp->isParseData = FALSE;
        }
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/view/static/list/index',
            $this->getViewObjects($views, new Model_Basic_LanguageObject(array(), '', 0), "site/view/static/list/index", "site/view/static/one/index", 0, FALSE));

        $this->_putInMain('/main/site/view/static/index');
    }

    public function action_save_view_statics() {
        $this->_sitePageData->url = '/cabinet/site/save_view_statics';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();

        $options = $this->_getOptionList();

        $viewAll = $this->_getViewList();

        $views = Request_RequestParams::getParamArray('views', array(), array());
        $originalViews = $views;

        // удаляем и меняем название
        $basic = $options['basic'];
        foreach($basic as $index => $value){
            if(key_exists($index, $views)){
                $title = Arr::path($views[$index], 'title', '');
                if(!empty($title)) {
                    $options['basic'][$index]['title'] = $title;
                }

                unset($views[$index]);
            }else{
                unset($options['basic'][$index]);
            }
        }

        // добавляем
        foreach($views as $index => $view){
            $title = Arr::path($view, 'title', '');
            if (empty($title)) {
                continue;
            }

            $name = Arr::path($view, 'name', '');
            if (!key_exists($name, $viewAll)) {
                continue;
            }

            $tmp = $viewAll[$name];
            $path = DIRECTORY_SEPARATOR . 'basic' . DIRECTORY_SEPARATOR . str_replace(' ', '_', str_replace('/', '_', str_replace('\\', '_', Func::get_in_translate_to_en($title))));

            $arrData  = array(
                'title' => $title,
                'class' => $tmp['class'],
                'table' => $tmp['table'],
                'function' => $tmp['function'],
                'one' => $tmp['table'] . $path,
                'params' => array()
            );

            if(Arr::path($tmp, 'is_one', FALSE) === TRUE) {
                $arrData['list'] = '';
            }else{
                $arrData['list'] = $tmp['table'] . 's' . $path;
            }

            // добавление, если группа
            if(key_exists('groups', $tmp)) {
                $arrGroup = array('one' => $tmp['table'] . DIRECTORY_SEPARATOR . 'group' . $path);
                if (Arr::path($tmp['groups'], 'is_one', FALSE) === TRUE) {
                    $arrGroup['list'] = '';
                } else {
                    $arrGroup['list'] = $tmp['table'] . 's' . DIRECTORY_SEPARATOR . 'group' . $path;
                }
                $arrData['group'] = $arrGroup;
            }

            $options['basic'][$index] = $arrData;
        }

        // меняем сортировку
        $basic = array();
        foreach($originalViews as $index => $value){
            if(key_exists($index, $options['basic'])){
                if(is_int($index)){
                    $sIndex = $index;
                }else{
                    $sIndex = microtime(TRUE) + count($basic);
                }

                $basic[$sIndex] = $options['basic'][$index];
                print_r($options['basic'][$index]);
            }
        }
        $options['basic'] = $basic;

        $this->_saveOptionList($options);

        $this->redirect('/cabinet/site/view_statics?id=' . Request_RequestParams::getParamInt('id') . '&url=' . Request_RequestParams::getParamStr('url') . '&language=' . Request_RequestParams::getParamInt('language').'&nocache='.rand(1, 10000));
    }

    public function action_view_static() {
        $this->_sitePageData->url = '/cabinet/site/view_static';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();
        $this->_readShopLanguageInterface();

        $options = $this->_getOptionList();
        $view = Request_RequestParams::getParamInt('view');
        if (!key_exists($view, $options['basic'])) {
            throw new HTTP_Exception_500('View not found.');
        }
        $data = $options['basic'][$view];

        $viewAll = $this->_getViewList();

        $keyFunction = $data['table'] . '_' . $data['function'];
        $this->_getParamsViews($viewAll[$keyFunction]['params'], $data['params']);
        $this->_getFieldsViews($viewAll[$keyFunction]['fields']);
        $this->_getRequestParamTypeViews(Arr::path($data, Request_RequestParams::READ_REQUEST_TYPE_NAME, array()));
        $this->_getFunctionsViews($this->_getViewFunctionList());

        // данные вьюшки
        $viewData = new MyArray();
        $viewData->isFindDB = TRUE;
        $viewData->isParseData = FALSE;
        $viewData->values['tag_list'] = $data['one'];
        $viewData->values['title_view'] = $data['title'];
        $viewData->values['is_one'] = Arr::path($viewAll[$keyFunction], 'is_one', FALSE);

        $viewData->values['list'] = $this->_getFileHtmlViews($data['list']);
        $viewData->values['one'] = $this->_getFileHtmlViews($data['one']);

        $groupsData = Arr::path($viewAll[$keyFunction], 'groups', NULL);
        if($groupsData !== NULL){
            $viewData->values['title_group'] = $groupsData['title'];
        }
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/view/static/one/edit',
            $this->getViewObject($viewData, new Model_Basic_LanguageObject(array(), '', 0), "site/view/static/one/edit", 0, FALSE));

        $this->_putInMain('/main/site/view/static/edit');
    }

    public function action_save_view_static()
    {
        $this->_sitePageData->url = '/cabinet/site/save_view_static';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();
        $this->_readShopLanguageInterface();

        $options = $this->_getOptionList();
        $view = Request_RequestParams::getParamInt('view');
        if (($view != '') && (empty($options['basic']))) {
            throw new HTTP_Exception_500('View not found.');
        }
        $data = $options['basic'][$view];

        $this->_saveFileHtmlViews($data['list'], Request_RequestParams::getParamStr('list'));
        $this->_saveFileHtmlViews($data['one'], Request_RequestParams::getParamStr('one'));

        $options['basic'][$view]['params'] = Request_RequestParams::getParamArray('params', array(), array());
        $options['basic'][$view][Request_RequestParams::READ_REQUEST_TYPE_NAME] = Request_RequestParams::getParamArray(Request_RequestParams::READ_REQUEST_TYPE_NAME, array(), array());

        $this->_saveOptionList($options);

        $this->redirect('/cabinet/site/view_static?id=' . Request_RequestParams::getParamInt('id') . '&language=' . Request_RequestParams::getParamInt('language') . '&view=' . Request_RequestParams::getParamInt('view').'&nocache='.rand(1, 10000));
    }

    public function action_urls() {
        $this->_sitePageData->url = '/cabinet/site/urls';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();

        $options = $this->_getOptionList();

        // получаем список URL
        $urls = new MyArray();
        foreach ($options['urls'] as $url => $value) {
            $tmp = $urls->addChild(0);
            $tmp->values['url'] =  !empty($url)?substr($url,1):$url;
            $tmp->values['title'] = Arr::path($value, 'title', '');
            $tmp->isFindDB = TRUE;
            $tmp->isParseData = FALSE;
        }
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/url/list/index',
            $this->getViewObjects($urls, new Model_Basic_LanguageObject(array(), '', 0), "site/url/list/index", "site/url/one/index", 0, FALSE));

        $this->_putInMain('/main/site/url/list');
    }

    public function action_save_urls() {
        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();

        $options = $this->_getOptionList();

        $urls = Request_RequestParams::getParamArray('urls', array(), array());

        // добавляем и меняем название
        $basic = array();
        foreach($urls as $index => $value){
            $s = Arr::path($value, 'url', '');
            $sURL = '/'.$s;
            if($sURL == '/'){
                $sURL = '';
            }

            if(key_exists($sURL, $options['urls'])){
                $basic[$sURL] = $options['urls'][$sURL];
            }else{
                $basic[$sURL] = array(
                    'main' => '/main/'. str_replace(' ', '_', str_replace('/', '_', str_replace('\\', '_', Func::get_in_translate_to_en($s)))),
                    'data' => array(), );
                if(empty($s)){
                    $basic[$sURL]['main'] = '/main/index';
                }
            }
            $basic[$sURL]['title'] = Arr::path($value, 'title', '');
        }

        // меняем сортировку
        $options['urls'] = array();
        foreach($urls as $value){
            $s = Arr::path($value, 'url', '');
            if(!empty($s)){
                $sURL = '/' . $s;
            }else{
                $sURL = '';
            }

            $options['urls'][$sURL] = $basic[$sURL];
        }
        $this->_saveOptionList($options);


        $this->redirect('/cabinet/site/urls?id=' . Request_RequestParams::getParamInt('id').'&nocache='.rand(1, 10000));
    }

    public function action_languages() {
        $this->_sitePageData->url = '/cabinet/site/languages';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();

        // получаем список языков
        $options = APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_shopSiteData->shopShablon->getShablonPath();
        if (!file_exists($options)) {
            throw new HTTP_Exception_404('File not found.');
        }

        $dir = scandir($options);
        $arr = array();
        foreach ($dir as $value) {
            $value = intval($value);
            if ($value > 0) {
                $arr[$value] = $value;
            }
        }

        $languages = Request_Request::findAllNotShop(DB_Language::NAME, $this->_sitePageData, $this->_driverDB, TRUE);
        foreach($languages->childs as $language){
            $language->additionDatas['is_public'] = key_exists($language->id, $arr);
        }
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/language/list/list',
            $this->getViewObjects($languages, new Model_Language(), "site/language/list/list", "site/language/one/list"));

        $this->_putInMain('/main/site/languages');
    }

    public function action_save_languages() {
        $this->_sitePageData->url = '/cabinet/site/save_languages';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();

        $options = APPPATH . 'views' . DIRECTORY_SEPARATOR . $this->_shopSiteData->shopShablon->getShablonPath() . DIRECTORY_SEPARATOR;
        if (!file_exists($options)) {
            throw new HTTP_Exception_404('File not found.');
        }

        $languages = Request_RequestParams::getParamArray('languages', array(), array());
        foreach ($languages as $language => $isPublic) {
            $language = intval($language);
            if ($language > 0) {
                $path = $options . $language . DIRECTORY_SEPARATOR;
                if(Request_RequestParams::isBoolean($isPublic)) {
                    if (!file_exists($path)) {
                        if (!Helpers_Path::createPath($path)) {
                            throw new HTTP_Exception_500('Can\'t create path');
                        }
                    }
                }else{
                    if (file_exists($path)) {
                        $this->removeDirectory($path);
                    }
                }
            }
        }

        $this->redirect('/cabinet/site/languages?id=' . Request_RequestParams::getParamInt('id') . '&url=' . Request_RequestParams::getParamStr('url').'&nocache='.rand(1, 10000));
    }

    public function action_html() {
        $this->_sitePageData->url = '/cabinet/site/html';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();
        $this->_readShopLanguageInterface();

        $options = $this->_getOptionList();
        $this->_getViewsSite($options['basic']);

        // считываем HTML
        $html = $this->_getFileHtmlViews('index');
        $header = $body = $footer = '';
        if (!empty($html)) {
            $tmp = strpos($html, '<!-- !@@&body&@@! -->');
            if($tmp > -1){
                $header = substr($html, 0, $tmp);
                $html = substr($html, $tmp + strlen('<!-- !@@&body&@@! -->'));

                $tmp = strpos($html, '<?php echo trim($data[\'view::body\']);?>');
                if($tmp > -1){
                    $body = substr($html, 0, $tmp);
                    $footer = substr($html, $tmp + strlen('<?php echo trim($data[\'view::body\']);?>'));
                }else{
                    $body = $html;
                }
            }
        } else {
            $header = file_get_contents(APPPATH.'views'.DIRECTORY_SEPARATOR.'cabinet'.DIRECTORY_SEPARATOR.'base_header.txt');
            $footer = file_get_contents(APPPATH.'views'.DIRECTORY_SEPARATOR.'cabinet'.DIRECTORY_SEPARATOR.'base_footer.txt');
        }
        $this->_sitePageData->addReplaceAndGlobalDatas('view::header', $header);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::body', $body);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::footer', $footer);

        $this->_getCSSViews();

        // получаем список URL
        $this->_getURLsViews($options['urls']);

        $this->_putInMain('/main/site/html');
    }

    public function action_save_html() {
        $this->_sitePageData->url = '/cabinet/site/save_html';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();
        $this->_readShopLanguageInterface();

        $html = trim(Request_RequestParams::getParamStr('header'))
            .'<!-- !@@&body&@@! -->'
            . trim(Request_RequestParams::getParamStr('body'))
            . '<?php echo trim($data[\'view::body\']);?>'
            . trim(Request_RequestParams::getParamStr('footer'));

        $this->_saveFileHtmlViews('index', $html);

        $this->redirect('/cabinet/site/html?id=' . $this->_shopSiteData->shopID . '&language=' . $this->_shopSiteData->languageID . '&nocache='.rand(1, 10000));
    }

    public function action_url() {
        $this->_sitePageData->url = '/cabinet/site/url';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();
        $this->_readShopLanguageInterface();

        $options = $this->_getOptionList();

        $url = Request_RequestParams::getParamStr('url');
        $url = !empty($url)?'/'.$url:$url;
        $urlData = $this->_getURLData($url, $options);

        $this->_getCSSViews();
        $this->_getURLsViews($options['urls']);
        $this->_getViewsSite($urlData['data']);
        $this->_sitePageData->addReplaceAndGlobalDatas('view::html', $this->_getFileHtmlViews($urlData['main']));

        $this->_putInMain('/main/site/url/one');
    }

    public function action_save_url() {
        $this->_sitePageData->url = '/cabinet/site/save_url';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();
        $this->_readShopLanguageInterface();

        $options = $this->_getOptionList();

        $url = Request_RequestParams::getParamStr('url');
        $url = !empty($url)?'/'.$url:$url;
        $urlData = $this->_getURLData($url, $options);

        $this->_saveFileHtmlViews($urlData['main'], Request_RequestParams::getParamStr('html'));

        $this->redirect('/cabinet/site/url'.
            URL::query(
                array(
                    'id' => $this->_shopSiteData->shopID,
                    'url' => Request_RequestParams::getParamStr('url'),
                    'language' => $this->_shopSiteData->languageID,
                    'nocache' => rand(1, 10000)
                ), FALSE)
        );
    }

    public function action_views() {
        $this->_sitePageData->url = '/cabinet/site/views';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();
        $this->_readShopLanguageInterface();

        $viewAll = $this->_getViewList();
        $this->_getViews($viewAll);

        $options = $this->_getOptionList();

        $url = Request_RequestParams::getParamStr('url');
        $url = !empty($url)?'/'.$url:$url;
        $urlData = $this->_getURLData($url, $options);

        // получаем список вьюшек
        $views = new MyArray();
        foreach ($urlData['data'] as $index => $value) {
            $tmp = $views->addChild(0);
            $tmp->values['index'] = $index;
            $tmp->values['title'] = Arr::path($value, 'title', '');
            $tmp->values['name'] = $value['table'] . '_' . $value['function'];
            $tmp->values['index_title'] = $viewAll[$tmp->values['name']]['title'];
            $tmp->isFindDB = TRUE;
            $tmp->isParseData = FALSE;
        }
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/view/list/index',
            $this->getViewObjects($views, new Model_Basic_LanguageObject(array(), '', 0), "site/view/list/index", "site/view/one/index", 0, FALSE));

        $this->_putInMain('/main/site/view/index');
    }

    public function action_save_views() {
        $this->_sitePageData->url = '/cabinet/site/save_views';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();

        $viewAll = $this->_getViewList();

        $options = $this->_getOptionList();
        $url = Request_RequestParams::getParamStr('url');
        $url = !empty($url)?'/'.$url:$url;
        $urlData = $this->_getURLData($url, $options);
        $urlData = $urlData['data'];

        $views = Request_RequestParams::getParamArray('views', array(), array());
        $originalViews = $views;

        // удаляем и меняем название
        $basic = $urlData;
        foreach($basic as $index => $value){
            if(key_exists($index, $views)){
                $title = Arr::path($views[$index], 'title', '');
                if(!empty($title)) {
                    $urlData[$index]['title'] = $title;
                }

                unset($views[$index]);
            }else{
                unset($urlData[$index]);
            }
        }

        // добавляем
        foreach($views as $index => $view){
            $title = Arr::path($view, 'title', '');
            if (empty($title)) {
                continue;
            }

            $name = Arr::path($view, 'name', '');
            if (!key_exists($name, $viewAll)) {
                continue;
            }

            $tmp = $viewAll[$name];
            $path = DIRECTORY_SEPARATOR . str_replace(' ', '_', str_replace('/', '_', str_replace('\\', '_', Func::get_in_translate_to_en($url.'_'.$title))));

            $arrData  = array(
                'title' => $title,
                'class' => $tmp['class'],
                'table' => $tmp['table'],
                'function' => $tmp['function'],
                'one' => $tmp['table'] . $path,
                'params' => array()
            );

            if(Arr::path($tmp, 'is_one', FALSE) === TRUE) {
                $arrData['list'] = '';
            }else{
                $arrData['list'] = $tmp['table'] . 's' . $path;
            }

            // добавление, если группа
            if(key_exists('groups', $tmp)) {
                $arrGroup = array('one' => $tmp['table'] . DIRECTORY_SEPARATOR . 'group' . $path);
                if (Arr::path($tmp['groups'], 'is_one', FALSE) === TRUE) {
                    $arrGroup['list'] = '';
                } else {
                    $arrGroup['list'] = $tmp['table'] . 's' . DIRECTORY_SEPARATOR . 'group' . $path;
                }
                $arrData['group'] = $arrGroup;
            }

            $urlData[$index] = $arrData;
        }

        // меняем сортировку
        $basic = array();
        foreach($originalViews as $index => $value){
            if(key_exists($index, $urlData)){
                if(intval($index)){
                    $sIndex = $index;
                }else{
                    $sIndex = microtime(TRUE) + count($basic);
                }

                $basic[$sIndex] = $urlData[$index];
            }
        }
        $urlData = $basic;
        $options['urls'][$url]['data'] = $urlData;

        $this->_saveOptionList($options);

        $this->redirect('/cabinet/site/views?id=' . Request_RequestParams::getParamInt('id') . '&url=' . Request_RequestParams::getParamStr('url') . '&language=' . Request_RequestParams::getParamInt('language').'&nocache='.rand(1, 10000));
    }

    public function action_view() {
        $this->_sitePageData->url = '/cabinet/site/view';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();
        $this->_readShopLanguageInterface();

        $options = $this->_getOptionList();

        $url = Request_RequestParams::getParamStr('url');
        $url = !empty($url)?'/'.$url:$url;
        $urlData = $this->_getURLData($url, $options);

        $view = Request_RequestParams::getParamInt('view');
        if (!key_exists($view, $urlData['data'])) {
            throw new HTTP_Exception_500('View not found.');
        }
        $data = $urlData['data'][$view];

        $viewAll = $this->_getViewList();

        $keyFunction = $data['table'] . '_' . $data['function'];
        $this->_getParamsViews($viewAll[$keyFunction]['params'], $data['params']);
        $this->_getFieldsViews($viewAll[$keyFunction]['fields']);
        $this->_getRequestParamTypeViews(Arr::path($data, Request_RequestParams::READ_REQUEST_TYPE_NAME, array()));
        $this->_getFunctionsViews($this->_getViewFunctionList());

        // данные вьюшки
        $viewData = new MyArray();
        $viewData->isFindDB = TRUE;
        $viewData->isParseData = FALSE;
        $viewData->values['tag_list'] = $data['one'];
        $viewData->values['title_view'] = $data['title'];
        $viewData->values['is_one'] = Arr::path($viewAll[$keyFunction], 'is_one', FALSE);
        $viewData->values['list'] = $this->_getFileHtmlViews($data['list']);
        $viewData->values['one'] = $this->_getFileHtmlViews($data['one']);

        $groupsData = Arr::path($viewAll[$keyFunction], 'groups', NULL);
        if($groupsData !== NULL){
            $viewData->values['title_group'] = $groupsData['title'];
        }
        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/view/one/edit',
            $this->getViewObject($viewData, new Model_Basic_LanguageObject(array(), '', 0), "site/view/one/edit", 0, FALSE));

        $this->_putInMain('/main/site/view/edit');
    }

    public function action_save_view() {
        $this->_sitePageData->url = '/cabinet/site/save_view';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();
        $this->_readShopLanguageInterface();

        $options = $this->_getOptionList();

        $url = Request_RequestParams::getParamStr('url');
        $url = !empty($url)?'/'.$url:$url;
        $urlData = $this->_getURLData($url, $options);

        $view = Request_RequestParams::getParamInt('view');
        if (!key_exists($view, $urlData['data'])) {
            throw new HTTP_Exception_500('View not found.');
        }
        $data = $urlData['data'][$view];

        $this->_saveFileHtmlViews($data['list'], Request_RequestParams::getParamStr('list'));
        $this->_saveFileHtmlViews($data['one'], Request_RequestParams::getParamStr('one'));

        $options['urls'][$url]['data'][$view]['params'] = Request_RequestParams::getParamArray('params', array(), array());
        $options['urls'][$url]['data'][$view][Request_RequestParams::READ_REQUEST_TYPE_NAME] = Request_RequestParams::getParamArray(Request_RequestParams::READ_REQUEST_TYPE_NAME, array(), array());

        $this->_saveOptionList($options);

        $this->redirect('/cabinet/site/view?id=' . Request_RequestParams::getParamInt('id') . '&url=' . Request_RequestParams::getParamStr('url') . '&language=' . Request_RequestParams::getParamInt('language') . '&view=' . Request_RequestParams::getParamInt('view').'&nocache='.rand(1, 10000));
    }

    public function action_view_group() {
        $this->_sitePageData->url = '/cabinet/site/view_group';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();
        $this->_readShopLanguageInterface();

        $options = $this->_getOptionList();

        $url = Request_RequestParams::getParamStr('url');
        $url = !empty($url)?'/'.$url:$url;
        $urlData = $this->_getURLData($url, $options);

        $view = Request_RequestParams::getParamInt('view');
        if (!key_exists($view, $urlData['data'])) {
            throw new HTTP_Exception_500('View not found.');
        }
        $data = $urlData['data'][$view];

        $keyFunction = $data['table'] . '_' . $data['function'];
        $data = $data['group'];
        if (!key_exists('params', $data)){
            $data['params'] = array();
        }

        $viewAll = $this->_getViewList();

        $this->_getParamsViews($viewAll[$keyFunction]['params'], $data['params']);
        $this->_getFieldsViews($viewAll[$keyFunction]['fields']);
        $this->_getRequestParamTypeViews(Arr::path($data, Request_RequestParams::READ_REQUEST_TYPE_NAME, array()));
        $this->_getFunctionsViews($this->_getViewFunctionList());

        // данные вьюшки
        $viewData = new MyArray();
        $viewData->isFindDB = TRUE;
        $viewData->isParseData = FALSE;

        $viewData->values['title_root'] = $urlData['data'][$view]['title'];


        $viewData->values['tag_list'] = $data['one'];
        $viewData->values['title_view'] = Arr::path($viewAll[$keyFunction], 'groups.title', NULL);
        $viewData->values['is_one'] = Arr::path($viewAll[$keyFunction], 'is_one', FALSE);
        $viewData->values['list'] = $this->_getFileHtmlViews($data['list']);
        $viewData->values['one'] = $this->_getFileHtmlViews($data['one']);

        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/view/group/one/edit',
            $this->getViewObject($viewData, new Model_Basic_LanguageObject(array(), '', 0), "site/view/group/one/edit", 0, FALSE));

        $this->_putInMain('/main/site/view/group/edit');
    }

    public function action_save_view_group() {
        $this->_sitePageData->url = '/cabinet/site/save_view_group';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();
        $this->_readShopLanguageInterface();

        $options = $this->_getOptionList();

        $url = Request_RequestParams::getParamStr('url');
        $url = !empty($url)?'/'.$url:$url;
        $urlData = $this->_getURLData($url, $options);

        $view = Request_RequestParams::getParamInt('view');
        if (!key_exists($view, $urlData['data'])) {
            throw new HTTP_Exception_500('View not found.');
        }
        $data = $urlData['data'][$view]['group'];

        $this->_saveFileHtmlViews($data['list'], Request_RequestParams::getParamStr('list'));
        $this->_saveFileHtmlViews($data['one'], Request_RequestParams::getParamStr('one'));

        $options['urls'][$url]['data'][$view]['group']['params'] = Request_RequestParams::getParamArray('params', array(), array());
        $options['urls'][$url]['data'][$view]['group'][Request_RequestParams::READ_REQUEST_TYPE_NAME] = Request_RequestParams::getParamArray(Request_RequestParams::READ_REQUEST_TYPE_NAME, array(), array());

        $this->_saveOptionList($options);

        $this->redirect('/cabinet/site/view_group?id=' . Request_RequestParams::getParamInt('id') . '&url=' . Request_RequestParams::getParamStr('url') . '&language=' . Request_RequestParams::getParamInt('language') . '&view=' . Request_RequestParams::getParamInt('view').'&nocache='.rand(1, 10000));
    }










    public function action_index(){

        $this->_sitePageData->url = '/cabinet/site/index';

        // получаем список ID типов оплаты
        $shopID = new MyArray();
        $shopID->id = Request_RequestParams::getParamInt('id');

        $model = new Model_Shop();
        $model->setDBDriver($this->_driverDB);

        if ($shopID->id > 0) {
            if (! $this->getDBObject($model, $shopID->id)) {
                throw new HTTP_Exception_404('Shop is not found.');
            }
            $shopID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopID);
        }

        $shopID->isFindDB = true;

        if ($shopID->id > 0) {
            $shop = $this->getViewObject($shopID, $model, "site/shop-edit", 0, FALSE);
        } else {
            $shop = $this->getViewObject($shopID, $model, "site/shop-new", 0, FALSE);
        }

        // генерируем основную часть
        $view = View::factory('cabinet/' . $this->_sitePageData->languageID . '/main/site/shop-edit');
        $view->data = array();
        $view->data['view::site/shop-edit'] = $shop;
        $view->siteData = $this->_sitePageData;
        $result = Helpers_View::viewToStr($view);

        // добавляем футер и хедер
        $isMain = Request_RequestParams::getParamBoolean('is_main');
        if ($isMain !== TRUE) {
            $result = $this->_putInIndex($result);
        }

        $this->response->body($result);
    }

    public function action_saveshop() {
        $this->_sitePageData->url = '/cabinet/site/saveshop';

        $model = new Model_Shop();

        $id = Request_RequestParams::getParamInt('id');
        if (! $this->dublicateObjectLanguage($model, $id)) {
            throw new HTTP_Exception_500('Shop not found.');
        }

        Request_RequestParams::setParamStr('info_delivery', $model);
        Request_RequestParams::setParamStr('name', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamInt('site_shablon_id', $model);
        Request_RequestParams::setParamInt('default_language_id', $model);
        Request_RequestParams::setParamInt('default_currency_id', $model);
        Request_RequestParams::setParamStr('sub_domain', $model);
        Request_RequestParams::setParamStr('domain', $model);
        Request_RequestParams::setParamStr('info_paid', $model);

        $tmp = Request_RequestParams::getParamArray('currency_ids');
        if (!empty($tmp)) {
            $tmp[] = $model->getDefaultCurrencyID();
            $model->setCurrencyIDs($tmp);
        }

        $tmp = Request_RequestParams::getParamArray('language_ids');
        if (!empty($tmp)) {
            $tmp[] = $model->getDefaultLanguageID();
            $model->setLanguageIDs($tmp);
        }

        $result = array();
        if ($model->validationFields($result)) {
            $mail = '';
            if ($model->id < 1) {
                $mail = Request_RequestParams::getParamStr('mail');
                if ((empty($mail)) && (!empty($model->getSubDomain()))) {
                    $mail = $model->getSubDomain() . '@oto.kz';
                }
            }

            $model->setEditUserID($this->_sitePageData->userID);
            $this->saveDBObject($model);

            if (! $this->getDBObject($model, $model->id)) {
                throw new HTTP_Exception_500('Database error!');
            }

            if ($model->getSiteShablonID() < 1) {
                $templatePath = $this->createPath($model->id);

                $modelShablon = new Model_SiteShablon();
                $modelShablon->setDBDriver($this->_driverDB);

                $modelShablon->setName($model->getName());
                $modelShablon->setShablonPath($templatePath);
                $modelShablon->setEditUserID($this->_sitePageData->userID);
                $this->saveDBObject($modelShablon);

                $model->setSiteShablonID($modelShablon->id);
                $this->saveDBObject($model);
            }

            // создаем пользователя для редактирования данных о магазине
            if(! empty($mail)){
                $password = Auth::instance()->hashPassword($model->getSubDomain());

                $modelShopUser = new Model_User();
                $modelShopUser->setDBDriver($this->_driverDB);

                $modelShopUser->setPassword($password);
                $modelShopUser->setEMail($mail);
                $modelShopUser->setName($model->getName());

                $modelShopUser->setEditUserID($this->_sitePageData->userID);
                $this->saveDBObject($modelShopUser);


                $modelShopOperation = new Model_Shop_Operation();
                $modelShopOperation->setDBDriver($this->_driverDB);

                $modelShopOperation->setPassword($password);
                $modelShopOperation->setEMail($mail);
                $modelShopOperation->setName($model->getName());
                $modelShopOperation->setUserID($modelShopUser->id);

                $modelShopOperation->setEditUserID($this->_sitePageData->userID);
                $this->saveDBObject($modelShopOperation);
            }

            $filePath = Request_RequestParams::getParamStr('image');
            if (!empty($filePath)) {
                $file = new Model_File($this->_sitePageData);
                $tmp = $file->saveImage($filePath, $model->id, Model_Shop::TABLE_ID, $this->_sitePageData);
                if (!empty($tmp)) {
                    $model->setImagePath($tmp);
                    $this->saveDBObject($model);

                    $result['values'] = $model->getValues();
                }
            }

            $result['values'] = $model->getValues();
        }

        $fileName = Request_RequestParams::getParamStr('file');
        if (!empty($fileName)) {
                $file = new Model_File($this->_sitePageData);
                $model->setImagePath($file->saveImage(DOCROOT . $fileName, $model->id, Model_Shop::TABLE_ID, $this->_sitePageData));
                $this->saveDBObject($model);
                $result['values'] = $model->getValues();
        }
        $this->redirect('/cabinet/site/css?id=' . $model->id);
    }

    /**
     * Создание путей (каталогов) для магазина
     * @param $shopId
     * @throws HTTP_Exception_500
     */
    private function createPath($shopId) {
        $templatePath = date('Y') . '/' .       // year
            date('m') . '/' .       // month
            date('d') . '/' .       // day
            $shopId;

        $viewPath = APPPATH .                               // application
            'views' . '/' .         // views
            $templatePath . '/';

        $cssPath = DOCROOT .                               // oto.flo
            'css' . '/' .           // css
            $templatePath . '/';

        if (!Helpers_Path::createPath($viewPath)) {
            throw new HTTP_Exception_500('Can\'t create path');
        }

        if (!Helpers_Path::createPath($cssPath)) {
            throw new HTTP_Exception_500('Can\'t create path');
        }

        // options.php
        $optionsPath = $viewPath . 'options.php';

        $s = '<?php' . "\r\n" . '$site_basic_options = ' . Helpers_Array::arrayToStrPHP(array()) . ';' . "\r\n" . '$site_options = ' . Helpers_Array::arrayToStrPHP(array()) . ';';

        $file = fopen($optionsPath, 'w');
        fwrite($file, $s);
        fclose($file);
        chmod($optionsPath, 0777);

        return $templatePath;
    }

    // Uploader
    public function action_upload() {
        if ($_FILES['filename']['size'] > 1024 * 50 * 1024) {
            echo('Размер файла превышает сто мегабайта');
            exit;
        }
        // Проверяем загружен ли файл
        if (is_uploaded_file($_FILES['filename']['tmp_name'])) {
            // Если файл загружен успешно, перемещаем его из временной директории в конечную
            if (move_uploaded_file($_FILES['filename']['tmp_name'], 'uploads' . DIRECTORY_SEPARATOR . $_FILES['filename']['name'])) {
                echo 'Файл загружен успешно!';
            } else {
                echo 'Ошибка при перемещении файла';
            }
        } else {
            echo('Ошибка загрузки файла');
        }
    }

    public function action_loadcss() {
        if (isset($_FILES['filename'])) {
            $model = new Model_Shop();
            $model->setDBDriver($this->_driverDB);

            $shopId = Request_RequestParams::getParamInt('id');

            if (! $this->getDBObject($model, $shopId)) {
                throw new HTTP_Exception_404('Shop is not found.');
            }

            $modelSiteShablon = new Model_SiteShablon();
            $modelSiteShablon->setDBDriver($this->_driverDB);

            if (! $this->getDBObject($modelSiteShablon, $model->getSiteShablonID())) {
                throw new HTTP_Exception_404('SiteShablonId is not found.');
            }

            // Берем путь магазина
            $dir = DOCROOT . 'css' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR;

            /*Создаем путь к стилям*/
            if (!file_exists($dir)) {
                if (!Helpers_Path::createPath($dir)) {
                    throw new HTTP_Exception_500('Path is not created!');
                }
            }

            // Создаем временный каталог tmp
            $dir = DOCROOT . 'css' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath();
            chmod($dir, 0777);

            // Копируем файл из tmp в css
            $filename = $_FILES['filename']['tmp_name'];

            $zip = new ZipArchive();
            $zip->open($filename);
            $zip->extractTo($dir);
            $zip->close();
            unlink($filename);
        }
        $this->redirect('/cabinet/site/css?id=' . Request_RequestParams::getParamInt('id'));
    }

    public function action_css()
    {
        $this->_sitePageData->url = '/cabinet/site/css';

        // получаем список ID типов оплаты
        $shopID = new MyArray();
        $shopID->id = Request_RequestParams::getParamInt('id');

        $model = new Model_Shop();
        $model->setDBDriver($this->_driverDB);

        if ($shopID->id > 0) {
            if (! $this->getDBObject($model, $shopID->id)) {
                throw new HTTP_Exception_404('Shop is not found.');
            }
            $shopID->values = $model->getValues(TRUE, TRUE, $this->_sitePageData->shopID);
        }

        $shopID->isFindDB = true;

        $modelSiteShablon = new Model_SiteShablon();
        $modelSiteShablon->setDBDriver($this->_driverDB);

        if (! $this->getDBObject($modelSiteShablon, $model->getSiteShablonID())) {
            throw new HTTP_Exception_404('SiteShablonId is not found.');
        }

        // список каталогов и файлов css
        $tmpDir = DOCROOT . 'css' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR;
        $path = $this->getpath($tmpDir, $tmpDir);
        $path->values['is_directory'] = true;
        $paths = $this->getViewObjects($path, $model, "site/paths", "site/path", 0, FALSE);

        // генерируем основную часть
        $view = View::factory('cabinet/' . $this->_sitePageData->languageID . '/main/site/css');
        $view->data = array();
        $view->data['view::site/paths'] = $paths;
        $view->siteData = $this->_sitePageData;
        $result = Helpers_View::viewToStr($view);

        // добавляем футер и хедер
        $isMain = Request_RequestParams::getParamBoolean('is_main');
        if ($isMain !== TRUE) {
            $result = $this->_putInIndex($result);
        }

        $this->response->body($result);
    }

    public function action_cleardir() {

        $model = new Model_Shop();
        $model->setDBDriver($this->_driverDB);

        $shopId = Request_RequestParams::getParamInt('id');

        if (! $this->getDBObject($model, $shopId)) {
            throw new HTTP_Exception_404('Shop is not found.');
        }

        $modelSiteShablon = new Model_SiteShablon();
        $modelSiteShablon->setDBDriver($this->_driverDB);

        if (! $this->getDBObject($modelSiteShablon, $model->getSiteShablonID())) {
            throw new HTTP_Exception_404('SiteShablonId is not found.');
        }

        $dir = DOCROOT . 'css' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath();
        $this->removeDirectory($dir);
        $this->redirect('/cabinet/site/css?id=' . Request_RequestParams::getParamInt('id'));
    }



    public function action_deletedir() {
        $directory = Request_RequestParams::getParamStr('directory');
        if (strpos($directory, '/./') > 0 || strpos($directory, '/../')) {
            throw new HTTP_Exception_500('Path is not correct!');
        }

        $model = new Model_Shop();
        $model->setDBDriver($this->_driverDB);

        $shopId = Request_RequestParams::getParamInt('id');

        if (! $this->getDBObject($model, $shopId)) {
            throw new HTTP_Exception_404('Shop is not found.');
        }

        $modelSiteShablon = new Model_SiteShablon();
        $modelSiteShablon->setDBDriver($this->_driverDB);

        if (! $this->getDBObject($modelSiteShablon, $model->getSiteShablonID())) {
            throw new HTTP_Exception_404('SiteShablonId is not found.');
        }

        $dir = DOCROOT . 'css' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . $directory;

        if (file_exists($dir)) {
            $this->removeDirectory($dir);
        }
        $this->redirect('/cabinet/site/css?id=' . Request_RequestParams::getParamInt('id'));
    }

    public function action_deletefile() {
        $filePath = Request_RequestParams::getParamStr('filename');
        if (strpos($filePath, '/./') > 0 || strpos($filePath, '/../')) {
            throw new HTTP_Exception_500('Path is not correct!');
        }

        $model = new Model_Shop();
        $model->setDBDriver($this->_driverDB);

        $shopId = Request_RequestParams::getParamInt('id');

        if (! $this->getDBObject($model, $shopId)) {
            throw new HTTP_Exception_404('Shop is not found.');
        }

        $modelSiteShablon = new Model_SiteShablon();
        $modelSiteShablon->setDBDriver($this->_driverDB);

        if (! $this->getDBObject($modelSiteShablon, $model->getSiteShablonID())) {
            throw new HTTP_Exception_404('SiteShablonId is not found.');
        }

        $filePath = DOCROOT . 'css' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . $filePath;
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $this->redirect('/cabinet/site/css?id=' . Request_RequestParams::getParamInt('id'));
    }

    public function action_downloadfile() {
        $filePath = Request_RequestParams::getParamStr('filename');
        $destination = $filePath;

        if (strpos($filePath, '/./') > 0 || strpos($filePath, '/../')) {
            throw new HTTP_Exception_500('Path is not correct!');
        }

        $model = new Model_Shop();
        $model->setDBDriver($this->_driverDB);

        $shopId = Request_RequestParams::getParamInt('id');

        if (! $this->getDBObject($model, $shopId)) {
            throw new HTTP_Exception_404('Shop is not found.');
        }

        $modelSiteShablon = new Model_SiteShablon();
        $modelSiteShablon->setDBDriver($this->_driverDB);

        if (! $this->getDBObject($modelSiteShablon, $model->getSiteShablonID())) {
            throw new HTTP_Exception_404('SiteShablonId is not found.');
        }

        $filePath = DOCROOT . 'css' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . $filePath;
        if (!file_exists($filePath)) {
            throw new HTTP_Exception_404('File or directory is not found.');
        }

        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            throw new HTTP_Exception_500('Can\'t create zip archive!');
        }

        $source = str_replace('\\', '/', realpath($filePath));

        if (is_dir($source) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file) {
                $file = str_replace('\\', '/', $file);

                // Ignore "." and ".." folders
                if (in_array(substr($file, strrpos($file, '/') + 1), array('.', '..'))) continue;

                $file = realpath($file);
                $file = str_replace('\\', '/', $file);

                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                } else if (is_file($file) === true) {
                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                }
            }
        } else if (is_file($source) === true) {
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        $zip->close();

        $this->redirect('/cabinet/site/css?id=' . Request_RequestParams::getParamInt('id'));
    }


    public function action_static_view_group() {
        $this->_sitePageData->url = '/cabinet/site/static_view_group';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();
        $this->_readShopLanguageInterface();

        $options = $this->_getOptionList();
        $urlData = $options['basic'];

        $view = Request_RequestParams::getParamInt('view');
        if (!key_exists($view, $urlData)) {
            throw new HTTP_Exception_500('View not found.');
        }
        $data = $urlData[$view];

        $keyFunction = $data['table'] . '_' . $data['function'];
        $data = $data['group'];
        if (!key_exists('params', $data)){
            $data['params'] = array();
        }

        $viewAll = $this->_getViewList();

        $this->_getParamsViews($viewAll[$keyFunction]['params'], $data['params']);
        $this->_getFieldsViews($viewAll[$keyFunction]['fields']);
        $this->_getRequestParamTypeViews(Arr::path($data, Request_RequestParams::READ_REQUEST_TYPE_NAME, array()));
        $this->_getFunctionsViews($this->_getViewFunctionList());

        // данные вьюшки
        $viewData = new MyArray();
        $viewData->isFindDB = TRUE;
        $viewData->isParseData = FALSE;

        $viewData->values['title_root'] = $urlData[$view]['title'];


        $viewData->values['tag_list'] = $data['one'];
        $viewData->values['title_view'] = Arr::path($viewAll[$keyFunction], 'groups.title', NULL);
        $viewData->values['is_one'] = Arr::path($viewAll[$keyFunction], 'is_one', FALSE);
        $viewData->values['list'] = $this->_getFileHtmlViews($data['list']);
        $viewData->values['one'] = $this->_getFileHtmlViews($data['one']);

        $this->_sitePageData->addReplaceAndGlobalDatas('view::site/view/static/group/one/edit',
            $this->getViewObject($viewData, new Model_Basic_LanguageObject(array(), '', 0), "site/view/static/group/one/edit", 0, FALSE));

        $this->_putInMain('/main/site/view/static/group/edit');
    }

    public function action_save_static_view_group() {
        $this->_sitePageData->url = '/cabinet/site/save_static_view_group';

        $this->_shopSiteData = new SitePageData();
        $this->_readShopSiteInterface();
        $this->_readShopSiteShablonInterface();
        $this->_readShopLanguageInterface();

        $options = $this->_getOptionList();
        $urlData = $options['basic'];

        $view = Request_RequestParams::getParamInt('view');
        if (!key_exists($view, $urlData)) {
            throw new HTTP_Exception_500('View not found.');
        }
        $data = $urlData[$view]['group'];

        $this->_saveFileHtmlViews($data['list'], Request_RequestParams::getParamStr('list'));
        $this->_saveFileHtmlViews($data['one'], Request_RequestParams::getParamStr('one'));

        $options['basic'][$view]['group']['params'] = Request_RequestParams::getParamArray('params', array(), array());
        $options['basic'][$view]['group'][Request_RequestParams::READ_REQUEST_TYPE_NAME] = Request_RequestParams::getParamArray(Request_RequestParams::READ_REQUEST_TYPE_NAME, array(), array());

        $this->_saveOptionList($options);

        $this->redirect('/cabinet/site/static_view_group?id=' . Request_RequestParams::getParamInt('id') . '&url=' . Request_RequestParams::getParamStr('url') . '&language=' . Request_RequestParams::getParamInt('language') . '&view=' . Request_RequestParams::getParamInt('view').'&nocache='.rand(1, 10000));
    }







    public function action_clientdata()
    {
        $this->_sitePageData->url = '/cabinet/site/clientdata';

        $tmp = Request_RequestParams::getParamInt('id');

        // получаем магазин
        $modelShop = new Model_Shop();
        $modelShop->setDBDriver($this->_driverDB);
        if (! $this->getDBObject($modelShop, $tmp)) {
            throw new HTTP_Exception_500('Shop not found.');
        }

        // получаем шаблон магазина
        $modelSiteShablon = new Model_SiteShablon();
        $modelSiteShablon->setDBDriver($this->_driverDB);
        if (! $this->getDBObject($modelSiteShablon, $modelShop->getSiteShablonID())) {
            throw new HTTP_Exception_500('Shablon not found.');
        }

        $options = APPPATH . 'views' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . 'options.php';
        if (!file_exists($options)) {
            throw new HTTP_Exception_500('File not found.');
        }
        include_once $options;

        $urls = new MyArray();

        $arr = array();
        foreach ($site_basic_options as $value) {
            $arr[] = array('title' => $value['title']);
        }
        if (count($arr) > 0) {
            $tmp = $urls->addChild(0);
            $tmp->values = array(
                'url' => '',
                'url_title' => '',
                'views' => $arr,
            );
            $tmp->isFindDB = TRUE;
            $tmp->isParseData = FALSE;
        }

        foreach ($site_options as $url => $data) {

            $arr = array();
            foreach ($data['data'] as $value) {
                $arr[] = array('title' => $value['title']);
            }
            if (count($arr) > 0) {
                $tmp = $urls->addChild(0);
                $tmp->values = array(
                    'url' => $url,
                    'url_title' => $data['title'],
                    'views' => $arr,
                );
                $tmp->isFindDB = TRUE;
                $tmp->isParseData = FALSE;
            }
        }

        $model = new Model_Basic_LanguageObject(array(), '', 0);
        $shop = $this->getViewObjects($urls, $model, "site/client-datas", "site/client-data", 0, FALSE);

        // генерируем основную часть
        $view = View::factory('cabinet/' . $this->_sitePageData->languageID . '/main/site/client-data');
        $view->data = array();
        $view->data['view::site/client-datas'] = $shop;
        $view->siteData = $this->_sitePageData;
        $result = Helpers_View::viewToStr($view);

        // добавляем футер и хедер
        $isMain = Request_RequestParams::getParamBoolean('is_main');
        if ($isMain !== TRUE) {
            $result = $this->_putInIndex($result);
        }

        $this->response->body($result);
    }


}

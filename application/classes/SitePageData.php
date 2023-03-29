<?php defined('SYSPATH') or die('No direct script access.');

class SitePageData {
    /**
     * ID интерфейса
     * @var int
     */
    public $interfaceID = 0;

    // название контролера
    public $controllerName = '';
    public $actionURLName = 'cabinet';

	// настройки шаблона
	// Model_SiteShablonCatalog
	public $shopShablonPath = 'mgadmin';
    private $shopShablonPathOld = 'mgadmin';

    /**
     * @var Model_SiteShablon
     */
	public $shopShablon = NULL;
	public $shopShablonOptions = array();

	
	// Объект пользователя
	public $userID = 0;
    /**
     * @var Model_User
     */
	public $user = NULL;

	// Объект оператора
	public $operationID = 0;
    /**
     * @var Model_Shop_Operation | Model_Ab1_Shop_Operation | Model_AutoPart_Shop_Operation
     */
	public $operation = NULL;

	// Объект администратора
	// тип объекта Model_SuperUser
	public $superUserID = 0;
	public $superUser = NULL;

	// данные о валюте отображения
	public $currencyID;
    /**
     * @var Model_Currency
     */
	public $currency;

	// данные о языке отображения интерфейса

	public $languageID;
    /**
     * @var Model_Language
     */
	public $language = NULL;
	public $languageIDDefault = Model_Language::LANGUAGE_RUSSIAN;

	// данные о языке отображения данных
    /**
     * @var int
     */
	public $dataLanguageID;
    /**
     * @var Model_Language
     */
	public $dataLanguage = NULL;

	// данные о магазине
	public $shopID = 0;
    /**
     * @var Model_Shop
     */
	public $shop = NULL;

	// данные о магазине (основной)
	public $shopMainID = 0;
    /**
     * @var Model_Shop
     */
	public $shopMain = NULL;

	// данные о магазине (родители)
	// Model_Shop_
	public $shopRootID = 0;
	public $shopRoot = NULL;

	// данные о магазине авторизированного пользователя
	// Model_Shop_
	public $userShopID = 0;
	public $userShop = NULL;
	
	// данные о городе
	public $cityID = 0;
    /**
     * @var null | Model_City
     */
	public $city = NULL;

	// данные о стране
	public $landID = 0;
    /**
     * @var null | Model_Land
     */
	public $land = NULL;

	// базовый URL
	public $urlBasic = 'http://oto.flo';
    public $scheme= 'http://';

    public $urlBasicLanguage = 'http://oto.flo/ru';
	
	// основная часть URL
	public $url = '';
	
	// каноническая ссылка 
	public $urlCanonical = '';

	// параметры для URL
	public $urlParams = array();

    // СЕО URL
    public $urlSEO = '';
	
	// базовые параметры для URL
	public $urlBasicParams = array();
	
	// для мета тегов rel="next" и rel="prev"
	public $page = -1;
	public $pages = -1;
	public $limit = -1;
	public $limitPage = -1;
	public $countRecord = 0;
	
	// необходима ли индексация страницы поисковыми системами
	public $isIndexRobots = FALSE;
	
	// Описание сайта
	public $siteDescription = '';
	
	// ключевые слова для сайта
	public $siteKeywords = '';

	// Заголовок сайта
	public $siteTitle = '';

	// Картинка для социальных сетей
	public $siteImage = '';
	
	// иконка для сайта
	// array | string
	// array('114x114' => 'путь')
	public $favicon = '';
	
	// id филиала
	// Model_Shop_
	public $branchID = 0;
    /**
     * @var Model_Shop
     */
	public $branch = NULL;
	
	// глобальные данные
	public $globalDatas = array();
	
	// замена данных в итоговом файле
	public $replaceDatas = array();

	// добавления метатегов на страницу сайта
	public $meta = '';

	// действие
	public $action = '';
	
	public function __construct(){
	    if (key_exists('REQUEST_SCHEME', $_SERVER)){
            $this->scheme = $_SERVER['REQUEST_SCHEME'].'://';
        }elseif ((key_exists('HTTPS', $_SERVER)) && ($_SERVER['HTTPS'] == 'on')){
            $this->scheme = 'https://';
        }

		$this->urlBasic = $this->scheme.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME']));
        $this->urlBasicLanguage = $this->urlBasic;
	}

	function getPageOptions(){
	    return [
            'page' => $this->page,
            'pages' => $this->pages,
            'limit' => $this->limit,
            'limitPage' => $this->limitPage,
            'countRecord' => $this->countRecord,
        ];
    }

    function setPageOptions(array $options){
        $this->page = intval(Arr::path($options, 'page', $this->page));
        $this->pages = intval(Arr::path($options, 'pages', $this->pages));
        $this->limit = intval(Arr::path($options, 'limit', $this->limit));
        $this->limitPage = intval(Arr::path($options, 'limitPage', $this->limitPage));
        $this->countRecord = intval(Arr::path($options, 'countRecord', $this->countRecord));
    }

    /**
     * Текущая ссылка
     * @return string
     */
    public function getCurrentURL(){
        $url = explode('?', $_SERVER['REQUEST_URI']);
        return $this->urlBasic . $url[0];
    }

    /**
     * Новый шаблон
     * @param $shopShablonPath
     */
    public function newShopShablonPath($shopShablonPath){
        $this->shopShablonPathOld = $this->shopShablonPath;
        if(!empty($shopShablonPath)) {
            $this->shopShablonPath = $shopShablonPath;
        }
    }

    /**
     * Предыдущий шаблон
     */
    public function previousShopShablonPath(){
        if(!empty($this->shopShablonPathOld)) {
            $this->shopShablonPath = $this->shopShablonPathOld;
        }
    }

    /**
     * Заполняется данными в конце, определяем переменную для заполнения
     * @param string $path
     * @param null $caseType - тип регистра
     * @return string
     */
    const CASE_FIRST_LETTER_UPPER = 1; // первая буква большая

    /**
     * @return mixed
     */
    public function getSiteName(){
        $result = str_replace('http://', '', str_replace('https://', '', $this->urlBasic));

        $n = strpos($result, '/');
        if($n !== FALSE){
            $result = substr($result, 0, $n);
        }

        return $result;
    }

    /**
     * @param $path
     * @param null | int $caseType
     * @return string
     */
	public static function setPathReplace($path, $caseType = NULL){
        switch($caseType){
            case self::CASE_FIRST_LETTER_UPPER:
                $path = $path.'_'.$caseType;
                break;
        }

        if(strpos($path, 'view::') === FALSE) {
            return '^#@view::' . $path . '@#^';
        }else{
            return '^#@' . $path . '@#^';
        }

	}

    /**
     * Заменяем переменные данными
     * @param string $prefix
     * @param array $replaceDatas
     * @param string $data
     * @return bool
     */
    private function _replaceStaticDatas($prefix, array $replaceDatas, &$data){
        $isReplace = FALSE;
        foreach ($replaceDatas as $key => $param) {

            if(is_array($param)){
                $isReplace = $this->_replaceStaticDatas($prefix.$key.'.', $param, $data) || $isReplace;
            }else {
                if(strpos($prefix.$key, '.') === FALSE){
                    $caseFinish = 0;
                }else{
                    $caseFinish = 1;
                }

                // перебираем все возможные регистры
                for ($caseType = 0; $caseType <= $caseFinish; $caseType++) {
                    $tmp = self::setPathReplace($prefix . $key, $caseType);
                    switch($caseType){
                        case self::CASE_FIRST_LETTER_UPPER:
                            $s = Func::mb_ucfirst($param);
                            break;
                        default:
                            $s = $param;
                    }

                    $isReplace = $isReplace || strpos($data, $tmp) > -1;
                    try {
                        $data = str_replace($tmp, $s, $data);
                    } catch (Exception $e) {
                        echo $tmp.'='. $s;
                        die;
                    }
                }
            }
        }

        return $isReplace;
    }

    /**
     * Заменяем переменные данными
     * @param string $data
     * @return string
     */
    public function replaceStaticDatas($data){
        for ($i = 0; $i < 5; $i++) {
            if($this->_replaceStaticDatas('', $this->replaceDatas, $data) === FALSE){
                break;
            }
        }
        return $data;
    }

    /**
     * Добавляет значение в $globalDatas
     * @param array $keys
     */
    public function addKeysInGlobalDatas(array $keys){
        foreach ($keys as $key){
            $this->addKeyInGlobalDatas($key);
        }
    }

    public function addKeyInGlobalDatas($key){
        if(strpos($key, 'view::') === FALSE) {
            $key = 'view::' . $key;
        }
        $value = SitePageData::setPathReplace($key);

        $this->globalDatas[$key] = $value;
        if(!key_exists($key, $this->replaceDatas)) {
            $this->replaceDatas[$key] = '';
        }
    }

    /**
     * Добавляет значение в $replaceDatas
     * @param $key
     * @param $value
     */
    public function addReplaceDatas($key, $value){
        $this->replaceDatas[$key] = $value;
    }

    /**
     * Добавляет значение в $globalDatas и $replaceDatas
     * @param $key
     * @param $value
     */
    public function addReplaceAndGlobalDatas($key, $value){
        $this->replaceDatas[$key] = $value;
        $this->globalDatas[$key] = self::setPathReplace($key);
    }
}

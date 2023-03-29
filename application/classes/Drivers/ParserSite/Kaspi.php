<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_Kaspi {

    /**
     * Получаем массив настроек для подключения к kaspi.kz кабинете
     * @param $shopCompanyID
     * @return mixed
     * @throws HTTP_Exception_500
     */
    public static function getConnectionOptions($shopCompanyID)
    {
        $shopCompanyID = intval($shopCompanyID);

        $file = Helpers_Path::getPathFile(APPPATH, ['config', 'kaspi'], 'companies.php');

        if ($shopCompanyID == 0 || !file_exists($file)) {
            $result = include Helpers_Path::getPathFile(APPPATH, ['config', 'kaspi'], 'merchantcabinet.php');
        } else {
            $companies = include $file;
            $result = Arr::path($companies, $shopCompanyID, []);
        }

        if(empty($result)){
            throw new HTTP_Exception_500('Connection options kaspi.kz not found.');
        }

        return $result;
    }

    /**
     * Получаем массив рубрик с процентами
     * https://kaspi.kz/merchantcabinet/support/pages/viewpage.action?pageId=8912971
     * @return array
     */
    public static function getRubricPercent(){
        $str = Helpers_URL::getDataURLEmulationBrowser('https://kaspi.kz/merchantcabinet/support/pages/viewpage.action?pageId=8912971');

        $rubrics = [];

        preg_match_all('/<tr>[\W\w]+<\/tr>/U', $str, $matches);
        unset($matches[0][0]);
        foreach ($matches[0] as $tr){
            preg_match_all('/<td.*>(.+)<\/td>/U', $tr, $result);
            if(count($result) != 2 || count($result[1]) < 4){
                continue;
            }

            $rubrics[strip_tags($result[1][0])][strip_tags($result[1][1])][strip_tags($result[1][2])] = str_replace('%', '', strip_tags($result[1][4]));
        }

        return $rubrics;
    }

    /**
     * Авторизация в личном кабинете
     * Возвращает соедение для запроса и настройки подключения
     * https://kaspi.kz/merchantcabinet
     * @param $shopCompanyID
     * @param array $options
     * @return resource
     */
    public static function authMerchantСabinet($shopCompanyID, array &$options)
    {
        $fileName = 'cookie_'.random_int(1, 999999).'.txt';

        Helpers_File::saveInLogs($fileName, '', ['cookies']);
        $opt = array(
            CURLOPT_ENCODING => 'gzip',
            CURLOPT_COOKIE => '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_HEADER => false,
            CURLOPT_COOKIESESSION => true,
            CURLOPT_COOKIEFILE => APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'cookies' . DIRECTORY_SEPARATOR . $fileName,
            CURLOPT_REFERER => null,
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36",
            CURLOPT_TIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYPEER => FALSE,
        );

        $cs = curl_init();

        // ************** Авторизация **************//
        $params = Drivers_ParserSite_Kaspi::getConnectionOptions($shopCompanyID);

        $paramsStr = URL::query($params, false);
        $paramsStr = substr($paramsStr, 1);

        $options = $opt;
        $options[CURLOPT_POST] = TRUE;
        $options[CURLOPT_URL] = 'https://kaspi.kz/merchantcabinet/login.do';
        $options[CURLOPT_POSTFIELDS] = $paramsStr;
        curl_setopt_array($cs, $options);
        curl_exec($cs);

        $options = $opt;
        return $cs;
    }

    /**
     * Новая авторизация
     * Авторизация в личном кабинете
     * Возвращает соедение для запроса и настройки подключения
     * https://kaspi.kz/merchantcabinet
     * @param $shopCompanyID
     * @return \Curl\Curl
     * @throws HTTP_Exception_500
     */
    public static function authMerchantСabinetV2($shopCompanyID)
    {
        require_once Helpers_Path::getPathFile(APPPATH, ['vendor', 'Curl'], 'autoload.php');

        // ************** Авторизация **************//
        $params = Drivers_ParserSite_Kaspi::getConnectionOptions($shopCompanyID);

        $curl = new Curl\Curl();
        $curl->setOpts(
            array(
                CURLOPT_ENCODING => 'gzip',
                CURLOPT_COOKIE => '',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_AUTOREFERER => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_COOKIESESSION => true,
                CURLOPT_REFERER => null,
                CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:94.0) Gecko/20100101 Firefox/94.0",
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_SSL_VERIFYPEER => FALSE,
            )
        );
        $curl->post('https://kaspi.kz/authorizationserver/oauth/token'
            . URL::query(
                [
                    'client_id' => 'merchantcabinet',
                    'client_secret' => 'secret',
                    'grant_type' => 'password',
                    'username' => $params['username'],
                    'password' => $params['password'],
                ],
                false
            )
        );

        if ($curl->error) {
            throw new HTTP_Exception_500('Kaspi.kz error ' . $curl->errorCode . ': ' . $curl->errorMessage);
        }

        $curl->setCookies($curl->getResponseCookies());
        $curl->setHeader('Authorization', $curl->response->token_type . ' ' . $curl->response->access_token);
        $curl->get('https://kaspi.kz/merchantcabinet/api/su/info');

        if ($curl->error) {
            throw new HTTP_Exception_500('Kaspi.kz error ' . $curl->errorCode . ': ' . $curl->errorMessage);
        }

        return $curl;
    }

    /**
     * Получаем значение важной куки ks.tck
     * @param $a
     * @param $b
     * @param $c
     * @return string
     */
    private static function getCookieKsTckValue($a, $b, $c){
        $path = Helpers_Path::getPathFile(APPPATH, ['classes', 'Drivers', 'Bank', 'Kaspi']);
        include_once $path . 'aes_small.php';
        include_once $path . 'cryptoHelpers.php';

        $a = cryptoHelpers::toNumbers($a);
        $b = cryptoHelpers::toNumbers($b);
        $c = cryptoHelpers::toNumbers($c);

        return cryptoHelpers::toHex(
            AES::decrypt($c, 32, AES::modeOfOperation_CBC, $a, count($a), $b)
        );
    }

    /**
     * Получаем значение важной куки ks.tck из HTML страницы сайта
     * @param $html
     * @return bool|string
     */
    private static function getCookieKsTckByHTML($html){

        $getParam = function ($field, $html){
            $position = strpos($html, $field. ' = toNumbers("');
            if($position === false){
                return false;
            }
            $html = substr($html, $position + strlen($field. ' = toNumbers("'));

            $position = strpos($html, '")');
            if($position === false){
                return false;
            }
            return substr($html, 0, $position);
        };

        $a = $getParam('a', $html);
        if($a === false){
            return false;
        }

        $b = $getParam('b', $html);
        if($a === false){
            return false;
        }

        $c = $getParam('c', $html);
        if($a === false){
            return false;
        }

        return self::getCookieKsTckValue($a, $b, $c);
    }

    /**
     * Получаем значение куки для работы с сайтом
     * @param $url
     * @param string $proxy
     * @return bool|string
     * @throws HTTP_Exception_500
     */
    public static function getCookieKsTck($url, $proxy = '')
    {
        $cs = curl_init();
        $opt = array(
            CURLOPT_URL => $url,
            CURLOPT_ENCODING => 'gzip',
            CURLOPT_COOKIE => '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_COOKIESESSION => true,
            CURLOPT_REFERER => null,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0',
            CURLOPT_TIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_PROXY => $proxy,
        );

        curl_setopt_array($cs, $opt);
        $result = curl_exec($cs);

        if(empty($result)){
            throw new HTTP_Exception_500('Kaspi.kz вернул пустую страницу.');
        }

        if(mb_strpos($result, 'Что-то пошло не так.') !== false){
            throw new HTTP_Exception_500('Kaspi.kz нас заблокировал по ip-адресу. :( Будем надеяться не надолго.');
        }

        $ksTck = self::getCookieKsTckByHTML($result);
        if ($ksTck === false) {
            return false;
        }

        return 'ks.tck=' . $ksTck;
    }

    /**
     * Получение данных продукта сайта по ссылке с эмуляцией заголовков браузера
     * @param $url
     * @param string $cookie
     * @param string $proxy
     * @param string $user
     * @param string $password
     * @param $urlEditIP
     * @param int $timeout
     * @return bool|mixed
     * @throws Drivers_ParserSite_Kaspi_Exception
     * @throws HTTP_Exception_500
     */
    public static function getPageHTMLProduct($url, &$cookie = '', $proxy = '', $user = '', $password = '', $urlEditIP, $proxyType = 0, $timeout = 10)
    {
        $cs = curl_init();

        // zenscrape.com
        if($proxyType == 1) {
            $data = [
                "url" => $url,
            ];

            $opt = array(
                CURLOPT_URL => "https://app.zenscrape.com/api/v1/get?" . http_build_query($data),
                CURLOPT_NOBODY => false,
                CURLOPT_ENCODING => 'gzip',
                CURLOPT_COOKIE => $cookie,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_COOKIESESSION => true,
                CURLOPT_REFERER => null,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0',
                CURLOPT_TIMEOUT => $timeout,
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_SSL_VERIFYPEER => FALSE,
                CURLOPT_SSL_VERIFYHOST => FALSE,
                CURLOPT_CONNECTTIMEOUT => $timeout,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "apikey: 11322900-ff35-11eb-8110-f7a886bfffde"
                )
            );
        }else {
            if (!empty($urlEditIP)) {
                file_get_contents($urlEditIP);
            }

            $cs = curl_init();
            $opt = array(
                CURLOPT_URL => $url,
                CURLOPT_NOBODY => false,
                CURLOPT_ENCODING => 'gzip',
                CURLOPT_COOKIE => $cookie,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_COOKIESESSION => true,
                CURLOPT_REFERER => null,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0',
                CURLOPT_TIMEOUT => $timeout,
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_SSL_VERIFYPEER => FALSE,
                CURLOPT_SSL_VERIFYHOST => FALSE,
                CURLOPT_PROXY => $proxy,
                CURLOPT_CONNECTTIMEOUT => $timeout,
                CURLOPT_PROXYUSERPWD => $user . ':' . $password,
            );
        }

        curl_setopt_array($cs, $opt);
        $result = curl_exec($cs);

        if(empty($result)){
            throw new Drivers_ParserSite_Kaspi_Exception('Kaspi.kz вернул пустую страницу. :( Возможно поблема с прокси.' .'<br>'.$proxy);
        }

        if(mb_strpos($result, 'Что-то пошло не так.') !== false){
            throw new HTTP_Exception_500('Kaspi.kz нас заблокировал по ip-адресу. :( Будем надеяться не надолго.');
        }

        // если куки не заданы, то получаем их самостоятельно
        if(empty($cookie) || strpos($result, 'var a = toNumbers("') !== false) {
            $ksTck = self::getCookieKsTckByHTML($result);
            if ($ksTck === false) {
                return false;
            }

            // Получаем значение важной куки ks.tck из HTML страницы сайта
            $opt[CURLOPT_COOKIE] = 'ks.tck=' . $ksTck;
            $cookie = $opt[CURLOPT_COOKIE];

            curl_setopt_array($cs, $opt);
            $result = curl_exec($cs);

            if(empty($result)){
                throw new Drivers_ParserSite_Kaspi_Exception('Kaspi.kz вернул пустую страницу. :( Возможно поблема с прокси.' .'<br>'.$proxy);
            }

            if(mb_strpos($result, 'Что-то пошло не так.') !== false){
                throw new HTTP_Exception_500('Kaspi.kz нас заблокировал по ip-адресу. :( Будем надеяться не надолго.');
            }
        }

        curl_close($cs);
        return $result;
    }

    /**
     * Возвращаем список цен на товары от поставщиков ввиде массива закодированого на сайте
     * @param $html
     * @return bool|array
     */
    public static function getProductPrices($html){
        $position = strpos($html, 'BACKEND.components.sellersOffers=');
        if($position === false){
            return false;
        }

        $html = substr($html, $position + strlen('BACKEND.components.sellersOffers='));

        $position = strpos($html, ';</script>');
        if($position === false){
            return false;
        }
        $html = substr($html, 0, $position);

        $prices = json_decode($html, true);
        if(!is_array($prices)){
            return false;
        }

        return $prices;
    }

    /**
     * Возвращаем список цен на товары от поставщиков ввиде массива закодированого на сайте
     * обновляем данные о товаре
     * @param Model_AutoPart_Shop_Product $modelProduct
     * @param Model_AutoPart_Shop_Product_Source $modelSource
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $url
     * @param string $cookie
     * @param string $proxy
     * @param string $user
     * @param string $password
     * @param string $urlEditIP
     * @return array|bool
     */
    public static function getProductPricesUpdateData($shopSourceID, Model_AutoPart_Shop_Product $modelProduct,
                                                      Model_AutoPart_Shop_Product_Source $modelSource,                                                                                                 SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                                      $url, &$cookie = '', $proxy = '', $user = '', $password = '',
                                                      $urlEditIP = ''){
        $page = self::getPageHTMLProduct($url, $cookie, $proxy, $user, $password, $urlEditIP);
        $position = strpos($page, 'BACKEND.components.sellersOffers=');
        if($position === false){
            return false;
        }

        self::loadProductByHTML(
            $page, $shopSourceID, $modelProduct, $modelSource, $sitePageData, $driver, false
        );

        return self::getProductPrices($page);
    }

    /**
     * Получаем id рубрики
     * @param $html
     * @param int $shopSourceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public static function getShopRubricSourceID($html, $shopSourceID, SitePageData $sitePageData,
                                                 Model_Driver_DBBasicDriver $driver)
    {
        preg_match_all('/<span itemprop=name>[\s\S]+(.+)<\/span>/U', $html, $result);
        if ((is_array($result)) && (count($result) == 2)) {
            $rubric = trim(strip_tags(end($result[0])));
            if (!empty($rubric)) {
                $shopRubricSource = Request_Request::findOne(
                    DB_AutoPart_Shop_Rubric_Source::NAME, 0, $sitePageData, $driver,
                    Request_RequestParams::setParams(
                        [
                            'name_full' => $rubric,
                            'shop_source_id' => $shopSourceID,
                        ]
                    )
                );

                if($shopRubricSource != null){
                    return $shopRubricSource->id;
                }
            }
        }

        return 0;
    }

    /**
     * Загружаем данные о об одном товаре
     * @param $html
     * @param $shopSourceID
     * @param Model_AutoPart_Shop_Product $modelProduct,
     * @param Model_AutoPart_Shop_Product_Source $modelSource,
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     */
    public static function loadProductByHTML($html, $shopSourceID, Model_AutoPart_Shop_Product $modelProduct,
                                             Model_AutoPart_Shop_Product_Source $modelSource,
                                             SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        // рубрика
        if($modelSource->getShopRubricSourceID() < 1) {
            $modelSource->setShopRubricSourceID(
                self::getShopRubricSourceID($html, $shopSourceID, $sitePageData, $driver)
            );
        }

        // Цена
        preg_match_all('/"unitPrice":(.+),/U', $html, $result);
        if (is_array($result) && count($result) == 2 && count($result[1]) > 0 ) {
            $modelSource->setPriceSource(floatval($result[1][0]));
        }

        // Название товара
        if($isReplace || Func::_empty($modelSource->getName())) {
            preg_match_all('/"card":\{"id":"[0-9]+","title":"(.+)"/U', $html, $result);
            if (is_array($result) && count($result) == 2 && count($result[1]) > 0) {
                $modelSource->setName($result[1][0]);
            }
        }

        // Характеристики
        if($isReplace || Func::_empty($modelProduct->getParams())) {
            preg_match_all('/<span class=specifications-list__spec-term-text>([\W\w]+)<\/span>/U', $html, $result);
            preg_match_all('/<dd class=specifications-list__spec-definition>([\W\w]+)<\/dd>/U', $html, $result2);
            if (is_array($result) && count($result) > 1 && is_array($result2) && count($result2) > 1) {
                if (count($result[1]) == count($result2[1])) {
                    $options = [];
                    for ($i = 0; $i < count($result[1]); $i++) {
                        $options[strip_tags($result[1][$i])] = strip_tags(trim($result2[1][$i]));
                    }

                    $modelProduct->addParamsArray($options);
                }
            }
        }
    }

    /**
     * Загружаем данные о товарах, у которых не задана рубрика
     * @param $shopSourceID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function loadProducts($shopSourceID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopProductSourceIDs = Request_Request::find(
            DB_AutoPart_Shop_Product_Source::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                [
                    'shop_source_id' => $shopSourceID,
                    'shop_rubric_source_id' => 0,
                    'options_empty' => false,
                ]
            ), 0, true
        );

        $proxies = include Helpers_Path::getFilesProxies();
        $user = $proxies['user'];
        $password = $proxies['password'];
        $urlEditIP = $proxies['edit_ip'];
        $proxies = $proxies['proxies'];

        $cookies = [];
        foreach ($proxies as $proxy){
            $cookies[$proxy] = '';
        }

        $getHTML = function ($url, $getHTML, &$i, &$proxies, &$cookies, &$n, $user, $password, $urlEditIP){
            $i += random_int(1, 3);
            $proxy = $proxies[$i % count($proxies)];

            try {
                $html = self::getPageHTMLProduct($url, $cookies[$proxy], $proxy, $user, $password, $urlEditIP);
            }catch (Drivers_ParserSite_Kaspi_Exception $e){
                $n++;
                if($n > count($proxies)){
                    throw new HTTP_Exception_500('Ни один прокси не работает. :(');
                }

                $html = $getHTML($url, $getHTML, $i, $proxies, $cookies, $n, $user, $password, $urlEditIP);
            }catch (HTTP_Exception_500 $e){
                $n++;
                if($n > count($proxies)){
                    throw new HTTP_Exception_500('Ни один прокси не работает. :(');
                }

                $html = $getHTML($url, $getHTML, $i, $proxies, $cookies, $n, $user, $password, $urlEditIP);
            }

            return $html;
        };

        $modelSource = new Model_AutoPart_Shop_Product_Source();
        $modelSource->setDBDriver($driver);

        $modelProduct = new Model_AutoPart_Shop_Product();
        $modelProduct->setDBDriver($driver);

        $i = random_int(1, count($proxies));
        foreach ($shopProductSourceIDs->childs as $child){
            $child->setModel($modelSource);

            $url = $modelSource->getOptionsValue('source.kaspi.url');
            if(empty($url)){
                continue;
            }

            $n = 0;
            $html = $getHTML($url, $getHTML, $i, $proxies, $cookies, $n, $user, $password, $urlEditIP);

            if(Helpers_DB::getDBObject($modelProduct, $modelSource->getShopProductID(), $sitePageData, 0)){
                self::loadProductByHTML($html, $shopSourceID, $modelProduct, $modelSource, $sitePageData, $driver, false);

                Helpers_DB::saveDBObject($modelProduct, $sitePageData, $modelProduct->shopID);
                Helpers_DB::saveDBObject($modelSource, $sitePageData, $modelSource->shopID);
            }
        }
    }
}
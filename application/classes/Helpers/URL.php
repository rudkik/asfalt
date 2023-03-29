<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_URL {
    const SHOP_GOOD_IS_ADD_ID = TRUE;
    const SHOP_TABLE_RUBRIC_IS_ADD_ID = FALSE;
    const SHOP_NEW_IS_ADD_ID = TRUE;
    const SHOP_TABLE_HASHTAG_IS_ADD_ID = FALSE;
    const SHOP_TABLE_BRAND_IS_ADD_ID = FALSE;
    const SHOP_TABLE_UNIT_IS_ADD_ID = FALSE;
    const SHOP_CAR_IS_ADD_ID = TRUE;

    /**
     * Получаем СЕО URL путь
     * @param Model_Shop_Basic_SEO $model
     * @return string
     */
    public static function getNameURL(Model_Shop_Basic_SEO $model)
    {
        switch ($model->tableID) {
            case Model_Shop_Good::TABLE_ID:
                $result = '/';
                if ($model->getShopTableRubricID() > 0) {
                    $rubric = $model->getElement('shop_table_rubric_id', TRUE);
                    if ($rubric !== NULL) {
                        $result = $rubric->getNameURL() . '/';
                    }
                }

                //$result .= Func::get_in_translate_to_en($model->getName());
                $tmp = Func::get_in_translate_to_en(strip_tags(Arr::path($model->getOptionsArray(), 'model', $model->getName())), TRUE);
                $result .= $tmp;
                if(self::SHOP_GOOD_IS_ADD_ID){
                    $result .= '-'.$model->id;
                }
                if(strlen($tmp) > 200){
                    $result = $tmp . '-' . $model->id;
                }
                break;
            case Model_Shop_New::TABLE_ID:
                $result = '/';
                if ($model->getShopTableRubricID() > 0) {
                    $rubric = $model->getElement('shop_table_rubric_id', TRUE);
                    if ($rubric !== NULL) {
                        $result = $rubric->getNameURL() . '/';
                    }
                }

                $tmp = Func::get_in_translate_to_en(strip_tags($model->getName()), TRUE);
                $result .= $tmp;
                if(self::SHOP_NEW_IS_ADD_ID){
                    $result .= '-'.$model->id;
                }

                if(strlen($tmp) > 200){
                    $result = $tmp . '-' . $model->id;
                }
                break;
            case Model_Shop_Table_Rubric::TABLE_ID:
                $result = '/';
                if ($model->getRootID() > 0) {
                    $rubric = $model->getElement('root_id', TRUE);
                    if ($rubric !== NULL) {
                        $result = $rubric->getNameURL() . '/';
                    }
                }

                $result .= Func::get_in_translate_to_en(strip_tags($model->getName()), TRUE);
                if(self::SHOP_TABLE_RUBRIC_IS_ADD_ID){
                    $result .= '-'.$model->id;
                }

                break;
            case Model_Shop_Table_Hashtag::TABLE_ID:
                $result = '/';
                if ($model->getShopTableRubricID() > 0) {
                    $rubric = $model->getElement('shop_table_rubric_id', TRUE);
                    if ($rubric !== NULL) {
                        $result = $rubric->getNameURL() . '/';
                    }
                }

                $result .= Func::get_in_translate_to_en(strip_tags($model->getName()));
                if(self::SHOP_TABLE_HASHTAG_IS_ADD_ID){
                    $result .= '-'.$model->id;
                }
                break;
            case Model_Shop_Table_Brand::TABLE_ID:
                $result = '/';
                if ($model->getShopTableRubricID() > 0) {
                    $rubric = $model->getElement('shop_table_rubric_id', TRUE);
                    if ($rubric !== NULL) {
                        $result = $rubric->getNameURL() . '/';
                    }
                }

                $result .= Func::get_in_translate_to_en(strip_tags($model->getName()));
                if(self::SHOP_TABLE_BRAND_IS_ADD_ID){
                    $result .= '-'.$model->id;
                }
                break;
            case Model_Shop_Table_Unit::TABLE_ID:
                $result = '/';
                if ($model->getShopTableRubricID() > 0) {
                    $rubric = $model->getElement('shop_table_rubric_id', TRUE);
                    if ($rubric !== NULL) {
                        $result = $rubric->getNameURL() . '/';
                    }
                }

                $result .= Func::get_in_translate_to_en(strip_tags($model->getName()));
                if(self::SHOP_TABLE_UNIT_IS_ADD_ID){
                    $result .= '-'.$model->id;
                }
                break;
            case Model_Shop_Model::TABLE_ID:
                $result = '/';
                if ($model->getShopMarkID() > 0) {
                    $rubric = $model->getElement('shop_mark_id', TRUE);
                    if ($rubric !== NULL) {
                        $result = $rubric->getNameURL() . '/';
                    }
                }

                $result .= Func::get_in_translate_to_en(strip_tags($model->getName()));
                break;
            case Model_Shop_Mark::TABLE_ID:
                $result = '/';
                if ($model->getShopTableRubricID() > 0) {
                    $rubric = $model->getElement('shop_table_rubric_id', TRUE);
                    if ($rubric !== NULL) {
                        $result = $rubric->getNameURL() . '/';
                    }
                }

                $result .= Func::get_in_translate_to_en(strip_tags($model->getName()));
                break;
            case Model_Shop_Car::TABLE_ID:
                $result = '/';
                if ($model->getShopTableRubricID() > 0) {
                    $rubric = $model->getElement('shop_table_rubric_id', TRUE);
                    if ($rubric !== NULL) {
                        $result = $rubric->getNameURL() . '/';
                    }
                }

                $result .= Func::get_in_translate_to_en(strip_tags($model->getNameTotal()));
                if(self::SHOP_CAR_IS_ADD_ID){
                    $result .= '-'.$model->id;
                }
                break;
            default:
                $result = '';
        }

        return $result;
    }

    /**
     * По СЕО URL находим id записи
     * на уровне bases и urls надо добавить эту структуру
     'seo_url' => array(
         '/catalog' => array(
             Model_Shop_Table_Rubric::TABLE_NAME => array(
                 'url' => '/catalog',
                 'params' => array('id' => 'id'),
             ),
             Model_Shop_Good::TABLE_NAME  => array(
                 'url' => '/goods',
                 'params' => array('id' => 'id'),
             ),
         )
     ),
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param array $siteOptions
     * @return bool
     */
    public static function findURL(SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, array &$siteOptions)
    {
        if (!key_exists('seo_url', $siteOptions)){
            return FALSE;
        }

        $result = FALSE;
        foreach ($siteOptions['seo_url'] as $prefix => $tables){
            if (((!empty($prefix) && mb_strpos($sitePageData->url, $prefix) === 0))
                || (empty($prefix))){
                $nameURL = mb_substr($sitePageData->url, mb_strlen($prefix));

                foreach ($tables as $table => $urlParams) {
                    $sql = GlobalData::newModelDriverDBSQL();
                    $sql->setTableName($table);
                    $sql->limit = 1;
                    $sql->getRootWhere()->addField('name_url', $table, $nameURL);
                    $sql->getRootWhere()->addField('is_delete', $table, 0);

                    $sitePageData->urlSEO = $nameURL;

                    $arr = $driver->getSelect($sql, TRUE, -1, $sitePageData->shopID)['result'];
                    if (!empty($arr)){
                        foreach ($arr as $record) {
                            foreach ($urlParams['params'] as $from => $to) {
                                $_GET[$to] = $record[$from];
                            }
                        }

                        $result = $urlParams['url'];
                        break 2;
                    }elseif((Model_Shop_Good::TABLE_NAME == $table) && (self::SHOP_GOOD_IS_ADD_ID)){
                        $n = strpos($nameURL, '-');
                        if($n !== false) {
                            $id = intval(substr($nameURL, $n + 1), 0);
                            if ($id > 0) {
                                $sql = GlobalData::newModelDriverDBSQL();
                                $sql->setTableName($table);
                                $sql->limit = 1;
                                $sql->getRootWhere()->addField('id', $table, $id);

                                $arr = $driver->getSelect($sql, TRUE, -1, $sitePageData->shopID)['result'];
                                if (!empty($arr)) {
                                    foreach ($arr as $record) {
                                        foreach ($urlParams['params'] as $from => $to) {
                                            $_GET[$to] = $record[$from];
                                        }
                                    }

                                    $sitePageData->urlSEO = $arr[0]['name_url'];

                                    $result = $urlParams['url'];
                                    break 2;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Получение данных по ссылке с эмуляцией заголовков браузера
     * @param $url
     * @param int $timeout
     * @param array | null $POST
     * @return string
     */
    public static function getDataURLEmulationBrowser($url, $timeout = 10, $POST = null)
    {
        $fileName = 'cookie_'.random_int(1, 999999).'.txt';
        Helpers_File::saveInLogs($fileName, '', ['cookies']);

        $url = str_replace(' ', '%20', $url);
        $cs = curl_init();
        $opt = array(
            CURLOPT_URL => $url,
            CURLOPT_ENCODING => 'gzip',
            CURLOPT_COOKIE => '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_COOKIESESSION => true,
            CURLOPT_COOKIEFILE => APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'cookies' . DIRECTORY_SEPARATOR . $fileName,
            CURLOPT_REFERER => null,
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36",
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYPEER => FALSE,
        );

        if(!empty($POST)){
            $opt[CURLOPT_POST] = 1;
            $opt[CURLOPT_POSTFIELDS] = $POST;
        }

        curl_setopt_array($cs, $opt);
        $result = curl_exec($cs);
        curl_close($cs);

        return $result;
    }

    /**
     * Получение файла по ссылке с эмуляцией заголовков браузера
     * @param $url
     * @param $filePath
     * @param int $timeout
     * @return mixed
     */
    public static function getFileURLEmulationBrowser($url, $filePath, $timeout = 10)
    {
        $url = str_replace(' ', '%20', $url);
        $opt = array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        file_put_contents($filePath, file_get_contents($url, FALSE, stream_context_create($opt)));
    }

    /**
     * Получаем базовую ссылку
     * @param string $path
     * @return string
     */
    public static function getBasicURL($path = '') {
        $https = !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') === 0 ||
            !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;

        return
            ($https ? 'https://' : 'http://').
            (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
                ($https && $_SERVER['SERVER_PORT'] === 443 ||
                $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
            (!empty($path) ? '/'.$path : '').'/';
    }

    /**
     * Получаем HTML страницу с рандомного прокси
     * @param $url
     * @param $fileProxies
     * @param int $timeout
     * @param null | array $postFields
     * @return bool|string
     * @throws Exception
     */
    public static function getPageHTMLRandomProxy($url, $fileProxies, $timeout = 10, $POST = null)
    {
        if(empty($fileProxies)){
            return self::getDataURLEmulationBrowser($url, $timeout, $POST);
        }

        $proxies = include $fileProxies;
        if(empty($proxies['proxies'])){
            return self::getDataURLEmulationBrowser($url, $timeout, $POST);
        }

        $user = $proxies['user'];
        $password = $proxies['password'];
        $proxy = $proxies['proxies'][random_int(0, count($proxies['proxies']) - 1)];

        $fileName = 'cookie_'.random_int(1, 999999).'.txt';
        Helpers_File::saveInLogs($fileName, '', ['cookies']);

        $cs = curl_init();
        $opt = array(
            CURLOPT_URL => $url,
            CURLOPT_NOBODY => false,
            CURLOPT_ENCODING => 'gzip',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_COOKIESESSION => true,
            CURLOPT_REFERER => null,
            CURLOPT_COOKIE => '',
            CURLOPT_COOKIEFILE => APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'cookies' . DIRECTORY_SEPARATOR . $fileName,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:88.0) Gecko/20100101 Firefox/88.0',
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_PROXY => $proxy,
            CURLOPT_CONNECTTIMEOUT => $timeout,
            CURLOPT_PROXYUSERPWD => $user . ':' .$password,
        );

        if(!empty($POST)){
            $opt[CURLOPT_POSTFIELDS] = $POST;
            $opt[CURLOPT_POST] = true;
        }

        curl_setopt_array($cs, $opt);
        $result = curl_exec($cs);
        curl_close($cs);

        return $result;
    }

    /**
     * Получаем базовую ссылку для файлов исходя из филиалов
     * @param $shopID
     * @param SitePageData $sitePageData
     * @param string $file
     * @return mixed|string
     */
    public static function getFileBasicURL($shopID, SitePageData $sitePageData, $file = 'branches_url')
    {
        $file = Helpers_Path::getPathFile(APPPATH, ['config'], $file. '.php');
        if(file_exists($file)){
            $urls = include $file;
            return Arr::path($urls, $shopID, $sitePageData->urlBasic);
        }

        return $sitePageData->urlBasic;
    }

}
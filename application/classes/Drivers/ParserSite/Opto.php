<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_Opto
{

    /**
     * Загружаем данные о товаре с других сайтов через штрихкод
     * @param $shopID
     * @param sitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function loadSiteByBarcode($shopID, sitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $shopGoods = Request_Request::find('DB_Shop_Good',$shopID, $sitePageData, $driver);

        $urls = array(
            'http://www.goodsmatrix.ru/goods/$barcode$.html' => 'www.goodsmatrix.ru',
            'http://kiranik.com/products?keyword=$barcode$' => 'kiranik.com',
            'https://www.pilot.pl.ua/catalogsearch/result/?cat=0&q=$barcode$' => 'www.pilot.pl.ua',
            'http://www.yakaboo.ua/search/?cat=&q=$barcode$' => 'www.yakaboo.ua',
            'https://www.moyo.ua/search.html?posted=1&s%5Btext%5D=$barcode$&x=0&y=0' => 'www.moyo.ua',
        );

        $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'shopgoods' . DIRECTORY_SEPARATOR . $sitePageData->shopID . DIRECTORY_SEPARATOR;
        foreach ($shopGoods->childs as $shopGood) {

            if (empty($shopGood->values['options'])) {
                continue;
            }
            $arr = json_decode($shopGood->values['options'], TRUE);
            $barcode = Arr::path($arr, 'barcode', '');
            if (empty($barcode)) {
                continue;
            }
            /* if($barcode != '4015400041641'){
                 continue;
             }
             echo $shopGood->id;*/

            foreach ($urls as $url => $name) {
                $file = $path . $shopGood->id . DIRECTORY_SEPARATOR;
                if (!file_exists($file)) {
                    Helpers_Path::createPath($file);
                }

                $file = $file . $name . '.html';
                if (file_exists($file)) {
                    continue;
                }

                $data = Helpers_URL::getDataURLEmulationBrowser(str_replace('$barcode$', $barcode, $url));
                file_put_contents($file, $data, FILE_APPEND); //die;
            }
        }
        echo 'Count: ' . count($shopGoods->childs) . '<br>finish';
    }

    /**
     * Парсим загруженные данные с сайтов загруженных через функцию
     * @return array
     */
    public static function parserLoadData()
    {
        $urls = array(
            'http://www.goodsmatrix.ru/goods/$barcode$.html' => 'www.goodsmatrix.ru',
            'http://kiranik.com/products?keyword=$barcode$' => 'kiranik.com',
            'https://www.pilot.pl.ua/catalogsearch/result/?cat=0&q=$barcode$' => 'www.pilot.pl.ua',
            'http://www.yakaboo.ua/search/?cat=&q=$barcode$' => 'www.yakaboo.ua',
            'https://www.moyo.ua/search.html?posted=1&s%5Btext%5D=$barcode$&x=0&y=0' => 'www.moyo.ua',
        );

        $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'shopgoods' . DIRECTORY_SEPARATOR;

        $result = array();

        $skip = array('.', '..');
        // получаем список магазинов
        $shopIDs = scandir($path, SCANDIR_SORT_NONE);
        foreach ($shopIDs as $shopID) {
            if ((in_array($shopID, $skip)) || (!is_dir($path . $shopID))) {
                continue;
            }

            $pathShop = $path . $shopID . DIRECTORY_SEPARATOR;

            // получаем список товаров
            $shopGoodIDs = scandir($pathShop, SCANDIR_SORT_NONE);
            foreach ($shopGoodIDs as $shopGoodID) {
                if ((in_array($shopGoodID, $skip)) || (!is_dir($pathShop . $shopGoodID))) {
                    continue;
                }

                $pathShopGood = $pathShop . $shopGoodID . DIRECTORY_SEPARATOR;

                // получаем данные по сайтам
                foreach ($urls as $url) {
                    $file = $pathShopGood . $url . '.html';
                    if ((!file_exists($file)) || (!is_file($file))) {
                        continue;
                    }

                    $str = file_get_contents($file);
                    if ($str === FALSE) {
                        continue;
                    }

                    switch ($url) {
                        case 'www.goodsmatrix.ru':
                            $str = iconv('windows-1251', 'utf-8', $str);
                            $data = self::_parserGoodsMatrixRU($str);
                            if ($data !== FALSE) {
                                $result[$shopID][$shopGoodID][$url] = self::_correctData($data);
                            }
                            break;
                        case 'kiranik.com':
                            $data = self::_parserGoodsKiranikCOM($str);
                            if ($data !== FALSE) {
                                $result[$shopID][$shopGoodID][$url] = self::_correctData($data);
                            }
                            break;
                        case 'www.pilot.pl.ua':
                            $data = self::_parserGoodsPilotPlUA($str);
                            if ($data !== FALSE) {
                                $result[$shopID][$shopGoodID][$url] = self::_correctData($data);
                            }
                            break;
                        case 'www.yakaboo.ua':
                            $data = self::_parserGoodsYakabooUA($str);
                            if ($data !== FALSE) {
                                $result[$shopID][$shopGoodID][$url] = self::_correctData($data);
                            }
                            break;
                        case 'www.moyo.ua':
                            $data = self::_parserGoodsMoyoUA($str);
                            if ($data !== FALSE) {
                                $result[$shopID][$shopGoodID][$url] = self::_correctData($data);
                            }
                            break;
                    }
                }
            }
        }
        file_put_contents($path . 'parser-result.php', '<?php' . "\r\n" . 'return ' .self::_arrayToStrPHP($result).';');

        echo 'Count: ' . count($result) . '<br>finish';

        return $result;
    }

    /**
     * Корректировка данных товара
     * @param array $data
     * @return array
     */
    private static function _correctData(array $data){
        if(key_exists('options', $data)){
            $options = array();
            foreach($data['options'] as $key => $value){
                $keyLower = mb_strtolower($key);
                if(($keyLower == 'артикул') || ($keyLower == 'штрихкод')){
                    continue;
                }

                // обрабатываем название атрибутов
                switch($keyLower){
                    case 'вес ребенка, кг':
                        $key = 'Вес ребенка (кг)';
                        break;
                    case 'гарантия, мес':
                        $key = 'Гарантия (мес.)';
                        break;
                    case 'количество в упаковке':
                    case 'количество в упаковке, шт':
                        $key = 'Кол-во в упаковке (шт.)';
                        break;
                    case 'максимальное количество одновременно заряжаемых ак':
                        $key = 'Макс. кол-во одновременно заряжаемых аккумуляторов';
                        break;
                    case 'об\'єм/вага':
                    case 'объем':
                        $key = 'Объём';
                        break;
                    case 'объём, л':
                        $key = 'Объём (л)';
                        break;
                    case 'Объем/Вес':
                        $key = 'Объём/вес';
                        break;
                    case 'страна-производитель':
                        $key = 'Страна производства';
                        break;
                    case 'размер товара':
                        $key = 'Размеры товара';
                        break;
                    case 'количество в коробе (шт.)':
                        $key = 'Кол-во в коробе (шт.)';
                        break;
                }

                $search = array (
                    '/ +/u' => ' ', // множественные пробелы заменяем на одинарные
                    '/ :/u' => ':',
                    '/ \,/u' => ',',
                    '/ \./u' =>  '.',
                    '/ \!/u' =>  '!',
                    '/ \?/u' => '?',
                );
                foreach($search as $k => $v) {
                    $key = preg_replace($k, $v, $key);
                }
                $key = trim($key);

                // обрабатываем значение атрибутов
                switch($key){
                    case 'Объём (л)':
                    case 'Масса брутто':
                    case 'Энергетический состав':
                    case 'Размеры упаковки (Ш x Г x В)':
                    case 'Размер упаковки':
                    case 'Размеры товара':
                    case 'Объем/Вес':
                    case 'Масса нетто':
                        $search = array (
                            '/([0-9]),([0-9])/u' => '\\1.\\2', // 0,54 => 0.54
                            '/([0-9]){1}\.[0]{2}/u' => '\\1', // 300.00 => 300
                            '/([0-9]{1}\.[1-9]{1})[0]{1}/u' => '\\1', // 300.10 => 302.1
                            '/(^|\s|[0-9]{1})шт([\s]|$)/u' => '\1 шт. ', // шт => шт.
                        );
                        break;
                    case 'Количество аккумуляторов в комплекте':
                    case 'Срок годности':
                        if($value == 'г.'){
                            $value = '';
                        }
                        $search = array (
                            '/1 г\./u' => '1 год',
                            '/2 г\./u' => '2 года',
                            '/3 г\./u' => '3 года',
                            '/4 г\./u' => '4 года',
                            '/5 г\./u' => '5 лет',
                            '/6 г\./u' => '6 лет',
                            '/7 г\./u' => '7 лет',
                            '/8 г\./u' => '8 лет',
                            '/9 г\./u' => '9 лет',
                            '/10 г\./u' => '10 лет',
                            '/(^|\s)мес([\s]|$)/u' => ' мес. ', // мес => мес.
                        );
                        break;
                    case 'Условия хранения':
                        $search = array (
                            '/\sградусов\sС/u' => 'C', // градусов С => C
                        );
                        break;
                    case 'Модель':
                        $search = array (
                            '/([0-9]),([0-9])/u' => '\\1.\\2', // 0,54 => 0.54
                            '/(^|\s|[0-9]{1})шт([\s]|$)/u' => '\1 шт. ', // шт => шт.
                            '/&amp;/u' => '&', // &amp; => &
                            '/ & /u' => '&', // ' & ' => &
                        );
                        break;
                    case 'Линейка':
                    case 'Производитель':
                        $search = array (
                            '/&amp;/u' => '&', // &amp; => &
                            '/ & /u' => '&', // ' & ' => &
                        );
                        break;
                    case 'Кол-во в упаковке (шт.)':
                        $search = array (
                            '/([0-9]),([0-9])/u' => '\\1.\\2', // 0,54 => 0.54
                            '/([0-9]){1}\.[0]{2}/u' => '\\1', // 300.00 => 300
                            '/([0-9]{1}\.[1-9]{1})[0]{1}/u' => '\\1', // 300.10 => 302.1
                            '/(^|\s|[0-9]{1})шт([\s]|$)/u' => '\1 шт. ', // шт => шт.
                        );
                        if(is_numeric($value)){
                            $value = $value.' шт.';
                        }
                        break;
                }
                foreach($search as $k => $v) {
                    $value = preg_replace($k, $v, $value);
                }


                $search = array (
                    '/ +/u' => ' ', // множественные пробелы заменяем на одинарные
                    '/(\r\n){3,}/u' => '\r\n\r\n', // убираем лишние переводы строк (больше 1 строки)
                    '/&amp;/u' => '&', // &amp; => &
                    '/ & /u' => '&', // ' & ' => &
                    '/ :/u' => ':',
                    '/ \,/u' => ',',
                    '/ \./u' => '.',
                    '/ \!/u' => '!',
                    '/ \?/u' => '?',
                );
                foreach($search as $k => $v) {
                    $value = preg_replace($k, $v, $value);
                }
                $value = trim(htmlspecialchars_decode($value));


                $options[$key] = $value;
            }

            $data['options'] = $options;
        }

        if(key_exists('name', $data)){
            $search = array (
                '/(^|\s|[0-9]{1})мл\./u' => '\\1 мл ',
                '/(^|\s|[0-9]{1})ml\./u' => '\\1 мл ',
                '/(^|\s|[0-9]{1})гр($|\s|\.)/u' => '\\1 г ',
                '/(^|\s|[0-9]{1})г($|\s|\.)/u' => '\\1 г ',
                '/(^|\s|[0-9]{1})кг($|\s|\.)/u' => '\\1 кг ',
                '/(^|\s|[0-9]{1})л($|\s|\.)/u' => '\\1 л ',
                '/([0-9]),([0-9])/u' => '\\1.\\2', // 0,54 => 0.54
                '/([0-9]){1}\.[0]{2}/u' => '\\1', // 300.00 => 300
                '/([0-9]{1}\.[1-9]{1})[0]{1}/u' => '\\1', // 300.10 => 302.1
                '/(^|\s|[0-9]{1})шт([\s]|$)/u' => '\1 шт. ', // шт => шт.
                '/\,/u' => ', ',
                '/ +/u' => ' ', // множественные пробелы заменяем на одинарные
                '/(\r\n){3,}/u' => '\r\n\r\n', // убираем лишние переводы строк (больше 1 строки)
                '/ 2 в 1 /' => '/ 2в1 /',
                '/ 3 в 1 /' => '/ 3в1 /',
                '/ :/u' => ':',
                '/ \,/u' => ',',
                '/ \./u' => '.',
                '/ \!/u' => '!',
                '/ \?/u' => '?',
            );

            $name = htmlspecialchars_decode($data['name']);
            foreach($search as $k => $v) {
                $name = preg_replace($k, $v, $name);
            }
            $name = str_replace('0.125 л', '125 мл', $name);
            $name = str_replace('0.2 л', '200 мл', $name);

            $data['name'] = trim($name);
        }


        return $data;
    }

    /**
     * Сохраняем данные в базу данных обработанных с помощью функции
     * parserLoadData
     * @param sitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    public static function saveLoadData(sitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'shopgoods' . DIRECTORY_SEPARATOR . 'parser-result.php';

        $model = new Model_Shop_Good();
        $model->setDBDriver($driver);

        $shopIDs = include $path;
        foreach ($shopIDs as $shopID => $shops) {
            foreach ($shops as $shopGoodID => $shopGoods) {

                $info = '';
                $name = '';
                $options = array();
                foreach ($shopGoods as $url) {
                    if(key_exists('info', $url)) {
                        if(!empty($info)){
                            $info = $info . '<br><br>'."\r\n\r\n";
                        }
                        $info = $info . $url['info'];
                    }

                    if(key_exists('name', $url)) {
                        if(!empty($name)){
                            $name = $name . '<br>'."\r\n";
                        }
                        $name = $name . $url['name'];
                    }

                    if(key_exists('options', $url)) {
                        $options = array_merge($options, $url['options']);
                    }
                }

                if(Helpers_DB::getDBObject($model, $shopGoodID, $sitePageData, $shopID)){
                    if(empty($model->getText())){
                        $model->setText($name.'<br><br>'."\r\n\r\n".$info);
                    }

                    $model->addOptionsArray($options, FALSE);

                    Helpers_DB::saveDBObject($model, $sitePageData, $shopID);
                }

            }
        }

        echo 'Finish';
    }


    private static function _arrayToStrPHP(array $data, $prefix = '    ') {
        $s = 'array(';
        foreach ($data as $key => $value) {
            $s = $s . "\r\n".$prefix;
            if (is_int($key)) {
                $s = $s .$key . ' => ';
            } else {
                $s = $s . "'" . str_replace("'", "\'", $key) . "'" . ' => ';
            }

            if (is_array($value)) {
                $s = $s . self::_arrayToStrPHP($value, $prefix.'    ') . ', ';
            } elseif (is_int($value)) {
                $s = $s . $value . ', ';
            } else {
                $s = $s . "'" . str_replace("'", "\'", $value) . "'" . ', ';
            }
        }

        $s = $s . ')';
        return $s;
    }

    /**
     * Парсим данные с сайта www.moyo.ua
     * @param $str
     * @return array|bool
     */
    private static function _parserGoodsMoyoUA($str){

        $result = array();

        // загружаем название
        $n = strpos($str, '<h1 itemprop="name">');
        if ($n === FALSE) {
            return FALSE;
        }

        $n = $n + strlen('<h1 itemprop="name">');
        $name = trim(substr($str, $n, strpos($str, '</h1>', $n) - $n));
        $result['name'] = $name;

        // загружаем options
        $start = strpos($str, '<div class="short_content">');
        if ($start === FALSE) {
            return FALSE;
        }
        $finish = strpos($str, '</div>', $start + 1);
        $record = strpos($str, '<li class="clear_after">', $start + 1);
        while(($record !== FALSE) && ($record < $finish)){
            $n = strpos($str, '<span>', $record + 1);
            if ($n === FALSE) {
                break;
            }

            $n = $n + strlen('<span>');
            $title = trim(substr($str, $n, strpos($str, '<', $n) - $n));
            if(mb_substr($title, mb_strlen($title) - 1) == ':'){
                $title = mb_substr($title, 0, -1);
            }

            $n = strpos($str, '<span class="bold">', $n + 1);
            if ($n === FALSE) {
                break;
            }

            $n = $n + strlen('<span class="bold">');
            $value = trim(substr($str, $n, strpos($str, '<', $n) - $n));

            if((!empty($title)) && (!empty($value))) {
                $result['options'][$title] = $value;
            }

            $record = strpos($str, '<li class="clear_after">', $record + 1);
        }

        // загружаем описание
        $n = strpos($str, '<div class="moredescription moretoshow addCopyright"><div class="text"');
        if ($n !== FALSE) {

            $n = $n + strlen('<div class="moredescription moretoshow addCopyright"><div class="text"');

            $n = strpos($str, '>', $n);
            if ($n !== FALSE) {
                $n = $n + strlen('>');
                $info = trim(substr($str, $n, strpos($str, '</div>', $n) - $n));

                $result['info'] = $info;
            }
        }

        return $result;
    }

    /**
     * Парсим данные с сайта www.yakaboo.ua
     * @param $str
     * @return array|bool
     */
    private static function _parserGoodsYakabooUA($str){
        $result = array();

        // загружаем название
        $n = strpos($str, '<h1 itemprop="description" itemprop="name">');
        if ($n === FALSE) {
            return FALSE;
        }

        $n = $n + strlen('<h1 itemprop="description" itemprop="name">');
        $name = trim(substr($str, $n, strpos($str, '</h1>', $n) - $n));

        $result['name'] = $name;

        // загружаем options
        $start = strpos($str, '<table class="product-attributes__table" id="product-attribute-specs-table">');
        if ($start === FALSE) {
            return FALSE;
        }
        $finish = strpos($str, '</table>', $start + 1);
        $record = strpos($str, '<tr>', $start + 1);
        while(($record !== FALSE) && ($record < $finish)){
            $n = strpos($str, '<td>', $record + 1);
            if ($n === FALSE) {
                break;
            }

            $n = $n + strlen('<td>');
            $title = trim(substr($str, $n, strpos($str, '<', $n) - $n));
            if(mb_substr($title, mb_strlen($title) - 1) == ':'){
                $title = mb_substr($title, 0, -1);
            }

            $n = strpos($str, '<td>', $n + 1);
            if ($n === FALSE) {
                break;
            }

            $n = $n + strlen('<td>');
            $value = trim(substr($str, $n, strpos($str, '<', $n) - $n));

            if((!empty($title)) && (!empty($value))) {
                switch($title){
                    case 'Вес':
                        $value = str_replace(' гр.', ' г', $value);
                        break;
                }

                $result['options'][$title] = $value;
            }

            $record = strpos($str, '<tr>', $record + 1);
        }

        // загружаем описание
        $n = strpos($str, '<span itemprop="description">');
        if ($n !== FALSE) {

            $n = $n + strlen('<span itemprop="description">');
            $info = trim(substr($str, $n, strpos($str, '</span>', $n) - $n));

            $result['info'] = $info;
        }

        return $result;
    }

    /**
     * Парсим данные с сайта kiranik.com
     * @param $str
     * @return array|bool
     */
    private static function _parserGoodsKiranikCOM($str){

        $result = array();

        // загружаем название
        $n = strpos($str, '<h2 data-product="');
        if ($n === FALSE) {
            return FALSE;
        }
        $n = strpos($str, '>', $n + 1);
        if ($n === FALSE) {
            return FALSE;
        }

        $n = $n + strlen('>');
        $name = trim(substr($str, $n, strpos($str, '</h2>', $n) - $n));
        $result['name'] = $name;

        // загружаем options
        $start = strpos($str, '<table class="basic-table">');
        if ($start === FALSE) {
            return FALSE;
        }
        $finish = strpos($str, '</table>', $start + 1);
        $record = strpos($str, '<tr>', $start + 1);
        while(($record !== FALSE) && ($record < $finish)){
            $n = strpos($str, '<th>', $record + 1);
            if ($n === FALSE) {
                break;
            }

            $n = $n + strlen('<th>');
            $title = trim(substr($str, $n, strpos($str, '<', $n) - $n));

            if(mb_substr($title, mb_strlen($title) - 1) == ':'){
                $title = mb_substr($title, 0, -1);
            }

            $n = strpos($str, '<td>', $n + 1);
            if ($n === FALSE) {
                break;
            }

            $n = $n + strlen('<td>');
            $value = trim(substr($str, $n, strpos($str, '<', $n) - $n));

            if((!empty($title)) && (!empty($value))) {
                if($title == 'Страна-производитель'){
                    $title = 'Страна производства';
                }
                $result['options'][$title] = $value;
            }

            $record = strpos($str, '<tr>', $record + 1);
        }

        // загружаем описание
        $n = strpos($str, '<div class="tab-content" id="tab1">');
        if ($n !== FALSE) {

            $n = $n + strlen('<div class="tab-content" id="tab1">');
            $info = trim(substr($str, $n, strpos($str, '</div>', $n) - $n));

            $result['info'] = $info;
        }

        return $result;
    }

    /**
     * Парсим данные с сайта www.pilot.pl.ua
     * @param $str
     * @return array|bool
     */
    private static function _parserGoodsPilotPlUA($str){

        $result = array();

        // загружаем название
        $n = strpos($str, '<h1>');
        if ($n === FALSE) {
            return FALSE;
        }

        $n = $n + strlen('<h1>');
        $name = trim(substr($str, $n, strpos($str, '</h1>', $n) - $n));
        $result['name'] = $name;

        // загружаем options
        $start = strpos($str, '<td class="data"><table>');
        if ($start === FALSE) {
            return FALSE;
        }
        $finish = strpos($str, '</table>', $start + 1);
        $record = strpos($str, '<tr>', $start + 1);
        while(($record !== FALSE) && ($record < $finish)){
            $n = strpos($str, '<th>', $record + 1);
            if ($n === FALSE) {
                break;
            }

            $n = $n + strlen('<th>');
            $title = trim(substr($str, $n, strpos($str, '<', $n) - $n));

            if(mb_substr($title, mb_strlen($title) - 1) == ':'){
                $title = mb_substr($title, 0, -1);
            }

            $n = strpos($str, '<td>', $n + 1);
            if ($n === FALSE) {
                break;
            }

            $n = $n + strlen('<td>');
            $value = trim(substr($str, $n, strpos($str, '<', $n) - $n));

            if((!empty($title)) && (!empty($value))) {
                $result['options'][$title] = $value;
            }

            $record = strpos($str, '<tr>', $record + 1);
        }

        // загружаем описание
        /*$n = strpos($str, 'id="tab_description_tabbed_contents"');
        if ($n !== FALSE) {
            $n = strpos($str, '<div class="std">', $n);
            if ($n !== FALSE) {
                $n = $n + strlen('<div class="std">');
                $info = trim(substr($str, $n, strpos($str, '</div>', $n) - $n));

                $n = strpos($info, '</p><p>');
                if ($n !== FALSE) {
                    $n = $n + strlen('</p>');
                    $info = trim(substr($str, $n));
                }

                $result['info'] = $info;
            }
        }*/

        return $result;
    }

    /**
     * Парсим данные с сайта www.goodsmatrix.ru
     * @param $str
     * @return array|bool
     */
    private static function _parserGoodsMatrixRU($str){
        $start = strpos($str, 'class="tblpad"');
        if ($start === FALSE) {
            return FALSE;
        }

        $result = array();

        // загружаем название
        $n = strpos($str, 'img id="ctl00_ContentPH_LSGoodPicture_GoodImg" title="');
        if ($n === FALSE) {
            return FALSE;
        }

        $n = $n + strlen('img id="ctl00_ContentPH_LSGoodPicture_GoodImg" title="');
        $name = trim(substr($str, $n, strpos($str, '"', $n) - $n));

        $result['name'] = $name;

        // загружаем options
        $finish = strpos($str, 'class="tblpad"', $start + 1);
        $record = strpos($str, 'class="tblborder"', $start + 1);
        while(($record !== FALSE) && ($record < $finish)){
            $n = strpos($str, 'style="font-weight:bold;">', $record + 1);
            if ($n === FALSE) {
                break;
            }

            $n = $n + strlen('style="font-weight:bold;">');
            $title = trim(substr($str, $n, strpos($str, '<', $n) - $n));

            if(mb_substr($title, mb_strlen($title) - 1) == ':'){
                $title = mb_substr($title, 0, -1);
            }

            $n = strpos($str, 'style="color:Black;">', $n + 1);
            if ($n === FALSE) {
                break;
            }

            $n = $n + strlen('style="color:Black;">');
            $value = trim(substr($str, $n, strpos($str, '<', $n) - $n));

            if((!empty($title)) && (!empty($value))){
                if($title == 'Описание') {
                    $result['info'] = $value;
                }else{
                    $result['options'][$title] = $value;
                }
            }

            $record = strpos($str, 'class="tblborder"', $record + 1);
        }

        return $result;
    }

}
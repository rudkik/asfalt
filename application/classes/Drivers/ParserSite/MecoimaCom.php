<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта http://mecoima.com/web/en
 * Class Drivers_ParserSite_MecoimaCom
 */
class Drivers_ParserSite_MecoimaCom extends Drivers_ParserSite_Basic
{
    public static function parserURLGoods($url, SitePageData $sitePageData){
        set_time_limit(3600000);
        ignore_user_abort(TRUE);
        ini_set('max_execution_time', 360000);

        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        if (file_exists( APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'mecoima.com-stop.txt')) {
            exit;
        }

        $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'mecoima.com-urls.txt';

        $isStop = TRUE;
        preg_match_all('/href="http:\/\/mecoima.com\/web\/en\/productes\/(.+)"/U', $data, $result);
        file_put_contents(APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'url.txt', $url.': '.print_r($result, TRUE)."\r\n" , FILE_APPEND);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            foreach ($result[1] as $url2){
                if (strpos($url2, 'feed/') !== FALSE){
                    continue;
                }
                $url2 = 'http://mecoima.com/web/en/productes/'.$url2;

                $urls = file_get_contents($path);
                $urls = explode("\r\n", $urls);
                $tmp = array();
                foreach ($urls as $url1) {
                    $tmp[$url1] = '';
                }
                $urls = $tmp;

                if (!key_exists($url2, $urls)){
                    echo $url2.'<br>';
                    self::parserURLGoods($url2, $sitePageData);

                    $isStop = FALSE;
                }

            }
        }else{
            print_r($data);die;
        }

        file_put_contents(APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'mecoima.com-urls.txt', $url."\r\n" , FILE_APPEND);

        $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'mecoima.com.txt';
        if (strpos($data, '<table class="principal_products">') === FALSE){
            file_put_contents($path, $url."\r\n" , FILE_APPEND);
        }

        if($isStop) {
            $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'mecoima.com-finish.txt';
            file_put_contents($path, '', FILE_APPEND);
        }
    }

    /**
     * Загрузка картинок используя макску, возвращающия массив из двух элементов
     * @param $pattern
     * @param $text
     * @param Model_Basic_Files $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     */
    private static function _parserImage($pattern, $text, Model_Basic_Files $model, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver){
        preg_match_all($pattern, $text, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            foreach ($result[1] as $urlImage) {
                $urlImage = trim($urlImage);
                try {
                    $file = new Model_File($sitePageData);
                    $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver, FALSE);
                } catch (Exception $e) {
                }
            }
        }
    }

    /**
     * Загружаем данные о об одном товаре
     * @param $url
     * @param $shopTableCatalogID
     * @param Model_Shop_Good $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     */
    public static function parserEN($url, $shopTableCatalogID, Model_Shop_Good $model, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        $sitePageData->dataLanguageID = Model_Language::LANGUAGE_ENGLISH;

        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        // возвращаем список ссылок на товары в списке
        if(Request_RequestParams::getParamBoolean('is_url')) {
            self::parserURLGoods($url, $sitePageData);
            die;
        }

        // Название
        preg_match_all('/<h1 class="entry-title">(.+)<\/h1>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) == 1)){
            $name = trim($result[1][0]);
        }

        if (empty($name)) {
            return FALSE;
        }

        // Описание
        preg_match_all('/<div class="entry-content">([\s\S]+)<\/div><!-- .entry-content -->/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) == 1)){
            $data =  html_entity_decode(trim($result[1][0]));
            $data = str_replace(
                '<img title="pdf para guardar/imprimir" src="http://www.mecoima.com/img/pdf30.gif" alt="" width="30" height="29" align="top" border="0" />',
                '',
                $data
            );

            // ссылки заменяем на выделения
            $data = self::replaceURLByStrong($data);
        }

        /** разбиваем таблицу на tr первого уровня **/
        $trs = array();
        $from = strpos($data, '<tr>');
        if ($from !== FALSE) {
            $prefix = substr($data, 0, $from);

            $n = 0;
            while (($from !== FALSE) && ($n < 100)) {
                $n++;
                $to = strpos($data, '</tr>', $from);
                if ($to === FALSE) {
                    break;
                }
                $to = $to + strlen('</tr>');

                $s = substr($data, $from, $to - $from);
                $fromChild = strpos($s, '<tr>', strlen('<tr>'));
                while ($fromChild !== FALSE) {
                    $toNext = strpos($data, '</tr>', $to);
                    if ($toNext === FALSE) {
                        $to = FALSE;
                        break 2;
                    }
                    $toNext = $toNext + strlen('</tr>');

                    $s = substr($data, $to, $toNext - $to);
                    $fromChild = strpos($s, '<tr>');
                    $to = $toNext;
                }
                $s = substr($data, $from, $to - $from);
                $trs[] = $s;

                $from = strpos($data, '<tr>', $to);
            }
            if($n == 100){
                echo 'жопа'; die;
            }

            if ($to === FALSE) {
                $trs = array();
                $prefix = '';
                $postfix = $data;
            } else {
                $postfix = substr($data, $to);
            }
        }else{
            $prefix = '';
            $postfix = $data;
        }

        /** Находим сколько товаров в таблице **/
        $goods = array();
        $index = -1;
        foreach ($trs as $key => $tr){
            $from = strpos($tr, 'width="580"><strong>Ref.');
            if ($from === FALSE){
                if($index < 0){
                    $prefix = $prefix . $tr;
                    unset($trs[$key]);
                }else{
                    $goods[$index] .= $tr;
                }
            }else{
                $index++;
                $goods[$index] = $tr;
            }
        }

        // если не найдено ни одного товара по разбивки "width="580"><strong>Ref.", то считаем, что все один товар
        if (count($goods) == 0) {
            $goods[0] = $prefix . $postfix;
            $prefix = '';
            $postfix = '';
        }

        /** Созадаем нужные товары **/
        foreach ($goods as $childText) {

            $from = strpos($childText, 'width="580"><strong>Ref.');
            if ($from !== FALSE) {
                $from = $from + strlen('width="580"><strong>');

                $n1 = strpos($childText, '</strong>', $from);

                $nameChild = substr(
                    $childText,
                    $from,
                    $n1 - $from
                );
                $oldID = $name . ' '. $nameChild;
            }else{
                $oldID = $name;
            }

            $isAddRussian = TRUE;
            $params = Request_RequestParams::setParams(
                array(
                    'old_id' => $oldID,
                    'type' => $shopTableCatalogID,
                    'is_delete' => FALSE,
                )
            );
            $shopGoodIDs = Request_Request::find('DB_Shop_Good',$sitePageData->shopID, $sitePageData,
                $driver, $params, 1, TRUE);
            if (count($shopGoodIDs->childs) == 1) {
                $model->__setArray(array('values' => $shopGoodIDs->childs[0]->values));
                $isAddRussian = FALSE;
            } else {
                $model->clear();
                $model->setOldID($oldID);
                $model->setShopTableCatalogID($shopTableCatalogID);
            }

            $model->setName($oldID . ' Mecoima');

            // Картинки
            if (Func::_empty($model->getImagePath())) {
                self::_parserImage('/<p align="center"><img src="(.+)"/U', $childText, $model, $sitePageData, $driver);
                self::_parserImage('/<p align="center"> <img src="(.+)"/U', $childText, $model, $sitePageData, $driver);
                self::_parserImage('/<p> <img src="(.+)"/U', $childText, $model, $sitePageData, $driver);
            }

            $text = str_replace('width="580"', '', $prefix . $childText . $postfix);
            $text = preg_replace('/height="(.+)"/U', '', $text);
            $text = preg_replace('/width="(.+)"/U', '', $text);
            $text = preg_replace('/<tr>[\s]+<td colspan="2" ><\/td>[\s]+<\/tr>/U', '', $text);
            $text = preg_replace('/<tr>[\s]+<td colspan="2" >&nbsp;<\/td>[\s]+<\/tr>/U', '', $text);
            $text = preg_replace('/<tr>[\s]+<td colspan="2" > <\/td>[\s]+<\/tr>/U', '', $text);
            $text = str_replace('<span style="font-size: small;">', '<span>', $text);
            $text = str_replace('<table>', '<table style="width: 100%;">', $text);
            $text = preg_replace('/style="color:[\s]*(.+);"/U', '', $text);
            $text = preg_replace('/bgcolor="(.+)"/U', '', $text);
            $text = str_replace('<img ', '<img style="max-height: 500px;" ', $text);

            // загружаем нужные картинки
            $text = self::parserImageText($text, $model, $sitePageData, $driver);

            if ((!empty($text)) && ($isReplace || (Func::_empty($model->getText())))) {
                $model->setText($text);
            }

            $model->setDBDriver($driver);

            if ($model->id == 0) {
                $model->setIsTranslatesCurrentLanguage(TRUE, $sitePageData->dataLanguageID, $sitePageData->shop->getLanguageIDsArray());
            }
            $model->setNameURL(Helpers_URL::getNameURL($model));
            Helpers_DB::saveDBObject($model, $sitePageData);

            if ($isAddRussian) {
                $model->globalID = 0;
                $model->dbSave(Model_Language::LANGUAGE_RUSSIAN, $sitePageData->userID, $sitePageData->shopID);
            } else {
                $sitePageData->dataLanguageID = Model_Language::LANGUAGE_RUSSIAN;
                if (Helpers_DB::getDBObject($model, $model->id, $sitePageData)) {
                    $model->setName($oldID . ' Mecoima');
                    Helpers_DB::saveDBObject($model, $sitePageData);
                }
            }
        }

        return TRUE;
    }
}
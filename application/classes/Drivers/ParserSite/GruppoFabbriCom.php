<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта http://www.gruppofabbri.com
 * Class Drivers_ParserSite_GruppoFabbriCom
 */
class Drivers_ParserSite_GruppoFabbriCom extends Drivers_ParserSite_Basic
{
    public static function parserURLGoods($url, SitePageData $sitePageData){
        set_time_limit(3600000);
        ignore_user_abort(TRUE);
        ini_set('max_execution_time', 360000);

        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        preg_match_all('/<div class="readMore"><a href="(.+)"\s+title="(.+)">читать далее<\/a><\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) && (count($result[1]) > 0)){
            foreach ($result[1] as $url){
                if (strpos($url, 'http://www.gruppofabbri.com') === FALSE){
                    $url = 'http://www.gruppofabbri.com' . $url;
                }
                echo $url.'<br>'."\r\n";
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
     * @throws HTTP_Exception_500
     */
    public static function parserENAndRus($url, $shopTableCatalogID, Model_Shop_Good $model, SitePageData $sitePageData,
                                    Model_Driver_DBBasicDriver $driver, $isReplace = TRUE){
        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        // возвращаем список ссылок на товары в списке
        if(Request_RequestParams::getParamBoolean('is_url')) {
            self::parserURLGoods($url, $sitePageData);
            die;
        }


        $name = '';
        preg_match_all('/<h2 class="bigTitle">(.+)<\/h2>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $name = trim($result[1][0]);
        }

        if(empty($name)){
            return FALSE;
        }

        $params = Request_RequestParams::setParams(
            array(
                'old_id' => $name,
                'type' => $shopTableCatalogID,
                'is_delete' => FALSE,
            )
        );
        if (strpos($url, 'http://www.gruppofabbri.com/ru/') !== FALSE){
            $sitePageData->dataLanguageID = Model_Language::LANGUAGE_RUSSIAN;

            $shopGoodIDs = Request_Request::find('DB_Shop_Good',$sitePageData->shopID, $sitePageData,
                $driver, $params, 1, TRUE);
            if(count($shopGoodIDs->childs) == 1){
                $model->__setArray(array('values' => $shopGoodIDs->childs[0]->values));
            }else{
                $model->setOldID($name);
            }
        }elseif (strpos($url, 'http://www.gruppofabbri.com/en/') !== FALSE){
            $sitePageData->dataLanguageID = Model_Language::LANGUAGE_ENGLISH;

            $shopGoodIDs = Request_Request::find('DB_Shop_Good',$sitePageData->shopID, $sitePageData,
                $driver, $params, 1, TRUE);
            if(count($shopGoodIDs->childs) == 1){
                $model->__setArray(array('values' => $shopGoodIDs->childs[0]->values));
            }else{
                $model->setOldID($name);
            }
        }else{
            return FALSE;
        }

        $model->setShopTableCatalogID($shopTableCatalogID);

        $sitePageData->dataLanguageID = Model_Language::LANGUAGE_RUSSIAN;
        $url = str_replace('http://www.gruppofabbri.com/en/', 'http://www.gruppofabbri.com/ru/', $url);
        self::_parserRus($url, $model, $sitePageData, $driver, $isReplace);

        $sitePageData->dataLanguageID = Model_Language::LANGUAGE_ENGLISH;
        $model->globalID = 0;
        $model->addOptionsArray(array('table' => array()));
        $url = str_replace('http://www.gruppofabbri.com/ru/', 'http://www.gruppofabbri.com/en/', $url);
        self::_parserEn($url, $model, $sitePageData, $driver, TRUE);

        return TRUE;

    }

    /**
     * Загружаем данные о об одном товаре на руссом
     * @param $url
     * @param Model_Shop_Good $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     */
    private static function _parserRus($url, Model_Shop_Good $model, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {

        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        // название
        preg_match_all('/<h2 class="bigTitle">(.+)<\/h2>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $name = trim($result[1][0]);
            $model->setName($name. ' Fabbri Group');
        }

        // Картинка
        preg_match_all('/<div class="productImage">\s+<img src="(.+)" border="0" alt="([\s\S]+)"/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) && (count($result[1]) > 0)){
            $urlImage = trim($result[1][0]);
            if (Func::_empty($model->getImagePath())) {
                try {
                    $file = new Model_File($sitePageData);
                    $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver, TRUE, TRUE, trim($result[2][0]));
                } catch (Exception $e) {
                }


                preg_match_all('/<div class="finalContainer">([\s\S]+)<\/div>/U', $data, $result);
                if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
                    $images = trim($result[1][0]);
                    preg_match_all('/<img src="(.+)" border="0" alt="([\s\S]+)"/U', $images, $result);
                    if ((is_array($result)) && (count($result) == 3) && (count($result[1]) > 0)){
                        for($i = 0; $i < count($result[1]); $i++){
                            $urlImage = trim($result[1][$i]);
                            try {
                                $file = new Model_File($sitePageData);
                                $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver, FALSE, TRUE, trim($result[2][$i]));
                            } catch (Exception $e) {
                            }
                        }
                    }

                }
            }
        }

        // ссылка на youtube
        preg_match_all('/<iframe src="https:\/\/www.youtube.com(.+)"/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $youtube = 'https://www.youtube.com'.trim($result[1][0]);
            $model->addOptionsArray(array('youtube' => $youtube));
        }

        // Описание
        $text = '';
        preg_match_all('/<p class="textInfoGeneric">([\s\S]+)<\/p>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $text =  '<p>'.html_entity_decode(trim($result[1][0])).'</p> ';
        }

        // Дополнительно
        preg_match_all('/<div class="lineDivider"><span class="optProduct">([\s\S]+)<\/span><\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $params = '';
            for($i = 0; $i < count($result[1]); $i++){
                $value = trim($result[1][$i]);
                if(strpos($value, '<span class="optProductCustom">') === FALSE){
                    $params .= '<li>'.$value.'</li>';
                }
            }
            if (!empty($params)) {
                $text .= '<ul>' . $params . '</ul>';
            }
        }

        if ((!empty($text)) && ($isReplace || (Func::_empty($model->getText())))) {
            $text = self::processingText($text, $model, $sitePageData, $driver);
            $model->setText($text);
        }

        // числовые параметры
        preg_match_all('/<div class="singleNumber">\s+<div class="bigNumber">([\s\S]+)<\/div>\s+<div class="textNumber">([\s\S]+)<\/div>\s+<\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) && (count($result[2]) > 0)){
            $arr = Arr::path($model->getOptionsArray(), 'table', array());

            $table = array();
            foreach ($arr as $child){
                $table[Arr::path($child, 'name', '')] = $child;
            }

            for($i = 0; $i < count($result[2]); $i++){
                $field = trim($result[2][$i]);

                $n = strpos($field, ':');
                if($n === FALSE){
                    $value = trim($result[1][$i]);
                }else{
                    $value = trim(substr($field, $n + 1));
                    $field = trim(substr($field, 0, $n));
                }

                if($isReplace || (!key_exists($field, $table))){
                    $table[$field] = array(
                        'is_public' => TRUE,
                        'name' => $field,
                        'title' => $value,
                    );
                }
            }

            $model->addOptionsArray(array('table' => $table));
        }

        // Основные характеристики
        preg_match_all('/<div class="lineDivider"><span class="optProduct">([\s\S]+)<\/span><span class="optProductCustom">([\s\S]+)<\/span><\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) && (count($result[2]) > 0)){
            $arr = Arr::path($model->getOptionsArray(), 'table', array());

            $table = array();
            foreach ($arr as $child){
                $table[Arr::path($child, 'name', '')] = $child;
            }

            for($i = 0; $i < count($result[2]); $i++){
                $field = trim($result[1][$i]);
                $value = trim($result[2][$i]);

                if($isReplace || (!key_exists($field, $table))){
                    $table[$field] = array(
                        'is_public' => TRUE,
                        'name' => $field,
                        'title' => $value,
                    );
                }
            }

            $model->addOptionsArray(array('table' => $table));
        }

        $model->setDBDriver($driver);

        if($model->id == 0) {
            $model->setIsTranslatesCurrentLanguage(TRUE, $sitePageData->dataLanguageID, $sitePageData->shop->getLanguageIDsArray());
        }
        $model->setNameURL(Helpers_URL::getNameURL($model));
        Helpers_DB::saveDBObject($model, $sitePageData);

        return TRUE;
    }

    /**
     * Загружаем данные о об одном товаре на руссом
     * @param $url
     * @param Model_Shop_Good $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     */
    private static function _parserEn($url, Model_Shop_Good $model, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {

        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        // название
        preg_match_all('/<h2 class="bigTitle">(.+)<\/h2>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $name = trim($result[1][0]);
            $model->setName($name. ' Fabbri Group');
        }

        // Описание
        $text = '';
        preg_match_all('/<p class="textInfoGeneric">([\s\S]+)<\/p>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $text =  '<p>'.html_entity_decode(trim($result[1][0])).'</p> ';
        }

        // Дополнительно
        preg_match_all('/<div class="lineDivider"><span class="optProduct">([\s\S]+)<\/span><\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $params = '';
            for($i = 0; $i < count($result[1]); $i++){
                $value = trim($result[1][$i]);
                if(strpos($value, '<span class="optProductCustom">') === FALSE){
                    $params .= '<li>'.$value.'</li>';
                }
            }
            if (!empty($params)) {
                $text .= '<ul>' . $params . '</ul>';
            }
        }

        if ((!empty($text)) && ($isReplace || (Func::_empty($model->getText())))) {
            // ссылки заменяем на выделения
            $text = self::replaceURLByStrong($text);
            $text = self::parserImageText($text, $model, $sitePageData, $driver);

            $text = str_replace('<p><br/></p>', '',
                str_replace('<p>&nbsp;</p>', '', $text));
            $model->setText($text);
        }

        // числовые параметры
        preg_match_all('/<div class="singleNumber">\s+<div class="bigNumber">([\s\S]+)<\/div>\s+<div class="textNumber">([\s\S]+)<\/div>\s+<\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) && (count($result[2]) > 0)){
            $arr = Arr::path($model->getOptionsArray(), 'table', array());

            $table = array();
            foreach ($arr as $child){
                $table[Arr::path($child, 'name', '')] = $child;
            }

            for($i = 0; $i < count($result[2]); $i++){
                $field = trim($result[2][$i]);

                $n = strpos($field, ':');
                if($n === FALSE){
                    $value = trim($result[1][$i]);
                }else{
                    $value = trim(substr($field, $n + 1));
                    $field = trim(substr($field, 0, $n));
                }

                if($isReplace || (!key_exists($field, $table))){
                    $table[$field] = array(
                        'is_public' => TRUE,
                        'name' => $field,
                        'title' => $value,
                    );
                }
            }

            $model->addOptionsArray(array('table' => $table));
        }

        // Основные характеристики
        preg_match_all('/<div class="lineDivider"><span class="optProduct">([\s\S]+)<\/span><span class="optProductCustom">([\s\S]+)<\/span><\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) && (count($result[2]) > 0)){
            $arr = Arr::path($model->getOptionsArray(), 'table', array());

            $table = array();
            foreach ($arr as $child){
                $table[Arr::path($child, 'name', '')] = $child;
            }

            for($i = 0; $i < count($result[2]); $i++){
                $field = trim($result[1][$i]);
                $value = trim($result[2][$i]);

                if($isReplace || (!key_exists($field, $table))){
                    $table[$field] = array(
                        'is_public' => TRUE,
                        'name' => $field,
                        'title' => $value,
                    );
                }
            }

            $model->addOptionsArray(array('table' => $table));
        }

        $model->setDBDriver($driver);

        if($model->globalID == 0) {
            $model->setIsTranslatesCurrentLanguage(TRUE, Model_Language::LANGUAGE_ENGLISH, $sitePageData->shop->getLanguageIDsArray());
        }
        $model->setNameURL(Helpers_URL::getNameURL($model));
        Helpers_DB::saveDBObject($model, $sitePageData);

        return TRUE;
    }


}
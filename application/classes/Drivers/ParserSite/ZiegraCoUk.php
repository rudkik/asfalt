<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта http://www.ziegra.co.uk/
 * Class Drivers_ParserSite_ZiegraCoUk
 */
class Drivers_ParserSite_ZiegraCoUk extends Drivers_ParserSite_Basic
{
    public static function parserURLGoods($url, SitePageData $sitePageData){
        set_time_limit(3600000);
        ignore_user_abort(TRUE);
        ini_set('max_execution_time', 360000);

        $data = Helpers_URL::getDataURLEmulationBrowser($url);
        file_put_contents(APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'ziegra.co.uk-urls.txt', $url."\r\n" , FILE_APPEND);


        $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'ziegra.co.uk.txt';
        preg_match_all('/href="\/product\/(.+)"/U', $data, $result);
        file_put_contents(APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'product.txt', $url.': '.print_r($result, TRUE)."\r\n" , FILE_APPEND);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            foreach ($result[1] as $url3){
                file_put_contents($path, 'http://www.ziegra.co.uk/product/'.$url3."\r\n" , FILE_APPEND);
            }
        }

        if (file_exists( APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'ziegra.co.uk-stop.txt')) {
            exit;
        }

        $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'ziegra.co.uk-urls.txt';

        $isStop = TRUE;
        preg_match_all('/href="(.+)"/U', $data, $result);
        file_put_contents(APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'url.txt', $url.': '.print_r($result, TRUE)."\r\n" , FILE_APPEND);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            foreach ($result[1] as $url2){
                if ((strpos($url2, ':') !== FALSE)
                    || (strpos($url2, '.') !== FALSE)){
                    continue;
                }

                if (strpos($url2, 'http://') === FALSE) {
                    $url2 = 'http://www.ziegra.co.uk' . $url2;
                }

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

        if($isStop) {
            $path = APPPATH . 'logs' . DIRECTORY_SEPARATOR . 'ziegra.co.uk-finish.txt';
            file_put_contents($path, '', FILE_APPEND);
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
        $isAddRussian = TRUE;
        preg_match_all('/<h1>(.+)<\/h1>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) == 1)){
            $name = trim($result[1][0]);
            $oldID = $name;

            if (!empty($name)) {
                $params = Request_RequestParams::setParams(
                    array(
                        'old_id' => $oldID,
                        'type' => $shopTableCatalogID,
                        'is_delete' => FALSE,
                    )
                );
                $shopGoodIDs = Request_Request::find('DB_Shop_Good',$sitePageData->shopID, $sitePageData,
                    $driver, $params, 1, TRUE);
                if(count($shopGoodIDs->childs) == 1){
                    $model->__setArray(array('values' => $shopGoodIDs->childs[0]->values));
                    $isAddRussian = FALSE;
                }else{
                    $model->setOldID($oldID);
                }

                $model->setName($name.' Ziegra');
            }
        }

        if(Func::_empty($model->getName())){
            return FALSE;
        }
        $model->setShopTableCatalogID($shopTableCatalogID);


        // Картинка
        preg_match_all('/<img id="cphScaffoldContainer_cphContainer_cphContent1_ctl01_imgProductImage" title="([\s\S]+)" class="img-responsive" src="(.+)"/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) && (count($result[2]) == 1)){
            $urlImage = 'http://www.ziegra.co.uk'.trim($result[2][0]);
            if (Func::_empty($model->getImagePath())) {
                try {
                    $file = new Model_File($sitePageData);
                    $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver);
                } catch (Exception $e) {
                }
            }
        }

        // Описание
        $text = '';
        preg_match_all('/<\/h1>[\s]+<div class="row">[\s]+<div class="col-xs-8">[\s]+<p>([\s\S]+)<\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) == 1)){
            $text =  html_entity_decode(trim($result[1][0]));

            // ссылки заменяем на выделения
            $text = self::replaceURLByStrong($text);

            $text = self::parserImageText($text, $model, $sitePageData, $driver, 'http://www.ziegra.co.uk');
        }

        // считываем вкладки
        preg_match_all('/<ul class="nav nav-tabs" role="tablist">[\s]+([\s\S]+)<\/ul>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) == 1)) {
            $tmp = trim($result[1][0]);
            preg_match_all('/<li id="(.+)"><a href="#(.+)" role="tab" data-toggle="tab">([\s\S]+)<\/a><\/li>/U', $tmp, $result);

            if ((is_array($result)) && (count($result) == 4) && (count($result[2]) > 1)) {
                for ($i = 0; $i < count($result[2]); $i++) {
                    $tabID = trim($result[2][$i]);
                    $tabName = trim($result[3][$i]);

                    switch ($tabID) {
                        case 'specifications':
                            self::_parserSpecificationsEN($tabID, $data, $model, $isReplace);
                            break;
                        case 'connections':
                        case 'dimensions':
                        case 'included':
                        case 'options':
                        $text = $text . ' '
                            .self::_parserAdditionTextEN($tabID, $tabName, $data, $model, $sitePageData, $driver);
                            break;
                    }
                }
            }
        }

        if ((!empty($text)) && ($isReplace || (Func::_empty($model->getText())))) {
            $text = str_replace('<p><br/></p>', '',
                str_replace('<p>&nbsp;</p>', '', $text));
            $model->setText($text);
        }

        $model->setDBDriver($driver);

        if($model->id == 0) {
            $model->setIsTranslatesCurrentLanguage(TRUE, $sitePageData->dataLanguageID, $sitePageData->shop->getLanguageIDsArray());
        }
        $model->setNameURL(Helpers_URL::getNameURL($model));
        Helpers_DB::saveDBObject($model, $sitePageData);

        if ($isAddRussian) {
            $model->globalID = 0;
            $model->dbSave(Model_Language::LANGUAGE_RUSSIAN, $sitePageData->userID, $sitePageData->shopID);
        }else{
            // при первой загрузки добавлял изменение название у существующих товаров в будущем не нужно
            if (FALSE) {
                $sitePageData->dataLanguageID = Model_Language::LANGUAGE_RUSSIAN;
                if (Helpers_DB::getDBObject($model, $model->id, $sitePageData)) {
                    $model->setName($name . ' Ziegra');
                    Helpers_DB::saveDBObject($model, $sitePageData);
                }
            }
        }

        return TRUE;
    }


    /**
     * Загрузка технических данных
     * @param $tabID
     * @param $data
     * @param Model_Shop_Good $model
     * @param $isReplace
     */
    public static function _parserSpecificationsEN($tabID, $data, Model_Shop_Good $model, $isReplace){
        $arr = Arr::path($model->getOptionsArray(), 'table', array());
        $options = array();
        foreach ($arr as $child){
            $options[Arr::path($child, 'name', '')] = $child;
        }


        preg_match_all('/<div class="tab-pane" id="'.$tabID.'">([\s\S]+)<\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) == 1)){
            $table = trim($result[1][0]);
            preg_match_all('/<tr>([\s\S]+)<\/tr>/U', $table, $result);
            if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 1)){
                for ($i = 0; $i < count($result[1]); $i++){
                    $tr = trim($result[1][$i]);

                    preg_match_all('/<td([\s\S]+)>([\s\S]+)<\/td>[\s]+<td([\s\S]+)>([\s\S]+)<\/td>/U', $tr, $resultTr);
                    if ((is_array($resultTr)) && (count($resultTr) == 5) && (count($resultTr[2]) == 1)){
                        $field = self::replaceURLByStrong(html_entity_decode(Func::trimTextNew(trim($resultTr[2][0]))));
                        $value = self::replaceURLByStrong(html_entity_decode(Func::trimTextNew(trim($resultTr[4][0]))));

                        if($isReplace || (!key_exists($field, $options))){
                            $options[$field] = array(
                                'is_public' => TRUE,
                                'name' => $field,
                                'title' => $value,
                            );
                        }
                    }
                }
            }
        }
        $model->addOptionsArray(array('table' => $options));
    }


    /**
     * Загрузка дополнительный тект
     * @param $tabID
     * @param $tabName
     * @param $data
     * @param Model_Shop_Good $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return string
     */
    public static function _parserAdditionTextEN($tabID, $tabName, $data, Model_Shop_Good $model,
                                                 SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        preg_match_all('/<div class="tab-pane" id="'.$tabID.'">([\s\S]+)<\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) == 1)){
            $text = trim($result[1][0]);

            // загружаем картинки
            $text = self::parserImageText($text, $model, $sitePageData, $driver, 'http://www.ziegra.co.uk');

            // ссылки заменяем на выделения
            $text = self::replaceURLByStrong($text);


        }

        return '<h3>'.$tabName.'</h3>'.$text;
    }
}
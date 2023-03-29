<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта http://techelectro.ru/
 * Class Drivers_ParserSite_TechelectroRU
 */
class Drivers_ParserSite_TechelectroRU extends Drivers_ParserSite_Basic
{
    /**
     * Парсим файл https://techelectro.ru/sitemap.xml и находим ссылки на продукцию
     * @param $url
     * @param SitePageData $sitePageData
     */
    public static function parserURLGoods($url, SitePageData $sitePageData){
        set_time_limit(3600000);
        ignore_user_abort(TRUE);
        ini_set('max_execution_time', 360000);

        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        preg_match_all('/<loc>https:\/\/techelectro.ru\/prod\/(.+)\/<\/loc>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            foreach ($result[1] as $url){
                if ((substr_count($url, '/') == 2) || (substr_count($url, '/') == 1)){
                    $url = 'https://techelectro.ru/prod/' . $url . '/';
                    echo $url.'<br>'."\r\n";
                }
            }
        }

        preg_match_all('/<loc>http:\/\/techelectro.ru\/prod\/(.+)\/<\/loc>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            foreach ($result[1] as $url){
                if ((substr_count($url, '/') == 2) || (substr_count($url, '/') == 1)){
                    $url = 'http://techelectro.ru/prod/' . $url . '/';
                    echo $url.'<br>'."\r\n";
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
     * @throws HTTP_Exception_500
     */
    public static function parserRus($url, $shopTableCatalogID, Model_Shop_Good $model, SitePageData $sitePageData,
                                     Model_Driver_DBBasicDriver $driver, $isReplace = TRUE){
        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        // возвращаем список ссылок на товары в списке
        if(Request_RequestParams::getParamBoolean('is_url')) {
            self::parserURLGoods('https://techelectro.ru/sitemap.xml', $sitePageData);
            die;
        }

        $text = '';
        preg_match_all('/<div class="editable-text" umi:element-id="(.+)" umi:field-name="descr" umi:empty="Содержание страницы">([\s\S]+)<\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) && (count($result[2]) > 0)){
            $text = trim($result[2][0]);
        }

        preg_match_all('/<td class="tooltip">([\s]*)<a href="\/prod\/(.+)">/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) && (count($result[2]) > 0)){
            foreach ($result[2] as $key){
                self::_parserOneRus('https://techelectro.ru/prod/' . $key, $shopTableCatalogID, $text, $model, $sitePageData, $driver, $isReplace);
            }
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /**
     * Загружаем данные о об одном товаре на русском сопоставляем по артиклу
     * @param $url
     * @param $shopTableCatalogID
     * @param $text
     * @param Model_Shop_Good $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     */
    private static function _parserOneRus($url, $shopTableCatalogID, $text, Model_Shop_Good $model, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        $article = '';
        preg_match_all('/<p itemprop="productID" content="">код товара: <b>(.+)<\/b><\/p>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $article = trim($result[1][0]);
        }

        if(empty($article)){
            return FALSE;
        }

        $params = Request_RequestParams::setParams(
            array(
                'article_full' => $article,
                'type' => $shopTableCatalogID,
                'is_delete' => FALSE,
            )
        );
        $shopGoodIDs = Request_Request::find('DB_Shop_Good',$sitePageData->shopID, $sitePageData,
            $driver, $params, 0, TRUE);
        foreach ($shopGoodIDs->childs as $child) {
            $child->setModel($model);
            self::_parserRus($data, $text, $model, $sitePageData, $driver, $isReplace);
        }
        return TRUE;
    }

    /**
     * Загружаем данные о об одном товаре на руссом
     * @param $data
     * @param $info
     * @param Model_Shop_Good $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     */
    private static function _parserRus($data, $info, Model_Shop_Good $model, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        $options = array();

        // размеры изделия
        preg_match_all('/<table>([\s\S]+)<\/table>/U', trim($data), $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0) && (strpos($result[1][0], 'Размеры (мм)') !== FALSE)) {
            preg_match_all('/<th>([\s\S]+)<\/th>/U', trim($result[1][0]), $th);
            preg_match_all('/<td>([\s\S]+)<\/td>/U', trim($result[1][0]), $td);
            if ((is_array($th)) && (count($th) == 2) && (count($th[1]) > 0)
                && (is_array($td)) && (count($td) == 2) && (count($td[1]) > 0)
                && (count($th[1]) == count($td[1]))) {
                for ($i = 0; $i < count($th[1]); $i++) {
                    $key = trim($th[1][$i]);
                    if ($key == 'Размеры (мм)') {
                        continue;
                    }

                    $options[$key] = trim($td[1][$i]);
                }
            }
        }

        // параметры + текст
        preg_match_all('/<ul class="obj-description" itemprop="description">([\s\S]+)<\/ul>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            preg_match_all('/<li>([\s\S]+)<\/li>/U', trim($result[1][0]), $result);
            if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)) {
                $text = '';
                foreach ($result[1] as $value){
                    $n = mb_strpos($value, ':');
                    if($n !== FALSE){
                       $key = trim(mb_substr($value, 0, $n - 1));
                       $value = trim(mb_substr($value, $n + 1));
                       $options[$key] = $value;
                    }else{
                        $text .= '<li>'.trim($value).'</li>';
                    }
                }

                if ((!empty($text)) && ($isReplace || (Func::_empty($model->getText())))) {
                    $text = '<ul>' . self::processingText($text, $model, $sitePageData, $driver) . '</ul>';
                    $info = self::processingText($info, $model, $sitePageData, $driver);
                    $model->setText($text . $info);
                }
            }
        }
        $model->addOptionsArray($options);

        // Картинка
        preg_match_all('/<img itemprop="image" class="icon-image" src="(.+)">/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $urlImage = 'http://techelectro.ru'.trim($result[1][0]);
            if (Func::_empty($model->getImagePath())) {
                try {
                    $info = pathinfo($urlImage);
                    $ultFile = $info['dirname'] . '/origin/' .$info['filename'] . '.jpg';

                    $file = new Model_File($sitePageData);
                    $file->addImageURLInModel($ultFile, $model, $sitePageData, $driver, TRUE, TRUE);
                } catch (Exception $e) {
                    $file = new Model_File($sitePageData);
                    $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver, TRUE, TRUE);
                }

                preg_match_all('/<img class="draw-image" src="(.+)">/U', $data, $result);
                if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)) {
                    $urlImage = 'http://techelectro.ru' . trim($result[1][0]);
                    try {
                        $file = new Model_File($sitePageData);
                        $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver, FALSE);
                    } catch (Exception $e) {
                    }
                }
            }
        }else {
            preg_match_all('/<img src="(.+)" width="150"/U', $data, $result);
            if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)) {
                $urlImage = 'http://techelectro.ru' . trim($result[1][0]);
                if (Func::_empty($model->getImagePath())) {
                    try {
                        $file = new Model_File($sitePageData);
                        $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver, TRUE, TRUE);
                    } catch (Exception $e) {
                    }

                    preg_match_all('/<img class="draw-image" src="(.+)">/U', $data, $result);
                    if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)) {
                        $urlImage = 'http://techelectro.ru' . trim($result[1][0]);
                        try {
                            $file = new Model_File($sitePageData);
                            $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver, FALSE);
                        } catch (Exception $e) {
                        }
                    }
                }
            }
        }

        $model->setDBDriver($driver);
        $model->setNameURL(Helpers_URL::getNameURL($model));
        Helpers_DB::saveDBObject($model, $sitePageData);

        return TRUE;
    }
}
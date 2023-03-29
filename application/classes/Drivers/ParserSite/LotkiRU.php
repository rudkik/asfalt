<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта https://www.lotki.ru
 * Поиск товаров: https://www.lotki.ru/search/index.php?q=#Данные запроса#
 * Class Drivers_ParserSite_LotkiRU
 */
class Drivers_ParserSite_LotkiRU extends Drivers_ParserSite_Basic
{
    // URL поиска товаров
    const URL_FIND = 'https://www.lotki.ru/search/index.php?q=#QUERY#';

    /**
     * Загружаем данные о об одном товаре
     * @param $url
     * @param Model_Shop_Good $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     */
    public static function loadOneInObject($url, Model_Shop_Good $model, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        if(!Func::_empty($model->getOldID())){
            return FALSE;
        }

        $article = $model->getArticle();
        $model->setOldID($article);

        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        // атрибуты
        preg_match_all('/<dl>([\s\S]+)<\/dl>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){

            preg_match_all('/<dt>(.+)<\/dt><dd>(.+)<\/dd>/U', trim($result[1][0]), $result);
            if ((is_array($result)) && (count($result) == 3) && (count($result[1]) > 0)){
                $options = array();
                for($i = 0; $i < count($result[1]); $i++){
                    $name = trim($result[1][$i]);
                    if(($name == 'Артикул') || ($name == 'Цена')){
                        continue;
                    }
                    $value = trim($result[2][$i]);

                    $options[$name] = $value;
                }
                $model->addOptionsArray($options, $isReplace);
            }
        }

        // изображения
        if (Func::_empty($model->getImagePath())) {
            preg_match_all('/<span class="bx_bigimages_aligner">([\s\S]+)<\/span>/U', $data, $result);
            if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)) {
                for ($i = 0; $i < count($result[1]); $i++) {
                    preg_match_all('/<img([\s\S]+)src="(.+)"/U', trim($result[1][$i]), $imgs);
                    if ((is_array($imgs)) && (count($imgs) == 3) && (count($imgs[2]) > 0)) {
                        for ($j = 0; $j < count($imgs[2]); $j++) {
                            $urlImage = 'https://www.lotki.ru' . trim($imgs[2][$j]);
                            $ext = strtolower(pathinfo($urlImage, PATHINFO_EXTENSION));
                            if (($ext != 'png') && ($ext != 'jpg') && ($ext != 'PNG') && ($ext != 'JPG')) {
                                continue;
                            }

                            try {
                                $file = new Model_File($sitePageData);
                                $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver);
                            } catch (Exception $e) {
                            }
                        }
                    }
                }
            }
        }

        // описание
        $n = strpos($data, '</dl>');
        if($n !== FALSE){
            $data = substr($data, $n);
        }

        preg_match_all('/<div class="item_info_section">([\s\S]+)<\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $text = '';
            for($i = 0; $i < count($result[1]); $i++){
                $text .= trim($result[1][$i]);
            }
            if ((!empty($text)) && ($isReplace || (Func::_empty($model->getText())))) {
                $model->setText($text);
            }
        }

        Helpers_DB::saveDBObject($model, $sitePageData);

        return TRUE;
    }


    /**
     * Загружаем данные о об одном товаре
     * @param $article
     * @param Model_Shop_Good $model
     * @param sitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     */
    public static function findOneInObject($article, Model_Shop_Good $model, sitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        if (empty($article)){
            return FALSE;
        }

        if(!Func::_empty($model->getOldID())){
            return FALSE;
        }

        $data = Helpers_URL::getDataURLEmulationBrowser(str_replace('#QUERY#', urlencode($article), self::URL_FIND));
        if(strpos($data, 'К сожалению, на ваш поисковый запрос ничего не найдено.') !== FALSE){
            return FALSE;
        }

        $n = strpos($data, '<div class="search-page">');
        if($n === FALSE){
            return FALSE;
        }
        $data = substr($data, $n);

        $n = strpos($data, '</section>');
        if($n === FALSE){
            return FALSE;
        }
        $data = substr($data, 0, $n);



        preg_match_all('/<a href="\/catalog\/(.+)">/U', $data, $result);
        if ((!is_array($result)) || (count($result) != 2) || (count($result[1]) < 1)){
            return FALSE;
        }

        $url = 'https://www.lotki.ru/catalog/'.trim($result[1][0]);
        if (!empty($url)) {
            $result = self::loadOneInObject($url, $model, $sitePageData, $driver, $isReplace);
        }else{
            $result = TRUE;
        }

        return $result;
    }


    /**
     * Загружаем данные о об одном товаре
     * @param $article
     * @param $id
     * @param $shopID
     * @param Model_Shop_Good $model
     * @param sitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     * @throws HTTP_Exception_404
     */
    public static function findOne($article, $id, $shopID, Model_Shop_Good $model, sitePageData $sitePageData,
                                   Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        $model->setDBDriver($driver);
        if (!Helpers_DB::getDBObject($model, $id, $sitePageData, $shopID)){
            throw new HTTP_Exception_404('Goods not is found!');
        }

        if (empty($article)){
            $article = $model->getArticle();
        }

        if(mb_strlen($article) < 5){
            return FALSE;
        }

        return self::findOneInObject($article, $model, $sitePageData, $driver, $isReplace);
    }

}
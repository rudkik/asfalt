<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта https://stolicaholoda.ru/
 * Поиск товаров: https://stolicaholoda.ru/fastsearch.php?query=#Данные запроса#
 * Class Drivers_ParserSite_StolicaholodaRU
 */
class Drivers_ParserSite_StolicaholodaRU
{
    // URL поиска товаров
    const URL_FIND = 'https://stolicaholoda.ru/fastsearch.php?query=#QUERY#';

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
        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        preg_match_all('/<img class="photo"[\s\S]+itemprop="image" src="(.+)"/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) || (count($result[1]) > 0)){
            foreach ($result[1] as $urlImage) {
                $urlImage = str_replace('thumb/50x50/', '', $urlImage);
                $urlImage = 'https:'.$urlImage;
                try {
                    $file = new Model_File($sitePageData);
                    $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver);
                } catch (Exception $e) {
                }
            }
        }

        $options = array();
        preg_match_all('/<table class="forcon characteristic">([\s\S]+)<\/table>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) || (count($result[1]) > 0)){
            preg_match_all('/<tr[\s\S]*>[\s]+<td>([\s\S]+)<\/td>[\s]+<td>([\s\S]+)<\/td>[\s]+<\/tr>/U', $result[1][0], $result);

            if ((is_array($result)) && (count($result) == 3) || (count($result[1]) > 0)) {
                for ($i = 0; $i < count($result[1]); $i++) {
                    $name = str_replace("\t", ' ', trim(Func::trimTextNew($result[1][$i])));
                    while (strpos($name, '  ') !== FALSE){
                        $name = str_replace('  ', ' ', $name);
                    }

                    $value = str_replace("\t", ' ', trim(Func::trimTextNew($result[2][$i])));
                    while (strpos($value, '  ') !== FALSE){
                        $value = str_replace('  ', ' ', $value);
                    }
                    $value = str_replace(' ,', ',', $value);

                    if((!empty($name)) && (!empty($value))) {
                        $options[$name] = $value;
                    }
                }
            }
        }

        preg_match_all('/<table class="characteristic forcon">([\s\S]+)<\/table>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) || (count($result[1]) > 0)){
            preg_match_all('/<tr[\s\S]*>[\s]*<td>([\s\S]+)<\/td>[\s]*<td>([\s\S]+)<\/td>[\s]*<\/tr>/U', $result[1][0], $result);

            if ((is_array($result)) && (count($result) == 3) || (count($result[1]) > 0)) {
                for ($i = 0; $i < count($result[1]); $i++) {
                    $name = str_replace("\t", ' ', trim(Func::trimTextNew($result[1][$i])));
                    while (strpos($name, '  ') !== FALSE){
                        $name = str_replace('  ', ' ', $name);
                    }

                    $value = str_replace("\t", ' ', trim(Func::trimTextNew($result[2][$i])));
                    while (strpos($value, '  ') !== FALSE){
                        $value = str_replace('  ', ' ', $value);
                    }
                    $value = str_replace(' ,', ',', $value);

                    if((!empty($name)) && (!empty($value))) {
                        $options[$name] = $value;
                    }
                }
            }
        }

        $model->addOptionsArray($options);

        $n = strpos($data, '<h3>Описание</h3>');
        if ($n === FALSE){
            return TRUE;
        }

        $data = substr($data, $n);
        $n = strpos($data, '</div>');
        $text = substr($data, 0, $n);
        if ((!empty($text)) && ($isReplace || (Func::_empty($model->getText())))) {
            if (Func::_empty($model->getText())) {
                $model->setText($text);
            }else{
                $model->setText($model->getText().'<br><br><br><br><br><br>'.$text);
            }
        }

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

        $json = json_decode(
            Helpers_URL::getDataURLEmulationBrowser(str_replace('#QUERY#', urlencode(str_replace(' ', '', $article)), self::URL_FIND)),
            TRUE
        );

        if (mb_strpos(Arr::path($json, 'suggestions.0', ''), 'не найдено совпадений') !== FALSE){
            return FALSE;
        }

        $article = mb_strtolower($article);
        for($i = 0; $i < count($json['suggestions']); $i++) {
            $name = $json['suggestions'][$i];
            if(strpos(mb_strtolower($name), $article) === FALSE){
                continue;
            }

            if ((!empty($name)) && ($isReplace || (Func::_empty($model->getName())))) {
                $model->setName($name);
            }

            $url = 'https://stolicaholoda.ru'.$json['data'][$i];
            if (!empty($url)) {
                $result = self::loadOneInObject($url, $model, $sitePageData, $driver, $isReplace);
            } else {
                $result = TRUE;
            }
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
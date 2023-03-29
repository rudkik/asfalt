<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта https://ru.made-in-china.com
 * Поиск товаров: https://ru.made-in-china.com/productSearch?keyword=#Данные запроса#
 * Class Drivers_ParserSite_MadeInChinaCOM
 */
class Drivers_ParserSite_MadeInChinaCOM
{
    // URL поиска товаров
    const URL_FIND = 'https://ru.made-in-china.com/productSearch?keyword=#QUERY#';

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

        preg_match_all('/<div class="hvalign(-cnt)*">[\s\S]*<img src="(.+)"/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) || (count($result[2]) > 0)){
            foreach ($result[2] as $urlImage) {
                $urlImage = str_replace('https://image.made-in-china.com/', '', $urlImage);
                $urlImage = 'https://image.made-in-china.com/2f0'.substr($urlImage, 3);
                if (!empty($urlImage)) {
                    try {
                        $file = new Model_File($sitePageData);
                        $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver);
                    } catch (Exception $e) {
                    }
                }
            }
        }

        $n = strpos($data, '<h3 class="h3">Описание Продукции </h3>');
        if ($n !== FALSE){
            $data = substr($data, $n);
            preg_match_all('/<div class="wrap">([\s\S]+)<\/div>/U', $data, $result);
        }else{
            $n = strpos($data, '<div class="detail-title">Описание Продукции</div>');
            if ($n !== FALSE){
                $data = substr($data, $n);
                preg_match_all('/<div class="detail-cnt">([\s\S]+)<\/div>/U', $data, $result);
            }else{
                return TRUE;
            }
        }
        if ((is_array($result)) && (count($result) == 2) || (count($result[1]) > 0)){
            $text = trim($result[1][0]);
            $text = str_replace('</p>', '</p>#*#',
                str_replace('<br>', '<br>#*#',
                    str_replace('</table>', '</table>#*#',$text)));


            $info = explode('#*#', $text);
            $text = '';
            foreach ($info as $p){
                if ((strpos($p, '<a ') !== FALSE) || (strpos($p, '<img ') !== FALSE)){
                    break;
                }
                $text = $text . $p;
            }
            if ((!empty($text)) && ($isReplace || (Func::_empty($model->getText())))) {
                if (Func::_empty($model->getText())) {
                    $model->setText($text);
                }else{
                    $model->setText($model->getText().'<br><br><br><br><br><br>'.$text);
                }
            }elseif ((!empty($text)) && (!$isReplace && (!Func::_empty($model->getText())))) {
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

        $data = Helpers_URL::getDataURLEmulationBrowser(str_replace('#QUERY#', urlencode(str_replace(' ', '', $article)), self::URL_FIND));

        preg_match_all('/<h2 class="product-name">[\s\S]*<a href="(.+)"[\s\S]+>([\s\S]+)<\/a>[\s\S]*<\/h2>/U', $data, $result);
        if ((!is_array($result)) || (count($result) != 3) || (count($result[1]) < 1)){
            return TRUE;
        }

        $isFirst = TRUE;
        $article = mb_strtolower($article);
        for($i = 0; $i < count($result[1]); $i++) {
            $name = $result[2][$i];
            if(strpos(mb_strtolower($name), $article) === FALSE){
                continue;
            }

            if ($isFirst || ($isFirst && (!empty($name)) && ($isReplace || (Func::_empty($model->getName()))))) {
                $model->setName($name);
            }
            $isFirst = FALSE;

            $url = $result[1][$i];
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
<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта http://phk-holod.ru
 * Поиск товаров: http://phk-holod.ru/index.php?route=product/search&search=#Данные запроса#
 * Class Drivers_ParserSite_EnstoCom
 */
class Drivers_ParserSite_PhkHolodRU
{
    // URL поиска товаров
    const URL_FIND = 'http://phk-holod.ru/index.php?route=product/search&search=#QUERY#';

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

        preg_match_all('/<a class="cloud-zoom main-image" id=\'zoom1\' rel="position:\'inside\'" href="(.+)"/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) || (count($result[1]) == 1)){
           $urlImage = trim($result[1][0]);
           if ((!empty($urlImage)) && ($isReplace || (Func::_empty($model->getImagePath())))) {
               try {
                   $file = new Model_File($sitePageData);
                   $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver);
               }catch (Exception $e){}
           }
        }

        preg_match_all('/<h1 class="inbreadcrumb">(.+)<\/h1>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) || (count($result[1]) == 1)){
            $name = trim($result[1][0]);
            if ((!empty($name)) && ($isReplace || (Func::_empty($model->getName())))) {
                $model->setName($name);
            }
        }

        // описание
        preg_match_all('/<div class="tab-pane active" id="tab-description" itemprop="description">([\s\S]+)<\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) || (count($result[1]) == 1)){
            $result = trim($result[1][0]);
            $result = str_replace('margin-top: 0pt;', '',
                str_replace('margin-bottom: 6pt;', '',
                    str_replace('line-height: 1.38;', '',
                        str_replace('font-variant-numeric: normal;', '',
                            str_replace('font-variant-east-asian: normal;', '',
                                str_replace('vertical-align: baseline;', '',
                                    str_replace('font-size: 9pt;', '',
                                        str_replace('font-family: Arial;', '',
                                            str_replace('background-color: transparent;', '',
                                                str_replace('dir="ltr"', '',
                                                    str_replace('&nbsp;', '',
                                                        str_replace('white-space: pre-wrap;', '',
                                                            str_replace('style=""', '', $result)))))))))))));

            while (strpos($result, '  ') !== FALSE){
                $result = str_replace('  ', ' ', $result);
            }

            $result = str_replace('style=" "', '',
                str_replace('style=""', '', $result));

            if ($result == 'Описание в обработке'){
                $result = '';
            }
            $text = '';
            if (preg_match_all('/<p(\s|>)[\s\S]+<\/p>/U', $result, $info)){
                foreach ($info[0] as $p){
                    if ((strpos($p, '<a ') !== FALSE) || (strpos($p, '<img ') !== FALSE)){
                        break;
                    }
                    $text = $text . $p;
                }
            }else{
                $text = $result;
            }

            if ((!empty($text)) && ($isReplace || (Func::_empty($model->getText())))) {
                $model->setText($text);
            }
        }

        // атрибуты
        $data = substr($data, strpos($data, '<div class="tab-pane" id="tab-specification">'));

        preg_match_all('/<tr itemprop="additionalProperty" itemscope itemtype="http:\/\/schema.org\/PropertyValue">([\s\S]+)<\/tr>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) || (count($result[1]) > 0)){
            $options = array();
            foreach ($result[1] as $paramValue){
                preg_match_all('/<td itemprop="name">([\s\S]+)<\/td>/U', $paramValue, $key);
                if ((is_array($key)) && (count($key) == 2) || (count($key[1]) == 1)){
                    preg_match_all('/<td itemprop="value">([\s\S]+)<\/td>/U', $paramValue, $value);
                    if ((is_array($value)) && (count($value) == 2) || (count($value[1]) == 1)){
                        $options[trim($key[1][0])] = trim($value[1][0]);
                    }
                }

            }
            $model->addOptionsArray($options, $isReplace);
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

        preg_match_all('/<h4><a href="(.+)">/U', $data, $result);
        if ((!is_array($result)) || (count($result) != 2) || (count($result[1]) < 1)){
            return TRUE;
        }

        $url = $result[1][0];
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
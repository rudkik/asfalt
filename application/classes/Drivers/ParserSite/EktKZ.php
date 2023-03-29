<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта https://ekt.kz
 * Поиск товаров: https://ekt.kz/products?keyword=#Данные запроса#
 * Class Drivers_ParserSite_EnstoCom
 */
class Drivers_ParserSite_EktKZ
{
    // URL поиска товаров
    const URL_FIND = 'https://ekt.kz/products?keyword=#QUERY#';

    /**
     * Загружаем данные о об одном товаре
     * @param $url
     * @param Model_Shop_Good $model
     * @param sitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     */
    public static function loadOneInObject($url, Model_Shop_Good $model, sitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        // загрузка картинки
        preg_match_all('/itemprop="image"[\s]+href="(.+)"/U', $data, $result);
        if ((!is_array($result)) || (count($result) == 1) || (count($result[1]) == 1)){
            $urlImage = trim($result[1][0]);
            if (Func::_empty($model->getImagePath())) {
                try {
                    $file = new Model_File($sitePageData);
                    $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver);
                } catch (Exception $e) {
                }
            }
        }

        // Описание
        preg_match_all('/<div itemprop="description">([\s\S]+)<\/div>/U', $data, $result);
        if ((!is_array($result)) || (count($result) == 1) || (count($result[1]) == 1)){
            $text = trim($result[1][0]);

            if ((!empty($text)) && ($isReplace || (Func::_empty($model->getText())))) {
                $model->setText($text);
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

        $data = Helpers_URL::getDataURLEmulationBrowser(str_replace('#QUERY#', urlencode($article), self::URL_FIND));

        preg_match_all('/<tbody>[\s\S]+<td class="sku">(.+)<\/td>/u', $data, $result);
        if ((!is_array($result)) || (count($result) != 2) || (count($result[1]) != 1)
            || (trim($article, '_') != trim(trim($result[1][0]), '_'))){
            return FALSE;
        }


        preg_match_all('/<tbody>[\s\S]+<td class="name">[\s]+<a href="(.+)">([\s\S]+)<\/a>/U', $data, $result);
        if ((!is_array($result)) || (count($result) == 3) || (count($result[1]) == 1)){
            $url = 'https://ekt.kz/'.trim($result[1][0]);

            $name = trim($result[2][0]);
            if ((!empty($name)) && ($isReplace || (Func::_empty($model->getName())))) {
                $model->setName($name);
            }

            $result = self::loadOneInObject($url, $model, $sitePageData, $driver, $isReplace);
        }else{
            $result = FALSE;
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

        return self::findOneInObject($article, $model, $sitePageData, $driver, $isReplace);
    }

}
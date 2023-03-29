<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта https://www.ensto.com
 * Поиск товаров: https://www.ensto.com/api/search/results?itemType=3&language=ru&page=1&pageSize=10&query=#Данные запроса#
 * Class Drivers_ParserSite_EnstoCom
 */
class Drivers_ParserSite_EnstoCom
{
    // URL поиска товаров
    const URL_FIND = 'https://www.ensto.com/api/search/results?itemType=3&language=ru&page=1&pageSize=10&query=#QUERY#';

    /**
     * Загружаем данные о об одном товаре
     * @param $url
     * @param Model_Shop_Good $model
     * @param bool $isReplace
     * @return bool
     */
    public static function loadOneInObject($url, Model_Shop_Good $model, $isReplace = TRUE)
    {
        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        preg_match_all('/technical-specifications="(.+)"/u', $data, $result);
        if ((!is_array($result)) || (count($result) != 2) || (count($result[1]) < 1)){
            return TRUE;
        }

        $result = htmlspecialchars_decode(trim($result[1][0]));
        $json = json_decode($result, TRUE);

        $options = array();

        foreach ($json as $child){
            $groups = Arr::path($child, 'groups', array());
            if (is_array($groups)) {
                foreach ($groups as $group) {
                    $attributes = Arr::path($group, 'attributes', array());
                    if (is_array($attributes)) {
                        foreach ($attributes as $attribute) {
                            $name = trim(Arr::path($attribute, 'name', ''));
                            if (empty($name)){
                                continue;
                            }

                            $value = trim(Arr::path($attribute, 'value', ''));
                            if (empty($value)){
                                continue;
                            }

                            $unit = trim(Arr::path($attribute, 'unit', ''));
                            if (!empty($unit)){
                                $value = $value . ' ' . $unit;
                            }

                            $options[$name] = $value;
                        }
                    }
                }
            }
        }

        $model->addOptionsArray($options, $isReplace);

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
            Helpers_URL::getDataURLEmulationBrowser(str_replace('#QUERY#', urlencode($article), self::URL_FIND)),
            TRUE
        );

        $json = Arr::path($json, 'Hits', '');
        if(empty($json)){
            return FALSE;
        }
        $json = $json[0];

        $model->setArticle($article);

        $name = trim(Arr::path($json, 'Title', '').' '.Arr::path($json, 'Name2', ''));
        if ((!empty($name)) && ($isReplace || (Func::_empty($model->getName())))) {
            $model->setName($name);
        }

        $barcode = trim(Arr::path($json, 'GTIN', ''));
        if (!empty($barcode)) {
            $model->addParamInOptions('barcode', $barcode, $isReplace);
        }

        $text = trim(Arr::path($json, 'IntroText', ''));
        if ((!empty($text)) && ($isReplace || (Func::_empty($model->getText())))) {
            $model->setText($text);
        }

        $urlImage = trim(Arr::path($json, 'ImageUrl', ''));
        if ((!empty($urlImage)) && ($isReplace || (Func::_empty($model->getImagePath())))) {
            $urlImage = 'https://www.ensto.com' . $urlImage;

            try {
                $file = new Model_File($sitePageData);
                $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver);
            }catch (Exception $e){}
        }

        $oldID = trim(Arr::path($json, 'Id', ''));
        if (!empty($oldID)) {
            $model->setOldID($oldID);
        }

        $url = trim(Arr::path($json, 'FriendlyUrl', ''));
        if (!empty($url)) {
             $result = self::loadOneInObject('https://www.ensto.com' . $url, $model, $isReplace);
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

        return self::findOneInObject($article, $model, $sitePageData, $driver, $isReplace);
    }

}
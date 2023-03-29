<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_ForcecomKZ{
    // загружать ли файлы картинок
    const IS_LOAD_IMAGE = false;

    // получаем список рубрик у сайте
    const URL_RUBRICS = 'https://forcecom.kz';

    /**
     * Загружаем данные о об одном товаре
     * @param $url
     * @param Model_AutoPart_Shop_Product $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $fileProxies
     * @param bool $isReplace
     */
    public static function loadProduct($url, Model_AutoPart_Shop_Product $model, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver, $fileProxies, $isReplace = TRUE)
    {
        $data = Helpers_URL::getPageHTMLRandomProxy($url, $fileProxies);

        // артикул
        /*if(Func::_empty($model->getIntegrations())) {
            preg_match_all('/<span class="value" itemprop="value">(.+)<\/span>/U', $data, $result);
            if (count($result) == 2 && count($result[1]) > 0) {
                $model->addIntegration($result[1][0]);
            }
        }*/

        // Цена
        preg_match_all('/<span data-value="([0-9]+)" data-currency="KZT"/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0) {
            $price = floatval(Request_RequestParams::strToFloat($result[1][0]));
            if ($price > 0) {
                $model->setPrice($price);
            }
        }

        // Цена
        preg_match_all('/<div  class="price_small" id=".+_price">[\S\s]+(.+) тг.\/шт/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0) {
            $price = floatval(Request_RequestParams::strToFloat(trim($result[1][0])));
            if ($price > 0) {
                $model->setPriceCost($price);
            }
        }

        // Название
        if($isReplace || Func::_empty($model->getName())) {
            preg_match_all('/<h1 id="pagetitle">(.+?)<\/h1>/U', $data, $result);
            if ((is_array($result)) && (count($result) == 2) && (count($result[1]) == 1)) {
                $name = trim($result[1][0]);
                if (!empty($name)) {
                    $model->setName($name);
                    $model->setNameSupplier($name);
                }
            }
        }

        // наличие
        $model->setIsPublic(
            mb_strpos($data, '<span class=\'store_view\'>Есть в наличии</span>') !== false
            || mb_strpos($data, '<span class=\'store_view\'>Мало в наличии</span>') !== false
        );
        $model->setIsInStock($model->getIsPublic());


        // Картинки
        preg_match_all('/<a href="(.+)" data-fancybox-group="item_slider_flex"/U', $data, $result);
        if (count($result) == 2){
            $images = [];
            foreach ($result[1] as $child){
                $images[] = 'https://forcecom.kz' . $child;
            }
            $model->setOptionsValue('image_urls', $images);

            if (self::IS_LOAD_IMAGE) {
                for ($i = 0; $i < count($result[1]); $i++){
                    try {
                        $file = new Model_File($sitePageData);
                        $file->addImageURLInModel(
                            'https://forcecom.kz' . $result[1][$i], $model, $sitePageData, $driver,
                            true, true
                        );
                    } catch (Exception $e) {
                    }
                }
            }
        }

        // Описание
        if ($isReplace || Func::_empty($model->getText())) {
            preg_match_all('/<div class="detail_text">([\W\w]+)<\/div>/U', $data, $result);
            if (count($result) == 2 && count($result[1]) == 1) {
                $text = trim($result[1][0]);
                if (!empty($text)) {
                    $model->setText($text);
                }
            }
        }

        // Характеристики
        preg_match_all('/<td class="char_name">([\W\w]+)<\/td>[\S\s]+<td class="char_value">([\W\w]+)<\/td>/U', $data, $result);
        if (count($result) == 3 && count($result[1]) == count($result[2])){
            $options = [];
            for ($i = 0 ; $i < count($result[1]); $i++){
                $name = trim(strip_tags(mb_substr($result[1][$i], mb_strpos($result[1][$i], '<span itemprop="name">'))));
                $value = trim(strip_tags(mb_substr($result[2][$i], mb_strpos($result[2][$i], '<span itemprop="value">'))));

                $options[$name] = $value;
            }

            $model->addParamsArray($options);
        }
    }

    /**
     * Получаем список ссылк на продукции по html страницы рубрики
     * @param $html
     * @return array
     */
    private static function _getProductURLsByRubricPage($html)
    {
        // получаем пагинатор
        preg_match_all('/<div class="article_block">[\S\s]+Артикул: ([\W\w]+)<\/div>/U', $html, $resultArticle);
        preg_match_all('/<div class="item-title">[\S\s]+<a href="(.+)"/U', $html, $resultURL);
        if (count($resultArticle) < 2 || count($resultURL) < 2 || count($resultArticle[1]) != count($resultURL[1])) {
            return [];
        }

        $list = [];
        for ($i = 0; $i < count($resultArticle[1]); $i++){
            $article = trim($resultArticle[1][$i]);

            $list[$article] = 'https://www.forcecom.kz' . trim($resultURL[1][$i]);
        }

        return $list;
    }

    /**
     * Получаем список ссылк на продукции по ссылке на рубрику
     * @param $url
     * @param $fileProxies
     * @return array
     */
    public static function getProductURLsByRubric($url, $fileProxies)
    {
        $data = Helpers_URL::getPageHTMLRandomProxy($url, $fileProxies);

        $list = self::_getProductURLsByRubricPage($data);

        // получаем список страниц в пагинаторе
        preg_match_all('/PAGEN_1=([0-9]+)"/U', $data, $result);
        if (count($result) < 2 || count($result[1]) < 1) {
            return $list;
        }

        $pages = intval($result[1][count($result[1]) - 1]);

        for ($i = 2; $i <= $pages; $i++){
            $data = Helpers_URL::getPageHTMLRandomProxy($url . '?PAGEN_1=' . $i, $fileProxies);

            $result = self::_getProductURLsByRubricPage($data);
            foreach ($result as $key => $child){
                $list[$key] = $child;
            }
        }

        return $list;
    }
}
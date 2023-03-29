<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Интеграция с сайтом moon.kz сравнение в базе данных происходит по 'MOON' + артиклу на сайте
 * Class Drivers_ParserSite_MoonKZ
 */
class Drivers_ParserSite_MoonKZ{
    // Префик для сравнения артикла, чтобы случайно не совпало с другими
    const ARTICLE_PREFIX = 'MOON';

    // загружать ли файлы картинок
    const IS_LOAD_IMAGE = false;

    // получаем список рубрик у сайте
    const URL_RUBRICS = 'https://moon.kz';

    /**
     * Загружаем данные о об одном товаре
     * @param $url
     * @param Model_AutoPart_Shop_Product $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     */
    public static function loadProduct($url, Model_AutoPart_Shop_Product $model, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver, $fileProxies, $isReplace = TRUE)
    {
        $data = Helpers_URL::getPageHTMLRandomProxy($url, $fileProxies);

        // Цена
        /*preg_match_all('/<div class="price" data-currency="KZT" data-value="([0-9]+)">/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0 ) {
            $model->setPrice($result[1][0]);
        }*/

        // Название товара
        if($isReplace || Func::_empty($model->getName())) {
            preg_match_all('/<h1 id="pagetitle">(.+)<\/h1>/U', $data, $result);
            if (count($result) == 2 && count($result[1]) > 0) {
                $name = htmlspecialchars_decode($result[1][0]);
                $model->setName($name);
                $model->setNameSupplier($name);
            }
        }

        // Описание товара
        if($isReplace || Func::_empty($model->getText())) {
            preg_match_all('/<div class="detail_text">([\w\W]+)<\/div>/U', $data, $result);
            if (count($result) == 2 && count($result[1]) > 0) {
                $model->setText($result[1][0]);
            }
        }

        // Характеристики
        preg_match_all('/<td class="cell_name"><span>(.+)<\/span><\/td>/U', $data, $result);
        preg_match_all('/<td class="cell_value"><span>(.+)<\/span><\/td>/U', $data, $result2);
        if (count($result[1]) == count($result2[1])) {
            $options = [];
            for ($i = 0; $i < count($result[1]); $i++) {
                if ($result[1][$i] != 'Рейтинг' && $result[1][$i] != 'Наличие товара'){
                    $options[$result[1][$i]] = strip_tags(trim($result2[1][$i]));
                }
            }

            $model->addParamsArray($options);
        }

        // Картинки
        preg_match_all('/<a href="(.+)" data-fancybox-group="item_slider" class="popup_link fancy" title=".+">/U', $data, $result);
        if (count($result) == 2) {
            $images = [];
            foreach ($result[1] as $href) {
                $images[] = $href;
            }
            $model->setOptionsValue('image_urls', $images);

            if (self::IS_LOAD_IMAGE) {
                foreach ($images as $href) {
                    try {
                        $file = new Model_File($sitePageData);
                        $file->addImageURLInModel($href, $model, $sitePageData, $driver);
                    } catch (Exception $e) {
                    }
                }
            }
        }

        // Наличие
        /*preg_match_all('/<span class="value">(.+)<\/span>/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0) {
            $model->getIsInStock($result[1][0] == 'Есть в наличии');
        }*/
    }

    /**
     * Получаем список ссылк на продукции по html страницы рубрики
     * @param $html
     * @return array
     */
    private static function _getProductURLsByRubricPage($html)
    {
        // получаем пагинатор
        preg_match_all('/<div class="item-title">[\S\s]*<a href="(.+)" class="dark_link"/U', $html, $result);
        preg_match_all('/<div class="article_block" data-name="Артикул" data-value="(.+)">/U', $html, $articles);
        if (count($result) < 2 || count($articles) < 2 || count($result[1]) != count($articles[1])) {
            return [];
        }

        $list = [];
        for ($i = 0; $i < count($result[1]); $i++){
            $list[self::ARTICLE_PREFIX . $articles[1][$i]] = $result[1][$i];
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

        // получаем пагинатор
        preg_match_all('/<a href="https:\/\/moon.kz\/.+=([0-9]+)" class="dark_link">/U', $data, $result);
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
<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_AComputersKZ{
    // загружать ли файлы картинок
    const IS_LOAD_IMAGE = false;

    // получаем список рубрик у сайте
    const URL_RUBRICS = 'https://acomputers.kz/tovary/';

    /**
     * Получаем артикул без букв
     * @param $html
     * @return string
     */
    public static function getArticle($html)
    {
        preg_match_all('/<span class="sku" itemprop="sku">.*([0-9]+)<\/span>/U', $html, $result);
        if (count($result) == 2 && count($result[1]) > 0) {
            return $result[1][0];
        }

        return '';
    }

    /**
     * Загружаем данные о об одном товаре
     * @param $html
     * @param Model_AutoPart_Shop_Product $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $fileProxies
     * @param bool $isReplace
     */
    public static function loadProduct($html, Model_AutoPart_Shop_Product $model, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver, $fileProxies, $isReplace = TRUE)
    {
        //$data = Helpers_URL::getPageHTMLRandomProxy($url, $fileProxies);
        //$data = file_get_contents('C:\WAMP\www\ct\al_style_catalog.xml');
        $data = $html;

        // Название
        if(Func::_empty($model->getName()) || Func::_empty($model->getNameSupplier())) {
            preg_match_all('/<h1 itemprop="name" class="mpcth-post-title mpcth-deco-header">[\S\s]+<span class="mpcth-color-main-border">([\W\w]+)<\/span>/U', $data, $result);
            if ((is_array($result)) && (count($result) == 2) && (count($result[1]) == 1)) {
                $name = trim($result[1][0]);
                if (Func::_empty($model->getName())) {
                    $model->setName($name);
                }

                if (Func::_empty($model->getNameSupplier())) {
                    $model->setNameSupplier($name);
                }
            }
        }

        // Описание
        if ($isReplace || Func::_empty($model->getText())) {
            preg_match_all('/<div class="panel entry-content" id="tab-description">([\W\w]+)<\/div>/U', $data, $result);
            if (count($result) == 2 && count($result[1]) == 1) {
                $text = trim($result[1][0]);
                if (!empty($text)) {
                    $model->setText($text);
                }
            }
        }

        // артикул
        /*preg_match_all('/<span class="sku" itemprop="sku">(.*[0-9]+)<\/span>/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0) {
            $model->setArticle($result[1][0]);
        }*/

        // Картинки
        preg_match_all('/<a class="mpcth-lightbox mpcth-lightbox-type-image" href="(.+)"/U', $data, $result);
        if (count($result) == 2){
            $images = [];
            foreach ($result[1] as $child){
                $images[] = $child;
            }
            $model->setOptionsValue('image_urls', $images);

            if (self::IS_LOAD_IMAGE) {
                for ($i = 0; $i < count($result[1]); $i++){
                    try {
                        $file = new Model_File($sitePageData);
                        $file->addImageURLInModel(
                            $result[1][$i], $model, $sitePageData, $driver, true, true
                        );
                    } catch (Exception $e) {
                    }
                }
            }
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
        preg_match_all('/<h6 class="mpcth-post-title"><a href="(.+)"/U', $html, $result);
        if (count($result) < 2) {
            return [];
        }

        $list = [];
        foreach ($result[1] as $url){
            $list[$url] = $url;
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
        //$data = file_get_contents('C:\WAMP\www\ct\al_style_catalog.xml');

        $list = self::_getProductURLsByRubricPage($data);

        // получаем список страниц в пагинаторе
        preg_match_all('/<a class="page-numbers" href=".+">([0-9]+)<\/a>/U', $data, $result);
        if (count($result) < 2 || count($result[1]) < 1) {
            return $list;
        }

        $pages = intval($result[1][count($result[1]) - 1]);

        for ($i = 2; $i <= $pages; $i++){
            $data = Helpers_URL::getPageHTMLRandomProxy($url . 'page/' . $i . '/', $fileProxies);

            $result = self::_getProductURLsByRubricPage($data);
            foreach ($result as $key => $child){
                $list[$key] = $child;
            }
        }

        return $list;
    }
}
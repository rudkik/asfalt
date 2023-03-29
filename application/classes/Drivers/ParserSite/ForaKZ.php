<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_ForaKZ
{
    // получаем список рубрик у сайте
    const URL_RUBRICS = 'https://fora.kz';

    // загружать ли файлы картинок
    const IS_LOAD_IMAGE = false;

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
        //$data = file_get_contents('C:\WAMP\www\ct\al_style_catalog.xml');

        // Цена
        /*preg_match_all('/<span itemprop="price">(.+)<\/span>/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0 ) {
            $model->setPrice(Request_RequestParams::strToFloat($result[1][0]));
        }*/

        // Название товара
        if($isReplace || Func::_empty($model->getName()) || Func::_empty($model->getNameSupplier())) {
            preg_match_all('/<h1  itemprop="name" >([\w\W]+)<\/h1>/U', $data, $result);
            if (is_array($result) && count($result) == 2) {
                $name = trim($result[1][0]);

                if (Func::_empty($model->getName())) {
                    $model->setName($name);
                }

                if (Func::_empty($model->getNameSupplier())) {
                    $model->setNameSupplier($name);
                }
            }
        }

        // Характеристики
        preg_match_all('/<th>(.+)<\/th>[\s\S]+<td>([\w\W]+)<\/td>/U', $data, $result);
        if (count($result) > 2 && count($result[1]) == count($result[2])) {
            $options = [];
            for ($i = 0; $i < count($result[1]); $i++) {
                    $options[strip_tags(trim($result[1][$i]))] = trim($result[2][$i]);
            }

            $model->addParamsArray($options);
        }

        // Картинки
        preg_match_all('/<a href="(.+)" class="fancybox" rel="gallery">/U', $data, $result);
        if (count($result) == 2) {
            $images = [];
            foreach ($result[1] as $child) {
                $images[] = $child;
            }
            $model->setOptionsValue('image_urls', $images);

            if (self::IS_LOAD_IMAGE) {
                foreach ($images as $child) {
                    try {
                        $file = new Model_File($sitePageData);
                        $file->addImageURLInModel(
                            $child, $model, $sitePageData, $driver, true, true
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
        preg_match_all('/<span> Артикул: (.*)<\/span>/U', $html, $articles);
        preg_match_all('/<div class="item-info">[\S\s]*<a href="(.+)">/U', $html, $result);
        if (count($result) < 2 || count($articles) < 2 || count($result[1]) != count($articles[1])) {
            preg_match_all('/data-merchant-sku="(.*)"/U', $html, $articles);
        }

        if (count($result) < 2 || count($articles) < 2 || count($result[1]) != count($articles[1])) {
            print_r($articles);
            print_r($result);die;
            return [];
        }

        $list = [];
        for ($i = 0; $i < count($result[1]); $i++){
            $list[$articles[1][$i]] = 'https://fora.kz' . $result[1][$i];
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
        if(empty($list)){
            return $list;
        }

        for ($i = 2; $i <= 200; $i++){
            $data = Helpers_URL::getPageHTMLRandomProxy($url . '?page=' . $i, $fileProxies);

            // проверяем, что последняя страница
            if(mb_strpos($data, '<div class="empty">Ничего не найдено.</div>') !== false){
                break;
            }

            $result = self::_getProductURLsByRubricPage($data);
            if(empty($result)){
                break;
            }

            foreach ($result as $key => $child){
                $list[$key] = $child;
            }
        }

        return $list;
    }

}
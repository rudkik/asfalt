<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_SvetKZ{
    // загружать ли файлы картинок
    const IS_LOAD_IMAGE = false;

    // получаем список рубрик у сайте
    const URL_RUBRICS = 'https://svet.kz';

    // Процент скидки от реализации
    const PERCENT = 30;

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
        //$data = file_get_contents('C:\WAMP\www\ct\al_style_catalog.xml');

        // артикул
        if(Func::_empty($model->getIntegrations())) {
            preg_match_all('/<div class="product-detail__art"> <span>артикул: <\/span>(.+)<\/div>/U', $data, $result);
            if (count($result) == 2 && count($result[1]) > 0) {
                $model->addIntegration($result[1][0]);
            }
        }

        // Цена
        preg_match_all('/<span class="product-detail__cur-price">([0-9\S\s]+)<\/span>/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0) {
            $price = floatval(Request_RequestParams::strToFloat($result[1][0]));
            if ($price > 0) {
                $model->setPrice($price);
                $model->setPriceCost(round($price / 100 * (100 - self::PERCENT)));
            }
        }

        // Название
        if($isReplace || Func::_empty($model->getName())) {
            preg_match_all('/<h1>(.+?)<\/h1>/U', $data, $result);
            if ((is_array($result)) && (count($result) == 2) && (count($result[1]) == 1)) {
                $name = trim($result[1][0]);
                if (!empty($name)) {
                    $model->setName($name);
                    $model->setNameSupplier($name);
                }
            }
        }

        // наличие
        preg_match_all('/<div class="product-detail__availability _true">в наличии ([0-9]+)шт.<\/div>/U', $data, $result);
        if (count($result) == 2) {
            $model->setStockCompareTypeID(Model_AutoPart_Shop_Product::COMPARE_STOCK_EQUALLY);
            if(count($result[1]) > 0){
                $model->setStockQuantity($result[1][0]);
            }

            $model->setIsPublic(count($result[1]) > 0);
            $model->setIsInStock($model->getIsPublic());
        }

        // Картинки
        preg_match_all('/<div><a href="(.+)" rel="product-detail-photo"/U', $data, $result);
        if (count($result) == 2){
            $images = [];
            foreach ($result[1] as $child){
                $images[] = 'https://svet.kz' . $child;
            }
            $model->setOptionsValue('image_urls', $images);

            if (self::IS_LOAD_IMAGE) {
                for ($i = 0; $i < count($result[1]); $i++){
                    try {
                        $file = new Model_File($sitePageData);
                        $file->addImageURLInModel(
                            'https://svet.kz' . $result[1][$i], $model, $sitePageData, $driver,
                            true, true
                        );
                    } catch (Exception $e) {
                    }
                }
            }
        }

        // Описание
        if ($isReplace || Func::_empty($model->getText())) {
            preg_match_all('/<div class="static-text">([\W\w]+)<p>Успей купить/U', $data, $result);
            if (count($result) == 2 && count($result[1]) == 1) {
                $text = str_replace('SVET.KZ', '', trim($result[1][0]));
                if (!empty($text)) {
                    $model->setText($text);
                }
            }
        }

        // Характеристики
        preg_match_all('/<div class="product-detail__characteristics-list fw">([\W\w]+)<div class="product-detail__characteristics-controls">/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0) {
            preg_match_all('/<td>([\W\w]+)<\/td>[\S\s]*<td class="_value">([\W\w]+)<\/td>/U', $result[1][0], $result);

            if (count($result) == 3 && count($result[1]) == count($result[2])) {
                $options = [];
                for ($i = 0; $i < count($result[1]); $i++) {
                    $name = trim($result[1][$i]);
                    if(mb_strpos($name, 'Остаток поставщика') !== false){
                        continue;
                    }

                    $n = mb_strpos($name, '<a');
                    if($n !== false){
                        $name = trim(mb_substr($name, 0, $n));

                    }
                    $value = trim($result[2][$i]);

                    $options[$name] = $value;
                }

                $model->addParamsArray($options);
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
        preg_match_all('/<div class="product-list-item__art"><span>артикул: <\/span>(.+)<\/div>/U', $html, $resultArticle);
        preg_match_all('/<a href="(.*)" class="product-list-item__title-link">.*<\/a>/U', $html, $resultURL);
        if (count($resultArticle) < 2 || count($resultURL) < 2 || count($resultArticle[1]) != count($resultURL[1])) {
            return [];
        }

        $list = [];
        for ($i = 0; $i < count($resultArticle[1]); $i++){
            $article = trim($resultArticle[1][$i]);

            $list[$article] = 'https://svet.kz' . trim($resultURL[1][$i]);
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
        $data = Helpers_URL::getPageHTMLRandomProxy($url, $fileProxies, 10, ['count' => 120]);
        //$data = file_get_contents('C:\WAMP\www\ct\al_style_catalog.xml');

        $list = self::_getProductURLsByRubricPage($data);

        // получаем список страниц в пагинаторе
        preg_match_all('/<a class="paging-btn paging-btn-arrow js-nextitems" value=".*" href=".*#page([0-9]+)">&raquo;/U', $data, $result);
        if (count($result) < 2 || count($result[1]) < 1) {
            return $list;
        }

        $pages = intval($result[1][count($result[1]) - 1]);
        for ($i = 2; $i <= $pages; $i++){
            $data = Helpers_URL::getPageHTMLRandomProxy($url, $fileProxies, 10, ['count' => 120, 'PAGEN_1' => $i]);

            $result = self::_getProductURLsByRubricPage($data);
            foreach ($result as $key => $child){
                $list[$key] = $child;
            }
        }

        return $list;
    }
}
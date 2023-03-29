<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_IntantKZ{
    // процент скидки от розничной цены
    const DISCOUNT_PERCENT = 13;

    // загружать ли файлы картинок
    const IS_LOAD_IMAGE = false;

    // получаем список рубрик у сайте
    const URL_RUBRICS = 'https://www.intant.kz';

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

        // Цена
        preg_match_all('/<span class="icard_pr">(.+)<\/span>/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0) {
            $price = floatval(Request_RequestParams::strToFloat($result[1][0]));
            if ($price > 0) {
                $model->setPrice($price);
                $model->setPriceCost($price / 100 * (100 - self::DISCOUNT_PERCENT));
            }
        }

        // Название
        if($isReplace || Func::_empty($model->getName())) {
            preg_match_all('/<h1 class="i_h1_cele">(.+?)<\/h1>/U', $data, $result);
            if ((is_array($result)) && (count($result) == 2) && (count($result[1]) == 1)) {
                $name = trim($result[1][0]);
                if (!empty($name)) {
                    $model->setName($name);
                    $model->setNameSupplier($name);
                }
            }
        }

        // Количество
        preg_match_all('/<span class="i_quan_tx ifleft">Количество:<span style="font-weight: bold;">(.+)<\/span>/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0) {
            $quantity = trim($result[1][0]);
            if($quantity == 'Нет на складе Алматы'){
                $model->setIsInStock(false);
                $model->setIsPublic(false);
            }else{
                if(strpos($quantity, '>') !== false){
                    $model->setStockCompareTypeID(Model_AutoPart_Shop_Product::COMPARE_STOCK_MORE);
                }elseif(strpos($quantity, '<') !== false){
                    $model->setStockCompareTypeID(Model_AutoPart_Shop_Product::COMPARE_STOCK_LESS);
                }else{
                    $model->setStockCompareTypeID(Model_AutoPart_Shop_Product::COMPARE_STOCK_EQUALLY);
                }

                $quantity = floatval(Request_RequestParams::strToFloat($quantity));
                $model->setStockQuantity($quantity);

                $model->setIsInStock($quantity > 0);
                $model->setIsPublic($quantity > 0);
            }
        }

        // Картинки
        preg_match_all('/data-fancybox="images" href="(.+)" title="(.+)"/U', $data, $result);
        if (count($result) == 3){
            $images = [];
            foreach ($result[1] as $child){
                $images[] = 'https://www.intant.kz' . $child;
            }
            $model->setOptionsValue('image_urls', $images);

            if (self::IS_LOAD_IMAGE) {
                for ($i = 0; $i < count($result[1]); $i++){
                    try {
                        $file = new Model_File($sitePageData);
                        $file->addImageURLInModel(
                            'https://www.intant.kz' . $result[1][$i], $model, $sitePageData, $driver,
                            true, true, $result[2][$i]
                        );
                    } catch (Exception $e) {
                    }
                }
            }
        }

        // Описание
        preg_match_all('/(<div class="idnone" jq_ai_content="1" style="display:block">[\s\S]+(.+?)[\s\S]+<\/div>)+/U', $data, $result);
        if (count($result) == 3 && count($result[1]) == 1) {
            $text = trim(strip_tags($result[1][0]));
            $title = trim(strip_tags($result[2][0]));
            $text = str_replace($title,'', $text);
            if (!empty($text) && ($isReplace || Func::_empty($model->getText()))) {
                $model->setText($text);
            }
        }

        // Характеристики
        preg_match_all('/<div class="i_cele_property">[\s\S]+<div class="i_cele_property_col">(.+)<\/div>[\s\S]+<div class="i_cele_property_col">[\s\S]+(.+)<\/div>[\s\S]+<\/div>/U', $data, $result);
        if (is_array($result) && count($result) == 3 && count($result[1]) == count($result[2])){
            $options = [];
            for ($i = 0 ; $i < count($result[1]); $i++){
                $options[$result[1][$i]] = trim($result[2][$i]);
            }

            $model->addParamsArray($options);
        }

        // Видео
        /*preg_match_all('/<div class="idnone" jq_ai_content="3">[\s\S]+(.+?)[\s\S]+<\/div>/U', $data, $result);
        if (count($result) == 2){
            $error = $result[1][0];
        }*/

        //Документ
        /*preg_match_all('/<a class="i_instruct" target="_blank" href="(.+)">[\s\S]+(.+?)[\s\S]+<\/a>/U', $data, $result);
        $urlFile = [];
        if ((count($result) == 3)){
            foreach ($result[1] as $key1 => $href){
                foreach ($result[2] as $key2 => $title) {
                    if ($key2 == $key1) {
                        $urlFile[trim($title)] = 'https://www.intant.kz' . trim($href);
                        if (Func::_empty($model->getImagePath())) {
                            try {
                                $file = new Model_File($sitePageData);
                                $file->saveAdditionFiles($urlFile[trim($title)], $model, $sitePageData, $driver);
                            } catch (Exception $e) {
                            }
                        }
                    }
                }
            }
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
        preg_match_all('/<a class="i_item_name" href="(.+)">/U', $html, $result);
        if (count($result) < 2) {
            return [];
        }

        $list = [];
        foreach ($result[1] as $child){
            $list[$child] = 'https://www.intant.kz' . $child;
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
        preg_match_all('/<li class="i_pg_active" title="Текущая страница">([\W\w]+)<li class="i_pg_right">/U', $data, $result);
        if (count($result) < 2 || count($result[1]) < 1) {
            return $list;
        }

        // получаем список страниц в пагинаторе
        $data1 = $result[1][0];
        preg_match_all('/title="Страница ([0-9]+)"/U', $data1, $result);
        if (count($result) < 2 || count($result[1]) < 1) {
            return $list;
        }

        $pages = intval($result[1][count($result[1]) - 1]);

        for ($i = 2; $i <= $pages; $i++){
            $data = Helpers_URL::getPageHTMLRandomProxy($url . '?PAGEN_1=' . $i . '&SIZEN_1=12', $fileProxies);

            $result = self::_getProductURLsByRubricPage($data);
            foreach ($result as $key => $child){
                $list[$key] = $child;
            }
        }

        return $list;
    }

    /**
     * Загружаем данные об товарах
     * @param $shopSupplierID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $fileProxies
     * @param bool $isReplace
     * @return bool
     */
    public static function loadProducts($shopSupplierID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                        $fileProxies, $isReplace = TRUE){

        $data = Helpers_URL::getPageHTMLRandomProxy(self::URL_RUBRICS, $fileProxies);
        preg_match_all('/<a href="(.+)" class="i_vmenu_a_2">/U', $data, $result);
        if (count($result) < 2) {
            return false;
        }

        $offers = [];
        foreach($result[1] as $url) {
            $result = self::getProductURLsByRubric('https://www.intant.kz' . $url, $fileProxies);
            foreach ($result as $key => $child){
                $offers[$key] = $child;
            }
        }

        $params = [
            'shop_supplier_id' => $shopSupplierID,
            'is_public_ignore' => true,
        ];
        $shopProductIDs = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams($params), 0, true
        );

        $model = new Model_AutoPart_Shop_Product();
        $model->setDBDriver($driver);

        foreach ($shopProductIDs->childs as $child) {
            $child->setModel($model);

            $key = '';
            foreach ($model->getIntegrationsArray() as $integration) {
                if (key_exists($integration, $offers)) {
                    $key = $integration;
                    break;
                }
            }

            $model->setIsPublic(!empty($key));
            if($model->getIsPublic()){
                // считываем параметры товара
                self::loadProduct($offers[$key], $model, $sitePageData, $driver, $fileProxies, $isReplace);

                unset($offers[$key]);
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);
        }

        foreach ($offers as $key => $url) {
            $model->clear();
            $model->addIntegration($key);

            // считываем параметры товара
            self::loadProduct($url, $model, $sitePageData, $driver, $fileProxies, $isReplace);

            Helpers_DB::saveDBObject($model, $sitePageData);

            $model->setArticle('I'.$model->id);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }

        return true;
    }
}
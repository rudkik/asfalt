<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_HatberKZ
{
    const PRODUCT_URL = 'https://hatber.kz/search/';

    // загружать ли файлы картинок
    const IS_LOAD_IMAGE = false;

    /**
     * Загружаем данные о об одном товаре поиск
     * @param $url
     * @param Model_AutoPart_Shop_Product $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $fileProxies
     * @param bool $isReplace
     * @return bool
     */
    public static function loadProductSearch($url, Model_AutoPart_Shop_Product $model, SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver, $fileProxies, $isReplace = TRUE)
    {
        $data = Helpers_URL::getPageHTMLRandomProxy($url, $fileProxies);
        //$data = file_get_contents('C:\WAMP\www\ct\al_style_catalog.xml');

        if(mb_strpos($data, 'По вашему запросу ничего не найдено') !== false
            || mb_strpos($data, 'Сожалеем, но ничего не найдено.') !== false){
            $model->setIsInStock(false);
            $model->setIsPublic(false);
            return true;
        }

        // ссылка на товар
        preg_match_all('/<div class="product-card-inner__title"><a href="(.+)"/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0 ) {
            return Drivers_ParserSite_HatberKZ::loadProduct(
                'https://hatber.kz' . $result[1][0], $model, $sitePageData, $driver, $fileProxies, $isReplace
            );
        }

        return false;
    }

    /**
     * Загружаем данные о об одном товаре
     * @param $url
     * @param Model_AutoPart_Shop_Product $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $fileProxies
     * @param bool $isReplace
     * @return bool
     */
    public static function loadProduct($url, Model_AutoPart_Shop_Product $model, SitePageData $sitePageData,
                                       Model_Driver_DBBasicDriver $driver, $fileProxies, $isReplace = TRUE)
    {
        $data = Helpers_URL::getPageHTMLRandomProxy($url, $fileProxies);
        //$data = file_get_contents('C:\WAMP\www\ct\al_style_catalog.xml');

        // Название товара
        if(Func::_empty($model->getNameSupplier()) || Func::_empty($model->getName())) {
            preg_match_all('/<h1 class="product_detail_title fonts__middle_title js-product-name">(.+)<\/h1>/U', $data, $result);
            if (count($result) == 2 && count($result[1]) > 0) {
                $name = htmlspecialchars_decode($result[1][0], ENT_QUOTES);

                if (Func::_empty($model->getName())) {
                    $model->setName($name);
                }
                if (Func::_empty($model->getNameSupplier())) {
                    $model->setNameSupplier($name);
                }
            }
        }

        // Описание товара
        if(Func::_empty($model->getText())) {
            preg_match_all('/<div class="detailed-tabs__content detailed-tabs__description active js-tabs-content">([\w\W]+)<\/div>/U', $data, $result);
            if (count($result) == 2 && count($result[1]) > 0) {
                $text = trim($result[1][0]);
                $text = trim(mb_substr($text, mb_strpos($text, '</h2>') + 5, -6));
                $model->setText(str_replace('<img src="/upload', '<img src="https://shop.kz/upload', $text));
            }
        }

        // Характеристики
        preg_match_all('/<p class="detailed-tabs-list__item-name">([\w\W]+)<\/p>/U', $data, $resultName);
        preg_match_all('/<p class="detailed-tabs-list__item-value">([\w\W]+)<\/p>/U', $data, $resultValue);
        if (count($resultName[1]) == count($resultValue[1])) {
            $options = [];
            for ($i = 0; $i < count($resultName[1]); $i++) {
                $options[trim($resultName[1][$i])] = trim($resultValue[1][$i]);
            }

            $model->addParamsArray($options);
        }

        // картинки
        preg_match_all('/"image": \"(.+)"\,/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0 ) {
            $result = json_decode('["' . $result[1][0] . '"]', true);
            $images = [];
            foreach ($result as $child) {
                $images[] = $child;
            }
            $model->setOptionsValue('image_urls', $images);

            if (self::IS_LOAD_IMAGE) {
                foreach ($result as $child) {
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

        // ссылка
        $model->setURL($url);

        // наличие
        preg_match_all("/<span>Наличие:<\/span><span>([0-9]+) шт/U", $data, $result);
        if (count($result) == 2 && count($result[1]) > 0) {
            $model->setStockQuantity($result[1][0]);

            $isInStock = $result[1][0] > 2;
            $model->setIsInStock($isInStock);
            $model->setIsPublic($isInStock);
        }else{
            $model->setIsInStock(false);
            $model->setIsPublic(false);
        }
        //print_r($model->getValues(true, true));die;
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
        $params = [
            'shop_supplier_id' => $shopSupplierID,
            'is_public_ignore' => true,
            'is_load_site_supplier' => false,
        ];

        // размер шага и позиция в шаге
        $step = Request_RequestParams::getParamInt('step');
        $stepCurrent = Request_RequestParams::getParamInt('step_current');
        if($step > 0 && $stepCurrent > 0) {
            $params['id_modulo'] = ['divisor' => $step, 'result' => $stepCurrent];
        }

        $shopProductIDs = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams($params), 0, true
        );

        $model = new Model_AutoPart_Shop_Product();
        $model->setDBDriver($driver);

        foreach ($shopProductIDs->childs as $child) {
            $child->setModel($model);

            foreach ($model->getIntegrationsArray() as $integration) {
                self::loadProductSearch(
                    self::PRODUCT_URL . URL::query(['q' => $integration], false),
                    $model, $sitePageData, $driver, $fileProxies, $isReplace
                );

                $model->setIsLoadSiteSupplier(true);
                Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);

                break;
            }
        }

        return true;
    }
}
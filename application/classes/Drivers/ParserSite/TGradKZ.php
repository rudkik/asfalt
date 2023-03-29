<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_TGradKZ
{
    const PRODUCT_URL = 'https://tgrad.kz/search/';

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

        if(mb_strpos($data, 'Сожалеем, по вашему запросу') !== false){
            return true;
        }

        // ссылка на товар
        preg_match_all('/<a href="(.+)" class="product__img">/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0 ) {
            return Drivers_ParserSite_TGradKZ::loadProduct(
                'https://tgrad.kz' . $result[1][0], $model, $sitePageData, $driver, $fileProxies, $isReplace
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
            preg_match_all('/<h1 class="product__name">(.+)<\/h1>/U', $data, $result);
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
            preg_match_all('/<div class="detail__block_tab char__tab">([\w\W]+)<\/div>/U', $data, $result);
            if (count($result) == 2 && count($result[1]) > 0) {
                $text = trim($result[1][0]);
                $text = trim(mb_substr($text, mb_strpos($text, '</h2>') + 5, -6));
                $model->setText(str_replace('<img src="/upload', '<img src="https://shop.kz/upload', $text));
            }
        }

        // Характеристики
        preg_match_all('/<div class="detail__block_tab char__tab" id="characteristics">([\w\W]+)<div class="char-hint">/U', $data, $result);
        if (count($result) > 1 && count($result[1]) > 0) {
            preg_match_all('/<td>[\S\s]*<span>([\w\W]+)<\/span>[\S\s]*<\/td>/U', $result[1][0], $result);
            if (count($result) > 1 && count($result[1]) % 2 == 0) {
                $options = [];
                for ($i = 0; $i < count($result[1]) - 1; $i += 2) {
                    $options[trim($result[1][$i])] = trim($result[1][$i + 1]);
                }
                $model->addParamsArray($options);
            }
        }

        // картинки
        preg_match_all('/src="(.+)" class="zoom-img">/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0 ) {
            $images = [];
            foreach ($result[1] as $child) {
                $images[] = 'https://tgrad.kz' . $child;
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
    public static function loadProductPrice($url, Model_AutoPart_Shop_Product $model, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver, $fileProxies)
    {
        $data = Helpers_URL::getPageHTMLRandomProxy($url, $fileProxies);
        //$data = file_get_contents('C:\WAMP\www\ct\al_style_catalog.xml');

        preg_match_all('/<div class="p-detail__buy">[\S\s]*<span class="new__price">(.+)<span class="valute">/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0) {
            $model->setPrice(Request_RequestParams::strToFloat($result[1][0]));
        }
    }


    /**
     * Загружаем данные об товарах
     * @param $shopSupplierID
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $fileProxies
     * @return bool
     */
    public static function loadProductsPrice($shopSupplierID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver,
                                             $fileProxies){
        $params = [
            'shop_supplier_id' => $shopSupplierID,
            'is_public_ignore' => true,
        ];
        $fileProxies = [];

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

            if(Func::_empty($model->getURL())){
                continue;
            }

            self::loadProductPrice($model->getURL(), $model, $sitePageData, $driver, $fileProxies);
            Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);
        }

        return true;
    }
}
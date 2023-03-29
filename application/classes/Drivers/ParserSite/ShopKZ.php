<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_ShopKZ
{
    const PRODUCT_URL = 'https://shop.kz/search/?q=';

    // загружать ли файлы картинок
    const IS_LOAD_IMAGE = false;

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

        if(empty($data)){
            $data = Helpers_URL::getPageHTMLRandomProxy($url, []);
        }

        if(mb_strpos($data, 'К сожалению, на ваш поисковый запрос ничего не найдено.') !== false
            || mb_strpos($data, '<title>Результаты поиска') !== false){
            $model->setIsInStock(false);
            $model->setIsPublic(false);
            return true;
        }

        // Цена
        preg_match_all('/<div class="item_current_price" id=".+" title="Цена в интернет-магазине">(.+) ₸<\/div>/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0 ) {
            $model->setPrice(Request_RequestParams::strToFloat($result[1][0]));
        }

        // Название товара
        if(Func::_empty($model->getNameSupplier()) || Func::_empty($model->getName())) {
            preg_match_all('/<h1 class="bx-title dbg_title" id="pagetitle">(.+)<\/h1>/U', $data, $result);
            if (count($result) == 2 && count($result[1]) > 0) {
                if (Func::_empty($model->getName())) {
                    $model->setName($result[1][0]);
                }
                if (Func::_empty($model->getNameSupplier())) {
                    $model->setNameSupplier($result[1][0]);
                }
            }
        }

        // Описание товара
        if(Func::_empty($model->getText())) {
            preg_match_all('/<div class="bx_item_description box-hide">([\w\W]+)<a href="javascript:void\(0\)"/U', $data, $result);
            if (count($result) == 2 && count($result[1]) > 0) {
                $text = trim($result[1][0]);
                $text = trim(mb_substr($text, mb_strpos($text, '</h2>') + 5, -6));
                $model->setText(str_replace('<img src="/upload', '<img src="https://shop.kz/upload', $text));
            }
        }

        // Характеристики
        preg_match_all('/<span class="glossary-term">(.+)<\/span>/U', $data, $resultName);
        preg_match_all('/<dd class="bx_detail_chars_i_field">([\w\W]+)<\/dd>/U', $data, $resultValue);
        if (count($resultName[1]) == count($resultValue[1])) {
            $options = [];
            for ($i = 0; $i < count($resultName[1]); $i++) {
                $options[$resultName[1][$i]] = trim($resultValue[1][$i]);
            }

            $model->addParamsArray($options);
        }

        // картинки
        preg_match_all('/"image": \["(.+)"\],/U', $data, $result);
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
        preg_match_all('/<link rel="alternate" href="(.+)"/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0 ) {
            $model->setURL(str_replace('?lang_ui=kz', '', $result[1][0]));
        }else{
            $model->setURL($url);
        }

        // наличие
        preg_match_all("/'ID':'([0-9]+)','IBLOCK_ID':'([0-9]+)'/U", $data, $result);
        if (count($result) == 3 && count($result[1]) > 0 && count($result[2]) > 0) {
            $data = Helpers_URL::getPageHTMLRandomProxy('https://shop.kz/include/ajax.php?items[0]='.$result[1][0].'&ib='.$result[2][0].'&rating_params[0]=0&rating_params[5]=1&rating_params[10]=2&rating_params[20]=3&rating_params[50]=4&action=getProductStores&type=ajax_store_action', $fileProxies);
            $data = json_decode($data, true);

            $isInStock = false;
            foreach (Arr::path($data, 'content.0.store', []) as $store){
                if($store['NAME'] == 'Алматы'){
                    $isInStock = true;
                    break;
                }
            }

            $model->setIsInStock($isInStock);
            $model->setIsPublic($isInStock);
        }

        /*echo '<pre>';
        print_r($model->getValues(true, true));
        echo $url;
        echo $data;die;*/
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
        $shopProductIDs = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams($params), 0, true
        );

        $model = new Model_AutoPart_Shop_Product();
        $model->setDBDriver($driver);

        foreach ($shopProductIDs->childs as $child) {
            $child->setModel($model);

            foreach ($model->getIntegrationsArray() as $integration) {
                self::loadProduct(self::PRODUCT_URL . $integration, $model, $sitePageData, $driver, $fileProxies, $isReplace);

                $model->setIsLoadSiteSupplier(true);
                Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);

                break;
            }
        }

        return true;
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_Bt24KZ
{
    const PRODUCT_URL = 'https://bt24.kz/';

    // загружать ли файлы картинок
    const IS_LOAD_IMAGE = false;

    /**
     * Загружаем данные о об одном товаре
     * @param $url
     * @param $shopTableCatalogID
     * @param Model_AutoPart_Shop_Product $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     */
    public static function loadProduct($url, Model_AutoPart_Shop_Product $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        $data = Helpers_URL::getDataURLEmulationBrowser($url);
        //$data = file_get_contents('C:\WAMP\www\ct\al_style_catalog.xml');

        if(mb_strpos($data, 'По вашему запросу ничего не найдено') !== false){
            return true;
        }

        // Название товара
        if(Func::_empty($model->getNameSupplier()) || Func::_empty($model->getName())) {
            preg_match_all('/<h1 class="ty-product-block-title" >(.+)<\/h1>/U', $data, $result);
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

        // Характеристики
        preg_match_all('/<span class="ty-product-feature__label">(.+):<\/span>/U', $data, $resultName);
        preg_match_all('/<div class="ty-product-feature__value">(.+)<\/div>/U', $data, $resultValue);
        if (count($resultName) > 1  && count($resultValue) > 1  && count($resultName[1]) == count($resultValue[1])) {
            $options = [];
            for ($i = 0; $i < count($resultName[1]); $i++) {
                $options[trim($resultName[1][$i])] = trim($resultValue[1][$i]);
            }

            $model->addParamsArray($options);
        }

        // Картинки
        preg_match_all('/data-ca-image-height="[0-9]+" href="(.+)"/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0 ) {
            $images = [];
            foreach ($result[1] as $child) {
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

        if (Func::_empty($model->getURL())) {
            preg_match_all('/link rel="canonical" href="(.+)"/U', $data, $result);
            if (count($result) == 2 && count($result[1]) > 0) {
                $model->setURL($result[1][0]);
            }
        }

        //echo '<pre>'; print_r($model->getValues(true, true)); die();
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
                self::loadProduct(
                    self::PRODUCT_URL . URL::query([
                        'subcats' => 'Y',
                        'pcode_from_q' => 'Y,Y',
                        'pshort' => 'Y,Y',
                        'pfull' => 'Y,Y',
                        'pname' => 'Y,Y',
                        'pkeywords' => 'Y,Y',
                        'search_performed' => 'Y',
                        'match' => 'all',
                        'pcode' => 'Y',
                        'q' => Func::addBeginSymbol($integration, '0', 11),
                        'dispatch' => 'products.search'
                    ], false),
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
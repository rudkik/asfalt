<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_PulserKZ
{
    const PRODUCT_URL = 'https://pulser.kz/';

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


        if(mb_strpos($data, 'Товар с таким кодом отсутствует в базе данных') !== false){
            return false;
        }

        // Название товара
        if(Func::_empty($model->getNameSupplier()) || Func::_empty($model->getName())) {
            preg_match_all('/<div class="mainhd">(.+)<\/h4>/U', $data, $result);
            if (count($result) == 2 && count($result[1]) > 0) {
                $name = htmlspecialchars_decode(str_replace('</div>', ' ', $result[1][0]), ENT_QUOTES);

                if (Func::_empty($model->getName())) {
                    $model->setName($name);
                }
                if (Func::_empty($model->getNameSupplier())) {
                    $model->setNameSupplier($name);
                }
            }
        }

        // Характеристики
        preg_match_all('/<table class="specTable"  >([\w\W]+)<\/table>/U', $data, $result);
        if (count($result) > 1 && count($result[1]) > 0) {
            preg_match_all('/<td>([\W\w]+)<\/td>/U', $result[1][0], $result);
            if (count($result) > 1 && count($result[1]) % 2 == 0) {
                $options = [];
                for ($i = 0; $i < count($result[1]) - 1; $i += 2) {
                    $options[trim($result[1][$i])] = trim($result[1][$i + 1]);
                }

                $model->addParamsArray($options);
            }
        }

        // картинки
        preg_match_all('/<img src="(.+)" width="500"/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0 ) {
            $images = [];
            foreach ($result[1] as $child) {
                if($child == 'images/na_500.png'){
                    return  false;
                }

                $images[] = 'https://pulser.kz/' . $child;
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

        // ссылка
        $model->setURL($url);

        //print_r($model->getValues(true, true));die;

        return  true;
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
        $fileProxies = [];
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
                $isLoadSite = self::loadProduct(
                    self::PRODUCT_URL . URL::query(['card' => $integration], false),
                    $model, $sitePageData, $driver, $fileProxies, $isReplace
                );

                $model->setIsLoadSiteSupplier($isLoadSite);
                Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);

                break;
            }
        }

        return true;
    }
}
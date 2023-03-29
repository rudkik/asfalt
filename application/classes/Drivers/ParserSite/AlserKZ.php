<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_AlserKZ
{
    const PRODUCT_URL = 'https://alser.kz/search';

    // загружать ли файлы картинок
    const IS_LOAD_IMAGE = false;

    /**
     * Загружаем данные о об одном товаре поиск
     * @param $url
     * @param $article
     * @param Model_AutoPart_Shop_Product $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param $fileProxies
     * @param bool $isReplace
     * @return bool
     * @throws HTTP_Exception_500
     */
    public static function loadProductSearch($url, $article, Model_AutoPart_Shop_Product $model, SitePageData $sitePageData,
                                             Model_Driver_DBBasicDriver $driver, $fileProxies, $isReplace = TRUE)
    {
        $data = Helpers_URL::getPageHTMLRandomProxy($url, $fileProxies);
        //$data = file_get_contents('C:\WAMP\www\ct\al_style_catalog.xml');

        if(strpos($data, 'Why do I have to complete a CAPTCHA?') !== false){
            throw new HTTP_Exception_500('Alser.kz заблокировал нас. :(');
        }

        // ссылка на товар
        preg_match_all('/<a class="product-item__image" href="(.+)"/U', $data, $result);
        preg_match_all('/<input class="product-sku__value noselect" value="(.+)"/U', $data, $resultArticle);
        if (count($result) == 2 && count($resultArticle) == 2 && count($result[1]) > 0 && count($result[1]) == count($resultArticle[1])) {
            for ($i = 0; $i < count($resultArticle[1]); $i++){
                if($resultArticle[1][$i] == $article){
                    return Drivers_ParserSite_HatberKZ::loadProduct(
                        'https://alser.kz' . $result[1][$i], $model, $sitePageData, $driver, $fileProxies, $isReplace
                    );
                }
            }
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
            preg_match_all('/<li class="active">(.+)<\/li>/U', $data, $result);
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
            preg_match_all('/<div class="detail-description__content">([\w\W]+)<div id="services">/U', $data, $result);
            if (count($result) == 2 && count($result[1]) > 0) {
                $text = trim($result[1][0]);
                $text = mb_substr($text, 0, -6);
                $model->setText(str_replace('src="/uploads', 'src="https://alser.kz/upload', $text));
            }
        }

        // Характеристики
        $text = mb_substr($data, mb_strpos($data, '<div class="detail-specifications__title">'));
        $text = mb_substr($text, 0, mb_strpos($text, '<div id="faq" class="detail-faq">'));
        preg_match_all('/<div class="col-md-4">[\S\s]+<p>([\w\W]+)<\/p>[\S\s]+<\/div>/U', $text, $result);
        if (count($result) > 1 &&count($result[1]) % 2 == 0) {
            $options = [];
            for ($i = 0; $i < count($result[1]) - 1; $i += 2) {
                $options[trim($result[1][$i])] = trim($result[1][$i + 1]);
            }

            $model->addParamsArray($options);
        }

        // картинки
        preg_match_all('/<img id="imageItemId[0-9]+" src="(.+)"/U', $data, $result);
        if (count($result) == 2 && count($result[1]) > 0 ) {
            $images = [];
            foreach ($result[1] as $child) {
                $images[] = str_replace('-520x325', '', $child);
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

        // наличие
        /*if ($model->getIsInStock() && mb_strpos($data, 'Есть в наличии') === false) {
            $model->setIsInStock(false);
            $model->setIsPublic(false);
        }*/

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
                self::loadProductSearch(
                    self::PRODUCT_URL . URL::query(['query' => $integration], false), $integration,
                    $model, $sitePageData, $driver, $fileProxies, $isReplace
                );

                $images = $model->getOptionsValue('image_urls');
                if(!empty($images)) {
                    try {
                        foreach ($images as $key => $image) {
                            if (strpos($image, 'https://alser.kz') === false) {
                                continue;
                            }

                            $image = str_replace('-520x325', '', $image);

                            $path = '/img' . str_replace('//', '/', str_replace('https://alser.kz', '', $image));

                            Helpers_Path::createPath(DOCROOT . dirname($path));

                            file_put_contents(DOCROOT . $path, file_get_contents($image));

                            $images[$key] = $path;
                            break;
                        }
                        $model->setOptionsValue('image_urls', $images);
                    }catch(Exception $e){}
                }

                $model->setIsLoadSiteSupplier(true);
                Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);

                break;
            }
        }

        return true;
    }
}
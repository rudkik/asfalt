<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта https://al-style.kz/upload/catalog_export/al_style_catalog.php
 * Class Drivers_ParserSite_AlStyleKZNotToken
 */
class Drivers_ParserSite_AlStyleKZNotToken extends Drivers_ParserSite_Basic
{
    const PARSER_AL_STYLE_KZ = 3;

    const URL = 'https://al-style.kz/upload/catalog_export/al_style_catalog.php';

    public static function loadProducts($shopSupplierID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $data = Helpers_URL::getDataURLEmulationBrowser(self::URL);

        $xml = simplexml_load_string($data);

        $offers = [];
        foreach($xml->shop->offers->offer as $offer) {
            $article = Helpers_XML::getXMLFieldValue($offer, 'vendorCode');

            // картинки
            $images = [];
            foreach ($offer->picture as $picture){
                $images[] = Helpers_XML::getXMLValue($picture);
            }

            // параметры
            $options = [];
            foreach ($offer->param as $param){
                $options[Helpers_XML::getXMLValue($param->attributes()->name)] = Helpers_XML::getXMLValue($param);
            }

            $offers[$article] = [
                'name' => Helpers_XML::getXMLFieldValue($offer, 'product_type') . ' ' . Helpers_XML::getXMLFieldValue($offer, 'name'),
                'brand' => Helpers_XML::getXMLFieldValue($offer, 'vendor'),
                'price' => Helpers_XML::getXMLFieldValue($offer, 'price'),
                'price_cost' => Helpers_XML::getXMLFieldValue($offer, 'purchase_price'),
                'url' => Helpers_XML::getXMLFieldValue($offer, 'url'),
                'text' => Helpers_XML::getXMLFieldValue($offer, 'description'),
                'is_in_stock' => Request_RequestParams::isBoolean(Helpers_XML::getXMLFieldValue($offer, 'available')),
                'stock_quantity' => Helpers_XML::getXMLFieldValue($offer, 'quantity_in_stock'),
                'options' => $options,
                'images' => $images,
            ];
        }

        $params = [
            'shop_supplier_id' => $shopSupplierID,
            'is_public_ignore' => true,
        ];
        $shopProductIDs = Request_Request::find(
            DB_AutoPart_Shop_Product::NAME, $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams($params), 0, true
        );

        $brands = [];

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
                $offer = $offers[$key];

                $model->setIsPublic($offer['is_in_stock']);

                if(Func::_empty($model->getName())) {
                    $model->setName($offer['name']);
                }

                if(!key_exists($offer['brand'], $brands)){
                    if(!empty($offer['brand'])) {
                        $brandID = Request_Request::findIDByFieldAndCreate(
                            DB_AutoPart_Shop_Brand::NAME, 'name', $offer['brand'], $sitePageData->shopID,
                            $sitePageData, $driver
                        );
                    }else{
                        $brandID = 0;
                    }

                    $brands[$offer['brand']] = $brandID;
                }

                $model->setShopBrandID($brands[$offer['brand']]);

                $model->setPrice($offer['price']);
                $model->setPriceCost($offer['price_cost']);
                $model->setURL($offer['url']);
                $model->setText($offer['text']);
                $model->setIsInStock($offer['is_in_stock']);
                $model->setStockQuantity($offer['stock_quantity']);

                $model->addParamsArray($offer['options']);
                $model->setOptionsValue('image_urls', $offer['images']);

                unset($offers[$key]);
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);
        }

        foreach ($offers as $key => $offer) {
            $model->clear();

            $model->setIsPublic($offer['is_in_stock']);
            $model->addIntegration($key);

            $model->setShopSupplierID($shopSupplierID);
            $model->setName($offer['name']);

            if(!key_exists($offer['brand'], $brands)){
                if(!empty($offer['brand'])) {
                    $brandID = Request_Request::findIDByFieldAndCreate(
                        DB_AutoPart_Shop_Brand::NAME, 'name', $offer['brand'], $sitePageData->shopID,
                        $sitePageData, $driver
                    );
                }else{
                    $brandID = 0;
                }

                $brands[$offer['brand']] = $brandID;
            }
            $model->setShopBrandID($brands[$offer['brand']]);

            $model->setPrice($offer['price']);
            $model->setPriceCost($offer['price_cost']);
            $model->setURL($offer['url']);
            $model->setText($offer['text']);
            $model->setIsInStock($offer['is_in_stock']);
            $model->setStockQuantity($offer['stock_quantity']);

            $model->addParamsArray($offer['options']);
            $model->setOptionsValue('image_urls', $offer['images']);

            Helpers_DB::saveDBObject($model, $sitePageData);

            // загружаем картинки
            /*foreach ($offer['images'] as $image){
                try {
                    $file = new Model_File($sitePageData);
                    $file->saveAdditionFiles($image, $model, $sitePageData, $driver);
                } catch (Exception $e) {
                }
            }*/

            $model->setArticle('I'.$model->id);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }
    }
}
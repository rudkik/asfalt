<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта https://www.ak-cent.kz/export/Exchange/codetnwed/Ware0099.xml
 * Class Drivers_ParserSite_AkCentKZNotToken
 */
class Drivers_ParserSite_AkCentKZNotToken extends Drivers_ParserSite_Basic
{
    const PARSER_AL_STYLE_KZ = 3;

    const URL = 'https://www.ak-cent.kz/export/Exchange/codetnwed1/Ware090921.xml';

    public static function loadProducts($shopSupplierID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $data = Helpers_URL::getDataURLEmulationBrowser(self::URL);

        $xml = simplexml_load_string($data);

        $offers = [];

        foreach($xml->shop->offers->offer as $offer) {
            $article = Helpers_XML::getXMLFieldValue($offer, 'Offer_ID');

            // картинки
            $images = [Helpers_XML::getXMLFieldValue($offer, 'picture')];

            // параметры
            $options = [
                'Срок годности' => Helpers_XML::getXMLFieldValue($offer, 'manufacturer_warranty'),
                'Вес' => Helpers_XML::getXMLFieldValue($offer, 'weight'),
                'Ширина' => Helpers_XML::getXMLFieldValue($offer, 'width'),
                'Длина' => Helpers_XML::getXMLFieldValue($offer, 'height'),
                'Размер' => Helpers_XML::getXMLFieldValue($offer, 'size'),

            ];
            foreach ($offer->Param as $param){
                $name = Helpers_XML::getXMLValue($param->attributes()->name);
                if($name == 'Сопутствующие товары'){
                    continue;
                }

                $options[$name] = Helpers_XML::getXMLValue($param);
            }

            $stock = htmlspecialchars_decode(Helpers_XML::getXMLFieldValue($offer, 'Stock'), ENT_XML1);
            if(strpos($stock, '>') !== false){
                $compare = Model_AutoPart_Shop_Product::COMPARE_STOCK_MORE;
            }elseif(strpos($stock, '<') !== false){
                $compare = Model_AutoPart_Shop_Product::COMPARE_STOCK_LESS;
            }else{
                $compare = Model_AutoPart_Shop_Product::COMPARE_STOCK_EQUALLY;
            }

            $price = 0;
            $priceCost = 0;
            foreach ($offer->prices->price as $param){
                $type = Helpers_XML::getXMLValue($param->attributes()->type);
                if($type == 'Дилерская цена'){
                    $priceCost = Helpers_XML::getXMLValue($param);
                }elseif($type == 'RRP'){
                    $price = Helpers_XML::getXMLValue($param);
                }

            }

            $offers[$article] = [
                'name' => Helpers_XML::getXMLFieldValue($offer, 'name'),
                'brand' => Helpers_XML::getXMLFieldValue($offer, 'vendor'),
                'price' => Request_RequestParams::strToFloat($price),
                'price_cost' => Request_RequestParams::strToFloat($priceCost),
                'url' => Helpers_XML::getXMLFieldValue($offer, 'url'),
                'text' => Helpers_XML::getXMLFieldValue($offer, 'description'),
                'stock_compare_type' => $compare,
                'stock_quantity' => Request_RequestParams::strToFloat($stock),
                'tnved' => Helpers_XML::getXMLFieldValue($offer, 'codetnwed'),
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

                $model->setIsPublic($offer['stock_quantity'] > 1);

                if(Func::_empty($model->getName())) {
                    $model->setName($offer['name']);
                }
                if(Func::_empty($model->getNameSupplier())) {
                    $model->setNameSupplier($offer['name']);
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
                $model->setIsInStock($offer['stock_quantity'] > 1);
                $model->setStockQuantity($offer['stock_quantity']);
                $model->setStockCompareTypeID($offer['stock_compare_type']);

                $model->addParamsArray($offer['options']);
                $model->setOptionsValue('image_urls', $offer['images']);

                unset($offers[$key]);
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);
        }

        foreach ($offers as $key => $offer) {
            $model->clear();

            $model->setIsPublic($offer['stock_quantity'] > 1);
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
            $model->setIsInStock($offer['stock_quantity'] > 1);
            $model->setStockQuantity($offer['stock_quantity']);
            $model->setStockCompareTypeID($offer['stock_compare_type']);

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
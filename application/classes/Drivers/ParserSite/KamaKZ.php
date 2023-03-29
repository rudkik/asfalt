<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта https://kama.kz
 * файл xml для их сайта
 * https://td-kama.kz/uploads/partners/residues.xml
 * файл xlsx это Excel для людей
 * https://td-kama.kz/uploads/partners/residues.xlsx
 *
 * Class Drivers_ParserSite_KamaKZ
 */
class Drivers_ParserSite_KamaKZ {
    const URL_ALL = 'https://td-kama.kz/uploads/partners/residues.xml';
    const URL = 'https://td-kama.kz/uploads/partners/AlmatyShini.xml';


    public static function loadProducts($shopSupplierID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $xml = simplexml_load_file(self::URL);

        $offers = [];
        foreach($xml->shop->offers->offer as $offer) {
            $article = Helpers_XML::getXMLFieldValue($offer, 'id');

            $options = [
                'manufacturer' => Helpers_XML::getXMLFieldValue($offer, 'manufacturer'),
                'product_type' => Helpers_XML::getXMLFieldValue($offer, 'product_type'),
            ];
            $images = [];
            foreach($offer->properties->children() as $name => $value) {
                if($name == 'urlpicture'){
                    $images[] = Helpers_XML::getXMLValue($value);
                    continue;
                }

                $options[$name] = Helpers_XML::getXMLValue($value);
            }

            $offers[$article] = [
                'name' => Helpers_XML::getXMLFieldValue($offer, 'product_type') . ' ' . Helpers_XML::getXMLFieldValue($offer, 'name'),
                'brand' => Helpers_XML::getXMLFieldValue($offer, 'vendor'),
                'price' => Helpers_XML::getXMLFieldValue($offer, 'recommended_price'),
                'price_cost' => Helpers_XML::getXMLFieldValue($offer, 'price'),
                'tnved' => Helpers_XML::getXMLFieldValue($offer, 'tnvd'),
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

                $model->addParamsArray($offer['options']);
                $model->setOptionsValue('image_urls', $offer['images']);

                $model->setPrice($offer['price']);
                $model->setPriceCost($offer['price_cost']);

                if(Func::_empty($model->getTNVED())) {
                    $model->setTNVED($offer['tnved']);
                }

                unset($offers[$key]);
            }

            Helpers_DB::saveDBObject($model, $sitePageData, $model->shopID);
        }

        foreach ($offers as $key => $offer) {
            $model->clear();

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

            $model->addParamsArray($offer['options']);
            $model->setOptionsValue('image_urls', $offer['images']);

            $model->setPrice($offer['price']);
            $model->setPriceCost($offer['price_cost']);
            $model->setTNVED($offer['tnved']);

            Helpers_DB::saveDBObject($model, $sitePageData);

            $model->setArticle('I'.$model->id);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }
    }
}
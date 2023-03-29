<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта https://www.ak-cent.kz/export/Exchange/codetnwed/Ware0099.xml
 * Class Drivers_ParserSite_AlfastarKz
 */
class Drivers_ParserSite_AlfastarKz extends Drivers_ParserSite_Basic
{
    const URL = 'https://api.alfastar.kz/api/v1/client/products';

    public static function loadProducts($shopSupplierID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $data = Helpers_URL::getDataURLEmulationBrowser(self::URL);

        $json = json_decode($data, true);

        $offers = [];

        foreach($json['products'] as $offer) {
            $article = $offer['vendor_code'];

            // картинки
            $images = $offer['images'];
            if(!is_array($images)){
                $images = json_decode($images, true);
            }
            if(empty($images)){
                $images = [];
            }
            if(!is_array($images)){
                $images = [$images];
            }
            foreach ($images as $key => $image){
                $images[$key] = 'https://api.alfastar.kz/v1c_files/' . $image;
            }

            $offers[$article] = [
                'name' => $offer['name'],
                'price' => $offer['price_wholesale'],
                'price_cost' => $offer['price_dealer'],
                'url' => 'https://portal.alfastar.kz/product/' . $offer['alias'],
                'text' => $offer['desc'],
                'stock_quantity' => $offer['remain'],
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

                $model->setPrice($offer['price']);
                $model->setPriceCost($offer['price_cost']);
                $model->setURL($offer['url']);
                $model->setText($offer['text']);
                $model->setIsInStock($offer['stock_quantity'] > 1);
                $model->setStockQuantity($offer['stock_quantity']);
                $model->setStockCompareTypeID(Model_AutoPart_Shop_Product::COMPARE_STOCK_EQUALLY);
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

            $model->setPrice($offer['price']);
            $model->setPriceCost($offer['price_cost']);
            $model->setURL($offer['url']);
            $model->setText($offer['text']);
            $model->setIsInStock($offer['stock_quantity'] > 1);
            $model->setStockQuantity($offer['stock_quantity']);
            $model->setStockCompareTypeID(Model_AutoPart_Shop_Product::COMPARE_STOCK_EQUALLY);

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
<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта https://b2b.marvel.kz
 * Class Drivers_ParserSite_MarvelKZ
 */
class Drivers_ParserSite_MarvelKZ extends Drivers_ParserSite_Basic
{
    const URL = 'https://b2b.marvel.kz/Api/';
    const URL_SHOW = 'https://b2b.marvel.kz/Stock/Details';

    const ACTION_GET_FULL_STOCK = 'GetFullStock';
    const ACTION_GET_ITEMS = 'GetItems';
    const ACTION_GET_ITEM_PHOTOS = 'GetItemPhotos';


    private static function _getURLData($action, array $params){
        if($action == self::ACTION_GET_FULL_STOCK) {
           // return file_get_contents('C:\WAMP\www\ct\al_style_catalog.xml');
        }

        $params['user'] = 'opto02';
        $params['password'] = '88vcr_PJ5E';
        $params['secretKey'] = '';

        $url = self::URL . $action . URL::query($params, false);
        return Helpers_URL::getDataURLEmulationBrowser($url, 10, true);
    }

    public static function loadProducts($shopSupplierID, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver){
        $data = self::_getURLData(self::ACTION_GET_FULL_STOCK, ['packStatus' => 1, 'responseFormat' => 0, 'instock' => 0]);

        $xml = simplexml_load_string($data);
        if(empty($xml->Body) || empty($xml->Body->CategoryItem)){
            return false;
        }

        $offers = [];
        foreach($xml->Body->CategoryItem as $offer) {
            $article = Helpers_XML::getXMLFieldValue($offer, 'WareArticle');

            // параметры
            $options = [
                'Вес нетто (кг)' => Helpers_XML::getXMLFieldValue($offer, 'NetWeight'),
                'Вес брутто (кг)' => Helpers_XML::getXMLFieldValue($offer, 'Weight'),
                'Объем (м3)' => Helpers_XML::getXMLFieldValue($offer, 'UnitVolume'),
                'Ширина (см)' => Helpers_XML::getXMLFieldValue($offer, 'Width'),
                'Высота (см)' => Helpers_XML::getXMLFieldValue($offer, 'Height'),
                'Глубина (см)' => Helpers_XML::getXMLFieldValue($offer, 'Depth'),
                'Кол-во в упаковке' => Helpers_XML::getXMLFieldValue($offer, 'TaxPackagingCount'),
            ];

            $offers[$article] = [
                'name' => Helpers_XML::getXMLFieldValue($offer, 'WareFullName'),
                'price' => Helpers_XML::getXMLFieldValue($offer, 'RRPrice'),
                'price_cost' => Helpers_XML::getXMLFieldValue($offer, 'WarePriceKZT'),
                'stock_quantity' => str_replace('+', '', Helpers_XML::getXMLFieldValue($offer, 'AvailableForB2BOrderQty')),
                'options' => $options,
            ];

            $offers[$article]['is_in_stock'] = $offers[$article]['stock_quantity'] > 0;
            $offers[$article]['url'] = self::URL_SHOW
                . URL::query(['ItemId' => $article, 'Condition' => 'OK', 'Filter' => 'Standard', 'PileId' => 'осн'], false);
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

                $model->setIsPublic($offer['is_in_stock']);

                if(Func::_empty($model->getName())) {
                    $model->setName($offer['name']);
                }

                if(Func::_empty($model->getNameSupplier())) {
                    $model->setNameSupplier($offer['name']);
                }

                $model->setPrice($offer['price']);
                $model->setPriceCost($offer['price_cost']);
                $model->setURL($offer['url']);
                $model->setIsInStock($offer['is_in_stock']);
                $model->setStockQuantity($offer['stock_quantity']);

                $model->addParamsArray($offer['options']);

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
            $model->setNameSupplier($offer['name']);

            $model->setPrice($offer['price']);
            $model->setPriceCost($offer['price_cost']);
            $model->setURL($offer['url']);
            $model->setIsInStock($offer['is_in_stock']);
            $model->setStockQuantity($offer['stock_quantity']);

            $request = '<Root><WareItem><ItemId>' . $key . '</ItemId></WareItem></Root>';
            $data = self::_getURLData(self::ACTION_GET_ITEM_PHOTOS, ['responseFormat' => 0, 'items' => $request]);
            $xml = simplexml_load_string($data);

            if (!empty($xml->Body)
                && !empty($xml->Body->Photo)) {
                $images = [];
                foreach ($xml->Body->Photo as $photo) {
                    $images[] = Helpers_XML::getXMLFieldValue($photo->BigImage, 'URL');
                }
                $model->setOptionsValue('image_urls', $images);
            }

            if(false) {
                $data = self::_getURLData(
                    self::ACTION_GET_ITEMS,
                    ['packStatus' => 0, 'responseFormat' => 0, 'getExtendedItemInfo' => 1, 'items' => $request]
                );
                $xml = simplexml_load_string($data);

                $options = [];
                if (!empty($xml->Body)
                    && !empty($xml->Body->CategoryItem)
                    && !empty($xml->Body->CategoryItem->ExtendedInfo)
                    && !empty($xml->Body->CategoryItem->ExtendedInfo->Parameter)) {
                    foreach ($xml->Body->CategoryItem->ExtendedInfo->Parameter as $parameter) {
                        $options[Helpers_XML::getXMLFieldValue($parameter, 'ParameterName')] =
                            Helpers_XML::getXMLFieldValue($parameter, 'ParameterValue');
                    }
                }
                $model->addParamsArray($options);
            }

            $model->addParamsArray($offer['options']);

            Helpers_DB::saveDBObject($model, $sitePageData);

            // загружаем картинки
            /*foreach ($images as $image){
                try {
                    $file = new Model_File($sitePageData);
                    $file->saveAdditionFiles($image, $model, $sitePageData, $driver);
                } catch (Exception $e) {
                }
            }*/

            $model->setArticle('I'.$model->id);
            Helpers_DB::saveDBObject($model, $sitePageData, $sitePageData->shopID);
        }
        die;
    }
}
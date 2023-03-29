<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта https://www.ak-cent.kz/export/Exchange/all/Ware0011.xml
 * Class Drivers_ParserSite_AkCentKZ
 */
class Drivers_ParserSite_AkCentKZ extends Drivers_ParserSite_Basic
{
    const PARSER_AKCENT_KZ = 1;
    const URL = 'https://www.ak-cent.kz/export/Exchange/all/Ware0011.xml';

    public static function parserGood($good, $shopTableCatalogID, Model_Shop_Good $model, SitePageData $sitePageData,
                                      Model_Driver_DBBasicDriver $driver, $isReplace = TRUE){
        $id = trim($good->Offer_ID);

        $objNew = Request_Shop_Good::findOne(
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'old_id' => $id,
                    'is_public_ignore' => TRUE,
                    'shop_table_catalog_id' => $shopTableCatalogID,
                    'shop_table_stock_id' => Drivers_ParserSite_AlStyleKZ::PARSER_AL_STYLE_KZ,
                )
            ), TRUE
        );
        if($objNew !== false){
            $objNew->setModel($model);
            $model->setIsPublic($objNew->values['price'] <= $good['price2']);
            Helpers_DB::saveDBObject($model, $sitePageData);
        }

        $obj = Request_Shop_Good::findOne(
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'old_id' => $id,
                    'is_public_ignore' => TRUE,
                    'shop_table_catalog_id' => $shopTableCatalogID,
                    'shop_table_stock_id' => self::PARSER_AKCENT_KZ,
                )
            ), TRUE
        );

        if($obj === FALSE){
            $model->clear();
            $model->setShopTableCatalogID($shopTableCatalogID);
            $model->setOldID($id);
            $model->setShopTableStockID(self::PARSER_AKCENT_KZ);
        }else{
            $obj->setModel($model);
        }

        $model->setName(trim($good->name));
        $model->setText(trim($good->description));

        $model->setIsPublic(intval($good->Stock) > 0 || !empty($good->Stock));

        $params = array();
        // <Param name="Страна происхождения">Китай</Param>
        foreach($good->Param as $param) {
            $param = Arr::path(Helpers_XML::xmlToArray($param), 'Param', array());

            $name = Arr::path($param, 'attributes.name', '');
            if($name == 'Сопутствующие товары'){
                continue;
            }
            $params[] = array(
                'is_public' => TRUE,
                'name' => $name,
                'title' => Arr::path($param, 'value', ''),
            );
        }
        $model->addParamInOptions('params', $params);

        foreach(Arr::path(Helpers_XML::xmlToArray($good->prices), 'prices.price', array()) as $price) {
            if(Arr::path($price, 'attributes.type', '') == 'RRP'){
                $model->setPrice(Arr::path($price, 'value', $model->getPrice()));
                continue;
            }
            if(Arr::path($price, 'attributes.type', '') == 'Дилерская цена'){
                $model->setPriceCost(Arr::path($price, 'value', $model->getPriceCost()));
            }
        }

        if (Func::_empty($model->getImagePath())) {
            try {
                $file = new Model_File($sitePageData);
                $file->addImageURLInModel(trim($good->picture), $model, $sitePageData, $driver);
            } catch (Exception $e) {
            }
        }

        $model->setNameURL(Helpers_URL::getNameURL($model));
        Helpers_DB::saveDBObject($model, $sitePageData);

        return TRUE;
    }

    /**
     * Загружаем данные о об одном товаре
     * @param $url
     * @param $shopTableCatalogID
     * @param Model_Shop_Good $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     */
    public static function parserRUS($shopTableCatalogID, Model_Shop_Good $model, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        set_time_limit(3600000);
        ignore_user_abort(TRUE);
        ini_set('max_execution_time', 360000);

        $url = self::URL;

        $data = Helpers_URL::getDataURLEmulationBrowser($url);
        $data = substr($data, strpos($data, '<?xml'));

        $ids = Request_Request::find('DB_Shop_Good',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_table_stock_id' => self::PARSER_AKCENT_KZ,
                    'is_delete_ignore' => TRUE,
                    'is_public_ignore' => TRUE,
                )
            ), 0, TRUE
        );
        $ids->runIndex(TRUE, 'old_id');

        // список артиклов для загрузки
        $articles = [];
        $list = explode("\r\n", file_get_contents(APPPATH.'config/kigston-articles.config'));
        foreach ($list as $one){
            $one = trim($one);
            $articles[$one] = $one;
        }

        $xml = simplexml_load_string($data);
        foreach($xml->shop->offers->offer  as $good) {
            $isAdd = false;
            foreach ($articles as $one){
                if(strpos($good->name, $one) !== false || strpos($good->model, $one) !== false){
                    $isAdd = true;
                    break;
                }
            }

            if(!$isAdd){
                continue;
            }

            if(self::parserGood($good, $shopTableCatalogID, $model, $sitePageData, $driver, $isReplace)){
                if(key_exists($model->getOldID(), $ids->childs)){
                    unset($ids->childs[$model->getOldID()]);
                }
            }
        }

        $driver->deleteObjectIDs(
            $ids->getChildArrayID(), $sitePageData->userID, Model_Shop_Good::TABLE_NAME,
            array(), $sitePageData->shopID
        );

        return TRUE;
    }
}
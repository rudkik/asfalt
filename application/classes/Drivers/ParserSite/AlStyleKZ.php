<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта https://order.al-style.kz/api/elements
 * Class Drivers_ParserSite_AlStyleKZ
 */
class Drivers_ParserSite_AlStyleKZ extends Drivers_ParserSite_Basic
{
    const PARSER_AL_STYLE_KZ = 2;

    // для KINGSTON
    const ACCESS_TOKEN = 'QZkgy17h6zwX53vmjqjnzsUXScIYhC3W';

    // список товаров
    const URL_GOODS_LIST = 'https://order.al-style.kz/api/elements';
    // подробно о товаре
    const URL_GOODS_INFO = 'https://order.al-style.kz/api/element-info';

    // для KINGSTON нужные рубрики
    const PARAMS_GOODS_LIST = '&category=3651,3774,3652,3778,3779,3654,4963&additional_fields=description,brand,weight,images,model,barcode,properties,article_pn';

    // для KINGSTON нужные рубрики
    const PARAMS_GOODS_INFO = '&additional_fields=description,brand,weight,images,model,barcode,properties,article_pn';

    public static function parserGood(array $good, $shopTableCatalogID, Model_Shop_Good $model, SitePageData $sitePageData,
                                      Model_Driver_DBBasicDriver $driver, $isReplace = TRUE){
        $id = trim($good['article_pn']);

        $objNew = Request_Shop_Good::findOne(
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'old_id' => $id,
                    'shop_table_catalog_id' => $shopTableCatalogID,
                    'shop_table_stock_id' => Drivers_ParserSite_AkCentKZ::PARSER_AKCENT_KZ,
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
                    'shop_table_stock_id' => self::PARSER_AL_STYLE_KZ,
                )
            ), TRUE
        );

        if($obj === FALSE){
            $model->clear();
            $model->setShopTableCatalogID($shopTableCatalogID);
            $model->setOldID($id);
            $model->setArticle($id);
            $model->setShopTableStockID(self::PARSER_AL_STYLE_KZ);

            // считываем параметры
            if(key_exists('properties', $good)) {
                $params = array();
                foreach ($good['properties'] as $name => $param) {
                    if ($name == 'item') {
                        $name = '';
                    }
                    $params[] = array(
                        'is_public' => TRUE,
                        'name' => $name,
                        'title' => $param,
                    );
                }
                $model->addParamInOptions('params', $params);
            }

            if(Func::_empty($model->getName()) || $isReplace) {
                $model->setName(trim($good['name']));
            }
            if(Func::_empty($model->getText()) || $isReplace) {
                $model->setText(trim($good['description']));
            }
        }else{
            $obj->setModel($model);
        }

      /*  if($model->id < -10000) {
            $url = self::URL_GOODS_INFO . '?access-token=' . self::ACCESS_TOKEN . self::PARAMS_GOODS_INFO;
            $data = Helpers_URL::getDataURLEmulationBrowser($url . '&article=' . $id);
            $data = json_decode($data, TRUE);
            if (count($data) > 0) {
                $good = $data[0];
            }
        }*/

        $good['quantity'] = str_replace('>', '', str_replace('<', '', $good['quantity']));
          if(!is_numeric($good['quantity'])){
              print_r($good);die;
          }

        $model->setIsPublic(floatval($good['quantity']) > 0 || !empty($good['quantity']));
        $model->setPrice($good['price2']);
        $model->setPriceCost($good['price1']);

        if (Func::_empty($model->getImagePath())) {
            try {
                $file = new Model_File($sitePageData);

                foreach ($good['images'] as $picture){
                    $file->addImageURLInModel($picture, $model, $sitePageData, $driver, FALSE);
                }
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

        $url = self::URL_GOODS_LIST . '?access-token=' . self::ACCESS_TOKEN . self::PARAMS_GOODS_LIST;

        $ids = Request_Request::find('DB_Shop_Good',
            $sitePageData->shopID, $sitePageData, $driver,
            Request_RequestParams::setParams(
                array(
                    'shop_table_stock_id' => self::PARSER_AL_STYLE_KZ,
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
            $articles[trim($one)] = '';
        }

        $start = Request_RequestParams::getParamInt('start');
        if($start == null){
            $start = 1;
        }
        $stop = Request_RequestParams::getParamInt('stop');
        if($stop == null){
            $stop = 10000;
        }

        for ($i = $start; $i < $stop; $i++) {
            $data = Helpers_URL::getDataURLEmulationBrowser($url.'&offset='.$i);
            $data = json_decode($data, TRUE);

            if(count($data) < 1){
                break;
            }

            foreach ($data as $good) {
                if(!key_exists($good['article_pn'], $articles)){
                    continue;
                }

                if (self::parserGood($good, $shopTableCatalogID, $model, $sitePageData, $driver, $isReplace)) {
                    if (key_exists($model->getOldID(), $ids->childs)) {
                        unset($ids->childs[$model->getOldID()]);
                    }
                }
            }
        }
/*
        $driver->deleteObjectIDs(
            $ids->getChildArrayID(), $sitePageData->userID, Model_Shop_Good::TABLE_NAME,
            array(), $sitePageData->shopID
        );
*/
        return TRUE;
    }
}
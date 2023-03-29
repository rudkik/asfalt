<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта http://www.idroinox.com/en
 * Class Drivers_ParserSite_IdroinoxCom
 */
class Drivers_ParserSite_IdroinoxCom extends Drivers_ParserSite_Basic
{
    public static function parserURLGoods($url, SitePageData $sitePageData){
        set_time_limit(3600000);
        ignore_user_abort(TRUE);
        ini_set('max_execution_time', 360000);

        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        preg_match_all('/<a rel="" title="(.+)" href="(.+)"><span class=\'link\'><\/span><\/a>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) && (count($result[1]) > 0)){
            foreach ($result[2] as $url){
                echo $url.'<br>'."\r\n";
            }
        }
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
    public static function parserEN($url, $shopTableCatalogID, Model_Shop_Good $model, SitePageData $sitePageData,
                                    Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        $sitePageData->dataLanguageID = Model_Language::LANGUAGE_ENGLISH;

        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        // возвращаем список ссылок на товары в списке
        if(Request_RequestParams::getParamBoolean('is_url')) {
            self::parserURLGoods($url, $sitePageData);
            die;
        }

        // Название
        $isAddRussian = TRUE;
        preg_match_all('/<h1>(.+)<\/h1>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $name = trim($result[1][0]);

            if($name == 'Web Page Blocked'){
                throw new HTTP_Exception_500('Web "'.$url.'" Page Blocked');
            }

            $oldID = $name;

            if (!empty($name)) {
                $params = Request_RequestParams::setParams(
                    array(
                        'old_id' => $oldID,
                        'type' => $shopTableCatalogID,
                        'is_delete' => FALSE,
                    )
                );
                $shopGoodIDs = Request_Request::find('DB_Shop_Good',$sitePageData->shopID, $sitePageData,
                    $driver, $params, 1, TRUE);
                if(count($shopGoodIDs->childs) == 1){
                    $model->__setArray(array('values' => $shopGoodIDs->childs[0]->values));
                    $isAddRussian = FALSE;
                }else{
                    $model->setOldID($oldID);
                }

                $model->setName($name.' IDROINOX');
            }
        }

        if(Func::_empty($model->getName())){
            return FALSE;
        }
        $model->setShopTableCatalogID($shopTableCatalogID);


        // Картинка
        preg_match_all('/rel="prettyPhoto" title="([\s\S]+)" href="(.+)"/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) && (count($result[2]) > 0)){
            $urlImage = trim($result[2][0]);
            if (Func::_empty($model->getImagePath())) {
                try {
                    $file = new Model_File($sitePageData);
                    $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver, TRUE, TRUE, trim($result[1][0]));
                } catch (Exception $e) {
                }
            }
        }

        // Описание
        $text = '';
        preg_match_all('/<h1>project details<\/h1>[\s]+<p>([\s\S]+)<\/p>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $text =  '<p>'.html_entity_decode(trim($result[1][0])).'</p> ';
        }
        preg_match_all('/<h1>project info<\/h1>[\s]+<p>([\s\S]+)<\/p>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $text =  $text.'<p>'.html_entity_decode(trim($result[1][0])).'</p> ';
        }

        if ((!empty($text)) && ($isReplace || (Func::_empty($model->getText())))) {
            // ссылки заменяем на выделения
            $text = self::replaceURLByStrong($text);
            $text = self::parserImageText($text, $model, $sitePageData, $driver);

            $text = str_replace('<p><br/></p>', '',
                str_replace('<p>&nbsp;</p>', '', $text));
            $model->setText($text);
        }


        $model->setDBDriver($driver);

        if($model->id == 0) {
            $model->setIsTranslatesCurrentLanguage(TRUE, $sitePageData->dataLanguageID, $sitePageData->shop->getLanguageIDsArray());
        }
        $model->setNameURL(Helpers_URL::getNameURL($model));
        Helpers_DB::saveDBObject($model, $sitePageData);

        if ($isAddRussian) {
            $model->globalID = 0;
            $model->dbSave(Model_Language::LANGUAGE_RUSSIAN, $sitePageData->userID, $sitePageData->shopID);
        }else{
            // при первой загрузки добавлял изменение название у существующих товаров в будущем не нужно
            if (FALSE) {
                $sitePageData->dataLanguageID = Model_Language::LANGUAGE_RUSSIAN;
                if (Helpers_DB::getDBObject($model, $model->id, $sitePageData)) {
                    $model->setName($name . ' IDROINOX');
                    Helpers_DB::saveDBObject($model, $sitePageData);
                }
            }
        }

        return TRUE;
    }


}
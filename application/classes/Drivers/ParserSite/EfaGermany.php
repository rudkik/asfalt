<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта http://www.efa-germany.com
 * Class Drivers_ParserSite_EfaGermany
 */
class Drivers_ParserSite_EfaGermany
{
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
            preg_match_all('/<h2 class="listEntryTitle">[\s]+<a href="(.+)"[\s\S]+<\/h2>/U', $data, $result);
            if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
                foreach ($result[1] as $url){
                    echo 'http://www.efa-germany.com'.$url.'<br>';
                }
            }
            die;
        }

        // Название
        $isAddRussian = TRUE;
        preg_match_all('/<h1>(.+)<\/h1>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) == 1)){
            $name = trim($result[1][0]);
            $oldID = $name;

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

            if (!empty($name)) {
                preg_match_all('/<h2 class="entry">(.+)<\/h2>/U', $data, $result);
                  if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
                    $name = trim(trim($result[1][0]) . ' ' . $name);
                }

                $model->setName($name);
            }
        }

        if(Func::_empty($model->getName())){
            return FALSE;
        }
        $model->setShopTableCatalogID($shopTableCatalogID);

        // Картинка
        preg_match_all('/<a href="(.+)" class="boxPictureOnly">/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) == 1)){
            $urlImage = 'http://www.efa-germany.com'.trim($result[1][0]);
            if (Func::_empty($model->getImagePath())) {
                try {
                    $file = new Model_File($sitePageData);
                    $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver);
                } catch (Exception $e) {
                }
            }
        }

        // Картинки с дополнительные товарами
        $n = strpos($data, 'listEntries listEntries2');
        if ($n !== FALSE) {
            $tmp = substr($data, $n);
            $n = strpos($tmp, 'class="listMoverBack"');
            if ($n !== FALSE) {
                $tmp = substr($tmp, 0, $n);
                preg_match_all('/data-src2x="(.+)"/U', $tmp, $result);
                if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)) {
                    if (count($model->getFilesArray()) < 2) {
                        foreach ($result[1] as $urlImage) {
                            $urlImage = 'http://www.efa-germany.com' . trim($urlImage);
                            try {
                                $file = new Model_File($sitePageData);
                                $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver, FALSE);
                            } catch (Exception $e) {
                            }
                        }
                    }
                }
            }
        }

        // Описание
        $isText = FALSE;
        preg_match_all('/<div class="description entry">([\s\S]+)<\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) == 1)){
            $text = trim($result[1][0]);
            if ((!empty($text)) && ($isReplace || (Func::_empty($model->getText())))) {
                $text = str_replace('<p><br/></p>', '',
                    str_replace('<p>&nbsp;</p>', '', $text));


                $model->setText($text);
                $isText = TRUE;
            }
        }

        // Объем поставки
        preg_match_all('/<div class="box lieferumfang">[\s]+<h2 class="entry">([\s\S]+)<\/h2>[\s]+<div>([\s\S]+)<\/div>[\s]+<\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) && (count($result[1]) == 1)){
            $text = '<h3>'.trim($result[1][0]).'</h3>'.trim($result[2][0]);
            if ($isText || ((!empty($text)) && ($isReplace || (Func::_empty($model->getText()))))) {
                $model->setText($model->getText().$text);
            }
        }

        // Хэштеги
        $hashtagType = 0;
        preg_match_all('/<img src="(.+)" alt="(.+)" class="anwendungs_icon"/U', $data, $result);
        if ((is_array($result)) && (count($result) == 3) && (count($result[1]) > 0)){
            $modelType = new Model_Shop_Table_Catalog();
            $modelType->setDBDriver($driver);
            if(Helpers_DB::getDBObject($modelType, $shopTableCatalogID, $sitePageData, $sitePageData->shopMainID)){
                $hashtagType = $modelType->getChildShopTableCatalogID('hashtag', $sitePageData->languageID);
            }

            for ($i = 0; $i < count($result[1]); $i++){
                $urlImage = 'http://www.efa-germany.com'.$result[1][$i];
                $name = $result[2][$i];

                $params = Request_RequestParams::setParams(
                    array(
                        'name_full' => $name,
                        'type' => $hashtagType,
                    )
                );
                $shopTableHashtagIDs = Request_Shop_Table_Hashtag::findShopTableHashtagIDs($sitePageData->shopID, $sitePageData,
                    $driver, $params, 1);
                if(count($shopTableHashtagIDs->childs) == 1){
                    $shopTableHashtagID = $shopTableHashtagIDs->childs[0]->id;
                }else{
                    $shopTableHashtagID = 0;
                    if ($hashtagType > 0) {
                        $modelHashtag = new Model_Shop_Table_Hashtag();
                        $modelHashtag->setDBDriver($driver);
                        $modelHashtag->setShopTableCatalogID($hashtagType);
                        $modelHashtag->setName($name);
                        $modelHashtag->setTableID(Model_Shop_Good::TABLE_ID);
                        $modelHashtag->setIsTranslatesCurrentLanguage(TRUE, $sitePageData->dataLanguageID, $sitePageData->shop->getLanguageIDsArray());

                        $modelHashtag->setNameURL(Helpers_URL::getNameURL($modelHashtag));
                        try {
                            $file = new Model_File($sitePageData);
                            $file->addImageURLInModel($urlImage, $modelHashtag, $sitePageData, $driver);
                        } catch (Exception $e) {
                        }
                        $shopTableHashtagID = Helpers_DB::saveDBObject($modelHashtag, $sitePageData);
                        $modelHashtag->globalID = 0;
                        $modelHashtag->dbSave(Model_Language::LANGUAGE_RUSSIAN, $sitePageData->userID, $sitePageData->shopID);
                    }
                }
                $model->addShopTableHashtagID($shopTableHashtagID);
            }
        }

        // Другие аксессуары
        preg_match_all('/<div class="elementStandard elementTable">([\s\S]+)<\/table>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[0]) > 0)){
            $tmp = trim($result[0][0]);

            preg_match_all('/<tr>[\s]+<td>([\s\S]+)<\/td>[\s]+<td>([\s\S]+)<\/td>[\s]+<\/tr>/U', $tmp, $result);
            if ((is_array($result)) && (count($result) == 3) && (count($result[1]) > 0)){

                $arr = Arr::path($model->getOptionsArray(), 'accessories', array());

                $accessories = array();
                foreach ($arr as $child){
                    $accessories[Arr::path($child, 'name', '')] = $child;
                }
                for ($i = 0; $i < count($result[1]); $i++){
                    $field = trim($result[1][$i]);
                    $value = trim($result[2][$i]);

                    if($isReplace || (!key_exists($field, $accessories))){
                        $accessories[$field] = array(
                            'is_public' => TRUE,
                            'name' => $field,
                            'title' => $value,
                        );
                    }
                }
                $model->addOptionsArray(array('accessories' => $accessories));
            }
        }

        $n = strpos($data, '<h2 class="entry">Technical Data</h2>');
        if($n !== FALSE){
            $data = substr($data, $n + strlen('<h2 class="entry">Technical Data</h2>'));

            $n = strpos($data, '<div class="row_3">');
            if($n !== FALSE) {
                $data = trim(substr($data, 0, $n));

                preg_match_all('/<div class="(.+)">[\s]+<div class="caption">([\s\S]+)<\/div>[\s]+<div class="value">([\s\S]+)<\/div>[\s]+<\/div>/U', $data, $result);
                if ((is_array($result)) && (count($result) == 4) && (count($result[2]) > 0)){

                    $arr = Arr::path($model->getOptionsArray(), 'table', array());

                    $table = array();
                    foreach ($arr as $child){
                        $table[Arr::path($child, 'name', '')] = $child;
                    }
                    for ($i = 0; $i < count($result[2]); $i++){
                        $field = trim($result[2][$i]);
                        $value = trim($result[3][$i]);

                        if($isReplace || (!key_exists($field, $table))){
                            $table[$field] = array(
                                'is_public' => TRUE,
                                'name' => $field,
                                'title' => $value,
                            );
                        }
                    }
                    $model->addOptionsArray(array('table' => $table));
                }
            }
        }
        $model->setDBDriver($driver);

        if($model->id == 0) {
            $model->setIsTranslatesCurrentLanguage(TRUE, $sitePageData->dataLanguageID, $sitePageData->shop->getLanguageIDsArray());
        }
        $model->setNameURL(Helpers_URL::getNameURL($model));
        Helpers_DB::saveDBObject($model, $sitePageData);
        if($hashtagType > 0) {
            $model->setShopTableHashtagIDsArray(
                Api_Shop_Table_ObjectToObject::saveToHashtags(
                    Model_Shop_Good::TABLE_ID, $model->id, $model->getShopTableCatalogID(),
                    $model->getShopTableHashtagIDsArray(), $hashtagType, $sitePageData, $driver
                )
            );
        }

        if ($isAddRussian) {
            $model->globalID = 0;
            $model->dbSave(Model_Language::LANGUAGE_RUSSIAN, $sitePageData->userID, $sitePageData->shopID);
        }

        return TRUE;
    }

}
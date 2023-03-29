<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Загружаем данные о товаре с сайта https://nzeta.ru
 * Поиск товаров: https://nzeta.ru/catalog/?q=#Данные запроса#
 * Class Drivers_ParserSite_NzetaRU
 */
class Drivers_ParserSite_NzetaRU extends Drivers_ParserSite_Basic
{
    // URL поиска товаров
    const URL_FIND = 'https://nzeta.ru/catalog/?q=#QUERY#';

    /**
     * Загружаем данные о об одном товаре
     * @param $url
     * @param Model_Shop_Good $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     */
    public static function loadOneInObject($url, Model_Shop_Good $model, SitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        if(!Func::_empty($model->getOldID())){
            return FALSE;
        }

        $article = $model->getArticle();
        $model->setOldID($article);

        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        // основные характеристики
        $goodOptions = array();
        preg_match_all('/<table class="table table-bordered table" id="products">([\s\S]+)<\/table>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $table = trim($result[1][0]);

            // считываем заголовки
            preg_match_all('/<thead>([\s\S]+)<\/thead>/U', $table, $result);
            if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
                $heads = array();

                $head = trim($result[1][0]);
                preg_match_all('/<tr>([\s\S]+)<\/tr>/U', $head, $result);
                if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
                    // считываем вторую строчку, если она есть
                    $two = array();
                    if (count($result[1]) > 1){
                        preg_match_all('/<td class="text-center"\s+>([\s\S]+)<\/td>/U', $result[1][1], $resultTwo);
                        if ((is_array($resultTwo)) && (count($resultTwo) == 2) && (count($resultTwo[1]) > 0)){
                            $two = $resultTwo[1];
                        }
                    }

                    // заголовки столбцов
                    preg_match_all('/<td class="text-center"\s+((rowspan|colspan)="(.+)"\s+)*>([\s\S]+)<\/td>/U', $result[1][0], $result);
                    if ((is_array($result)) && (count($result) == 5) && (count($result[2]) > 0)){
                        $shiftTwo = 0;
                        for($i = 0; $i < count($result[2]); $i++){
                            $s = trim($result[2][$i]);
                            if(($s == 'rowspan') || ($s == '')){
                                $heads[] = trim($result[4][$i]);
                            }elseif($s == 'colspan'){
                                for($j = 0; $j < $result[3][$i]; $j++) {
                                    $heads[] = trim($result[4][$i]) . ' (' . trim($two[$shiftTwo]) . ')';
                                    $shiftTwo++;
                                }
                            }
                        }
                    }

                    // собираем данные товаров
                    if(count($heads) > 0) {
                        preg_match_all('/<tbody>([\s\S]+)<\/tbody>/U', $table, $result);
                        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)) {
                            $body = trim($result[1][0]);
                            preg_match_all('/<tr itemprop="itemListElement" itemscope="" itemtype="http:\/\/schema.org\/Product">([\s\S]+)<\/tr>/U', $body, $result);
                            if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)) {
                                for($i = 0; $i < count($result[1]); $i++){
                                    preg_match_all('/<td class=".*">([\s\S]+)<\/td>/U', $result[1][$i], $resultTr);
                                    if ((is_array($resultTr)) && (count($resultTr) == 2) && (count($resultTr[1]) == count($heads))) {
                                        $options = array();
                                        for($j = 0; $j < count($resultTr[1]); $j++){
                                            $value = trim(Func::trimTextNew($resultTr[1][$j]));
                                            while(strpos($value, '  ') !== FALSE){
                                                $value = str_replace('  ', ' ', $value);
                                            }

                                            $options[$heads[$j]] = $value;
                                        }
                                        if (key_exists('Артикул', $options)){
                                            $options['Артикул'] = trim(str_replace('Артикул', '', $options['Артикул']));
                                            $goodOptions[$options['Артикул']] = $options;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if(key_exists($article, $goodOptions)){
            $model->addOptionsArray($goodOptions[$article]);
            unset($goodOptions[$article]);
        }

        // описание
        preg_match_all('/<div class="col-md-7 ">([\s\S]+)<\/div>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $text = trim($result[1][0]);
            $text = self::processingText($text, $model, $sitePageData, $driver);

            if ((!empty($text)) && ($isReplace || (Func::_empty($model->getText())))) {
                $model->setText($text);
            }
        }

        // характеристики
        preg_match_all('/<table class="table">([\s\S]+)<\/table>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            $params = trim($result[1][0]);
            preg_match_all('/<td>([\s\S]+)<\/td>\s+<td>([\s\S]+)<\/td>/U', $params, $result);
            if ((is_array($result)) && (count($result) == 3) && (count($result[1]) > 0)){
                $options = array();
                for($i = 0; $i < count($result[1]); $i++){
                    $field = trim(
                        str_replace('&nbsp', ' ',
                            str_replace('  :', '',
                                Func::trimTextNew($result[1][$i])
                            )
                        )
                    );
                    $value = trim($result[2][$i]);
                    $options[$field] = $value;
                }
                $model->addOptionsArray($options);
            }
        }

        // картинки
        preg_match_all('/<a class="fancybox" href="(.+)"/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
           if ($isReplace || (Func::_empty($model->getImagePath()))) {
               foreach ($result[1] as $urlImage) {
                   $urlImage = 'https://nzeta.ru'.trim($urlImage);
                   $ext = strtolower(pathinfo($urlImage, PATHINFO_EXTENSION));
                   if(($ext != 'png') && ($ext != 'jpg') && ($ext != 'PNG') && ($ext != 'JPG')){
                       continue;
                   }

                   try {
                       $file = new Model_File($sitePageData);
                       $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver);
                   } catch (Exception $e) {
                   }
               }

               preg_match_all('/<div class="drag_canvas d-none d-md-block" id="drag_canvas" style="position:relative;">\s+<img class="" src="(.+)"/U', $data, $result);
               if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
                   $ext = strtolower(pathinfo($urlImage, PATHINFO_EXTENSION));
                   if(($ext == 'png') || ($ext == 'jpg')){
                       $urlImage = 'https://nzeta.ru'.trim($result[1][0]);
                       try {
                           $file = new Model_File($sitePageData);
                           $file->addImageURLInModel($urlImage, $model, $sitePageData, $driver, FALSE);
                       }catch (Exception $e){}
                   }
               }

           }
        }

        // изменяем данные у дополнительных товарах
        $type = $model->getShopTableCatalogID();
        $shopID = $model->shopID;

        $modelChild = new Model_Shop_Good();
        $modelChild->setDBDriver($driver);
        foreach ($goodOptions as $article => $options){
            $params = Request_RequestParams::setParams(
                array(
                    'article' => $article,
                    'type' => $type,
                )
            );
            $goodIDs = Request_Request::find('DB_Shop_Good',$shopID, $sitePageData, $driver, $params, 1, TRUE);
            if(count($goodIDs->childs) > 0){
                $goodIDs->childs[0]->setModel($modelChild);

                if(!Func::_empty($modelChild->getOldID())){
                    continue;
                }
                $modelChild->setOldID($article);
                $modelChild->addOptionsArray($model->getOptionsArray());

                if ($isReplace || (Func::_empty($modelChild->getImagePath()))) {
                    $modelChild->setImagePath($model->getImagePath());
                    $modelChild->setFiles($model->getFiles());
                }

                if ($isReplace || (Func::_empty($modelChild->getText()))) {
                    $modelChild->setText($model->getText());
                }

                Helpers_DB::saveDBObject($modelChild, $sitePageData);
            }

        }

        return TRUE;
    }


    /**
     * Загружаем данные о об одном товаре
     * @param $article
     * @param Model_Shop_Good $model
     * @param sitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     */
    public static function findOneInObject($article, Model_Shop_Good $model, sitePageData $sitePageData,
                                           Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        if (empty($article)){
            return FALSE;
        }

        if(!Func::_empty($model->getOldID())){
            return FALSE;
        }

        $data = Helpers_URL::getDataURLEmulationBrowser(str_replace('#QUERY#', urlencode(str_replace(' ', '', $article)), self::URL_FIND));

        preg_match_all('/<td class="name"><a href="(.+)">/U', $data, $result);
        if ((!is_array($result)) || (count($result) != 2) || (count($result[1]) < 1)){
            return TRUE;
        }

        $url = 'https://nzeta.ru'.trim($result[1][0]);
        if (!empty($url)) {
            $result = self::loadOneInObject($url, $model, $sitePageData, $driver, $isReplace);
        }else{
            $result = TRUE;
        }

        return $result;
    }


    /**
     * Загружаем данные о об одном товаре
     * @param $article
     * @param $id
     * @param $shopID
     * @param Model_Shop_Good $model
     * @param sitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     * @throws HTTP_Exception_404
     */
    public static function findOne($article, $id, $shopID, Model_Shop_Good $model, sitePageData $sitePageData,
                                   Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        $model->setDBDriver($driver);
        if (!Helpers_DB::getDBObject($model, $id, $sitePageData, $shopID)){
            throw new HTTP_Exception_404('Goods not is found!');
        }

        if (empty($article)){
            $article = $model->getArticle();
        }

        if(mb_strlen($article) < 5){
            return FALSE;
        }

        return self::findOneInObject($article, $model, $sitePageData, $driver, $isReplace);
    }

}
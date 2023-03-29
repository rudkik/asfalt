<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_TechodomKZ
{
    /**
     * Загружаем данные о об одном товаре
     * @param $url
     * @param $shopTableCatalogID
     * @param Model_AutoPart_Shop_Product $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     * @return bool
     */
    public static function loadProduct($url, Model_AutoPart_Shop_Product $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        $data = Helpers_URL::getDataURLEmulationBrowser($url);


        // Цена
        preg_match_all('/<span class="sum" data-price="(.+)">/U', $data, $result);
        if (is_array($result) && count($result) == 2 && count($result[1]) > 0 ) {
            $model->setPrice(floatval($result[1][0]));
        }


        // Название товара
        preg_match_all('/<h1 class="product-container-title">(.+)<\/h1>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2)) {
                $model->setName($result[1][0]);
        }



        // Характеристики
        preg_match_all('/<tr>[\s\S]+<td>[\s\S]+(.+?)[\s\S]+<\/td>[\s\S]+<td>[\s]+(.+?)[\s]+<\/td>/U', $data, $result);

        if (count($result[1]) == count($result[2])) {
            $options = [];
            for ($i = 0; $i < count($result[1]); $i++) {
                $options[trim($result[1][$i])] = strip_tags($result[2][$i]);
            }

            $model->addOptionsArray($options);
        }
        echo '<pre>';
        print_r($model->getValues(true, true));
        die();


    }


}
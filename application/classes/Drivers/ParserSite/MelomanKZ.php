<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_MelomanKZ
{
    /**
     * Загружаем данные о об одном товаре
     * @param $url
     * @param Model_AutoPart_Shop_Product $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isReplace
     */
    public static function loadProduct($url, Model_AutoPart_Shop_Product $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isReplace = TRUE)
    {
        $data = Helpers_URL::getDataURLEmulationBrowser($url);

        // Цена
        preg_match_all('/<span class="price">(.+)<\/span>/U', $data, $result);
        if (is_array($result) && count($result) == 2 && count($result[1]) > 0 ) {
            $model->setPrice(str_replace('%C2%A0', '',
                str_replace('₸', '', urlencode($result[1][0]))
                        )
            );
        }


        // Название товара
        preg_match_all('/<span class="base" data-ui-id="page-title-wrapper" >(.+)<\/span>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2)) {
                $model->setName($result[1][0]);
        }

        // Описание товара
        preg_match_all('/<strong class="type">Описание<\/strong>  <div class="value" ><p>(.+)<\/p><\/div>/U', $data, $result);
        if (!empty($result[1])){
                $model->setText(strip_tags($result[1][0]));
        }

        // Характеристики + Артикул
        preg_match_all('/<td class="col data" data-th="(.+)">(.+)<\/td>/U', $data, $result);
        if (count($result[1]) == count($result[2])) {
            $options = [];
            for ($i = 0; $i < count($result[1]); $i++) {
                $options[$result[1][$i]] = strip_tags(trim($result[2][$i]));
                if ($result[1][$i] == 'Артикул'){
                    $model->setArticle($result[2][$i]);
                }
            }
            $model->addOptionsArray($options);
        }

        // Картинки
        preg_match_all('/"img":"(.+)"/U', $data, $result);
        if (count($result) == 2) {
            if (Func::_empty($model->getImagePath())) {
                foreach ($result[1] as $href) {
                    try {
                        $file = new Model_File($sitePageData);
                        $file->addImageURLInModel(str_replace('\\', '', $href), $model, $sitePageData, $driver);
                    } catch (Exception $e) {
                    }
                }
            }
        }

        // Статус
        preg_match_all('/<div class="stock available" title="Доступность"><svg><use xmlns:xlink=".+" xlink:href=".+"><\/use><\/svg> <span>(.+)<\/span>/U', $data, $result);
        if ((is_array($result)) && (count($result) == 2)) {
          $status = $result[1][0];
        }

    }


}
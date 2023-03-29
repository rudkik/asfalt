<?php defined('SYSPATH') or die('No direct script access.');

class Drivers_ParserSite_Basic
{
    /**
     * Загрузка картинок из текста
     * @param $text
     * @param Model_Basic_Files $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param string $urlBasic
     * @return mixed
     */
    public static function parserImageText($text, Model_Basic_Files $model, SitePageData $sitePageData,
                                            Model_Driver_DBBasicDriver $driver, $urlBasic = ''){
        preg_match_all('/<img[\s\S]+src="(.+)"[\s\S]*\/>/U', $text, $result);
        if ((is_array($result)) && (count($result) == 2) && (count($result[1]) > 0)){
            for ($i = 0; $i < count($result[1]); $i++){
                $urlImage = str_replace(' ', '%20', $urlBasic. trim($result[1][$i]));
                try {
                    $file = new Model_File($sitePageData);
                    $urlImage = $file->addImageURLInModel($urlImage, $model,  $sitePageData, $driver,
                        FALSE, FALSE);
                    $text = str_replace($result[1][$i], $urlImage, $text);
                } catch (Exception $e) {
                    $text = str_replace($result[0][$i], '', $text);
                }
            }
        }

        return $text;
    }

    /**
     * Замена ссылок на жирность
     * @param $text
     * @return mixed
     */
    public static function replaceURLByStrong($text){
        $text = preg_replace('/<a href="(.+)">(.+)<\/a>/U', '<strong>${2}</strong>', $text);
        $text = preg_replace('/<a>(.+)<\/a>/U', '<strong>${2}</strong>', $text);

        return $text;
    }

    /**
     * Обработка текста
     * @param $text
     * @param Model_Basic_Files $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return mixed
     */
    public static function processingText($text, Model_Basic_Files $model, SitePageData $sitePageData,
                                          Model_Driver_DBBasicDriver $driver, $urlBasic = ''){
        // ссылки заменяем на выделения
        $text = self::replaceURLByStrong($text);
        $text = self::parserImageText($text, $model, $sitePageData, $driver);

        $text = str_replace('<p><br/></p>', '',
            str_replace('<p>&nbsp;</p>', '', $text));

        return $text;
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_Address {
    /**
     * Получаем адрес ввиде строки взависимости от языка
     * @param SitePageData $sitePageData
     * @param array $values
     * @param string $break
     * @param bool $isCity
     * @param bool $isLand
     * @return string
     */
    public static function getAddressStr(SitePageData $sitePageData, array &$values, $break = ', ', $isCity = TRUE,
                                         $isLand = FALSE){
        switch ($sitePageData->dataLanguageID){
            case Model_Language::LANGUAGE_RUSSIAN:
                $result = self::getAddressStrRus($values, $break, $isCity, $isLand);
                break;
            case Model_Language::LANGUAGE_KAZAKH:
                $result = self::getAddressStrKaz($values, $break, $isCity, $isLand);
                break;
            case Model_Language::LANGUAGE_ENGLISH:
                $result = self::getAddressStrEn($values, $break, $isCity, $isLand);
                break;
            case Model_Language::LANGUAGE_ARABIC:
                $result = self::getAddressStrAE($values, $break, $isCity, $isLand);
                break;
            default:
                $result = self::getAddressStrEn($values, $break, $isCity, $isLand);
        }

        return $result;
    }

    /**
     * Получаем адрес ввиде строки на казахстком языек
     * @param array $values
     * @param string $break
     * @param bool $isCity
     * @param bool $isLand
     * @return string
     */
    public static function getAddressStrKaz(array &$values, $break = ', ', $isCity = TRUE, $isLand = FALSE){
        if(empty($break)){
            $break = ', ';
        }
        $result = '';
        if($isLand === TRUE) {

            $tmp = Arr::path($values, '$elements$.land_id.name', '');
            if (!empty($tmp)) {
                $result = $result . $tmp . $break;
            }
        }

        if($isCity === TRUE) {
            $tmp = Arr::path($values, '$elements$.city_id.name', '');
            if (!empty($tmp)) {
                $result = $result . $tmp . ' қаласы' . $break;
            }
        }

        $street = Arr::path($values, 'street', '');
        if (!empty($street)){
            $result = $result.$street;
        }

        $tmp = Arr::path($values, 'house', '');
        if (!empty($tmp)){
            $result = $result.', '.$tmp.' үй' ;

            $tmp = Arr::path($values, 'office', '');
            if (!empty($tmp)){
                $result = $result.', '.$tmp.' кеңсе' ;
            }
        }
        if (!empty($street)){
            $result = $result . $break;
        }

        $tmp = Arr::path($values, 'street_conv', '');
        if (!empty($tmp)){
            $result = $result.' '.$tmp.$break ;
        }

        $tmp = Arr::path($values, 'comment', '');
        if (!empty($tmp)){
            $result = $result.' '.str_replace('\n', '<br>', str_replace('\r\n', '<br>', $tmp)).$break ;
        }

        return trim(mb_substr($result, 0, mb_strlen($result) - mb_strlen($break)));
    }

    /**
     * Получаем адрес ввиде строки на русском языке
     * @param array $values
     * @param string $break
     * @param bool $isCity
     * @param bool $isLand
     * @return string
     */
    public static function getAddressStrRus(array &$values, $break = ', ', $isCity = TRUE, $isLand = FALSE){
        if(empty($break)){
            $break = ', ';
        }
        $result = '';
        if($isLand === TRUE) {

            $tmp = Arr::path($values, '$elements$.land_id.name', '');
            if (!empty($tmp)) {
                $result = $result . $tmp . $break;
            }
        }

        if($isCity === TRUE) {
            $tmp = Arr::path($values, '$elements$.city_id.name', '');
            if (!empty($tmp)) {
                $result = $result . 'г. ' . $tmp . $break;
            }
        }

        $street = Arr::path($values, 'street', '');
        if (!empty($street)){
            $result = $result.$street;
        }

        $tmp = Arr::path($values, 'house', '');
        if (!empty($tmp)){
            $result = $result.', '.'д. '.$tmp ;

            $tmp = Arr::path($values, 'office', '');
            if (!empty($tmp)){
                $result = $result.', '.'офис '.$tmp ;
            }
        }
        if (!empty($street)){
            $result = $result . $break;
        }

        $tmp = Arr::path($values, 'street_conv', '');
        if (!empty($tmp)){
            $result = $result.' '.$tmp.$break ;
        }

        $tmp = Arr::path($values, 'comment', '');
        if (!empty($tmp)){
            $result = $result.' '.str_replace('\n', '<br>', str_replace('\r\n', '<br>', $tmp)).$break ;
        }

        return trim(mb_substr($result, 0, mb_strlen($result) - mb_strlen($break)));
    }

    /**
     * Получаем адрес ввиде строки на английском языке
     * @param array $values
     * @param string $break
     * @param bool $isCity
     * @param bool $isLand
     * @return string
     */
    public static function getAddressStrEn(array &$values, $break = ', ', $isCity = TRUE, $isLand = FALSE){
        if(empty($break)){
            $break = ', ';
        }
        $result = '';
        if($isLand === TRUE) {

            $tmp = Arr::path($values, '$elements$.land_id.name', '');
            if (!empty($tmp)) {
                $result = $result . $tmp . $break;
            }
        }

        if($isCity === TRUE) {
            $tmp = Arr::path($values, '$elements$.city_id.name', '');
            if (!empty($tmp)) {
                $result = $result . $tmp . ' city' . $break;
            }
        }

        $street = Arr::path($values, 'street', '');
        if (!empty($street)){
            $result = $result.$street;
        }

        $tmp = Arr::path($values, 'house', '');
        if (!empty($tmp)){
            $result = $result.', '.'house '.$tmp ;

            $tmp = Arr::path($values, 'office', '');
            if (!empty($tmp)){
                $result = $result.', '.$tmp ;
            }
        }
        if (!empty($street)){
            $result = $result . $break;
        }

        $tmp = Arr::path($values, 'street_conv', '');
        if (!empty($tmp)){
            $result = $result.' '.$tmp.$break ;
        }

        $tmp = Arr::path($values, 'comment', '');
        if (!empty($tmp)){
            $result = $result.' '.str_replace('\n', '<br>', str_replace('\r\n', '<br>', $tmp)).$break ;
        }

        return trim(mb_substr($result, 0, mb_strlen($result) - mb_strlen($break)));
    }


    /**
     * Получаем адрес ввиде строки на арабском языке
     * @param array $values
     * @param string $break
     * @param bool $isCity
     * @param bool $isLand
     * @return string
     */
    public static function getAddressStrAE(array &$values, $break = ', ', $isCity = TRUE, $isLand = FALSE){
        if(empty($break)){
            $break = ', ';
        }
        $result = '';
        if($isLand === TRUE) {

            $tmp = Arr::path($values, '$elements$.land_id.name', '');
            if (!empty($tmp)) {
                $result = $result . $tmp . $break;
            }
        }

        if($isCity === TRUE) {
            $tmp = Arr::path($values, '$elements$.city_id.name', '');
            if (!empty($tmp)) {
                $result = $result . $tmp . $break;
            }
        }

        $street = Arr::path($values, 'street', '');
        if (!empty($street)){
            $result = $result.$street;
        }

        $tmp = Arr::path($values, 'house', '');
        if (!empty($tmp)){
            $result = $result.', '.'house '.$tmp ;

            $tmp = Arr::path($values, 'office', '');
            if (!empty($tmp)){
                $result = $result.', '.$tmp ;
            }
        }
        if (!empty($street)){
            $result = $result . $break;
        }

        $tmp = Arr::path($values, 'street_conv', '');
        if (!empty($tmp)){
            $result = $result.' '.$tmp.$break ;
        }

        $tmp = Arr::path($values, 'comment', '');
        if (!empty($tmp)){
            $result = $result.' '.str_replace('\n', '<br>', str_replace('\r\n', '<br>', $tmp)).$break ;
        }

        return trim(mb_substr($result, 0, mb_strlen($result) - mb_strlen($break)));
    }

    /**
     * @param array $address
     * @return string
     */
    public static function getUserAddressName(array $address){
        $result = '';

        $tmp = Arr::path($address, 'street', '');
        if (!empty($tmp)){
            $result = $result.$tmp.', ' ;
        }

        $tmp = Arr::path($address, 'street_corner', '');
        if (!empty($tmp)){
            $result = $result.$tmp.', ' ;
        }

        $tmp = Arr::path($address, 'house', '');
        if (!empty($tmp)){
            $result = $result.'д.'.$tmp.', ' ;
        }

        $tmp = Arr::path($address, 'apartment', '');
        if (!empty($tmp)){
            $result = $result.'кв.'.$tmp.', ' ;
        }

        $tmp = Arr::path($address, 'floor', '');
        if (!empty($tmp)){
            $result = $result.'этаж '.$tmp.', ' ;
        }

        $tmp = Arr::path($address, 'front_door', '');
        if (!empty($tmp)){
            $result = $result.'подъезд '.$tmp.', ' ;
        }

        return mb_substr($result, 0, strlen($result) - 2);
    }

}
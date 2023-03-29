<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_Yandex {
    /**
     * Получаем координаты из строки Yandex карты
     * https://yandex.kz/maps/
     * @param $url
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function getYandexMapsCoordinates($url)
    {
        if(empty($url)){
            return [];
        }

        $url = parse_url($url);
        $query = [];
        parse_str($url['query'], $query);
        if(!key_exists('rtext', $query)){
            throw new HTTP_Exception_500('URL param "rtext" not found.');
        }

        $query = explode('~', $query['rtext']);

        $result = [];
        foreach ($query as $str) {
            $coordinates = explode(',', $str);
            if (count($coordinates) != 2) {
                continue;
            }

            $result[] = $coordinates;
        }

        return $result;
    }
}
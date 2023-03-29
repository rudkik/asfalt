<?php defined('SYSPATH') or die('No direct script access.');

class Api_Ab1_Basic
{
    /**
     * Получаем дату загрузки баланса из 1С, после этой даты пересчитывать баланс из АСВЫ
     * @return string
     */
    public static function getDateFromBalance1С()
    {
        return '2020-01-01 06:00:00';

        $options = DOCROOT . '1S'.DIRECTORY_SEPARATOR.'v1S'.DIRECTORY_SEPARATOR.'time.php';
        if(file_exists($options)) {
            $times = include $options;
        }else{
            $times = array();
        }

        return Arr::path($times, 'savecars', date('Y-m-d').' 06:00:00');
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_DateTime {
    /**
     * Переводим секунды в формат  0 д 00 ч 00 м 00 с
     * @param int $seconds
     * @return string
     */
    public static function secondToTime($seconds)
    {
        $seconds = intval($seconds);

        $result = '';
        $days = floor($seconds / 86400);
        $seconds = $seconds % 86400;
        if($days > 0){
            $result = $days . ' д ';
        }

        $hours = floor($seconds / 3600);
        $seconds = $seconds % 3600;
        if($days > 0 || $hours > 0){
            $result .= Func::addBeginSymbol($hours, '0', 2) . ' ч ';
        }

        $minutes = floor($seconds / 60);
        if($days > 0 || $hours > 0 || $minutes > 0){
            $result .= Func::addBeginSymbol($minutes, '0', 2) . ' м ';
        }

        $seconds = $seconds % 60;
        if($days > 0 || $hours > 0 || $minutes > 0 || $seconds > 0){
            $result .= Func::addBeginSymbol($seconds, '0', 2) . ' с';
            $result = ltrim($result, 0);
        }else{
            $result .= '0 с';
        }

        return trim($result);

    }

    /**
     * Возвращаем наибольшую дату
     * @param $date1
     * @param $date2
     * @return mixed
     */
    public static function moreDates($date1, $date2){
        if(empty($date1)){
            return $date2;
        }
        if(empty($date2)){
            return $date1;
        }

        if(strtotime($date1) > strtotime($date2)){
            return $date1;
        }
        return $date2;
    }

    /**
     * Меняем день в дате
     * @param $date
     * @param $day
     * @return false|int|string
     */
    public static function changeDateDay($date, $day){
        $date = strtotime($date);

        $day = intval($day);
        $month = floatval(date('m', $date));
        switch ($month){
            case 2:
                if(($day > 28)){
                    if(date('Y', $date) % 4 == 0){
                        $day = 28;
                    }elseif ($day > 29){
                        $day = 29;
                    }
                }
                break;
            case 4:
            case 6:
            case 9:
            case 11:
                if($day > 30){
                    $day = 30;
                }
                break;
            default:
                if($day > 31){
                    $day = 31;
                }
        }
        if(strlen($day) == 1){
            $day = '0'.$day;
        }

        return date('Y-m-'.$day, $date);
    }

    /**
     * Меняем год в дате
     * @param $date
     * @param $year
     * @return false|int|string
     */
    public static function changeDateYear($date, $year){
        $date = strtotime($date);
        if((date('d', $date) == 29) && (floatval(date('m', $date)) == 2) && ($year % 4 == 0) && (date('Y', $date) % 4 != 0)){
            $date = $year.'-02-28';
        }else{
            $date = date($year.'-m-d', $date);
        }

        return $date;
    }

    /**
     * Отнимаем от даты несколько минут
     * @param $date
     * @param $minutes
     * @return false|int|string
     */
    public static function minusMinutes($date, $minutes){
        $date = strtotime($date.' -'.$minutes.' minutes');
        if (!empty($date)){
            $date = date('Y-m-d H:i:s', $date);
        }
        return $date;
    }

    /**
     * Отнимаем от даты несколько секунд
     * @param $date
     * @param $seconds
     * @return false|int|string
     */
    public static function minusSeconds($date, $seconds){
        $date = strtotime($date.' -'.$seconds.' seconds');
        if (!empty($date)){
            $date = date('Y-m-d H:i:s', $date);
        }
        return $date;
    }

    /**
     * Отнимаем от даты несколько месяцев
     * @param $date
     * @param $months
     * @param boolean $isNatural
     * @return false|int|string
     */
    public static function minusMonth($date, $months, $isNatural = false){
        if (empty(strtotime($date))){
            return '';
        }

        if($isNatural) {
            $date = strtotime($date);
            $d = date('j', $date);  // день
            $m = date('n', $date);  // месяц
            $y = date('Y', $date);  // год
            $h = date('G', $date);  // час
            $minute = intval(date('i', $date));  // минута
            $s = intval(date('s', $date));  // секунда

            // Прибавить месяц(ы)
            $m -= $months;
            if ($m < -12) {
                $y += floor($m / 12);
                $m = ($m % 12);
                // Дополнительная проверка на декабрь
                if (!$m) {
                    $m = 12;
                    $y++;
                }
            }
            if($m < 1) {
                $m = 12 + $m;
            }

            // Это последний день месяца?
            if ($d == date('t', $date)) {
                $d = 31;
            }

            // Открутить дату, пока она не станет корректной
            while (true) {
                if (checkdate($m, $d, $y)) {
                    break;
                }
                $d--;

                if($d < 1){
                    return '';
                }
            }
            // Вернуть новую дату в TIMESTAMP
            return date('Y-m-d H:i:s', mktime($h, $minute, $s, $m, $d, $y));
        }

        $date = strtotime($date . ' -'.$months.' months');
        if (!empty($date)){
            $date = date('Y-m-d H:i:s', $date);
        }
        return $date;
    }

    /**
     * Прибавляет к дате несколько месяцев
     * @param $date
     * @param $months
     * @param boolean $isNatural
     * @return false|int|string
     */
    public static function plusMonth($date, $months, $isNatural = false){
        if (empty(strtotime($date))){
            return '';
        }

        if($isNatural) {
            $date = strtotime($date);
            $d = date('j', $date);  // день
            $m = date('n', $date);  // месяц
            $y = date('Y', $date);  // год
            $h = date('G', $date);  // час
            $minute = intval(date('i', $date));  // минута
            $s = intval(date('s', $date));  // секунда

            // Прибавить месяц(ы)
            $m += $months;
            if ($m > 12) {
                $y += floor($m / 12);
                $m = ($m % 12);
                // Дополнительная проверка на декабрь
                if (!$m) {
                    $m = 12;
                    $y--;
                }
            }

            // Это последний день месяца?
            if ($d == date('t', $date)) {
                $d = 31;
            }
            // Открутить дату, пока она не станет корректной
            while (true) {
                if (checkdate($m, $d, $y)) {
                    break;
                }
                $d--;
            }
            // Вернуть новую дату в TIMESTAMP
            return date('Y-m-d H:i:s', mktime($h, $minute, $s, $m, $d, $y));
        }
        $date = strtotime($date.' '.$months.' months');
        if (!empty($date)){
            $date = date('Y-m-d H:i:s', $date);
        }
        return $date;
    }

    /**
     * Отнимаем от даты несколько дней
     * @param $date
     * @param $days
     * @return false|int|string
     */
    public static function minusDays($date, $days){
        $date = strtotime($date.' -'.$days.' days');
        if (!empty($date)){
            $date = date('Y-m-d H:i:s', $date);
        }
        return $date;
    }

    /**
     * Прибавляет к дате несколько минут
     * @param $date
     * @param $minutes
     * @return false|int|string
     */
    public static function plusMinutes($date, $minutes){
        $date = strtotime($date.' '.$minutes.' minutes');
        if (!empty($date)){
            $date = date('Y-m-d H:i:s', $date);
        }
        return $date;
    }

    /**
     * Прибавляет к дате несколько дней
     * @param $date
     * @param $days
     * @return false|int|string
     */
    public static function plusDays($date, $days){
        $date = strtotime($date.' '.$days.' days');
        if (!empty($date)){
            $date = date('Y-m-d H:i:s', $date);
        }
        return $date;
    }

    /**
     * Прибавляет к дате несколько часов
     * @param $date
     * @param $hours
     * @return false|int|string
     */
    public static function plusHours($date, $hours){
        $date = strtotime($date.' '.$hours.' hours');
        if (!empty($date)){
            $date = date('Y-m-d H:i:s', $date);
        }
        return $date;
    }

    /**
     * Переводим в формат 11.12.2039 в 09:09
     * @param $date
     * @param bool $isTime
     * @return string
     */
    public static function getDateTimeFormatRusWithTime($date, $isTime = FALSE){
        if ($isTime){
            return strftime('%d.%m.%Y в %H:%M', strtotime($date));
        }else{
            return self::getDateFormatRus($date);
        }
    }

    /**
     * Переводим в формат 3 сен
     * @param string $date в формате даты 2015-09-03
     * @return string
     */
    public static function getDateTimeShortFormatRusMonthStr($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            $month = '';
            switch (strftime('%m', $tmp)) {
                case '01': $month = 'янв'; break;
                case '02': $month = 'фев'; break;
                case '03': $month = 'мар'; break;
                case '04': $month = 'апр'; break;
                case '05': $month = 'мая'; break;
                case '06': $month = 'июн'; break;
                case '07': $month = 'июл'; break;
                case '08': $month = 'авг'; break;
                case '09': $month = 'сен'; break;
                case '10': $month = 'окт'; break;
                case '11': $month = 'ноя'; break;
                case '12': $month = 'дек'; break;
            }

            $day = strftime('%d', $tmp);
            if ($day[0] == '0'){
                $day = substr($day, 1);
            }
            return $day.' '.$month;
        }else{
            return '';
        }
    }

    /**
     * Месяц по русски
     * @param $month
     * @param $suffix
     * @return string
     */
    public static function getMonthRusStr($month, $suffix = TRUE)
    {
        switch ($month) {
            case '01':
            case '1':
                $result = 'январ' . ($suffix ? 'я' : 'ь');
                break;
            case '02':
            case '2':
                $result = 'феврал' . ($suffix ? 'я' : 'ь');
                break;
            case '03':
            case '3':
                $result = 'март' . ($suffix ? 'а' : '');
                break;
            case '04':
            case '4':
                $result = 'апрел' . ($suffix ? 'я' : 'ь');
                break;
            case '05':
            case '5':
                $result = 'ма' . ($suffix ? 'я' : 'й');
                break;
            case '06':
            case '6':
                $result = 'июн' . ($suffix ? 'я' : 'ь');
                break;
            case '07':
            case '7':
                $result = 'июл' . ($suffix ? 'я' : 'ь');
                break;
            case '08':
            case '8':
                $result = 'август' . ($suffix ? 'а' : '');
                break;
            case '09':
            case '9':
                $result = 'сентябр' . ($suffix ? 'я' : 'ь');
                break;
            case '10':
                $result = 'октябр' . ($suffix ? 'я' : 'ь');
                break;
            case '11':
                $result = 'ноябр' . ($suffix ? 'я' : 'ь');
                break;
            case '12':
                $result = 'декабр' . ($suffix ? 'я' : 'ь');
                break;
            default:
                $result = '';
        }

        return $result;
    }




     /**
     * Переводим в формат 3 сентября 2015 г.
     * @param string $date в формате даты 2015-09-03
     * @param bool $isYear
     * @return string
     */
    public static function getDateTimeFormatRusMonthStr($date, $isYear = TRUE){
        $tmp = strtotime($date);
        if ($tmp > 0){

            $month = self::getMonthRusStr(strftime('%m', $tmp));
            $day = strftime('%d', $tmp);
            if ($day[0] == '0'){
                $day = substr($day, 1);
            }
            if ($isYear){
                return $day . ' ' . $month . ' ' . strftime('%Y', $tmp) . ' г.';

            }else {
                return $day . ' ' . $month;
            }
        }else{
            return '';
        }
    }

    /**
     * Переводим в формат сентября 2015 г
     * @param string $date в формате даты 2015-09-03
     * @return string
     */
    public static function getDateMonthAndYearRus($date){
        $tmp = strtotime($date);
        if ($tmp > 0) {
            return self::getMonthRusStr(strftime('%m', $tmp)) . ' ' . strftime('%Y', $tmp) . ' г';
        }else{
            return '';
        }
    }

    /**
     * Возвращаем часы и минуты из даты в формате 23:00
     * @param string $date в формате даты 2015-09-03 23:00:05
     * @return string
     */
    public static function getTimeByDate($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            return strftime('%H:%M', $tmp);
        }
        return '';
    }

    /**
     * Возвращаем год
     * @param string $date в формате даты 2015-09-03
     * @return string
     */
    public static function getYear($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            return strftime('%Y', $tmp);
        }
        return '';
    }

    /**
     * Возвращаем период в формате
     * января 2019 г. / 3 января 2019 г. / 3 - 5 января 2019 г. / 3 января - 5 мая 2019 г. / 3 января 2019 г. - 5 мая 2020 г.
     * @param string $dateFrom в формате даты 2015-09-03
     * @param string $dateTo в формате даты 2015-09-03
     * @param boolean $suffix
     * @return string
     */
    public static function getPeriodRus($dateFrom, $dateTo, $suffix = false, $pretext = false){
        $dateFrom = self::getDateFormatPHP($dateFrom);
        $dateTo = self::getDateFormatPHP($dateTo);

        if($dateFrom == $dateTo){
            if ($pretext){
                return 'за ' . Helpers_DateTime::getDateTimeDayMonthRus($dateFrom, TRUE);
            }
            return Helpers_DateTime::getDateTimeDayMonthRus($dateFrom, TRUE);
        }elseif(Helpers_DateTime::getYear($dateFrom) != Helpers_DateTime::getYear($dateTo)){
            if ($pretext){
                return 'с ' . Helpers_DateTime::getDateTimeDayMonthRus($dateFrom, TRUE) . ' по '
                    . Helpers_DateTime::getDateTimeDayMonthRus($dateTo, TRUE) ;
            }
            return Helpers_DateTime::getDateTimeDayMonthRus($dateFrom, TRUE) . ' - '
                . Helpers_DateTime::getDateTimeDayMonthRus($dateTo, TRUE) ;
        }elseif(Helpers_DateTime::getMonth($dateFrom) != Helpers_DateTime::getMonth($dateTo)){
            if ($pretext){
                return 'с ' . Helpers_DateTime::getDateTimeDayMonthRus($dateFrom) . ' по '
                    . Helpers_DateTime::getDateTimeDayMonthRus($dateTo) . ' ' . Helpers_DateTime::getYear($dateFrom).' г.';
            }
            return Helpers_DateTime::getDateTimeDayMonthRus($dateFrom) . ' - '
                . Helpers_DateTime::getDateTimeDayMonthRus($dateTo) . ' ' . Helpers_DateTime::getYear($dateFrom).' г.';
        }elseif(Helpers_DateTime::getDay($dateFrom) == 1
            && $dateTo == Helpers_DateTime::getMonthEndStr(Helpers_DateTime::getMonth($dateTo), Helpers_DateTime::getYear($dateTo))) {
            if ($pretext){
                return 'за ' . Helpers_DateTime::getMonthRusStr(Helpers_DateTime::getMonth($dateFrom), $suffix) . ' ' . Helpers_DateTime::getYear($dateFrom).' г.';
            }
            return Helpers_DateTime::getMonthRusStr(Helpers_DateTime::getMonth($dateFrom), $suffix) . ' ' . Helpers_DateTime::getYear($dateFrom).' г.';
        }else{
            if ($pretext){
                return 'с ' . (Helpers_DateTime::getDay($dateFrom)) . ' по ' . (Helpers_DateTime::getDay($dateTo)) . ' '
                    . Helpers_DateTime::getMonthRusStr(Helpers_DateTime::getMonth($dateFrom)) . ' ' . Helpers_DateTime::getYear($dateFrom).' г.';
            }
            return (Helpers_DateTime::getDay($dateFrom)) . ' - ' . (Helpers_DateTime::getDay($dateTo)) . ' '
                . Helpers_DateTime::getMonthRusStr(Helpers_DateTime::getMonth($dateFrom)) . ' ' . Helpers_DateTime::getYear($dateFrom).' г.';
        }
    }

    /**
     * Возвращаем период в формате
     * 06:00 часов 3 января по 06:00 часов 5 мая 2019 года / 06:00 часов 3 января 2019 года по 06:00 часов 5 мая 2020 года
     * @param string $dateFrom в формате даты 2015-09-03 06:00:00
     * @param string $dateTo в формате даты 2015-09-03 06:00:00
     * @return string
     */
    public static function getPeriodWithTimeRus($dateFrom, $dateTo){
        if(self::getYear($dateFrom) == self::getYear($dateTo)){
            return
                self::getTimeByDate($dateFrom) . ' часов ' . self::getDateTimeDayMonthRus($dateFrom)
                . ' по '
                . self::getTimeByDate($dateTo) . ' часов ' . self::getDateTimeDayMonthRus($dateTo)
                . ' ' . Helpers_DateTime::getYear($dateFrom).' года';
        }

        return
            self::getTimeByDate($dateFrom) . ' часов ' . self::getDateTimeDayMonthRus($dateFrom)
            . ' ' . Helpers_DateTime::getYear($dateFrom).' года'
            . ' по '
            . self::getTimeByDate($dateTo) . ' часов ' . self::getDateTimeDayMonthRus($dateTo)
            . ' ' . Helpers_DateTime::getYear($dateFrom).' года';
    }

    /**
     * Возвращаем номер месяца размеров в два символа
     * @param string $date в формате даты 2015-09-03
     * @return string
     */
    public static function getMonth($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            return strftime('%m', $tmp);
        }
        return '';
    }

    /**
     * Возвращаем минут размеров в два символа
     * @param string $date в формате даты 2015-09-03
     * @return string
     */
    public static function getMinute($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            return strftime('%M', $tmp);
        }
        return '';
    }

    /**
     * Возвращаем час размеров в два символа
     * @param string $date в формате даты 2015-09-03
     * @return string
     */
    public static function getHour($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            return strftime('%H', $tmp);
        }
        return '';
    }

    /**
     * Возвращаем номер дня размеров в два символа
     * @param string $date в формате даты 2015-09-03
     * @return int
     */
    public static function getDay($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            return intval(strftime('%d', $tmp));
        }
        return '';
    }

    /**
     * Переводим в формат ISO-8601 Excel 2004-02-12T15:19:21.000
     * @param string $date в формате даты 2015-09-03
     * @return string
     */
    public static function getDateTimeExcel($date)
    {
        $tmp = strtotime(trim($date));
        if ($tmp > 0){
            return str_replace(' ', 'T', date('Y-m-d H:i:s.000', $tmp));
        }else{
            return '';
        }
    }

    /**
     * Переводим время в формат ISO-8601 Excel 2004-02-12T15:19:21.000
     * @param string $date в формате даты 2015-09-03
     * @return string
     */
    public static function getTimeExcel($date)
    {
        $tmp = strtotime(trim($date));
        if ($tmp > 0){
            return '1899-12-31T' . date('H:i:s.000', $tmp);
        }else{
            return '';
        }
    }

    /**
     * Переводим в формат ISO-8601 Excel 2004-02-12T15:19:21.000
     * @param string $date в формате даты 2015-09-03
     * @return string
     */
    public static function getDateExcel($date)
    {
        $tmp = strtotime(trim($date));
        if ($tmp > 0){
            return str_replace(' ', 'T', date('Y-m-d 00:00:00.000', $tmp));
        }else{
            return '';
        }
    }

    /**
     * Переводим в формат ISO-8601 2004-02-12T15:19:21+00:00
     * @param string $date в формате даты 2015-09-03
     * @return string
     */
    public static function getDateTimeISO8601($date)
    {
        $tmp = strtotime(trim($date));
        if ($tmp > 0){
            return date('c', $tmp);
        }else{
            return '';
        }
    }

    /**
     * Получаем русское название месяца по числу
     * @param string|integer $month
     * @return string
     */
    public static function monthToStrRus($month){
        switch ($month) {
            case '1':
            case '01': $month = 'январь'; break;
            case '2':
            case '02': $month = 'февраль'; break;
            case '3':
            case '03': $month = 'март'; break;
            case '4':
            case '04': $month = 'апрель'; break;
            case '5':
            case '05': $month = 'май'; break;
            case '6':
            case '06': $month = 'июнь'; break;
            case '7':
            case '07': $month = 'июль'; break;
            case '8':
            case '08': $month = 'август'; break;
            case '9':
            case '09': $month = 'сентябрь'; break;
            case '10': $month = 'октябрь'; break;
            case '11': $month = 'ноябрь'; break;
            case '12': $month = 'декабрь'; break;
            default:
                $month = '';
        }
        return $month;
    }

    /**
     * Дата в формате год-месяц-дата
     * @param string $date
     * @return string
     */
    public static function getDateFormatPHP($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            return date('Y-m-d', $tmp);
        }
        return '';
    }

    /**
     * Возвращаем порядковый день недели
     * Порядковый номер дня недели в соответствии со стандартом ISO-8601
     * от 1 (понедельник) до 7 (воскресенье)
     * @param $date
     * @return int
     */
    public static function getNumberDayWeek($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            return date('N', $tmp);
        }
        return 0;
    }

    /**
     * Дата в формате дата.месяц.год
     * @param $date
     * @return string
     */
    public static function getDateFormatRus($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            return strftime('%d.%m.%Y', $tmp);
        }
        return '';
    }

    /**
     * Дата в формате год-месяц-дата часы:минуты:секунды
     * @param $date
     * @return string
     */
    public static function getDateTimeFormatPHP($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            return date('Y-m-d H:i:s', $tmp);
        }
        return '';
    }

    /**
     * Дата в формате дата.месяц.год часы:минуты
     * @param $date
     * @param bool $isReplaceZeroHour
     * @return mixed|string
     */
    public static function getDateTimeFormatRus($date, $isReplaceZeroHour = false){
        $tmp = strtotime($date);
        if ($tmp > 0){
            $result = strftime('%d.%m.%Y %H:%M', $tmp);

            if($isReplaceZeroHour){
                $result = str_replace(' 00:00', '', $result);
            }

            return $result;
        }
        return '';
    }

    /**
     * Дата в формате часы:минуты
     * @param $date
     * @return string
     */
    public static function getTimeFormatRus($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            return strftime('%H:%M', $tmp);
        }
        return '';
    }

    /**
     * Дата в формате дата.месяц.год часы:минуты:секунды
     * @param $date
     * @return string
     */
    public static function getDateTimeFormatRusAndSecond($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            return str_replace(' 00:00:00', '', strftime('%d.%m.%Y %H:%M:%S', $tmp));
        }
        return '';
    }
    /**
     * Получаем дату на заданного количество лет назад
     * @param $date
     * @param $year
     * @return float|int
     */
    public static function deductDateYears($date, $year){
        return date('Y-m-d', strtotime($date.' -'.(intval($year)).' years'));
    }

    /**
     * Получаем период в заданных месяц в указанный период
     * $dateFrom = 2018-11-05, $dateTo = 2018-12-31, $month = 11, $year = 2018 => array('from' => '2018-11-05', 'to' => '2018-11-30')
     * @param $dateFrom
     * @param $dateTo
     * @param $month
     * @param $year
     * @return array|null
     */
    public static function getPeriodDateByMonth($dateFrom, $dateTo, $month, $year)
    {
        $monthFromD = strtotime(Helpers_DateTime::getMonthBeginStr($month, $year));
        $monthToD = strtotime(Helpers_DateTime::getMonthEndStr($month, $year));

        $dateFromD = strtotime($dateFrom);
        $dateToD = strtotime($dateTo);

        $monthFrom = NULL;
        $monthTo = NULL;

        while (($monthFromD <= $dateToD) && ($monthFromD <= $monthToD)) {
            if ($monthFromD >= $dateFromD) {
                if ($monthFrom === NULL) {
                    $monthFrom = $monthFromD;
                    $monthTo = $monthFromD;
                } else {
                    $monthTo = $monthFromD;
                }
            }
            $monthFromD += 24 * 60 * 60;
        }

        if ($monthFrom === NULL) {
            return NULL;
        }else{
            return array(
                'from' => date('Y-m-d', $monthFrom),
                'to' => date('Y-m-d', $monthTo),
            );

        }
    }

    /**
     * Кол-во дней в заданном периоде
     * @param $dateTo
     * @param $dateFrom
     * @return float|int
     */
    public static function diffDays($dateTo, $dateFrom){

        $diff = strtotime($dateTo) - strtotime($dateFrom);
        return $diff / (60 * 60 * 24);
    }

    /**
     * Кол-во минут в заданном периоде
     * @param $dateTo
     * @param $dateFrom
     * @return float|int
     */
    public static function diffMinutes($dateTo, $dateFrom){

        $diff = strtotime($dateTo) - strtotime($dateFrom);
        return $diff / 60;
    }

    /**
     * Кол-во секунд в заданном периоде
     * @param $dateTo
     * @param $dateFrom
     * @return float|int
     */
    public static function diffSeconds($dateTo, $dateFrom){

        $diff = strtotime($dateTo) - strtotime($dateFrom);
        return $diff;
    }

    /**
     * Кол-во времени в заданном периоде в формате Деней Часов:Минут:Секунд
     * @param $dateTo
     * @param $dateFrom
     * @return float|int
     */
    public static function diffTimeRUS($dateTo, $dateFrom){
        $diff = self::diffSeconds($dateTo, $dateFrom);
        if($diff <= 0){
            return '';
        }

        $time = new DateTime('@' . $diff);
        if($time->format('z') > 0){
            return $time->format('z').' '. $time->format('G') . ':' . $time->format('i') . ':' . $time->format('s');
        }else{
            return $time->format('G') . ':' . $time->format('i') . ':' . $time->format('s');
        }
    }

    /**
     * Кол-во часов в заданном периоде
     * @param $dateTo
     * @param $dateFrom
     * @return float|int
     */
    public static function diffHours($dateTo, $dateFrom){

        $diff = strtotime($dateTo) - strtotime($dateFrom);
        return $diff / 60 / 60;
    }

    /**
     * Формат даты в русском формате день.месяц.год часы:минуты
     * @param $date
     * @return mixed|string
     */
    public static function getDateTimeRusWithoutSeconds($date){
        $tmp = strtotime($date);
        if ($tmp > 0){
            return str_replace(' 00:00', '', strftime('%d.%m.%Y %H:%M', $tmp));
        }
        return '';
    }

    /**
     * Переводим в формат 3 June 2017
     * @param string $date в формате даты 2015-09-03
     * @param bool $isYear
     * @return string
     */
    public static function getDateTimeDayMonthENG($date, $isYear = FALSE){
        $tmp = strtotime($date);

        if ($tmp > 0){

            $month = '';
            switch (strftime('%m', $tmp)) {
                case '01': $month = 'January'; break;
                case '02': $month = 'February'; break;
                case '03': $month = 'March'; break;
                case '04': $month = 'April'; break;
                case '05': $month = 'May'; break;
                case '06': $month = 'June'; break;
                case '07': $month = 'July'; break;
                case '08': $month = 'August'; break;
                case '09': $month = 'September'; break;
                case '10': $month = 'October'; break;
                case '11': $month = 'November'; break;
                case '12': $month = 'December'; break;
            }

            $day = strftime('%d', $tmp);
            if ($day[0] == '0'){
                $day = substr($day, 1);
            }
            if($isYear){
                return $day . ' ' . $month . ' ' . strftime('%Y', $tmp);
            }else {
                return $day . ' ' . $month;
            }
        }
        return '';
    }

    /**
     * Переводим в формат 3 сентября 2017 г.
     * @param string $date в формате даты 2015-09-03
     * @param bool $isYear
     * @return string
     */
    public static function getDateTimeDayMonthRus($date, $isYear = FALSE){
        $tmp = strtotime($date);

        if ($tmp > 0){

            $month = '';
            switch (strftime('%m', $tmp)) {
                case '01': $month = 'января'; break;
                case '02': $month = 'февраля'; break;
                case '03': $month = 'марта'; break;
                case '04': $month = 'апреля'; break;
                case '05': $month = 'мая'; break;
                case '06': $month = 'июня'; break;
                case '07': $month = 'июля'; break;
                case '08': $month = 'августа'; break;
                case '09': $month = 'сентября'; break;
                case '10': $month = 'октября'; break;
                case '11': $month = 'ноября'; break;
                case '12': $month = 'декабря'; break;
            }

            $day = strftime('%d', $tmp);
            if ($day[0] == '0'){
                $day = substr($day, 1);
            }
            if($isYear){
                return $day . ' ' . $month . ' ' . strftime('%Y', $tmp). ' г.';
            }else {
                return $day . ' ' . $month;
            }
        }
        return '';
    }

    /**
     * Переводим в формат 3 сентября 2017 г. в зависимости от языка
     * @param SitePageData $sitePageData
     * @param $date
     * @param bool $isYear
     * @return string
     */
    public static function getDateTimeDayMonth(SitePageData $sitePageData, $date, $isYear = FALSE){
        switch ($sitePageData->dataLanguageID){
            case Model_Language::LANGUAGE_RUSSIAN:
                return self::getDateTimeDayMonthRus($date, $isYear);
                break;
            case Model_Language::LANGUAGE_ENGLISH:
                return self::getDateTimeDayMonthENG($date, $isYear);
                break;
        }
        return self::getDateTimeDayMonthRus($date, $isYear);
    }

    /**
     * Получаем массив месяцев в периоде
     * @param $dateFrom - строка 2018-12-11
     * @param $dateTo - строка 2018-12-11
     * @return array
     */
    public static function getMonthsPeriod($dateFrom, $dateTo){
        $months = array();
        $dateFromD = strtotime($dateFrom);

        $dateToD = strtotime($dateTo);
        $yearTo = strftime('%Y', $dateToD);
        $monthTo = strftime('%m', $dateToD);
        do{
            $yearFrom = strftime('%Y', $dateFromD);
            $monthFrom = strftime('%m', $dateFromD);

            $months[$yearFrom.'_'.$monthFrom] = array(
                'year' => $yearFrom,
                'month' => $monthFrom,
            );

            $dateFromD = strtotime(date('Y-m-d', $dateFromD). ' +27 day');
        }while(!(($yearFrom > $yearTo) || (($yearFrom == $yearTo) && ($monthFrom >= $monthTo))));

        return $months;
    }

    /**
     * Возвращаем строку даты начала года
     * @param $year
     * @return string
     */
    public static function getYearBeginStr($year){
        return $year.'-01-01';
    }

    /**
     * Возвращаем строку даты конца года
     * @param $year
     * @return string
     */
    public static function getYearEndStr($year){
        return $year.'-12-31';
    }

    /**
     * Возвращаем строку даты начала недели
     * @param $date
     * @return string
     */
    public static function getWeekBeginStr($date){
        if(date('N', strtotime($date)) == 1){
            return $date;
        }else {
            return date("Y-m-d", strtotime($date . ' last Monday'));
        }
    }

    /**
     * Возвращаем строку даты начала месяца
     * @param $month
     * @param $year
     * @return string
     */
    public static function getMonthBeginStr($month, $year){
        $month = '0'.$month;
        $month = substr($month, strlen($month) - 2);

        return $year.'-'.$month.'-01';
    }

    /**
     * Возвращаем строку даты
     * @param $day
     * @param $month
     * @param $year
     * @return string
     */
    public static function getDateStr($day, $month, $year){
        $day = '0'.$day;
        $day = substr($day, strlen($day) - 2);
        $month = '0'.$month;
        $month = substr($month, strlen($month) - 2);

        return $year.'-'.$month.'-'.$day;
    }

    /**
     * Возвращаем последний последний день месяца года
     * @param $month
     * @param $year
     * @return int
     */
    public static function getLastDayMonthEndStr($month, $year){
        switch (intval($month)){
            case 1:
            case 3:
            case 5:
            case 7:
            case 8:
            case 10:
            case 12:
                $day = 31;
                break;
            case 2:
                if ($year % 4 == 0){
                    $day = 29;
                }else{
                    $day = 28;
                }
                break;
            default:
                $day = 30;
        }

        return $day;
    }

    /**
     * Возвращаем строку даты конца месяца
     * @param $month
     * @param $year
     * @return string
     */
    public static function getMonthEndStr($month, $year){
        return self::getDateStr(self::getLastDayMonthEndStr($month, $year), $month, $year);
    }

    /**
     * Получаем текущую дату со временем в формате PHP
     * @return string
     */
    public static function getCurrentDateTimePHP(){
        return date('Y-m-d H:i:s');
    }

    /**
     * Получаем текущую дату в формате PHP
     * @return string
     */
    public static function getCurrentDatePHP(){
        return date('Y-m-d');
    }

    /**
     * Получаем текущую дату в формате PHP
     * @return string
     */
    public static function getDateTimeEndDay($date){
        if(empty($date)){
            return '';
        }
        return date('Y-m-d 23:59:59', strtotime($date));
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_Array {
    /**
     * Проверяем пустой ли массив, чтобы массив не был пустым должно быть хоть одно значение отличающееся от 0 и пустой строки
     * @param $data
     * @return bool
     */
    public static function _empty($data)
    {
        if(!is_array($data)){
            return true;
        }

        $empty = function (array $data, $func){
            foreach ($data as $child){
                if(!is_array($child)){
                    if(!empty($child)){
                        return false;
                    }

                    continue;
                }

                if(!$func($child, $func)){
                    return false;
                }

            }

            return true;
        };


        return $empty($data, $empty);
    }

    /**
     * Прибавляем к значению ключа массива $quantity
     * @param array $array
     * @param $field
     * @param float|int $quantity
     * @return float|int
     */
    public static function plusValue(array &$array, $field, $quantity) {
        if(!key_exists($field, $array)){
            $array[$field] = 0;
        }

        $array[$field] += $quantity;
        return $array[$field];
    }

    /**
     * Массив в преобразуем в список уникальный числовых значений больше нуля
     * @param array $array
     * @return array
     */
    public static function getUniqueNumbers(array $array) {
        $result = array();
        foreach ($array as $child){
            $child = intval($child);
            if($child > 0){
                $result[$child] = $child;
            }
        }

        return array_values($result);
    }

    /**
     * Ищем в массиве значение ключа массива и преобразуем в вещественного число
     * @param $array
     * @param $path
     * @param null $default
     * @param null $delimiter
     * @return int|float
     */
    public static function pathFloat($array, $path, $default = NULL, $delimiter = NULL) {
        $result = Arr::path($array, $path, $default, $delimiter);
        $result = str_replace(',', '.', $result);
        return floatval(preg_replace('/[^0-9,\.]/', '', $result));
    }

    /**
     * Преобразовать массив в строку для PHP файла c сохранить ее в файл
     * @param array $data
     * @param $fileName
     * @return string
     */
    public static function saveArrayToStrPHP(array $data, $fileName) {
        $data = '<?php' . "\r\n" . 'return ' . self::arrayToStrPHP($data) . ';';

        $file = fopen($fileName, 'w');
        fwrite($file, $data);
        fclose($file);

        try {
            chmod($fileName, 0777);
        } catch (Exception $e) {

        }
    }

    /**
     * Преобразовать массив в строку для PHP файла
     * @param array $data
     * @param string $prefix
     * @return string
     */
    public static function arrayToStrPHP(array $data, $prefix = '    ') {
        $s = 'array(';
        foreach ($data as $key => $value) {
            $s = $s . "\r\n".$prefix;
            if (is_int($key)) {
                $s = $s .$key . ' => ';
            } else {
                $s = $s . "'" . $key . "'" . ' => ';
            }

            if (is_array($value)) {
                $s = $s . self::arrayToStrPHP($value, $prefix.'    ') . ', ';
            } elseif (is_int($value)) {
                $s = $s . $value . ', ';
            } else {
                $s = $s . "'" . $value . "'" . ', ';
            }
        }

        $s = $s . ')';
        return $s;
    }

    /**
     * Рекурсивное объединение двух массивов, заменяя данные первого массива данными второго массива
     * недостающие данные первого массива добавляются в конце
     * @param array $array1
     * @param array $array2
     * @return array
     */
    public static function arrayJoin(array $array1, array $array2) {
        $result = $array1;
        foreach ($result as $key => $child){
            if(key_exists($key, $array2)){
                if ((is_array($child) && (is_array($array2[$key])))){
                    $result[$key] = self::arrayJoin($child, $array2[$key]);
                }else{
                    $result[$key] = $array2[$key];
                }
                unset($array2[$key]);
            }
        }
        foreach ($array2 as $key => $child){
            $result[$key] = $child;
        }

        return $result;
    }

}
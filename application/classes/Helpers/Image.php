<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_Image {

    /**
     * Выбираем картинку по типу "image_type"
     * @param array $files
     * @param $imageType
     * @param bool $isArray
     * @return string
     */
    public static function getPhotoPathByImageType(array $files, $imageType, $isArray = FALSE){
        foreach($files as $index => $file){
            if(($file['type'] == Model_ImageType::IMAGE_TYPE_IMAGE)
                && (Arr::path($file, 'image_type', '') == $imageType)) {
                if ($isArray){
                    return $file;
                }else {
                    return $file['file'];
                }
            }
        }
        if ($isArray) {
            return array();
        }else{
            return '';
        }
    }

    /**
     * Добавляем картинке размеры в пикселях
     * "название файла"-"ширина"x"высота"."расширение файла"
     * @param $filePath
     * @param $width
     * @param $height
     * @param string $notFile
     * @param bool $isResizeNotFile
     * @return string
     */
    public static function getPhotoPath($filePath, $width, $height, $notFile = '/img/file-not-found/file_not_found.png', $isResizeNotFile = TRUE)
    {
        if (empty($filePath)) {
            if (($isResizeNotFile === TRUE) && (!empty($notFile))) {
                return Func::addSiteNameInFilePath(pathinfo($notFile, PATHINFO_DIRNAME) . '/'
                    . pathinfo($notFile, PATHINFO_FILENAME) . '-'
                    . $width . 'x' . $height . '.'
                    . pathinfo($notFile, PATHINFO_EXTENSION));
            } else {
                return $notFile;
            }
        } else {
            return Func::addSiteNameInFilePath(pathinfo($filePath, PATHINFO_DIRNAME) . '/'
                . pathinfo($filePath, PATHINFO_FILENAME) . '-'
                . $width . 'x' . $height . '.'
                . pathinfo($filePath, PATHINFO_EXTENSION));
        }
    }

    /**
     * Выбираем оптимальную картинку по размеру
     * @param array $files
     * @param $width
     * @param $height
     * @param string $default
     * @return string
     */
    public static function getOptimalSizePhotoPath(array $files, $width, $height, $default = ''){
        $arr = array();
        foreach($files as $index => $file){
            if($file['type'] == Model_ImageType::IMAGE_TYPE_IMAGE) {
                if ((key_exists('w', $file)) && (key_exists('h', $file)) && ($file['w'] > 0) && ($file['h'] > 0)) {
                    if(($file['w'] == $width) && ($file['h'] == $height)){
                        return $file['file'];
                    }else {
                        $arr[] = array(
                            'c' => abs(($file['w'] / $width) - ($file['h'] / $height)),
                            'index' => $index,
                            'less' => ($file['w'] < $width) && ($file['h'] < $height),
                            'shift' => abs($file['w'] - $width) + abs($file['h'] - $height),
                        );
                    }
                }else{
                    $arr[] = array(
                        'c' => 99999999,
                        'index' => $index,
                        'less' => FALSE,
                        'shift' => 0,
                    );
                }
            }
        }

        if(count($arr) == 0){
            return $default;
        }

        $min = -1;
        foreach($arr as $key => $value){
            if((! $value['less']) && (($min == -1) || ($value['c'] < $arr[$min]['c']))){
                $min = $key;
            }
        }

        if($min == -1){
            $min = -1;
            foreach($arr as $key => $value){
                if(($value['less']) && (($min == -1) || ($value['c'] < $arr[$min]['c']))){
                    $min = $key;
                }
            }
        }

        return $files[$arr[$min]['index']]['file'];
    }

    /**
     * Переводит массив файлов в список файлов
     * при $name = 'shop_goods'; $path = '16291.options'
     * $_FILES = {"shop_goods":{"name":{"16291":{"options":{"image":"cart-goods.png"}},"16285":{"options":{"image":"Picture1.png"}},"16283":{"options":{"image":"cart-goods.png"}},"16277":{"options":{"image":"1920x800.png"}},"16293":{"options":{"image":"cart-goods.png"}}},"type":{"16291":{"options":{"image":"image\/png"}},"16285":{"options":{"image":"image\/png"}},"16283":{"options":{"image":"image\/png"}},"16277":{"options":{"image":"image\/png"}},"16293":{"options":{"image":"image\/png"}}},"tmp_name":{"16291":{"options":{"image":"\/tmp\/phpamQo5v"}},"16285":{"options":{"image":"\/tmp\/phpmsZsYu"}},"16283":{"options":{"image":"\/tmp\/phpCRczRt"}},"16277":{"options":{"image":"\/tmp\/php3bUFKs"}},"16293":{"options":{"image":"\/tmp\/phpUAvNDr"}}},"error":{"16291":{"options":{"image":0}},"16285":{"options":{"image":0}},"16283":{"options":{"image":0}},"16277":{"options":{"image":0}},"16293":{"options":{"image":0}}},"size":{"16291":{"options":{"image":2284}},"16285":{"options":{"image":61483}},"16283":{"options":{"image":2284}},"16277":{"options":{"image":7495}},"16293":{"options":{"image":2284}}}},"receiver_data":{"name":{"file":"1920x800.png"},"type":{"file":"image\/png"},"tmp_name":{"file":"\/tmp\/phpkUGVwq"},"error":{"file":0},"size":{"file":7495}}}
     * return {"image":{"tmp_name":"\/tmp\/phpamQo5v","name":"cart-goods.png","type":"image\/png","error":0,"size":2284}}
     * @param $name
     * @param string $path
     * @param array $default
     * @return array
     */
    public static function getChildrenFILES($name, $path = '', $default = array()){
        if(! key_exists($name, $_FILES)){
            return $default;
        }

        if(! is_array($_FILES[$name]['tmp_name'])){
            if(empty($path)) {
                return array(0 => $_FILES[$name]);
            }else{
                return $default;
            }
        }

        if(empty($path)) {
            $tmpName = $_FILES[$name]['tmp_name'];
        }else{
            $tmpName = Arr::path($_FILES[$name]['tmp_name'], $path, '');
        }
        if(empty($tmpName)){
            return $default;
        }

        $result = array();
        if(! is_array($tmpName)){
            $result[] = array(
                'tmp_name' => $tmpName,
                'name' => Arr::path($_FILES[$name]['name'], $path, ''),
                'type' => Arr::path($_FILES[$name]['type'], $path, ''),
                'error' => Arr::path($_FILES[$name]['error'], $path, ''),
                'size' => Arr::path($_FILES[$name]['size'], $path, ''),
            );

            return $result;
        }

        foreach($tmpName as $key => $value){
            $result[$key] = array(
                'tmp_name' => $value,
                'name' => Arr::path($_FILES[$name]['name'], $path.'.'.$key, ''),
                'type' => Arr::path($_FILES[$name]['type'], $path.'.'.$key, ''),
                'error' => Arr::path($_FILES[$name]['error'], $path.'.'.$key, ''),
                'size' => Arr::path($_FILES[$name]['size'], $path.'.'.$key, ''),
            );
        }

        return $result;
    }

    /**
     * Размер файла в русской транскрипции
     * @param $fileSize
     * @return string
     */
    public static function getFileSizeStrRus($fileSize){
        $fileSize = floatval($fileSize);
        if($fileSize == 0){
            return '';
        }
        if($fileSize < 1024){
            return Func::getNumberStr($fileSize).' Б';
        }

        $fileSize = $fileSize / 1024;
        if($fileSize < 1024){
            return Func::getNumberStr($fileSize).' КБ';
        }

        $fileSize = $fileSize / 1024;
        if($fileSize < 1024){
            return Func::getNumberStr($fileSize).' МБ';
        }

        $fileSize = $fileSize / 1024;
        if($fileSize < 1024){
            return Func::getNumberStr($fileSize).' ГБ';
        }

        $fileSize = $fileSize / 1024;
        return Func::getNumberStr($fileSize).' TБ';
    }
}
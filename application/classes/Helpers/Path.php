<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_Path {

    /**
     * Получай файл с настройками прокси
     * @return string
     */
    public static function getFilesProxies(){
        $path = Helpers_Path::getPathFile(APPPATH, ['config', 'kaspi'], 'proxies.php');
        if(file_exists($path)){
            return $path;
        }

        return '';
    }

    /**
     * Создаем путь до файла
     * @param string $basicPath
     * @param array $directories
     * @param string $fileName
     * @return string
     */
	public static function getPathFile($basicPath, array $directories, $fileName = ''){
	    $result = $basicPath;

	    foreach ($directories as $directory){
            $result .= $directory . DIRECTORY_SEPARATOR;
        }

        return $result . $fileName;
	}

    /**
     * Создаем полный путь, если папки не существет то создаем ее
     * @param $path
     * @param int $mode
     * @return bool
     */
    public static function createPath($path, $mode = 0777) {
        if(is_dir($path)){
            return true;
        }

        $dirs = explode(DIRECTORY_SEPARATOR, str_replace('/', DIRECTORY_SEPARATOR, $path));
        $path = '';
        foreach ($dirs as $value) {
            $path .= $value . DIRECTORY_SEPARATOR;
            try {
                if (($value !== '') && (!file_exists($path))) {
                    if (!mkdir($path, $mode)) {
                        return false;
                    }
                    chmod($path, 0777);
                }
            }catch(Exception $e){
            }
        }
        return true;
    }

    /**
     * Поиск файлов в папке и подпапках
     * @param $path
     * @param $pattern
     * @return array
     */
    public static function globTreeSearch($path, $pattern)
    {
        if(empty($path)){
            return [];
        }

        if(mb_substr($path, mb_strlen($path) -1) != DIRECTORY_SEPARATOR){
            $path .= DIRECTORY_SEPARATOR;
        }

        $out = array();
        foreach(glob($path . $pattern, GLOB_BRACE) as $file) {
            $out[] = $path . basename($file);
        }

        foreach(glob($path . '*', GLOB_ONLYDIR) as $file) {
            $out = array_merge($out, self::globTreeSearch($file, $pattern));
        }

        return $out;

    }
}
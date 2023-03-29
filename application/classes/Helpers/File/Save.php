<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_File_Save {
    const IMAGETYPE_GIF = 1;
    const IMAGETYPE_JPEG = 2;
    const IMAGETYPE_PNG = 3;

    /**
     * Сохраняем файлы в текущий проект
     * @param array $files
     * @param $id
     * @param $name
     * @param $nameOld
     * @param $date
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param string $path
     * @return array
     */
	public static function saveFiles(array $files, $id, $name, $nameOld, $date, SitePageData $sitePageData,
                                     Model_Driver_DBBasicDriver $driver, $path = 'files'){
        $name = self::get_in_translate_to_en($name);
        $nameOld = self::get_in_translate_to_en($nameOld);

	    // базовый путь проекта
        $basicPath = DOCROOT . $path . DIRECTORY_SEPARATOR
            . Helpers_DateTime::getYear($date) . DIRECTORY_SEPARATOR
            . Helpers_DateTime::getMonth($date) . DIRECTORY_SEPARATOR
            . $name . ' (' . $id . ')' . DIRECTORY_SEPARATOR;

        // переименовываем старый каталог на новое название
        if(!empty($nameOld) && $name != $nameOld){
            $basicPathOld = DOCROOT . $path . DIRECTORY_SEPARATOR
                . Helpers_DateTime::getYear($date) . DIRECTORY_SEPARATOR
                . Helpers_DateTime::getMonth($date) . DIRECTORY_SEPARATOR
                . $nameOld . ' (' . $id . ')' . DIRECTORY_SEPARATOR;

            if(!file_exists($basicPath)){
                rename($basicPathOld, $basicPath);
            }
        }
        Helpers_Path::createPath($basicPath);

        // базовый путь URL проекта
        $basicURL = Helpers_URL::getBasicURL('files'). Helpers_DateTime::getYear($date) . '/'
            . Helpers_DateTime::getMonth($date) . '/'
            . $name . ' (' . $id . ')' . '/';

        $tmpPath = DOCROOT . 'tmp_files' . DIRECTORY_SEPARATOR . session_id() . DIRECTORY_SEPARATOR;

        // находим файлы в текущей проекте
        $currentFiles = array();
        foreach (scandir($basicPath) as $file){
            if($file == '.' || $file == '..'){
                continue;
            }
            $currentFiles[$file] = '';
        }

        $modelImage = new Model_Shop_Image();
        $modelImage->setDBDriver($driver);

	    $result = array();
	    foreach ($files as $file){
	        if(!is_array($file)){
	            continue;
            }

            if(key_exists('id', $file)){
                if(! Helpers_DB::getDBObject($modelImage, $file['id'], $sitePageData)){
                    continue;
                }
                $modelImage->setImagePath($basicURL . $modelImage->getFileName());

                unset($currentFiles[$modelImage->getFileName()]);
            }else{
                if(!key_exists('name', $file)){
                    continue;
                }

                if(!file_exists($tmpPath . $file['name'])){
                    continue;
                }

                // находим одинаковые файлы
                $newFile = $file['name'];
                for($j = 0; $j < 10000; $j++){
                    if (!file_exists($basicPath . $newFile)) {
                        break;
                    }
                    $newFile = self::_getFileIndex($file['name'], $j);
                }

                if(!rename($tmpPath . $file['name'], $basicPath . $newFile)){
                    continue;
                }

                $modelImage->clear();
                $modelImage->setFileName($file['name']);
                $modelImage->setFileSize(filesize($basicPath. $newFile));
                $modelImage->setImagePath($basicURL . $newFile);

                if (self::is_valid_image_file($basicPath . $newFile)) {
                    $modelImage->setImageTypeID(Model_ImageType::IMAGE_TYPE_IMAGE);
                }
            }
            Helpers_DB::saveDBObject($modelImage, $sitePageData);

            $result[] = array(
                'title' => '',
                'image_type' => $modelImage->getImageTypeID(),
                'file' => $modelImage->getImagePath(),
                'file_name' => $modelImage->getFileName(),
                'file_size' => $modelImage->getFileSize(),
                'id' => $modelImage->id,
                'type' => $modelImage->getImageTypeID(),
                'options' => $modelImage->getOptionsArray(),
                'w' => $modelImage->getWidth(),
                'h' => $modelImage->getHeight(),
            );
        }

        // удаляем лишние файлы
        foreach ($currentFiles as $file => $s){
            unlink($basicPath . $file);
        }

        return $result;
	}


    /**
     * Является ли картинкой
     * @param $file_path
     * @return bool
     */
    private static function is_valid_image_file($file_path) {
        if (!preg_match('/\.(gif|jpe?g|png)$/i', $file_path)) {
            return false;
        }
        return !!self::imagetype($file_path);
    }

    /**
     * Тип картинки
     * @param $file_path
     * @return bool
     */
    private static  function imagetype($file_path) {
        $fp = fopen($file_path, 'r');
        $data = fread($fp, 4);
        fclose($fp);
        // GIF: 47 49 46 38
        if ($data === 'GIF8') {
            return self::IMAGETYPE_GIF;
        }
        // JPG: FF D8 FF
        if (bin2hex(substr($data, 0, 3)) === 'ffd8ff') {
            return self::IMAGETYPE_JPEG;
        }
        // PNG: 89 50 4E 47
        if (bin2hex(@$data[0]).substr($data, 1, 4) === '89PNG') {
            return self::IMAGETYPE_PNG;
        }
        return false;
    }

    /**
     * Добавляем к файлу номер
     * @param $index
     * @param $fileName
     * @return string
     */
    private static function _getFileIndex($index, $fileName) {
        $fileInfo = pathinfo($fileName);
        return $fileInfo['filename'] . ' (' . $index . ') .' . Arr::path($fileInfo, 'extension', '');
    }

    /**
     * Перевод русских букв в английские
     * @param $string
     * @param bool $isOnlySymbols
     * @return mixed|string
     */
    private static function get_in_translate_to_en($string, $isOnlySymbols = FALSE)
    {
        $replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
            "Е"=>"E","е"=>"e","Ё"=>"E","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
            "Й"=>"I","й"=>"i","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n","О"=>"O","о"=>"o",
            "П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t","У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f",
            "Х"=>"Kh","х"=>"kh","Ц"=>"Tc","ц"=>"tc","Ч"=>"Ch","ч"=>"ch","Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch",
            "Ы"=>"Y","ы"=>"y","Э"=>"E","э"=>"e","Ю"=>"Yu","ю"=>"yu","Я"=>"Ya","я"=>"ya","ъ"=>"","ь"=>"",
            "Ә" =>"A","ә" =>"a","Ғ"=>'G',"ғ"=>"g","Қ"=>"Q","қ"=>"q","Ң"=>"N","ң"=>"n","Ө"=>"O","ө"=>"o",
            "Ұ"=>"U","ұ"=>"u","Ү"=>"U","ү"=>"u");

        $string = trim(
            str_replace('/', '-',
                str_replace('\\', '-',
                    str_replace('/', '-',
                        str_replace('\\', '-',
                            str_replace('%20', ' ', $string)
                        )
                    )
                )
            )
        );
        $tmp = iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));

        $arr = array('q'=>'','w'=>'','e'=>'','r'=>'','t'=>'','y'=>'','u'=>'','i'=>'','o'=>'','p'=>'','a'=>'','s'=>'','d'=>'',
            'f'=>'','g'=>'','h'=>'','j'=>'','k'=>'','l'=>'','z'=>'','x'=>'','c'=>'','v'=>'','b'=>'','n'=>'','m'=>'',
            '1'=>'','2'=>'','3'=>'','4'=>'','5'=>'','6'=>'','7'=>'','8'=>'','9'=>'','0'=>'','-'=>'',' '=>'','_'=>'','.'=>'');

        $s = '';
        for ($i = 0; $i < mb_strlen($tmp); $i++) {
            $c = mb_substr($tmp, $i, 1);
            if(key_exists($c, $arr)){
                $s = $s.$c;
            }
        }
        return $tmp;
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

class Model_File extends Model {

    public $basicURL = '';

    // нужно ли удалять файл
    public $isDeleteFile = TRUE;

    // секретные ключи для Amazon S3
    public $pathSave;

    public function __construct(SitePageData $sitePageData, $isBasicURL = FALSE) {
        if($isBasicURL === TRUE) {
            $this->basicURL = $sitePageData->scheme. (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME']));
        }

        $this->pathSave = APPPATH . 'img' . DIRECTORY_SEPARATOR;
    }

    private function _getPath($tableID, $id, $basicDir = 'img') {
        return $basicDir . DIRECTORY_SEPARATOR
        . $tableID . DIRECTORY_SEPARATOR
        . date('Y') . DIRECTORY_SEPARATOR
        . date('m') . DIRECTORY_SEPARATOR
        . date('d') . DIRECTORY_SEPARATOR
        . $id . DIRECTORY_SEPARATOR;
    }

    /**
     * @param $path
     * @param $id
     * @param $fileName
     * @param int $languageID
     * @return string
     */
    private function _getPathFile($path, $id, $fileName, $languageID = 0) {
        if((!empty($fileName)) && (strpos($fileName, '.') !== FALSE)){
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        }else{
            $fileExt = pathinfo($path, PATHINFO_EXTENSION);
        }
        if(empty($fileExt)){
            $fileExt = 'png';
        }

        $fileName = Func::get_in_translate_to_en(pathinfo($fileName, PATHINFO_FILENAME), TRUE);

        if($languageID > 0){
            return $path . $fileName . '_' . $id . '_' . $languageID . '.' . $fileExt;
        }else {
            return $path . $fileName . '_' . $id . '.' . $fileExt;
        }
    }

    private function _saveFile($filePath, $newFilePath) {
        if (file_exists($newFilePath)) {
            $this->removeDirectory(pathinfo($newFilePath, PATHINFO_DIRNAME));
        }

        $tmp = pathinfo($newFilePath, PATHINFO_DIRNAME);
        if (!is_dir($tmp)) {
            Helpers_Path::createPath($tmp);
        }
        try {
            if($this->isDeleteFile){
                if (file_exists($filePath) && (move_uploaded_file($filePath, $newFilePath)) || (copy($filePath, $newFilePath))) {
                    try {
                        unlink($filePath);
                    }catch(Exception $e){}
                    return TRUE;
                } else {
                    return FALSE;
                }
            }else{
                return copy($filePath, $newFilePath);
            }
        }catch(Exception $e){
            throw new HTTP_Exception_500($e->getMessage()."\r\nPath: ".$newFilePath);
        }
    }

    private function removeDirectory($dir) {
        if ($objs = glob($dir . "/*")) {
            foreach ($objs as $obj) {
                is_dir($obj) ? $this->removeDirectory($obj) : unlink($obj);
            }
        }
        rmdir($dir);
    }

    /**
     * Сохраняем фотографию
     * @param $filePath
     * @param $id
     * @param $tableID
     * @param SitePageData $sitePageData
     * @return string
     */
    public function saveImage($filePath, $id, $tableID, SitePageData $sitePageData) {
         if(strpos($filePath, $sitePageData->scheme) === 0){
            return $filePath;
        }

        $fileName = pathinfo($filePath, PATHINFO_BASENAME);

        $filePath = DOCROOT . 'tmp_files' . DIRECTORY_SEPARATOR . str_replace('/', '', str_replace('\\', '', $filePath));
        if (!file_exists($filePath)) {
            return '';
        }

        $newPath = $this->_getPath($tableID, $id);
        $newFile = $this->_getPathFile($newPath, $id, $fileName);

        $result = $this->_saveFile($filePath, $newFile);

        if ($result === TRUE) {
            if($this->isDeleteFile){
                unlink($filePath);
            }

            return $this->basicURL . '/' . str_replace("\\", '/', $newFile);
        }

        return '';
    }

    /**
     * Сохраняем фотографию
     * @param $filePath
     * @param $id
     * @param $tableID
     * @return array|string
     */
    public function addImage($filePath, $id, $tableID) {
        if (!file_exists($filePath['tmp_name'])) {
            return array();
        }

        $newPath = $this->_getPath($tableID, $id);
        $newFile = $this->_getPathFile($newPath, $id, $filePath['name']);

        $result = $this->_saveFile($filePath['tmp_name'], $newFile);

        if ($result === TRUE) {
         //   unlink($filePath);
            return $this->basicURL . '/' . str_replace("\\", '/', $newFile);
        }

        return '';
    }

    /**
     * Сохранение файла
     * @param $fileName
     * @param $filePath
     * @param Model_Shop_Image $modelImage
     * @param Model_Basic_Files $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    private function _saveFileFile($fileName, $filePath, Model_Shop_Image $modelImage, Model_Basic_Files $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {
        // добавляем новые файлы
        $newPath = $this->_getPath($model->tableID, $model->id);

        // проверяем не передан ли путь к файлу
        if(! file_exists($filePath)) {
            $tmpPath = DOCROOT . 'tmp_files' . DIRECTORY_SEPARATOR;

            $filePathTMP = $tmpPath . str_replace('/', '', $filePath);
            if (!file_exists($filePathTMP)) {
                // если файл не найден, то возможно это ссылка
                return $this->_saveFileImageURL($fileName, $filePath, $modelImage, $model, $sitePageData, $driver);
            }
        }else{
            $filePathTMP = $filePath;
        }

        // проверяем есть ли уже данный файл и находим следующую по очереди файл
        $newFile = $this->_getPathFile($newPath, $model->id, $fileName);
        if(file_exists(DOCROOT . $newFile)) {
            for ($j = 1; $j < 10000; $j++) {
                $s = $this->_getPathFile($newPath, $model->id.'_'.$j, $fileName);
                if (!file_exists(DOCROOT. $s)) {
                    $newFile = $s;
                    break;
                }
            }
        }

        // сохраняем в нужный каталог файл
        if(! $this->_saveFile($filePathTMP, DOCROOT. $newFile)){
            return FALSE;
        }


        $modelImage->setImagePath( $this->basicURL . '/' . str_replace("\\", '/', $newFile));
        $modelImage->setTableID($model->tableID);
        $modelImage->setFileName($fileName);
        $modelImage->setFileSize(filesize(DOCROOT. $newFile));

        $modelImage->setWidth(0);
        $modelImage->setHeight(0);

        $modelImage->setShopObjectLanguageIDsArray(
            array(
                $model->id.'-'.$sitePageData->dataLanguageID => array(
                    'id' => $model->id,
                    'language' => $sitePageData->dataLanguageID,
                )
            )
        );
        $modelImage->setImageTypeID(Model_ImageType::IMAGE_TYPE_FILE);

        Helpers_DB::saveDBObject($modelImage,$sitePageData);

        // здесь надо сделать считывание размеров

        return TRUE;
    }

    /**
     * Сохранение картинки
     * @param $fileName
     * @param Model_Shop_Image $modelImage
     * @param Model_Basic_Files $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    private function _saveFileImage($fileName, $filePath, Model_Shop_Image $modelImage, Model_Basic_Files $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {
        // добавляем новые файлы
        $newPath = $this->_getPath($model->tableID, $model->id);

        // проверяем не передан ли путь к файлу
        if(! file_exists($filePath)) {
            $tmpPath = DOCROOT . 'tmp_files' . DIRECTORY_SEPARATOR;

            $filePathTMP = $tmpPath . str_replace('/', '', $filePath);
            if (!file_exists($filePathTMP)) {
                // если файл не найден, то возможно это ссылка
                return $this->_saveFileImageURL($fileName, $filePath, $modelImage, $model, $sitePageData, $driver);
            }
        }else{
            $filePathTMP = $filePath;
        }

        // проверяем есть ли уже данный файл и находим следующую по очереди файл
        $newFile = $this->_getPathFile($newPath, $model->id, $fileName);
        if(file_exists(DOCROOT . $newFile)) {
            for ($j = 1; $j < 10000; $j++) {
                $s = $this->_getPathFile($newPath, $model->id.'_'.$j, $fileName);
                if (!file_exists(DOCROOT. $s)) {
                    $newFile = $s;
                    break;
                }
            }
        }

        // сохраняем в нужный каталог файл
        if(! $this->_saveFile($filePathTMP, DOCROOT. $newFile)){
            return FALSE;
        }

        $modelImage->setImagePath( $this->basicURL . '/' . str_replace("\\", '/', $newFile));
        $modelImage->setTableID($model->tableID);
        $modelImage->setFileName($fileName);
        $modelImage->setFileSize(filesize(DOCROOT. $newFile));

        // размер картинки
        $size = getimagesize(DOCROOT. $newFile);
        $modelImage->setWidth(floatval($size[0]));
        $modelImage->setHeight(floatval($size[1]));

        $modelImage->setShopObjectLanguageIDsArray(
            array(
                $model->id.'-'.$sitePageData->dataLanguageID => array(
                    'id' => $model->id,
                    'language' => $sitePageData->dataLanguageID,
                )
            )
        );
        $modelImage->setImageTypeID(Model_ImageType::IMAGE_TYPE_IMAGE);

        Helpers_DB::saveDBObject($modelImage,$sitePageData);

        // здесь надо сделать считывание размеров

        return TRUE;
    }

    /**
     * Сохранение файлов
     * @param $fileName
     * @param $fileType
     * @param array $fileOptions
     * @param Model_Shop_Image $modelImage
     * @param Model_Basic_Files $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    private function saveFile($fileName, $filePath, $fileType, array $fileOptions, Model_Shop_Image $modelImage,
                              Model_Basic_Files $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {
        switch($fileType){
            case Model_ImageType::IMAGE_TYPE_IMAGE:
                return $this->_saveFileImage($fileName, $filePath, $modelImage, $model, $sitePageData, $driver);
                break;
            case Model_ImageType::IMAGE_TYPE_FILE:
                return $this->_saveFileFile($fileName, $filePath, $modelImage, $model, $sitePageData, $driver);
                break;
        }
    }

    /**
     * Сохранение картинки URL
     * @param $fileName
     * @param $filePath
     * @param Model_Shop_Image $modelImage
     * @param Model_Basic_Files $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    private function _saveFileImageURL($fileName, $filePath, Model_Shop_Image $modelImage, Model_Basic_Files $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {
        $modelImage->setImagePath($filePath);
        $modelImage->setTableID($model->tableID);
        $modelImage->setFileName($fileName);
        $modelImage->setFileSize(0);

        // размер картинки
        $modelImage->setWidth(0);
        $modelImage->setHeight(0);

        $modelImage->setShopObjectLanguageIDsArray(
            array(
                $model->id.'-'.$sitePageData->dataLanguageID => array(
                    'id' => $model->id,
                    'language' => $sitePageData->dataLanguageID,
                )
            )
        );
        $modelImage->setImageTypeID(Model_ImageType::IMAGE_TYPE_IMAGE);

        Helpers_DB::saveDBObject($modelImage,$sitePageData);

        // здесь надо сделать считывание размеров

        return TRUE;
    }

    /**
     * Сохраняем файлы
     * @param $files
     * @param Model_Basic_Files $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isAddFiles
     * @return bool
     */
    public function saveFiles($files, Model_Basic_Files $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isAddFiles = FALSE) {
        if($files === NULL){
            return FALSE;
        }

        $result = array();
        foreach($files as $file){
            if(is_array($file)
                && (key_exists('url', $file))
                && (key_exists('type', $file))) {
                $arr = array(
                    'title' => Arr::path($file, 'title', ''),
                    'file' => $file['url'],
                    'type' => $file['type'],
                    'options' => array(),
                );

                $arr['id'] = intval(Arr::path($file, 'id', ''));
                $arr['file_name'] = Arr::path($file, 'file_name', '');
                if(is_array($arr['file_name'])){
                    $arr['file_name'] = '';
                }

                $arr['image_type'] = Arr::path($file, 'image_type', '');

                if((key_exists('options', $file)) && (is_array($file['options']))){
                    $arr['options'] = $file['options'];
                }

                if (!empty($file['url'])) {
                    $result[] = $arr;
                }
            }
        }

        $modelImage = new Model_Shop_Image();
        $modelImage->setDBDriver($driver);

        $files = array();
        foreach($result as $file){
            if($file['id'] > 0) {
                // если картинка существует, то добавляем связь
                if (Helpers_DB::getDBObject($modelImage, $file['id'], $sitePageData)) {
                    // добавляем связь файла и объекта
                    $arr = $modelImage->getShopObjectLanguageIDsArray();
                    $tmpID = $model->id . '-' . $sitePageData->dataLanguageID;
                    if (!key_exists($tmpID, $arr)) {
                        $arr[$tmpID] = array(
                            'id' => $model->id,
                            'language' => $sitePageData->dataLanguageID,
                        );
                    }
                }else{
                    $modelImage->clear();
                    $modelImage->setImagePath($file['file']);
                    $modelImage->setFileName($file['file_name']);
                    $modelImage->setImageTypeID($file['type']);
                    $modelImage->setOptionsArray($file['options']);

                    Helpers_DB::saveDBObject($modelImage, $sitePageData);
                }

                $files[] = array(
                    'title' => $file['title'],
                    'image_type' => $file['image_type'],
                    'file' => $modelImage->getImagePath(),
                    'file_name' => $modelImage->getFileName(),
                    'file_size' => $modelImage->getFileSize(),
                    'id' => $modelImage->id,
                    'type' => $modelImage->getImageTypeID(),
                    'options' => $modelImage->getOptionsArray(),
                    'w' => $modelImage->getWidth(),
                    'h' => $modelImage->getHeight(),
                );
            }else{
                // добавляем связь с картинкой
                $modelImage->clear();
                if($this->saveFile($file['file_name'], $file['file'], $file['type'], $file['options'], $modelImage, $model, $sitePageData, $driver)){
                    $files[] = array(
                        'title' => $file['title'],
                        'image_type' => $file['image_type'],
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
            }
        }

        if ($isAddFiles){
            $files = array_merge($model->getFilesArray(), $files);
            $model->setFilesArray($files);
            if (count($files) > 0) {
                $model->setImagePath($files[0]['file']);
            } else {
                $model->setImagePath('');
            }
        }else {
            // удаляем ссылки с файлов на объект
            $currentFiles = $model->getFilesArray();
            foreach ($currentFiles as $currentFile) {
                if ((!is_array($currentFile)) || (!key_exists('id', $currentFile))) {
                    continue;
                }
                $id = $currentFile['id'];
                $b = FALSE;
                foreach ($files as $file) {
                    if ($file['id'] == $id) {
                        $b = TRUE;
                        break;
                    }
                }

                if ($b === FALSE) {
                    if (Helpers_DB::getDBObject($modelImage, $id, $sitePageData)) {
                        $arr = $modelImage->getShopObjectLanguageIDsArray();

                        $tmpID = $model->id . '-' . $sitePageData->dataLanguageID;
                        if (!key_exists($tmpID, $arr)) {
                            unset($arr[$tmpID]);
                        }

                        $modelImage->setShopObjectLanguageIDsArray($arr);
                        Helpers_DB::saveDBObject($modelImage, $sitePageData);
                    }
                }
            }

            $model->setFilesArray($files);
            if (count($files) > 0) {
                $model->setImagePath($files[0]['file']);
            } else {
                $model->setImagePath('');
            }
        }

        return TRUE;
    }

    /**
     * Сохраняем фотографию
     * @param $fileIndexes
     * @param $isDels
     * @param $filePaths
     * @param array $currentFiles
     * @param $id
     * @param $tableID
     * @param SitePageData $sitePageData
     * @return array|bool
     */
    public function saveImages($fileIndexes, $isDels, $filePaths, array $currentFiles, $id, $tableID, SitePageData $sitePageData) {
        if ((! is_array($fileIndexes))
            || (! is_array($isDels))
            || (! is_array($filePaths))
            || (count($fileIndexes) == 0)
            || (count($fileIndexes) != count($isDels))
            || (count($fileIndexes) != count($filePaths))
        ) {
            return $currentFiles;
        }

        // добавляем новые файлы
        $newPath = $this->_getPath($tableID, $id).'files'.DIRECTORY_SEPARATOR;
        $tmpPath = DOCROOT . 'tmp_files' . DIRECTORY_SEPARATOR;

        for($i = 0; $i < count($filePaths); $i++){
            $s = str_replace('\\', '', $filePaths[$i]);
            if(empty($s)){
                continue;
            }

            // добавляем фотографию, при дублировании из предыдущего товара
            if(strpos($s, $sitePageData->scheme) > -1){
                $isAdd = TRUE;
                foreach($currentFiles as $currentFile){
                    if($currentFile['file'] == $s){
                        $isAdd = FALSE;
                        break;
                    }
                }
                if($isAdd === TRUE){
                    $currentFiles[] = array('type' => Model_ImageType::IMAGE_TYPE_IMAGE, 'file' => $s);
                    $fileIndex[$i] = count($currentFiles) - 1;
                }

                continue;
            }

            $filePath = $tmpPath . str_replace('/', '', $s);
            if (!file_exists($filePath)) {
                continue;
            }

            $newFile = $tmpPath;
            for($j = $i; $j < 10000; $j++){
                if (! file_exists($newPath.$j.DIRECTORY_SEPARATOR)) {
                    $newFile = $newPath.$j.DIRECTORY_SEPARATOR;
                    break;
                }
            }
            $newFile = $this->_getPathFile($newFile, $i + 1, $filePath);

            $result = $this->_saveFile($filePath, $newFile);

            if ($result === TRUE) {
                $index = $fileIndexes[$i];
                if(($index >= 0) && (key_exists($index, $currentFiles))) {
                    $currentFiles[$index] = array('type' => Model_ImageType::IMAGE_TYPE_IMAGE, 'file' => $this->basicURL . '/' . str_replace("\\", '/', $newFile));
                }else{
                    if($this->isDeleteFile){
                        unlink($filePath);
                    }

                    $currentFiles[] = array('type' => Model_ImageType::IMAGE_TYPE_IMAGE, 'file' => $this->basicURL . '/' . str_replace("\\", '/', $newFile));
                    $fileIndex[$i] = count($currentFiles) - 1;
                }
            }
        }

        // ставим по прядку файлы
        $result = array();
        for($i = 0; $i < count($fileIndexes); $i++) {
            $index = $fileIndexes[$i];
            if($index == ''){
                $index = $i;
            }

            if(key_exists($index, $currentFiles)){
                if($isDels[$i]){
                    //$this->removeDirectory(pathinfo($currentFiles[$index]['file'], PATHINFO_DIRNAME));
                }else{
                    $result[] = array('type' => Model_ImageType::IMAGE_TYPE_IMAGE, 'file' => $currentFiles[$index]['file']);
                }
            }
        }

        return $result;
    }

    /**
     * Сохраняем фотографию
     * @param string $filePath
     * @param integer $id
     */
    public function addImages(array $filePaths, $id, $tableID) {
        if ((count($filePaths) == 0)) {
            return array();
        }

        // добавляем новые файлы
        $newPath = $this->_getPath($tableID, $id).'files'.DIRECTORY_SEPARATOR;
        $result = array();
        $i = 0;
        foreach($filePaths as $value){
            $filePath = $value['tmp_name'];
            if (!file_exists($filePath)) {
                continue;
            }
            $newFile = $newPath. $i.DIRECTORY_SEPARATOR;
            $newFile = $this->_getPathFile($newFile, $i++, $value['name']);
            $b = $this->_saveFile($filePath, $newFile);

            if ($b === TRUE) {
                $result[] = array('type' => Model_ImageType::IMAGE_TYPE_IMAGE, 'file' => $this->basicURL . '/' . str_replace("\\", '/', $newFile));
            }
        }

        return $result;
    }

    /**
     * Сохраняем любой файл
     * @param $file string | array
     * @param $id
     * @param $tableID
     * @param SitePageData $sitePageData
     * @return mixed|string
     */
    public function saveDownloadFilePath($file, $id, $tableID, SitePageData $sitePageData) {
        if(is_array($file)){
            $filePath = Arr::path($file, 'tmp_name', '');
            $fileName = Arr::path($file, 'name', '');
        }else{
            $filePath = $file;
            $fileName = $file;
        }

        if(strpos($filePath, $sitePageData->scheme) === 0){
            return $filePath;
        }

        if (!file_exists($filePath)) {
            return '';
        }

        $newPath = $this->_getPath($tableID, $id, 'files');

        // проверяем есть ли уже данный файл и находим следующую по очереди файл
        $newFile = $this->_getPathFile($newPath, $id, $fileName, $sitePageData->dataLanguageID);
        if(file_exists(DOCROOT . $newFile)) {
            for ($j = 1; $j < 10000; $j++) {
                $s = $this->_getPathFile($newPath, $id.'_'.$j, $fileName, $sitePageData->dataLanguageID);
                if (!file_exists(DOCROOT. $s)) {
                    $newFile = $s;
                    break;
                }
            }
        }

        $result = $this->_saveFile($filePath, DOCROOT.$newFile);

        if ($result === TRUE) {
            return $this->basicURL . '/' . str_replace("\\", '/', $newFile);
        }

        return '';
    }

    /**
     * Добавляем файл в начала списка
     * @param $filePath
     * @param Model_Basic_Files $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return bool
     */
    public function addImageInModel($filePath, Model_Basic_Files $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver) {
        if(is_array($filePath)){
            if(!file_exists($filePath['tmp_name'])){
                return FALSE;
            }
        }else {
            if (!file_exists($filePath)) {
                return FALSE;
            }

            $filePath = array(
                'tmp_name' => $filePath,
                'name' => pathinfo($filePath, PATHINFO_FILENAME),
            );
        }

        $modelImage = new Model_Shop_Image();
        $modelImage->setDBDriver($driver);

        // добавляем связь с картинкой
        $modelImage->clear();
        if($this->saveFile($filePath['name'], $filePath['tmp_name'], Model_ImageType::IMAGE_TYPE_IMAGE, array(), $modelImage, $model, $sitePageData, $driver)){
            $files = array(
                'title' => '',
                'file' => $modelImage->getImagePath(),
                'file_name' => $modelImage->getFileName(),
                'file_size' => $modelImage->getFileSize(),
                'id' => $modelImage->id,
                'type' => $modelImage->getImageTypeID(),
                'options' => $modelImage->getOptionsArray(),
                'w' => $modelImage->getWidth(),
                'h' => $modelImage->getHeight(),
            );

            $model->setFilesArray(array_merge(array($files), $model->getFilesArray()));
            $model->setImagePath($modelImage->getImagePath());
        }else {
            return FALSE;
        }

        return TRUE;
    }


    /**
     * Добавляем файл из ссылки в начала списка
     * @param $url
     * @param Model_Basic_Files $model
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @param bool $isFirstImage
     * @param bool $isAddImage
     * @param string $title
     * @return bool|string
     */
    public function addImageURLInModel($url, Model_Basic_Files $model, SitePageData $sitePageData,
      Model_Driver_DBBasicDriver $driver, $isFirstImage = TRUE, $isAddImage = TRUE, $title = '') {

        // скачиваем файл по URL
        $path = DOCROOT.'tmp_files'.DIRECTORY_SEPARATOR.microtime(TRUE);
        while(file_exists($path.'.tmp')){
            $path = $path .microtime(TRUE);
        }
        $path = $path.'.tmp';
        Helpers_URL::getFileURLEmulationBrowser($url, $path);

        $modelImage = new Model_Shop_Image();
        $modelImage->setDBDriver($driver);

        // добавляем связь с картинкой
        $modelImage->clear();

        $n = strpos($url, '?');
        if($n !== FALSE){
            $url = substr($url, 0, $n);
        }
        if($this->saveFile(pathinfo($url, PATHINFO_BASENAME), $path, Model_ImageType::IMAGE_TYPE_IMAGE, array(), $modelImage, $model, $sitePageData, $driver)){
            $files = array(
                'title' => $title,
                'file' => $modelImage->getImagePath(),
                'file_name' => $modelImage->getFileName(),
                'file_size' => $modelImage->getFileSize(),
                'id' => $modelImage->id,
                'type' => $modelImage->getImageTypeID(),
                'options' => $modelImage->getOptionsArray(),
                'w' => $modelImage->getWidth(),
                'h' => $modelImage->getHeight(),
            );

            if ($isAddImage) {
                if ($isFirstImage || Func::_empty($model->getImagePath())) {
                    $model->setFilesArray(array_merge(array($files), $model->getFilesArray()));
                    $model->setImagePath($modelImage->getImagePath());
                } else {
                    $model->setFilesArray(array_merge($model->getFilesArray(), array($files)));
                }
            }else{
                return $modelImage->getImagePath();
            }
        }else {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Сохраняем файлы
     * @param string $filePath
     * @param integer $id
     */
    public function saveAdditionFiles($files, Model_Basic_Files $model, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver, $isAddFiles = FALSE) {
        if($files === NULL){
            return FALSE;
        }

        foreach($files as $file){
            if(is_array($file)
                && (key_exists('title', $file))
                && (key_exists('url', $file))
                && (key_exists('type', $file))) {
                $arr = array(
                    'title' => $file['title'],
                    'file' => $file['url'],
                    'type' => $file['type'],
                    'options' => array(),
                );

                $arr['id'] = intval(Arr::path($file, 'id', ''));
                $arr['file_name'] = Arr::path($file, 'file_name', '');
                if(is_array($arr['file_name'])){
                    $arr['file_name'] = '';
                }

                if((key_exists('options', $file)) && (is_array($file['options']))){
                    $arr['options'] = $file['options'];
                }

                if (!empty($file['url'])) {
                    $result[] = $arr;
                }
            }
        }

        $modelImage = new Model_Shop_Image();
        $modelImage->setDBDriver($driver);

        $files = array();
        foreach($result as $file){
            if($file['id'] > 0) {
                // если картинка существует, то добавляем связь
                if (Helpers_DB::getDBObject($modelImage, $file['id'], $sitePageData)) {
                    // добавляем связь файла и объекта
                    $arr = $modelImage->getShopObjectLanguageIDsArray();
                    $tmpID = $model->id . '-' . $sitePageData->dataLanguageID;
                    if (!key_exists($tmpID, $arr)) {
                        $arr[$tmpID] = array(
                            'id' => $model->id,
                            'language' => $sitePageData->dataLanguageID,
                        );
                    }
                }else{
                    $modelImage->clear();
                    $modelImage->setImagePath($file['file']);
                    $modelImage->setFileName($file['file_name']);
                    $modelImage->setImageTypeID($file['type']);
                    $modelImage->setOptionsArray($file['options']);

                    Helpers_DB::saveDBObject($modelImage, $sitePageData);
                }

                $files[] = array(
                    'title' => $file['title'],
                    'file' => $modelImage->getImagePath(),
                    'file_name' => $modelImage->getFileName(),
                    'file_size' => $modelImage->getFileSize(),
                    'id' => $modelImage->id,
                    'type' => $modelImage->getImageTypeID(),
                    'options' => $modelImage->getOptionsArray(),
                    'w' => $modelImage->getWidth(),
                    'h' => $modelImage->getHeight(),
                );
            }else{
                // добавляем связь с картинкой
                $modelImage->clear();
                if($this->saveFile($file['file_name'], $file['file'], $file['type'], $file['options'], $modelImage, $model, $sitePageData, $driver)){
                    $files[] = array(
                        'title' => $file['title'],
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
            }
        }

        if ($isAddFiles){
            $files = array_merge($model->getAdditionFilesArray(), $files);
            $model->setAdditionFilesArray($files);
        }else {
            // удаляем ссылки с файлов на объект
            $currentFiles = $model->getAdditionFilesArray();
            foreach ($currentFiles as $currentFile) {
                if ((!is_array($currentFile)) || (!key_exists('id', $currentFile))) {
                    continue;
                }
                $id = $currentFile['id'];
                $b = FALSE;
                foreach ($files as $file) {
                    if ($file['id'] == $id) {
                        $b = TRUE;
                        break;
                    }
                }

                if ($b === FALSE) {
                    if (Helpers_DB::getDBObject($modelImage, $id, $sitePageData)) {
                        $arr = $modelImage->getShopObjectLanguageIDsArray();

                        $tmpID = $model->id . '-' . $sitePageData->dataLanguageID;
                        if (!key_exists($tmpID, $arr)) {
                            unset($arr[$tmpID]);
                        }

                        $modelImage->setShopObjectLanguageIDsArray($arr);
                        Helpers_DB::saveDBObject($modelImage, $sitePageData);
                    }
                }
            }

            $model->setAdditionFilesArray($files);
        }

        return TRUE;
    }

}

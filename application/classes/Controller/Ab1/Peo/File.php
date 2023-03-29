<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Peo_File extends Controller_Ab1_Peo_BasicAb1 {


    public function action_loadimage() {

        ini_set('display_errors', 'on');

        if (!ImageFunc::IS_POST() || !$_FILES) {
            ImageFunc::stopAndResponseMessage('error', 'Только POST, FILES');
        }

        $files = ImageFunc::convertFileInformation($_FILES);

        if (!isset($files['file'])) {
            ImageFunc::stopAndResponseMessage('error', 'Файл не загружался');
        }

        $file = $files['file'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            ImageFunc::stopAndResponseMessage('error', ImageFunc::uploadCodeToMessage($file['error']));
        }

        $mimeType = ImageFunc::guessMimeType($file['tmp_name']);
        if (!$mimeType) {
            ImageFunc::stopAndResponseMessage('error', 'Тип файла не распознан.');
        }

        $validMimeType = array('image/png', 'image/jpeg', 'image/gif', 'image/tif', 'image/tiff');
        if (!in_array($mimeType, $validMimeType)) {
            ImageFunc::stopAndResponseMessage('error', 'Загружать можно только png, jpg, tiff.');
        }

        $size = filesize($file['tmp_name']);
        if ($size > 100 * 1024 * 1024) {
            ImageFunc::stopAndResponseMessage('error', 'Файл слишком большой.');
        }

        $uploadDir = DOCROOT . '/tmp_files';
        if (!is_writable($uploadDir)) {
            ImageFunc::stopAndResponseMessage('error', 'Папка для файлов не доступна для записи.');
        }

        $filename = time() . '-' . mt_rand(0000, 9999) . '.' . ImageFunc::guessFileExtension($mimeType);
        if (!move_uploaded_file($file['tmp_name'], $uploadDir . '/' . $filename)) {
            ImageFunc::stopAndResponseMessage('error', 'Файл не был перемещен.');
        }

        ImageFunc::sendResponse('upload', array('url' => $this->_sitePageData->url.'/tmp_files/' . $filename, 'file' => $filename, 'file_name' => $file['name']));

        #
        # if used php-fpm
        #   * send response (finish request)
        #   * clear old images (created >= 5 minutes ago)
        #
        if (!function_exists('fastcgi_finish_request'))
            exit;

        fastcgi_finish_request();

        ImageFunc::clearOldFiles($uploadDir, '/*.{jpg,png,jpeg}', 5);
    }

    /**
     * Загрузка дополнительный файлов
     */
    function action_loadaddimage_old(){
        // разрешенные форматы графических файлов (см. описание фукнции image_type_to_mime_type
        $images_exts = array(
            IMAGETYPE_GIF => 'gif',
            IMAGETYPE_JPEG => 'jpg',
            IMAGETYPE_PNG => 'png',
            IMAGETYPE_TIFF_II => 'tif',
            IMAGETYPE_TIFF_MM => 'tiff'
        );

        $file = '';
        if(!isset($_FILES['upload']) || !is_uploaded_file($_FILES['upload']['tmp_name'])){
            $message = 'Вы не указали файл для загрузки';
        }else {
            $is = @getimagesize($_FILES['upload']['tmp_name']);
            if (!isset($images_exts[$is[2]])) {
                $message = 'Необходимо указать файл формата ' . implode(', ', $images_exts);
            }else{
                if(!file_exists($_FILES['upload']['tmp_name'])) {
                    $message = 'Файл не был сохранен во временный каталог ' . $_FILES['upload']['name'];
                }else{
                    // шаблон магазина
                    $this->_readSiteShablonInterface($this->_sitePageData->shop->getSiteShablonID());

                    $name = Func::get_in_translate_to_en($_FILES['upload']['name']);
                    $dir = DOCROOT . 'data' . DIRECTORY_SEPARATOR . $this->_sitePageData->shopShablon->getShablonPath() . DIRECTORY_SEPARATOR;
                    Helpers_Path::createPath($dir);

                    $dir = $dir . $name;
                    if (!@move_uploaded_file($_FILES['upload']['tmp_name'], $dir)) {
                        $message = 'Невозможно сохранить файл, проверьте настройки папки для файлов ' . $_FILES['upload']['name'];
                    } else {
                        $message = '';//'Файл '.$_FILES['upload']['name'].' загружен';
                        $file = $this->_sitePageData->urlBasic . '/' . 'data' . '/' .
                            $this->_sitePageData->shopShablon->getShablonPath() . '/' . $name;
                    }
                }
            }
        }

        $callback = $_REQUEST['CKEditorFuncNum'];
        $this->response->body('<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'
            .$callback.'", "'.$file.'", "'.$message.'" );</script>');
    }

    /**
     * Загрузка дополнительный файлов
     */
    function action_loadaddimage(){
        $file = '';
        if(!isset($_FILES['upload']) || !is_uploaded_file($_FILES['upload']['tmp_name'])){
            $message = 'Вы не указали файл для загрузки';
        }else {
            $filename = $_FILES['upload']['tmp_name'];
            if (strtolower(pathinfo($filename, PATHINFO_EXTENSION)) == 'php') {
                $message = 'Нельзя загружать файлы с расширением php.';
            }else{
                if(!file_exists($filename)) {
                    $message = 'Файл не был сохранен во временный каталог ' . $_FILES['upload']['name'];
                }else{
                    // шаблон магазина
                    $this->_readSiteShablonInterface($this->_sitePageData->shop->getSiteShablonID());

                    $name = Func::get_in_translate_to_en($_FILES['upload']['name']);
                    $dir = DOCROOT . 'data' . DIRECTORY_SEPARATOR . $this->_sitePageData->shopShablon->getShablonPath() . DIRECTORY_SEPARATOR;
                    Helpers_Path::createPath($dir);

                    $dir = $dir . $name;
                    if (!@move_uploaded_file($filename, $dir)) {
                        $message = 'Невозможно сохранить файл, проверьте настройки папки для файлов ' . $_FILES['upload']['name'];
                    } else {
                        $message = '';//'Файл '.$_FILES['upload']['name'].' загружен';
                        $file = $this->_sitePageData->urlBasic . '/' . 'data' . '/' .
                            $this->_sitePageData->shopShablon->getShablonPath() . '/' . $name;
                    }
                }
            }
        }

        $callback = $_REQUEST['CKEditorFuncNum'];
        $this->response->body('<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'
            .$callback.'", "'.$file.'", "'.$message.'" );</script>');
    }

    /**
     * Получение списка дополнительных файлов
     */
    function action_getaddimages()
    {
       $path = DOCROOT.'css'.DIRECTORY_SEPARATOR.'_component'.DIRECTORY_SEPARATOR.'elfinder'.DIRECTORY_SEPARATOR.'php'.DIRECTORY_SEPARATOR;

        require $path.'autoload.php';

        elFinder::$netDrivers['ftp'] = 'FTP';

        // шаблон магазина
        $this->_readSiteShablonInterface($this->_sitePageData->shop->getSiteShablonID());
        $dir = DOCROOT . 'data' . DIRECTORY_SEPARATOR . $this->_sitePageData->shopShablon->getShablonPath() . DIRECTORY_SEPARATOR;

        $opts = array(
            'debug' => true,
            'roots' => array(
                array(
                    'driver'        => 'LocalFileSystem',           // driver for accessing file system (REQUIRED)
                    'path'          => $dir,                 // path to files (REQUIRED)
                    'URL'           => $this->_sitePageData->urlBasic.'/'.'data'.'/'.$this->_sitePageData->shopShablon->getShablonPath().'/', // URL to files (REQUIRED)
                    'uploadDeny'    => array('all'),                // All Mimetypes not allowed to upload
                  //  'uploadAllow'   => array('image', 'text/plain'),// Mimetype `image` and `text/plain` allowed to upload
                    'uploadOrder'   => array('deny', 'allow'),      // allowed Mimetype `image` and `text/plain` only
                )
            )
        );

        // run elFinder
        $connector = new elFinderConnector(new elFinder($opts));
        $connector->run();
    }

    public function action_loadfile() {
        if((! isset($_FILES['upl'])) || ($_FILES['upl']['error'] != 0)) {
            throw new HTTP_Exception_500('File error.');
        }else {
            $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
            $filename =  time() . '-' . mt_rand(0000, 9999) . '.' . $extension;
            if (!move_uploaded_file($_FILES['upl']['tmp_name'], DOCROOT . '/tmp_files/' . $filename)) {
                throw new HTTP_Exception_500('File error.');
            } else {
                echo $filename;
            }
        }

        exit;
    }
}

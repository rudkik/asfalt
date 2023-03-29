<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_File
{
    /**
     * Загрузить файл в папку tmp_files
     * @param SitePageData $sitePageData
     * @param bool $isReturnResult
     * @return array
     */
    public static function loadImage(SitePageData $sitePageData, bool $isReturnResult = TRUE) {

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

        $result = array(
            'url' => $sitePageData->urlBasic.'/tmp_files/' . $filename,
            'file' => $filename,
            'file_name' => $file['name']
        );
        ImageFunc::sendResponse('upload', $result);

        if($isReturnResult) {
            #
            # if used php-fpm
            #   * send response (finish request)
            #   * clear old images (created >= 5 minutes ago)
            #
            if (!function_exists('fastcgi_finish_request'))
                exit;

            fastcgi_finish_request();

            ImageFunc::clearOldFiles($uploadDir, '/*.{jpg,png,jpeg}', 5);
        }else{
            return $result;
        }
    }

    /**
     * Сохраняем данные в файл, предварительно создаем путь для файла
     * @param $basicPath
     * @param array $directories
     * @param $fileName
     * @param $data
     * @param int $flags [optional] <p>
     * The value of flags can be any combination of
     * the following flags (with some restrictions), joined with the binary OR
     * (|) operator.
     * </p>
     * <p>
     * <table>
     * Available flags
     * <tr valign="top">
     * <td>Flag</td>
     * <td>Description</td>
     * </tr>
     * <tr valign="top">
     * <td>
     * FILE_USE_INCLUDE_PATH
     * </td>
     * <td>
     * Search for filename in the include directory.
     * See include_path for more
     * information.
     * </td>
     * </tr>
     * <tr valign="top">
     * <td>
     * FILE_APPEND
     * </td>
     * <td>
     * If file filename already exists, append
     * the data to the file instead of overwriting it. Mutually
     * exclusive with LOCK_EX since appends are atomic and thus there
     * is no reason to lock.
     * </td>
     * </tr>
     * <tr valign="top">
     * <td>
     * LOCK_EX
     * </td>
     * <td>
     * Acquire an exclusive lock on the file while proceeding to the
     * writing. Mutually exclusive with FILE_APPEND.
     * @since 5.1.0
     * </td>
     * </tr>
     * </table>
     * </p>
     * @return bool
     */
    public static function saveInFile($basicPath, array $directories, $fileName, $data, $flag = FILE_APPEND){
        $path = Helpers_Path::getPathFile($basicPath, $directories);
        $result = Helpers_Path::createPath($path);

        $path .= $fileName;

        try{
            $result = file_put_contents($path, $data, $flag) !== false && $result;
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }


    /**
     * Сохраняем данные каталог logs в заданный файл
     * @param $fileName
     * @param $data
     * @param array|null $directories
     * @param int $flag
     * @return bool
     */
    public static function saveInLogs($fileName, $data, array $directories = null, $flag = FILE_APPEND){
        $path = Helpers_Path::getPathFile(APPPATH, ['logs']);

        if(is_array($directories)){
            $path = Helpers_Path::getPathFile($path, $directories);
            Helpers_Path::createPath($path);
        }

        $path .= $fileName;

        if(is_array($data)){
            $data = print_r($data, true);
        }

        try{
            $result = file_put_contents($path, Date::formatted_time('now').': ' . $data . "\r\n", $flag) !== false;
        } catch (Exception $e) {
            $result = false;
        }

        return $result;
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Для разрешения приложения
 * credentials.json - настройки подключения https://developers.google.com/calendar/quickstart/php
 * token.json - токен подключения (при выполнени команды: php application\vendor\GoogleCalendar\quickstart.php)
 * Файлы должны храниться в views + шаблон + google/disk
 * Class Drivers_Google_Disk
 */
class Drivers_Google_Disk {

    /**
     * @var Google_Client
     */
    private $client;
    /**
     * @var Google_Service_Drive
     */
    private $service = null;
    /**
     * Часовой пояс
     * @var string
     */
    private $timeZone;
    /**
     * ID календаря
     * @var string
     */
    private $calendarID = 'primary';

    public function __construct()
    {
        require_once APPPATH . 'vendor/GoogleCalendar/vendor/autoload.php';

        $this->client = new Google_Client();
        $this->client->setScopes(Google_Service_Drive::DRIVE);

        $this->timeZone = date_default_timezone_get();
    }

    /**
     * Авторизация
     * Требуются файлы:
     * credentials.json - настройки подключения https://developers.google.com/calendar/quickstart/php
     * token.json - токен подключения (при выполнени команды: php quickstart.php)
     * Файлы должны храниться в views + шаблон + google-calendar
     * @param SitePageData $sitePageData
     * @return Google_Client
     * @throws HTTP_Exception_500
     */
    public function auth(SitePageData $sitePageData){
        $path = Helpers_Path::getPathFile(
            APPPATH,
            ['views', $sitePageData->shopShablonPath, 'google' . DIRECTORY_SEPARATOR . 'disk']
        );

        if(!file_exists($path . 'credentials.json')){
            throw new HTTP_Exception_500('File auth config ' . $path . 'credentials.json not found.');
        }
        if(!file_exists($path . 'token.json')){
            throw new HTTP_Exception_500('File access token '  .$path . 'token.json not found.');
        }

        $this->client->setAuthConfig($path . 'credentials.json');
        $accessToken = json_decode(file_get_contents($path . 'token.json'), true);
        $this->client->setAccessToken($accessToken);

        return $this->client;
    }

    /**
     * Создаем папку
     * @param $name
     * @param string $parentID
     * @param string $description
     * @return Google_Service_Drive_DriveFile
     */
    public function createDirectory($name, $parentID = '', $description = ''){
        $service = $this->getService();

        $directory = new Google_Service_Drive_DriveFile();
        $directory->setName($name);
        $directory->setDescription($description);
        $directory->setMimeType('application/vnd.google-apps.folder');
        $directory->setParents(array());

        // привязываем к родителю
        if(!empty($parentID)) {
            $directory->setParents(array($parentID));
        }

        return $service->files->create($directory);
    }

    /**
     * Получаем / создаем id каталога по пути
     * @param $pathDisk
     * @return string
     */
    public function getParentIDByPath($pathDisk){
        if(empty($pathDisk)){
            return null;
        }

        $service = $this->getService();

        $pathDisk = str_replace('\\', '/', $pathDisk);
        $pathDisks = explode('/', $pathDisk);

        $root = '';
        $rootName = array_shift($pathDisks);
        $directories = $service->files->listFiles(
            array(
                'q' => "mimeType='application/vnd.google-apps.folder' and name='" . $rootName . "'",
            )
        );

        /** @var Google_Service_Drive_DriveFile $file */
        foreach ($directories->getFiles() as $directory){
            $root = $directory->getId();
        }

        // если папка не найдена, то создаем ее
        if(empty($root)){
            $root = $this->createDirectory($rootName)->getId();
        }

        foreach ($pathDisks as $path){
            $directories = $service->files->listFiles(
                array(
                    'q' => "'" . $root . "' in parents and mimeType='application/vnd.google-apps.folder' and name='" . $path . "'",
                )
            );

            $child = '';
            /** @var Google_Service_Drive_DriveFile $file */
            foreach ($directories->getFiles() as $directory){
                $child = $directory->getId();
            }

            // если папка не найдена, то создаем ее
            if(empty($child)){
                $child = $this->createDirectory($path, $root)->getId();
            }

            $root = $child;
        }
        return $root;
    }

    /**
     * Удаляем файл с диска
     * @param $fileName
     * @param string $pathDisk - путь до файла
     */
    public function deleteFile($fileName, $pathDisk = ''){
        $service = $this->getService();

        if(empty($pathDisk)){
            $files = $service->files->listFiles(
                array(
                    'q' => "mimeType!='application/vnd.google-apps.folder' and name='" . $fileName . "'",
                )
            );
        }else {
            $root = $this->getParentIDByPath($pathDisk);
            $files = $service->files->listFiles(
                array(
                    'q' => "'" . $root . "' in parents and mimeType!='application/vnd.google-apps.folder' and name='" . $fileName . "'",
                )
            );
        }

        // удаляем найденные файлы
        /** @var Google_Service_Drive_DriveFile $file */
        foreach ($files->getFiles() as $file){
            $service->files->delete($file->getId());
        }
    }

    /**
     * Вставляем файл на диск
     * @param $fileName
     * @param string $pathDisk - путь для сохранения
     * @param string $description
     * @return Google_Service_Drive_DriveFile
     */
    public function insertFile($fileName, $pathDisk = '', $description = ''){
        $service = $this->getService();

        $mimeType = mime_content_type($fileName);

        $file = new Google_Service_Drive_DriveFile();
        $file->setName(basename($fileName));
        $file->setDescription($description);
        $file->setMimeType($mimeType);

        // создаем путь для сохранения файла
        if(!empty($pathDisk)){
            $file->setParents(
                array(
                    $this->getParentIDByPath($pathDisk)
                )
            );
        }

        $data = file_get_contents($fileName);
        $createdFile = $service->files->create(
            $file,
            array(
                'data' => $data,
                'mimeType' => $mimeType,
                'uploadType' => 'multipart'
            )
        );

        return $createdFile;
    }

    /**
     * Подключение к календарю
     * @return Google_Client
     */
    public function getClient(){
        return $this->client;
    }

    /**
     * Сервис работы с данными диска
     * @return Google_Service_Drive
     */
    public function getService(){
        if(empty($this->service)) {
            $this->service = new Google_Service_Drive($this->client);
        }

        return $this->service;
    }

    /**
     * Часовой пояс
     * @return string
     */
    public function getTimeZone(){
        return $this->timeZone;
    }

    /**
     * Часовой пояс
     * @param $value
     */
    public function setTimeZone($value){
        $this->timeZone = $value;
    }
}
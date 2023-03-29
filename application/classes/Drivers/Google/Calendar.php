<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Для разрешения приложения
 * credentials.json - настройки подключения https://developers.google.com/drive/api/v3/quickstart/php?hl=ru
 * token.json - токен подключения (при выполнени команды: php application\vendor\GoogleCalendar\quickstart.php)
 * Файлы должны храниться в views + шаблон + google/calendar
 * Class Drivers_Google_Calendar
 */
class Drivers_Google_Calendar {

    /**
     * @var Google_Client
     */
    private $client;
    /**
     * @var Google_Service_Calendar
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
        $this->client->setScopes(Google_Service_Calendar::CALENDAR);

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
            ['views', $sitePageData->shopShablonPath, 'google'.DIRECTORY_SEPARATOR.'calendar']
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
     * По названию календаря находим его ID
     * @param $name
     * @return string
     */
    public function getCalendarIDByName($name){
        $service = $this->getService();

        $name = mb_strtolower($name);
        foreach ($service->calendarList->listCalendarList()->getItems() as $calendar){
            if(mb_strtolower($calendar->summary) == $name){
                return $calendar->id;
            }
        }
        return '';
    }

    /**
     * Добавление события в календарь
     * @param $name - название
     * @param $description
     * @param $dateFrom
     * @param $dateTo
     * @param int $reminder - за сколько времени напоминать
     * @return Google_Service_Calendar_Event
     */
    public function addEvent($name, $description, $dateFrom, $dateTo, $reminder = 10){
        $service = $this->getService();

        $event = new Google_Service_Calendar_Event(
            array(
                'summary' => $name,
                'description' => $description,
                'start' => array(
                    'dateTime' => Helpers_DateTime::getDateTimeISO8601($dateFrom),
                    'timeZone' => $this->timeZone,
                ),
                'end' => array(
                    'dateTime' => Helpers_DateTime::getDateTimeISO8601($dateTo),
                    'timeZone' => $this->timeZone,
                ),
                'reminders' => array(
                    'useDefault' => FALSE,
                    'overrides' => array(
                        array('method' => 'popup', 'minutes' => $reminder),
                    ),
                ),
            )
        );

        $event = $service->events->insert($this->calendarID, $event);
        return $event;
    }

    /**
     * Удаления события из календаря
     * @param $eventID
     * @return expectedClass|Google_Http_Request
     */
    public function delEvent($eventID){
        $service = $this->getService();
        return $service->events->delete($this->calendarID, $eventID);
    }

    /**
     * Изменяем событие в календаре
     * @param $eventID
     * @param $name - название
     * @param $description
     * @param $dateFrom
     * @param $dateTo
     * @param int $reminder - за сколько времени напоминать
     * @return Google_Service_Calendar_Event
     */
    public function editEvent($eventID, $name, $description, $dateFrom, $dateTo, $reminder = 10){
        if(empty($eventID)){
            return $this->addEvent($name, $description, $dateFrom, $dateTo, $reminder);
        }

        $service = $this->getService();

        $event = new Google_Service_Calendar_Event(
            array(
                'summary' => $name,
                'description' => $description,
                'start' => array(
                    'dateTime' => Helpers_DateTime::getDateTimeISO8601($dateFrom),
                    'timeZone' => $this->timeZone,
                ),
                'end' => array(
                    'dateTime' => Helpers_DateTime::getDateTimeISO8601($dateTo),
                    'timeZone' => $this->timeZone,
                ),
                'reminders' => array(
                    'useDefault' => FALSE,
                    'overrides' => array(
                        array('method' => 'popup', 'minutes' => $reminder),
                    ),
                ),
            )
        );

        $event = $service->events->update($this->calendarID, $eventID, $event);
        return $event;
    }

    /**
     * Подключение к календарю
     * @return Google_Client
     */
    public function getClient(){
        return $this->client;
    }

    /**
     * Сервис работы с данными календаря
     * @return Google_Service_Calendar
     */
    public function getService(){
        if(empty($this->service)) {
            $this->service = new Google_Service_Calendar($this->client);
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

    /**
     * ID календаря
     * @return string
     */
    public function getCalendarID(){
        return $this->calendarID;
    }

    /**
     * ID календаря
     * @param $value
     */
    public function setCalendarID($value){
        $this->calendarID = $value;
    }
}
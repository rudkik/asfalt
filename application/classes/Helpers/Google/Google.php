<?php defined('SYSPATH') or die('No direct script access.');

class Helpers_Google_Google {

    /**
     * Добавление события в календарь
     * @param SitePageData $sitePageData
     * @param $calendarName - название календаря
     * @param $name - название
     * @param $description
     * @param $dateFrom
     * @param $dateTo
     * @param int $reminder - за сколько времени напоминать
     * @return string
     */
    public static function addEventCalendar(SitePageData $sitePageData, $calendarName, $name, $description, $dateFrom, $dateTo, $reminder = 10){
        $googleCalendar = new Helpers_Google_Calendar();
        $googleCalendar->auth($sitePageData);

        // определяем календарь
        $calendarID = $googleCalendar->getCalendarIDByName($calendarName);
        if(!empty($calendarID)){
            $googleCalendar->setCalendarID($calendarID);
        }

        $event = $googleCalendar->addEvent(
            $name, $description, $dateFrom, $dateTo, $reminder
        );
        return $event->id;
    }

    /**
     * Изменяем события в календаре
     * @param SitePageData $sitePageData
     * @param $calendarName - название календаря
     * @param $eventID
     * @param $name - название
     * @param $description
     * @param $dateFrom
     * @param $dateTo
     * @param int $reminder - за сколько времени напоминать
     * @return string
     */
    public static function editEventCalendar(SitePageData $sitePageData, $calendarName, $eventID, $name, $description,
                                             $dateFrom, $dateTo, $reminder = 10){
        $googleCalendar = new Helpers_Google_Calendar();
        $googleCalendar->auth($sitePageData);

        // определяем календарь
        $calendarID = $googleCalendar->getCalendarIDByName($calendarName);
        if(!empty($calendarID)){
            $googleCalendar->setCalendarID($calendarID);
        }

        $event = $googleCalendar->editEvent(
            $eventID, $name, $description, $dateFrom, $dateTo, $reminder
        );
        return $event->id;
    }

    /**
     * Удаления события из календаря
     * @param SitePageData $sitePageData
     * @param $calendarName - название календаря
     * @param $eventID
     * @return expectedClass|Google_Http_Request
     */
    public static function delEventCalendar(SitePageData $sitePageData, $calendarName, $eventID){
        $googleCalendar = new Helpers_Google_Calendar();
        $googleCalendar->auth($sitePageData);

        // определяем календарь
        $calendarID = $googleCalendar->getCalendarIDByName($calendarName);
        if(!empty($calendarID)){
            $googleCalendar->setCalendarID($calendarID);
        }

        $googleCalendar->delEvent($eventID);
    }
}
<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Calendar_BasicCalendar extends Controller_Calendar_BasicList
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'calendar';

        parent::__construct($request, $response);

        $this->_sitePageData->actionURLName = 'calendar';
    }
}
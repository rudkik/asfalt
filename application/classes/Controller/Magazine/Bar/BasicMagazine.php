<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Bar_BasicMagazine extends Controller_Magazine_All
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'bar';
        $this->prefixView = 'bar';

        parent::__construct($request, $response);

        $this->_sitePageData->actionURLName = 'bar';
    }
}
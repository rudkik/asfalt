<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_BasicAb1 extends Controller_Ab1_All
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'ab1-admin';
        $this->prefixView = 'admin';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'ab1-admin';
    }

}
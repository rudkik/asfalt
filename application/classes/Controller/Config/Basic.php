<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Config_Basic extends Controller_Config_All
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'config';
        $this->prefixView = 'config';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'config';
    }

}
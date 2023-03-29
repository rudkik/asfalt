<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Nur_Admin_BasicNur extends Controller_Nur_BasicList
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'admin';
        $this->sessionKey = 'nur-admin';

        parent::__construct($request, $response);

        $this->_sitePageData->actionURLName = 'nur-admin';
    }
}
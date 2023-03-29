<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Accounting_BasicMagazine extends Controller_Magazine_All
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'accounting';
        $this->prefixView = 'accounting';

        parent::__construct($request, $response);

        $this->_sitePageData->actionURLName = 'accounting';
    }
}
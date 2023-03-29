<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Finance_Admin_Basic extends Controller_Finance_All
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'admin';
        $this->prefixView = 'admin';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'admin';

        $this->limit = 0;
    }


}
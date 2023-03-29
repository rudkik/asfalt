<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Smg_Market_Basic extends Controller_Smg_All
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'market';
        $this->prefixView = 'market';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'market';

        $this->limit = 0;
    }


}
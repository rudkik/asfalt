<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Nur_Bookkeeping_BasicNur extends Controller_Nur_BasicList
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'bookkeeping';
        $this->sessionKey = 'nur-bookkeeping';

        parent::__construct($request, $response);

        $this->_sitePageData->actionURLName = 'nur-bookkeeping';
    }
}
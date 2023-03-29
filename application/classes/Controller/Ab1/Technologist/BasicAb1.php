<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Technologist_BasicAb1 extends Controller_Ab1_All
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'technologist';
        $this->prefixView = 'technologist';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'technologist';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_TECHNOLOGIST;
    }
}
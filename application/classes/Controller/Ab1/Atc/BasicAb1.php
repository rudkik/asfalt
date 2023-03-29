<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Atc_BasicAb1 extends Controller_Ab1_All
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'atc';
        $this->prefixView = 'atc';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'atc';
        $this->_sitePageData->interfaceID = Model_Ab1_Shop_Operation::RUBRIC_ATC;
    }

}
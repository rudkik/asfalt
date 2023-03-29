<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Workflow_BasicAb1 extends Controller_Ab1_All
{
    public function __construct(Request $request, Response $response)
    {
        $this->actionURLName = 'workflow';
        $this->prefixView = 'workflow';

        parent::__construct($request, $response);
        $this->_sitePageData->actionURLName = 'workflow';
    }
}
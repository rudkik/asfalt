<?php
$type = Request_RequestParams::getParamInt('type');
$view = View::factory('smmarket/sadmin/35/shopbranches/index-'.$type);
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
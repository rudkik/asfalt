<?php
$type = Request_RequestParams::getParamInt('type');
$view = View::factory('smmarket/sadmin/35/shopbranch/new-'.$type);
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
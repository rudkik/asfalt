<?php
$view = View::factory($siteData->shopShablonPath.'/36/maps');
$view->siteData = $siteData;
echo Helpers_View::viewToStr($view);
?>
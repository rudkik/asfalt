<?php
$view = View::factory($siteData->shopShablonPath.'/35/maps');
$view->siteData = $siteData;
echo Helpers_View::viewToStr($view);
?>
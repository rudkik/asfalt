<?php
$view = View::factory('cabinet/35/shopinformationdatacatalog/_shopmenu');
$view->siteData = $siteData;
$view->data = $data;
$view->isShowMenuAll = TRUE;
echo Helpers_View::viewToStr($view);
?>
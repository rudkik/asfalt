<?php
$view = View::factory('cabinet/35/shopnewcatalog/_shopmenu');
$view->siteData = $siteData;
$view->data = $data;
$view->isShowMenuAll = TRUE;
echo Helpers_View::viewToStr($view);
?>
<?php
$view = View::factory('cabinet/35/shop/table/catalog/_shopmenu');
$view->siteData = $siteData;
$view->data = $data;
$view->isShowMenuAll = FALSE;
echo Helpers_View::viewToStr($view);
?>
<?php
$view = View::factory('cabinet/35/_shop/_table/catalog/one/new/shop-car');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
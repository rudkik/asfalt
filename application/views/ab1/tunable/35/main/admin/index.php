<?php
$view = View::factory('ab1/admin/35/menu');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
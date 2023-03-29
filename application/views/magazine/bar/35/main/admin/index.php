<?php
$view = View::factory('magazine/admin/35/index');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>

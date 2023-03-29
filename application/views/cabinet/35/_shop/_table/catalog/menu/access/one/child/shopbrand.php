<?php
$view = View::factory('cabinet/35/_shop/_table/catalog/menu/access/one/child/_shop-table-basic');
$view->siteData = $siteData;
$view->data = $data;
$view->isShowMenuAll = TRUE;
$view->name = 'shoptablebrand';
echo Helpers_View::viewToStr($view);
?>
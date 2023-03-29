<?php
$type = $data->values['shop_branch_type_id'];
$view = View::factory('smmarket/sadmin/35/shopbranch/edit-'.$type);
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
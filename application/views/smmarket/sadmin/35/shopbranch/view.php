<?php
$type = $data->values['shop_branch_type_id'];
$view = View::factory('smmarket/sadmin/35/shopbranch/view-'.$type);
$view->siteData = $siteData;
$view->data = $data;
$view->select = $select;
echo Helpers_View::viewToStr($view);
?>
<?php
if($siteData->shopID == $data->id) {
    $view = View::factory('smmarket/supplier/35/shopbranch/edit-supplier');
}else{
    $view = View::factory('smmarket/supplier/35/shopbranch/edit-customer');
}
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
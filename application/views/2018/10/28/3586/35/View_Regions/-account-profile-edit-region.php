<?php
$regionID = 'data-id="'.Request_RequestParams::getParamInt('region-id').'""';
foreach ($data['view::View_Region\-account-profile-edit-region']->childs as $value){
    echo str_replace($regionID, $regionID.' selected', $value->str);
}
die;
?>

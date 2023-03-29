<?php
$cityID = 'data-id="'.Request_RequestParams::getParamInt('city-id').'""';
foreach ($data['view::View_City\-account-profile-edit-goroda']->childs as $value){
    echo str_replace($cityID, $cityID.' selected', $value->str);
}
die;
?>

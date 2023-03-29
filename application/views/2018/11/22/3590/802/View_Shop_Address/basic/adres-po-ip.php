<?php
$arr = array();
$data->values['comment'] = '';
$address = Helpers_Address::getAddressStr($siteData, $data->values, ', ', TRUE, FALSE);
foreach ($data->values['land_ids'] as $land){
    $arr[$land] = $address;
}
echo json_encode($arr);
?>
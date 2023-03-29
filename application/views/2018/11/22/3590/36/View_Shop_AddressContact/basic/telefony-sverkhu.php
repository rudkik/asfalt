<?php
$arr = array();
$address = Func::getContactHTMLRus($data->values, FALSE, TRUE);
foreach ($data->values['land_ids'] as $land){
    $arr[$land] = $address;
}
echo json_encode($arr);
?>
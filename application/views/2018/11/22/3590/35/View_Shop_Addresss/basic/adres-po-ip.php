<?php
$arr = array();
foreach ($data['view::View_Shop_Address\basic\adres-po-ip']->childs as $value){
    $tmp = json_decode($value->str, TRUE);
    foreach ($tmp as $k => $v){
        $arr[$k] = $v;
    }
}
$landID = Helpers_IP::getCountryIDByIP('', $siteData, GlobalData::newModelDriverDBSQLMem());
echo Arr::path($arr, $landID, Arr::path($arr, 0, ''));
?>
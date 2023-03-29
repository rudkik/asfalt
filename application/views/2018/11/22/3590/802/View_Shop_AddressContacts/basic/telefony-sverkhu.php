<?php
$arr = array();
foreach ($data['view::View_Shop_AddressContact\basic\telefony-sverkhu']->childs as $value){
    $tmp = json_decode($value->str, TRUE);
    foreach ($tmp as $k => $v){
        if(key_exists($k, $arr)){
            if($arr[$k]['count'] < 2) {
                $arr[$k]['value'] .= $v;
                $arr[$k]['count']++;
            }
        }else {
            $arr[$k] = array(
                'value' => $v,
                'count' => 1,
            );
        }
    }
}
$landID = Helpers_IP::getCountryIDByIP('', $siteData, GlobalData::newModelDriverDBSQLMem());
$v = Arr::path($arr, $landID, Arr::path($arr, 0, array('value' => '')));
echo $v['value'];
?>
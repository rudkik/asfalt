[<?php
$s = '';
foreach ($data['view::View_Shop_Calendar\scheduleevents-sobytiya-kalendarya']->childs as $value){
    if(!empty($value->str)) {
        $s .= $value->str . ',';
    }
}
echo substr($s, 0, -1);
?>]<?php die; ?>
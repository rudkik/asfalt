<?php
$i = 1;
$count = count($data['view::View_Shop_New\-main-slaider-na-glavnoi']->childs);
$count = '0000000000'.$count;
$count = substr($count, strlen($count) - 2);
foreach ($data['view::View_Shop_New\-main-slaider-na-glavnoi']->childs as $value){
    $n = '0000000000'.$i;
    $n = substr($n, strlen($n) - 2);
    echo str_replace('#index#', $n, str_replace('#count#', $count, $value->str));
    $i++;
}
?>
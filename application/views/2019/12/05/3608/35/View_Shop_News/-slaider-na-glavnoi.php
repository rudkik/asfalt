<?php
$i = 0;
foreach ($data['view::View_Shop_New\-slaider-na-glavnoi']->childs as $value){
    if($i == 0){
        $value->str = str_replace('<div class="item">', '<div class="item active">', $value->str);
        $i++;
    }
    echo $value->str;
}
?>
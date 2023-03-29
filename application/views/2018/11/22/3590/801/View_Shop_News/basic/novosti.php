<?php
$i = 1;
foreach ($data['view::View_Shop_New\basic\novosti']->childs as $value){
    if($i == 1){
        echo str_replace('<div class="item">', '<div class="item active">', $value->str);
        $i++;
    }else {
        echo $value->str;
    }
}
?>
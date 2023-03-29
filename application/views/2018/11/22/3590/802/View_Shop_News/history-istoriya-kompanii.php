<?php
$i = 1;
foreach ($data['view::View_Shop_New\history-istoriya-kompanii']->childs as $value){
    if($i == 2){
        $value->str = str_replace('<div class="col-md-3">', '<div class="col-md-3 pull-right">', $value->str);
        $i = 0;
    }
    $i++;
    echo $value->str;
}
?>
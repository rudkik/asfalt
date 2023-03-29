<?php
$i = 1;
foreach ($data['view::View_Shop_New\-about-us-job-positions-vakansii-zagolovki']->childs as $value){
    if($i == 1){
        $value->str = str_replace('<li>', '<li class="active">', $value->str);
        $i++;
    }
    echo $value->str;
}
?>

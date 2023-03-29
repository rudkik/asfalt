<?php
$i = 1;
foreach ($data['view::View_Shop_Address\-contact-us-fillialy-zagolovki']->childs as $value){
    if($i == 1){
        echo str_replace('<li>', '<li class="active">', $value->str);
        $i++;
    }else {
        echo $value->str;
    }
}
?>

<?php
$i = 1;
foreach ($data['view::View_Shop_Address\-contact-us-fillialy']->childs as $value){
    if($i == 1){
        echo str_replace('class="tab-pane fade in"', 'class="tab-pane fade in active"', $value->str);
        $i++;
    }else {
        echo $value->str;
    }
}
?>
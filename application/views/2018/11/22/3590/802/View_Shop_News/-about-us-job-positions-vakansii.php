<?php
$i = 1;
foreach ($data['view::View_Shop_New\-about-us-job-positions-vakansii']->childs as $value){
    if($i == 1){
        $value->str = str_replace('class="tab-pane fade in"', 'class="tab-pane fade in active"', $value->str);
        $i++;
    }
    echo $value->str;
}
?>
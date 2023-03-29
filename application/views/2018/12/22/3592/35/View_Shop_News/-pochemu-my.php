<?php
$i = 0;
$n = count($data['view::View_Shop_New\-pochemu-my']->childs);
foreach ($data['view::View_Shop_New\-pochemu-my']->childs as $value){
    $i++;
    if ($n == $i){
        $value->str = str_replace('class="img-right"', 'class="img-right" style="display: none"', $value->str);
    }
    echo str_replace('#index#', '0'.$i, $value->str);
}
?>
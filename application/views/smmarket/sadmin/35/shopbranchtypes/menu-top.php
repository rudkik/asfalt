<?php
$i = 0;
foreach ($data['view::shopbranchtype/menu-top']->childs as $value){
    if($i > 0){
        echo '<li class="divider" role="presentation"></li>';
    }

    echo $value->str;
    $i++;
}
?>
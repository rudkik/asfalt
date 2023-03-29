<?php
$i = 0;
foreach ($data['view::shopnewcatalog/menu-top']->childs as $value){
    echo $value->str;
    $i++;
}
?>
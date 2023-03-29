<div>
<?php
$n = 1;
$i = 1;
foreach ($data['view::View_Shop_New/basic/futtor']->childs as $value){
    if($i == $n + 1){
        echo '</div><div>';
        $i = 1;
    }
    $i++;
    echo $value->str;
}
?>
</div>
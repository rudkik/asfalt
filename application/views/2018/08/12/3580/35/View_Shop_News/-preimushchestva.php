<div class="row">
<?php
$n = 3;
$i = 1;
foreach ($data['view::View_Shop_New\-preimushchestva']->childs as $value){
    if($i == $n + 1){
        echo '</div><div class="row">';
        $i = 1;
    }
    $i++;
    echo $value->str;
}
?>
</div>
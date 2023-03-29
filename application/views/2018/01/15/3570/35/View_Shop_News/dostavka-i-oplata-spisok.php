<div class="row deliveries">
<?php
$n = 3;
$i = 1;
foreach ($data['view::View_Shop_New\dostavka-i-oplata-spisok']->childs as $value){
    if($i == $n + 1){
        echo '</div><div class="row deliveries">';
        $i = 1;
    }
    $i++;
    echo $value->str;
}
?>
</div>
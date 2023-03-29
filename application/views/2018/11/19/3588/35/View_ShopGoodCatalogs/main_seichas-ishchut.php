<div class="col-md-2-5 rubric">
<?php
$n = ceil(count($data['view::View_ShopGoodCatalog\main_seichas-ishchut']->childs) / 5);
$i = 1;
foreach ($data['view::View_ShopGoodCatalog\main_seichas-ishchut']->childs as $value){
    if($i == $n + 1){
        echo '</div><div class="col-md-2-5 rubric">';
        $i = 1;
    }
    $i++;
    echo $value->str;
}
?>
</div>
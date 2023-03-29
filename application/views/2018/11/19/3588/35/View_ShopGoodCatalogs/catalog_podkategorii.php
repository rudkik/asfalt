<div class="col-md-2-5">
    <?php
    $count = count($data['view::View_ShopGoodCatalog\catalog_podkategorii']->childs);
    $n = ceil($count / 5);
    $i = 1;
    foreach ($data['view::View_ShopGoodCatalog\catalog_podkategorii']->childs as $value){
        if($i == $n + 1){
            echo '</div><div class="col-md-2-5">';
            $i = 1;
        }
        $i++;
        echo $value->str;
    }
    ?>
</div>
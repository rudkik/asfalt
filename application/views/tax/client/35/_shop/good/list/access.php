<div class="ks-plans">
    <?php
    $n = 4;
    $i = 1;
    foreach ($data['view::_shop/good/one/access']->childs as $value){
        if($i == $n + 1){
            echo '</div><div class="ks-plans">';
            $i = 1;
        }
        $i++;
        echo $value->str;
    }
    ?>
</div>

<div class="row flex-center">
    <?php
    $n = 3;
    $i = 1;
    foreach ($data['view::View_ShopFileRubric\event_sponsor_group']->childs as $value){
        if($i == $n + 1){
            echo '</div><div class="row flex-center">';
            $i = 1;
        }
        $i++;

        echo $value->str;
    }
    ?>
</div>

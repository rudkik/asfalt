<div class="item active">
    <?php
    $n = 3;
    $i = 1;
    foreach ($data['view::View_Shop_New/basic/otzyvy']->childs as $value){
        if($i == $n + 1){
            echo '</div><div class="item">';
            $i = 1;
        }
        $i++;
        echo $value->str;
    }
    ?>
</div>


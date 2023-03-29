<div class="item active">
    <?php
    $i = 1;
    foreach ($data['view::View_Shop_Comment\-articles-otzyvy']->childs as $value){
        echo $value->str;
        if($i == 2){
            echo '</div><div class="item">';
            $i = 0;
        }
        $i++;
    }
    ?>
</div>

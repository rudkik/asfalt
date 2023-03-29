<div class="row box-list-menu">
    <?php
    $n = 4;
    $i = 1;
    foreach ($data['view::View_Shop_Good\-main-v-futore-rubriki']->childs as $value){
        if($i == $n + 1){
            echo '</div><div class="row box-line-top box-list-menu">';
            $i = 1;
        }
        $i++;
        echo $value->str;
    }
    ?>
</div>

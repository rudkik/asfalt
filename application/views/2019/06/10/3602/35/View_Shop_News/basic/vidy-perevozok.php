<div class="row">
    <?php
    $n = 9;
    $i = 1;
    foreach ($data['view::View_Shop_New/basic/vidy-perevozok']->childs as $value){
        if($i == $n + 1){
            echo '</div><div class="row"><div class="col-1-3">.</div>';
            $i = 1;
        }
        $i++;
        echo $value->str;
    }
    ?>
</div>

<div class="col-md-2-5">
    <?php
    $count = count($data['view::_shop/rubric/one/common']->childs);
    $n = ceil($count / 5);
    $i = 1;
    foreach ($data['view::_shop/rubric/one/common']->childs as $value){
        if($i == $n + 1){
            echo '</div><div class="col-md-2-5">';
            $i = 1;
        }
        $i++;
        echo $value->str;
    }
    ?>
</div>


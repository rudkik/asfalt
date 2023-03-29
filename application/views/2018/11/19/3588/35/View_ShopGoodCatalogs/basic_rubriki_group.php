<?php
$count = count($data['view::View_ShopGoodCatalog\basic_rubriki_group']->childs);
if($count > 0){

    ?>
    <div class="dropdown-menu" role="menu" aria-labelledby="drop1">
        <ul class="popup-menu-list">
            <?php
            if($count < 6){
                $n = $count;
            }elseif($count < 9){
                $n = ceil($count / 2);
            }else{
                $n = ceil($count / 3);
            }
            $i = 1;
            foreach ($data['view::View_ShopGoodCatalog\basic_rubriki_group']->childs as $value){
                if($i == $n + 1){
                    echo '</ul><ul class="popup-menu-list">';
                    $i = 1;
                }
                $i++;
                echo $value->str;
            }
            ?>
        </ul>
    </div>
<?php } ?>
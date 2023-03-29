<?php if(count($data['view::View_Shop_Good\group\basic\vodopodgotovka']->childs) > 0){ ?>
    <div class="col-md-6">
        <ul class="list-menu-child border-r-grey">
            <?php
            $n = ceil(count($data['view::View_Shop_Good\group\basic\vodopodgotovka']->childs) / 2);
            $i = 1;
            foreach ($data['view::View_Shop_Good\group\basic\vodopodgotovka']->childs as $value){
                if($i == $n + 1){
                    echo '</ul></div><div class="col-md-6"><ul class="list-menu-child">';
                    $i = 1;
                }
                $i++;
                echo $value->str;
            }
            ?>
        </ul>
    </div>
<?php } ?>


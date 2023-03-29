<?php if(count($data['view::View_ShopFileRubric\event_sponsor_new']->childs) > 0){ ?>
        <div class="sponsors">
            <div class="container">

                <?php
                $count = count($data['view::View_ShopFileRubric\event_sponsor_new']->childs);
                if($count < 3){
                    $s = '<div class="col-6">';
                }elseif($count == 4){
                    $s = '<div class="col-3">';
                }elseif($count == 3){
                    $s = '<div class="col-4">';
                }else{
                    $s = '<div class="col-2">';
                }

                foreach ($data['view::View_ShopFileRubric\event_sponsor_new']->childs as $value){
                    echo str_replace('<div class="col-6">', $s, $value->str);
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>
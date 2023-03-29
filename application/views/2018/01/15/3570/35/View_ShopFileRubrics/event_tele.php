<?php if(count($data['view::View_ShopFileRubric\event_tele']->childs) > 0){ ?>
    <div class="exhibition__header">
        <div class="container">
            <div class="row flexCenter">
                <?php
                foreach ($data['view::View_ShopFileRubric\event_tele']->childs as $value){
                    echo $value->str;
                }
                ?>
            </div>
        </div>
<?php } ?>
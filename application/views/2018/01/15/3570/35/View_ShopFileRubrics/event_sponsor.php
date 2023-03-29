<?php if(count($data['view::View_ShopFileRubric\event_sponsor']->childs) > 0){ ?>
    <section class="tz-portfolio-wrapper" style="margin: 60px;">
        <?php
        foreach ($data['view::View_ShopFileRubric\event_sponsor']->childs as $value){
            echo $value->str;
        }
        ?>
    </section>
<?php } ?>
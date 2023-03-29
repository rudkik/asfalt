<?php if(count($data['view::View_ShopGallery\event_logo']->childs) > 0){ ?>
    <?php
    foreach ($data['view::View_ShopGallery\event_logo']->childs as $value){
        echo $value->str;
    }
    ?>
<?php } ?>
<?php if (count($data['view::View_Shop_New\basic\sotcialnye-seti']->childs) > 0) {?>
    <ul class="socials">
        <?php
        foreach ($data['view::View_Shop_New\basic\sotcialnye-seti']->childs as $value){
            echo $value->str;
        }
        ?>
    </ul>
<?php } ?>
<?php if (count($data['view::View_Shop_Good\group\-main-gruppy-s-rubrikami']->childs) > 0){ ?>
    <ul>
        <?php
        foreach ($data['view::View_Shop_Good\group\-main-gruppy-s-rubrikami']->childs as $value){
            echo $value->str;
        }
        ?>
    </ul>
<?php } ?>
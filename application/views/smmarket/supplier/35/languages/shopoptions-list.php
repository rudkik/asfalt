<select name="<?php echo $data['view::language/shopoptions-list']->additionDatas['field_name'];?>" class="form-control select2" style="width: 100%;">
    <?php
    foreach ($data['view::language/shopoptions-list']->childs as $value){
        echo $value->str;
    }
    ?>
</select>

<select name="<?php echo $data['view::currency/shopoptions-list']->additionDatas['field_name'];?>" class="form-control select2" style="width: 100%;">
    <?php
    foreach ($data['view::currency/shopoptions-list']->childs as $value){
        echo $value->str;
    }
    ?>
</select>

<option value="<?php echo $data->values['id'];?>" data-id="<?php echo $data->values['id'];?>">
    <?php echo $data->values['name']; if(!empty($data->values['bin'])){echo ' ('.$data->values['bin'].')';}?>
</option>
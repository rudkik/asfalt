<option value="<?php echo $data->values['id'];?>" data-id="<?php echo $data->values['id'];?>" data-amount="<?php echo $data->values['amount'] - $data->values['block_amount'];?>">
    <?php echo $data->values['name']; if(!empty($data->values['phone'])){echo ' ('.$data->values['phone'].')';}?>
</option>
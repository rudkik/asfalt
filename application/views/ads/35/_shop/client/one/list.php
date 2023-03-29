<option value="<?php echo $data->values['id'];?>" data-id="<?php echo $data->values['id'];?>" data-delivery-amount="<?php echo $data->values['delivery_amount'];?>">
    <?php echo $data->values['name']; if(!empty($data->values['phone'])){echo ' ('.$data->values['phone'].')';}?>
</option>
<option value="<?php echo $data->values['id'];?>" data-id="<?php echo $data->values['id'];?>" data-price="<?php echo $data->values['price'];?>">
    <?php echo $data->values['name'];?>
    <?php
    $shop = $data->getElementValue('shop_id');
    if(!empty($shop)){ ?>
        (<?php echo $shop;?>)
    <?php } ?>
    <?php if($data->values['is_delete'] == 1){ ?>
        (удаленный)
    <?php } ?>
    <?php if($data->values['is_public'] == 0){ ?>
        (неактивный)
    <?php } ?>
</option>
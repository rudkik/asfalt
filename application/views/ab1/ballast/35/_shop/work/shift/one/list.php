<option value="<?php echo $data->values['id'];?>" data-id="<?php echo $data->values['id'];?>">
    <?php echo $data->values['name'];?>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        (<?php echo $data->getElementValue('shop_id');?>)
    <?php } ?>
</option>
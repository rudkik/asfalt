<option value="<?php echo $data->values['id'];?>" data-id="<?php echo $data->values['id'];?>">
    <?php echo $data->values['name'];?>
    <?php if($siteData->operation->getIsAdmin() || $siteData->shopID != $data->values['shop_id']){ ?>
        (<?php echo $data->getElementValue('shop_id');?>)
    <?php } ?>
</option>
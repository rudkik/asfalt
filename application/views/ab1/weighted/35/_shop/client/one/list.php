<option value="<?php echo $data->values['id'];?>"
        data-id="<?php echo $data->values['id'];?>"
        data-amount="<?php echo Func::getPriceStr($siteData->currency, $data->values['balance'], TRUE, FALSE);?>"
        data-amount-int="<?php echo $data->values['balance'];?>">
    <?php echo $data->values['name']; if(!empty($data->values['bin'])){echo ' ('.$data->values['bin'].')';}?>
</option>
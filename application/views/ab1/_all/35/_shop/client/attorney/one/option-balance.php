<?php $amount = $data->values['balance']; ?>
<option
        value="<?php echo $data->values['id'];?>"
        data-id="<?php echo $data->values['id'];?>"
        data-contract="<?php echo $data->values['shop_client_contract_id'];?>"
        data-amount="<?php echo $amount; ?>">
    <?php echo $data->values['name']; ?><br>
    <span class="text-red"> Остаток: <b style="font-size: 18px;"><?php echo Func::getPriceStr($siteData->currency, $amount); ?></b></span>
</option>
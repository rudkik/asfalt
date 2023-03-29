<tr <?php if($siteData->url == '/accounting/shopinvoice/edit' && $data->values['quantity'] != $data->values['esf_receive_quantity']){ ?> class="b-red"<?php }?>>
    <td class="text-center">
        <input type="checkbox" class="minimal" <?php if (Arr::path($data->values, 'is_esf', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> disabled>
    </td>
    <td data-id="index" class="text-right">#index#</td>
    <td>
        <span><?php echo $data->getElementValue('shop_production_id'); ?></span>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
</tr>
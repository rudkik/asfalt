<tr <?php if($siteData->url == '/accounting/shopinvoice/edit' && !$data->values['is_esf']){ ?> class="b-red"<?php }?>>
    <td class="text-center">
        <input type="checkbox" class="minimal" <?php if (Arr::path($data->values, 'is_esf', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> disabled>
    </td>
    <td data-id="index" class="text-right">#index#</td>
    <td>
        <span><?php echo $data->getElementValue('shop_product_id', 'name', $data->getElementValue('shop_production_id')); ?></span>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td class="text-right">
        <input data-action="save-invoice-price"
               data-shop_invoice_item_id="<?php echo Arr::path($data->values, 'id', -1); ?>"
               data-shop_production_id="<?php echo $data->getElementValue('shop_production_id', 'id', 0); ?>"
               data-shop_product_id="<?php echo $data->getElementValue('shop_product_id', 'id', 0); ?>"
               data-quantity="<?php echo $data->values['quantity']; ?>"
               type="text" class="form-control text-right" placeholder="Цена" value="<?php echo Func::getNumberStr($data->values['price'], TRUE, 2, FALSE); ?>">

    </td>
    <td class="text-right" data-id="amount"><?php echo Func::getNumberStr(round(round($data->values['quantity'], 3) * $data->values['price'], 2), TRUE, 2, FALSE); ?></td>
</tr>
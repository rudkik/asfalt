<tr <?php if($siteData->url == '/accounting/shopinvoice/edit' && $data->values['quantity'] != $data->values['esf_receive_quantity']){ ?> class="b-red"<?php }?>>
    <td class="text-center">
        <input type="checkbox" class="minimal" <?php if (Arr::path($data->values, 'is_esf', '1') == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> disabled>
    </td>
    <td data-id="index" class="text-right">#index#</td>
    <td>
        <span><?php echo $data->getElementValue('shop_product_id', 'name', $data->getElementValue('shop_production_id')); ?></span>
    </td>
    <td>
        <input data-action="edit-gtd-items"
               data-price_realization="<?php echo $data->values['price_realization']; ?>"
               data-shop_production_id="<?php echo $data->values['shop_production_id']; ?>"
               data-tru_origin_code="<?php echo $data->values['tru_origin_code']; ?>"
               data-product_declaration="<?php echo $data->values['product_declaration']; ?>"
               data-product_number_in_declaration="<?php echo $data->values['product_number_in_declaration']; ?>"
               data-is_esf="<?php echo $data->values['is_esf']; ?>"
               type="text" class="form-control text-right" placeholder="Признак происхождения" value="<?php echo $data->values['tru_origin_code']; ?>">

    </td>
    <td><?php echo $data->values['product_declaration']; ?></td>
    <td><?php echo $data->values['product_number_in_declaration']; ?></td>
    <td><?php echo $data->values['catalog_tru_id']; ?></td>
    <td><?php echo $data->getElementValue('unit_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['price_realization'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr(round(round($data->values['quantity'], 3) * $data->values['price_realization'], 2), TRUE, 2, FALSE); ?></td>
</tr>
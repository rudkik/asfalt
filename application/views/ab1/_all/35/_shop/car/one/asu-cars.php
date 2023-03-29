<?php if (Arr::path($data->values, 'is_all', FALSE) == TRUE){ ?>
    <tr style="font-weight: 700; background-color: #5EC4CD;">
        <td colspan="4">Всего</td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?></td>
    </tr>
<?php }else{ ?>
    <tr>
        <td class="text-right">#index#</td>
        <td><?php echo $data->values['name']; ?></td>
        <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name', ''); ?></td>
        <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true, 3); ?></td>
    </tr>
<?php } ?>

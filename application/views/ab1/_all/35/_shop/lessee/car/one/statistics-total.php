<tr>
    <td class="text-right">#index#</td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_raw_id', 'name', $data->getElementValue('shop_product_id')); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity_year'], TRUE, 3, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
</tr>

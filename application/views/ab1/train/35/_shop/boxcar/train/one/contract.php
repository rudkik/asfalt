<tr>
    <td><?php echo $data->getElementValue('shop_boxcar_client_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_raw_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['paid_quantity'], TRUE, 3); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['received_quantity'], TRUE, 3); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['in_way_quantity'], TRUE, 3); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['balance_quantity'], TRUE, 3); ?></td>
</tr>

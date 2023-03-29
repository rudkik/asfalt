<?php $percent = round($data->values['quantity'] / ($data->values['size_meter'] * $data->values['ton_in_meter']) * 100, 2); ?>
<tr>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('shop_raw_storage_group_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_raw_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($percent, true, 2, false); ?></td>
    <td><?php echo $data->values['unit']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['meter'], true, 3, false); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
</tr>


<tr>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['created_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_raw_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_subdivision_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_heap_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></td>
</tr>

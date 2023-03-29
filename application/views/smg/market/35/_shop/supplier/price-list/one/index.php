<tr>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['created_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_supplier_id'); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['old_count'], true); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['new_count'], true); ?></td>
</tr>

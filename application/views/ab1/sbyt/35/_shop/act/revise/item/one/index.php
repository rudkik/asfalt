<tr>
    <td><?php echo $data->values['old_id']; ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td class="text-right"><?php $tmp = 1; if ($data->values['is_receive'] == 0){ $tmp = -1; } ?><?php echo Func::getNumberStr($data->values['amount'] * $tmp, TRUE, 2, FALSE); ?></td>
    <td>
        <?php if ($data->values['is_cache'] == 1){ ?>
            Наличные
        <?php }else{ ?>
            Безналичные
        <?php } ?>
    </td>
</tr>

<tr>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date']); ?></td>
    <td>
        <?php echo $data->getElementValue('shop_client_id'); ?>
    </td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['amount'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['block_amount'], TRUE, 2, FALSE); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['balance'], TRUE, 2, FALSE); ?></td>
</tr>

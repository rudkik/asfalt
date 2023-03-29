<tr>
    <td>
        <?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['date']); ?>
        <input name="shop_act_revise_items[<?php echo $data->values['table_id']; ?>][]" value="<?php echo $data->values['id']; ?>" style="display: none">
    </td>
    <td>
        <?php echo $data->values['name']; ?>
    </td>
    <td>
        <?php echo Func::getNumberStr($data->values['debit'], TRUE, 2); ?>
    </td>
    <td>
        <?php echo Func::getNumberStr($data->values['credit'], TRUE, 2); ?>
    </td>
</tr>
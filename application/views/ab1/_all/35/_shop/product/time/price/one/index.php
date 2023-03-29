<tr>
    <td>
        <?php echo Helpers_DateTime::getDateFormatRus($data->values['from_at']);?>
    </td>
    <td>
        <?php echo Helpers_DateTime::getDateFormatRus($data->values['to_at']);?>
    </td>
    <td>
        <?php echo Func::getNumberStr($data->values['price'], true, 2, false);?>
    </td>
</tr>
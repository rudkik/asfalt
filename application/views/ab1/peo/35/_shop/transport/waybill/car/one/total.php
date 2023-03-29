<tr class="total">
    <td class="text-right" colspan="10">
        Итого:
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['count_trip'], true, 0, true); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['distance'], true, 2, false); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?>
    </td>
    <td class="text-right">
        <?php echo Func::getNumberStr($data->values['wage'], true, 2, false); ?>
    </td>
</tr>
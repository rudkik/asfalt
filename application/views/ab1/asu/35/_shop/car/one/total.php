<tr>
    <td><?php echo Helpers_DateTime::getDateFormatRus(Arr::path($data->values, 'exit_at_date')); ?></td>
    <td class="text-right"><?php echo Func::getNumberStr(Arr::path($data->values, 'quantity'), true, 3, false); ?></td>
</tr>

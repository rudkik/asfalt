<tr>
    <td><?php echo $data->getElementValue('shop_boxcar_client_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_raw_id'); ?></td>
    <td><?php echo Func::getNumberStr(Arr::path($data->values, 'quantity_month', 0), TRUE, 3); ?></td>
    <td><?php echo Func::getNumberStr(Arr::path($data->values, 'quantity_year', 0), TRUE, 3); ?></td>
</tr>

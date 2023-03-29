<tr>
    <td><?php echo $data->getElementValue('shop_boxcar_client_id'); ?></td>
    <td><?php echo $data->getElementValue('shop_raw_id'); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_shipment']); ?></td>
    <td><?php echo $data->values['number']; ?></td>
    <td class="text-right"><?php echo Func::getNumberStr($data->values['quantity'], TRUE, 3, FALSE); ?></td>
    <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['date_arrival']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeFormatRus($data->values['date_drain_from']); ?></td>
</tr>

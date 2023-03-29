<tr>
    <td><?php echo $data->values['text']; ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.parcel_status_id.name', ''); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td><?php echo Func::getNumberStr($data->values['amount']); ?></td>
    <td><?php echo Func::getNumberStr($data->values['paid_amount']); ?></td>
</tr>
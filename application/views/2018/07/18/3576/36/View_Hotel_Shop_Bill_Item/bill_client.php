<tr>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_room_id.name', ''); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_room_id.human', 0); ?></td>
    <td><?php echo $data->values['human_extra']; ?></td>
    <td><?php echo $data->values['child_extra']; ?></td>
    <td><?php echo Func::getPriceStr($siteData->currency,  $data->values['amount']); ?></td>
</tr>
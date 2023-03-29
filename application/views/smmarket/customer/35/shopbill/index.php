<tr>
    <td><?php echo $data->id; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['client_delivery_date']); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_bill_status_id.name', ''); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name', ''); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.create_user_id.name', ''); ?></td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></td>
    <td><a href="<?php echo $siteData->urlBasic; ?>/customer/shopbill/edit?id=<?php echo $data->id; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>">Просмотр</a></td>
</tr>
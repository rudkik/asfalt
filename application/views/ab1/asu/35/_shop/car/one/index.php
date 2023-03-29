<tr>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['exit_at']); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name', ''); ?></td>
    <td <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['quantity'], true, 3).' '.Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.unit', ''); ?></td>
    <?php if($siteData->operation->getIsAdmin()){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.asu_operation_id.name', ''); ?></td>
    <?php } ?>
</tr>

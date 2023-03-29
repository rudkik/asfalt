<tr>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <td><?php echo $data->getElementValue('shop_client_id'); ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_driver_id.name', ''); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.name', ''); ?></td>
    <td <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['tarra']).' т'; ?></td>
    <td <?php if($data->values['is_test']){ ?>style="background: #e47365 !important;"<?php } ?>><?php echo Func::getNumberStr($data->values['quantity'], true, 3).' '.Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_product_id.unit', ''); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_turn_id.name', ''); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/edit', array('id' => 'id'), array(), $data->values); ?>" class="link-blue"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/del', array('id' => 'id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopmovecar/del', array('id' => 'id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>

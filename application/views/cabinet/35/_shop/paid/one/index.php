<tr>
    <td><?php echo $data->id; ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <?php if (Func::isShopMenu('shoppaid/paid_shop_id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.paid_shop_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shoppaid/name?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
    <td><?php echo $data->values['name']; ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shoppaid/shop_operation_id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_operation_id.name', '');  ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shoppaid/shop_paid_id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_paid_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shoppaid/paid_id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.paid_id.name', ''); ?></td>
    <?php } ?>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></td>
    <?php if (Func::isShopMenu('shoppaid/text?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo $data->values['text']; ?></td>
    <?php } ?>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoppaid/edit', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shoppaid/clone', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-black text-sm"><i class="fa fa-clone margin-r-5"></i> Дублировать</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoppaid/del', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shoppaid/del', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>

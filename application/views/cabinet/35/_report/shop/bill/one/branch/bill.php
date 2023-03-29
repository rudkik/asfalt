<?php $groupBy = Request_RequestParams::getParamArray('group_by'); ?>
<tr>
    <?php if($groupBy === NULL){ ?>
        <td><?php echo $data->id; ?></td>
        <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <?php }elseif((array_search('created_at_date', $groupBy) !== FALSE)){ ?>
        <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['created_at_date']); ?></td>
    <?php }elseif((array_search('created_at_year', $groupBy) !== FALSE)){ ?>
        <td><?php echo $data->values['created_at_year']; ?></td>
    <?php }elseif((array_search('created_at_month', $groupBy) !== FALSE)){ ?>
        <td><?php echo $data->values['created_at_year']; ?></td>
        <td><?php echo Helpers_DateTime::monthToStrRus($data->values['created_at_month']); ?></td>
    <?php }?>
    <?php if(($groupBy === NULL) || (array_search('shop_bill_status_id', $groupBy) !== FALSE)){ ?>
        <?php if (Func::isShopMenu('shopbill/shop_bill_status_id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
            <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_bill_status_id.name', ''); ?></td>
        <?php } ?>
    <?php } ?>
    <?php if(($groupBy === NULL) || (array_search('shop_root_id', $groupBy) !== FALSE)){ ?>
        <?php if (Func::isShopMenu('shopbill/shop_root_id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
            <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_root_id.name', ''); ?></td>
        <?php } ?>
    <?php } ?>
    <?php if(($groupBy === NULL) || (array_search('shop_paid_type_id', $groupBy) !== FALSE)){ ?>
        <?php if (Func::isShopMenu('shopbill/shop_paid_type_id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
            <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_paid_type_id.name', ''); ?></td>
        <?php } ?>
    <?php } ?>
    <?php if(($groupBy === NULL) || (array_search('shop_delivery_type_id', $groupBy) !== FALSE)){ ?>
        <?php if (Func::isShopMenu('shopbill/shop_delivery_type_id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
            <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_delivery_type_id.name', ''); ?></td>
        <?php } ?>
    <?php } ?>
    <?php if(($groupBy === NULL) || (array_search('name', $groupBy) !== FALSE)){ ?>
        <?php if (Func::isShopMenu('shopbill/name?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
            <td><?php echo $data->values['amount']; ?></td>
        <?php } ?>
    <?php } ?>
    <?php if(($groupBy === NULL) || (array_search('create_user_id', $groupBy) !== FALSE)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.create_user_id.name', ''); ?></td>
    <?php } ?>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']);?></td>
</tr>

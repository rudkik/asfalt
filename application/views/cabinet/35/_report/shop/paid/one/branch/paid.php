<?php $groupBy = Request_RequestParams::getParamArray('group_by'); ?>
<tr>
    <?php if($groupBy === NULL){ ?>
        <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <?php }elseif((array_search('created_at_date', $groupBy) !== FALSE)){ ?>
        <td><?php echo Helpers_DateTime::getDateFormatRus($data->values['created_at_date']); ?></td>
    <?php }elseif((array_search('created_at_year', $groupBy) !== FALSE)){ ?>
        <td><?php echo $data->values['created_at_year']; ?></td>
    <?php }elseif((array_search('created_at_month', $groupBy) !== FALSE)){ ?>
        <td><?php echo $data->values['created_at_year']; ?></td>
        <td><?php echo Helpers_DateTime::monthToStrRus($data->values['created_at_month']); ?></td>
    <?php }?>
    <?php if(($groupBy === NULL) || (array_search('paid_shop_id', $groupBy) !== FALSE)){ ?>
        <?php if (Func::isShopMenu('shoppaid/paid_shop_id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.paid_shop_id.name', ''); ?></td>
        <?php } ?>
    <?php } ?>
    <?php if(($groupBy === NULL) || (array_search('shop_operation_id', $groupBy) !== FALSE)){ ?>
        <?php if (Func::isShopMenu('shoppaid/shop_operation_id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
            <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_operation_id.name', '');  ?></td>
        <?php } ?>
    <?php } ?>
    <?php if(($groupBy === NULL) || (array_search('shop_paid_type_id', $groupBy) !== FALSE)){ ?>
        <?php if (Func::isShopMenu('shoppaid/shop_paid_type_id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
            <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_paid_type_id.name', ''); ?></td>
        <?php } ?>
    <?php } ?>
    <?php if(($groupBy === NULL) || (array_search('paid_type_id', $groupBy) !== FALSE)){ ?>
        <?php if (Func::isShopMenu('shoppaid/paid_type_id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
            <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.paid_type_id.name', ''); ?></td>
        <?php } ?>
    <?php } ?>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></td>
</tr>

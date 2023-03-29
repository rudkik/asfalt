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
    <?php if(($groupBy === NULL) || (array_search('create_user_id', $groupBy) !== FALSE)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.create_user_id.name', ''); ?></td>
    <?php } ?>
    <?php if(($groupBy === NULL) || (array_search('shop_root_id', $groupBy) !== FALSE)){ ?>
        <?php if (Func::isShopMenu('shopreturn/shop_root_id?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
            <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_root_id.name', ''); ?></td>
        <?php } ?>
    <?php } ?>
    <?php if(($groupBy === NULL) || (array_search('shop_good_id', $groupBy) !== FALSE)){ ?>
            <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.name', ''); ?></td>
    <?php } ?>
    <td><?php echo Func::getNumberStr($data->values['count']);?></td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']);?></td>
</tr>

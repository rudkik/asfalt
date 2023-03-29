<tr>
    <?php if(Request_RequestParams::getParamInt('is_branch')){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name', ''); ?></td>
    <?php } ?>
    <td><?php echo $data->id; ?></td>
    <td><?php if ($data->values['is_close'] == 1){echo 'закрыто';}else{echo 'открыто';} ?></td>
    <td><?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></td>
    <?php if (Func::isShopMenu('shopoperationstock/shop_operation_id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_operation_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopoperationstock/name?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo $data->values['name']; ?></td>
    <?php } ?>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['amount_first']);?></td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']);?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/edit?id=<?php echo $data->id; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Открыть</a></li>
            <li class="tr-remove"><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/del?id=<?php echo $data->id; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shopoperationstock/del?is_undel=1&id=<?php echo $data->id; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
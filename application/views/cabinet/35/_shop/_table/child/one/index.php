<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablechild/save?id=<?php echo $data->id; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" type="checkbox" class="minimal">
    </td>
    <td><?php echo $data->id; ?></td>
    <?php if (Func::isShopMenu('shoptablechild/image?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <?php } ?>
    <td><?php echo $data->values['name']; ?></td>
    <?php
    $fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options.shop_table_child', array());
    if(! is_array($fields)){
        $fields = array();
    }

    $values = Arr::path($data->values, 'options', array());
    if(! is_array($values)){
        $values = array();
    }

    foreach ($fields as $field){ ?>
        <td><?php echo Arr::path($values, $field['field'], ''); ?></td>
    <?php }?>
    <td><?php echo $data->values['order']; ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablechild/edit?id=<?php echo $data->id; ?>&type=<?php echo $data->values['shop_table_catalog_id']; ?>&root_table_id=<?php echo $data->values['root_table_id']; ?>&shop_root_table_catalog_id=<?php echo $data->values['shop_root_table_catalog_id']; ?>&shop_root_table_object_id=<?php echo $data->values['shop_root_table_object_id']; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablechild/clone?id=<?php echo $data->id; ?>&type=<?php echo $data->values['shop_table_catalog_id']; ?>&root_table_id=<?php echo $data->values['root_table_id']; ?>&shop_root_table_catalog_id=<?php echo $data->values['shop_root_table_catalog_id']; ?>&shop_root_table_object_id=<?php echo $data->values['shop_root_table_object_id']; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="link-black text-sm"><i class="fa fa-clone margin-r-5"></i> Дублировать</a></li>
            <li class="tr-remove"><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablechild/del?id=<?php echo $data->id; ?>&type=<?php echo $data->values['shop_table_catalog_id']; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablechild/del?is_undel=1&id=<?php echo $data->id; ?>&type=<?php echo $data->values['shop_table_catalog_id']; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>
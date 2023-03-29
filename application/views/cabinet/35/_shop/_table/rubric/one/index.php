<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablerubric/save?id=<?php echo $data->id; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" type="checkbox" class="minimal">
    </td>
    <td><?php echo $data->id; ?></td>
    <?php if (Func::isShopMenu('shoptablerubric/image?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <?php } ?>
    <td><?php echo $data->values['name']; ?></td>
    <?php if (Func::isShopMenu('shoptablerubric/root?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php $s = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.root_id.name', ''); if(empty($s)){echo 'Верхнего уровня';}else{echo $s;}  ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shoptablerubric/table/unit?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_unit_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shoptablerubric/table/select?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_select_id.name', ''); ?></td>
    <?php } ?>
    <td><?php echo $data->values['order']; ?></td>
    <?php
    $view = View::factory('cabinet/35/language/tr-translate');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablerubric/edit?id=<?php echo $data->id; ?>&type=<?php echo $data->values['shop_table_catalog_id']; ?>&table_id=<?php echo $data->values['table_id']; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablerubric/clone?id=<?php echo $data->id; ?>&type=<?php echo $data->values['shop_table_catalog_id']; ?>&table_id=<?php echo $data->values['table_id']; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="link-black text-sm"><i class="fa fa-clone margin-r-5"></i> Дублировать</a></li>
            <li class="tr-remove"><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablerubric/del?id=<?php echo $data->id; ?>&type=<?php echo $data->values['shop_table_catalog_id']; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablerubric/del?is_undel=1&id=<?php echo $data->id; ?>&type=<?php echo $data->values['shop_table_catalog_id']; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
            <?php if (Func::isShopMenu('shoptablerubric/root?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
            <li><a href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablerubric/index?root_id=<?php echo $data->id; ?>&type=<?php echo $data->values['shop_table_catalog_id']; ?>&table_id=<?php echo $data->values['table_id']; ?>is_public_ignore=1<?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" class="link-blue text-sm"><i class="fa fa-list margin-r-5"></i> Детвора</a></li>
            <?php } ?>
        </ul>
    </td>
</tr>
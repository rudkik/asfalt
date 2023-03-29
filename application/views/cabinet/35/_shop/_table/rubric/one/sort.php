<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo $siteData->urlBasic; ?>/<?php echo $siteData->actionURLName; ?>/shoptablerubric/save?id=<?php echo $data->id; ?><?php if($siteData->superUserID > 0){echo '&shop_id='.$siteData->shopID;} ?><?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>" type="checkbox" class="minimal">
    </td>
    <td><?php echo $data->id; ?></td>
    <?php if (Func::isShopMenu('shoptablerubric/image?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><img data-action="modal-image" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shoptablerubric/root?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php $s = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.name', ''); if(empty($s)){echo 'Верхнего уровня';}else{echo $s;}  ?></td>
    <?php } ?>
    <td><?php echo $data->values['name']; ?></td>
    <td>
        <input data-id="order" name="order[<?php echo $data->id; ?>]" value="<?php echo $data->values['order']; ?>" hidden>
        <ul class="list-inline tr-button sort-btn">
            <li><a data-id="up" href="" class="link-blue text-sm"><i class="fa fa-angle-up margin-r-5"></i> Вверх</a></li>
            <li><a data-id="down" href="" class="link-blue text-sm"><i class="fa fa-angle-down margin-r-5"></i> Вниз</a></li>
        </ul>
        <ul class="list-inline tr-button sort-btn">
            <li><a data-id="up-first"  href="" class="link-blue text-sm"><i class="fa fa-angle-double-up margin-r-5"></i> Начало</a></li>
            <li><a data-id="down-last" href="" class="link-blue text-sm"><i class="fa fa-angle-double-down margin-r-5"></i> Конец</a></li>
        </ul>
    </td>
</tr>
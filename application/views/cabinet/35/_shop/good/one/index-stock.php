<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopgood/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <?php if (Func::isShopMenu('shopgood/table/id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo $data->id; ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopgood/table/article?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo $data->values['article']; ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopgood/table/image?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><img data-action="modal-image" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <?php } ?>
    <td><?php echo $data->values['name']; ?></td>
    <?php if (Func::isShopMenu('shopgood/table/rubric?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php $s = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', ''); if(empty($s)){echo 'Верхнего уровня';}else{echo $s;}  ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopgood/table/stock?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_stock_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopgood/table/stock_rubric?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_stock_rubric_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopgood/table/stock_name?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo $data->values['stock_name']; ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopgood/table/unit?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_unit_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopgood/table/select?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_select_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopgood/table/brand?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_brand_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopgood/table/price?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td>
            <?php
            echo Func::getPriceStr($siteData->currency, $data->values['price']);
            if($data->values['price_old'] > 0){
                echo '<br>'.Func::getPriceStr($siteData->currency, $data->values['price_old']);
            }
            ?>
        </td>
    <?php } ?>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopgood/edit_work', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopgood/clone', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-black text-sm"><i class="fa fa-clone margin-r-5"></i> Дублировать</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopgood/del', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopgood/del', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>

<tr>
    <td>
        <input name="set-is-public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> href="<?php echo Func::getFullURL($siteData, '/shopcar/save', array('id' => 'id'), array(), $data->values); ?>" type="checkbox" class="minimal" data-id="<?php echo $data->id; ?>">
    </td>
    <?php if (Func::isShopMenu('shopcar/table/id?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo $data->id; ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopcar/table/article?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo $data->values['article']; ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopcar/table/image?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><img data-action="modal-image" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopcar/table/name?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo $data->values['name']; ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopcar/table/name_total?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo $data->values['name_total']; ?></td>
    <?php } ?>
    <?php if ($data->values['shop_table_catalog_id'] == 3820){ ?>
        <td><?php echo Arr::path($data->values['options'], 'model', ''); ?></td>
    <?php }?>
    <?php if (Func::isShopMenu('shopcar/table/rubric?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php $s = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', ''); if(empty($s)){echo 'Верхнего уровня';}else{echo $s;}  ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopcar/table/stock?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_stock_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopcar/table/stock_rubric?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_stock_rubric_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopcar/table/stock_name?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo $data->values['stock_name']; ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopcar/table/unit?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_unit_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopcar/table/select?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_select_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopcar/table/brand?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_brand_id.name', ''); ?></td>
    <?php } ?>
    <?php if (Func::isShopMenu('shopcar/table/price?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td>
            <?php
            echo Func::getCarPriceStr($siteData->currency, $data, $price, $priceOld);
            if($data->values['price_old'] > 0){
                echo '<br>'.$priceOld;
            }
            ?>
        </td>
    <?php } ?>
    <?php
    $view = View::factory('cabinet/35/_addition/params/td');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
    <?php
    $view = View::factory('cabinet/35/language/tr-translate');
    $view->siteData = $siteData;
    $view->data = $data;
    echo Helpers_View::viewToStr($view);
    ?>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopcar/edit', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-blue text-sm"><i class="fa fa-edit margin-r-5"></i> Изменить</a></li>
            <li><a href="<?php echo Func::getFullURL($siteData, '/shopcar/clone', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-black text-sm"><i class="fa fa-clone margin-r-5"></i> Дублировать</a></li>
            <li class="tr-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopcar/del', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array(), $data->values); ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
            <li class="tr-un-remove"><a href="<?php echo Func::getFullURL($siteData, '/shopcar/del', array('id' => 'id', 'type' => 'shop_table_catalog_id'), array('is_undel' => 1), $data->values); ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i> Восстановить</a></li>
        </ul>
    </td>
</tr>

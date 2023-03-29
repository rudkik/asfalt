<tr>
    <td><input name="set-is-public" <?php if($data->values['is_public'] == 1){echo 'checked';}?> value="1" checked href="/supplier/shopgood/save?id=<?php echo $data->id; ?>" type="checkbox" class="minimal"></td>
    <td><input name="set-is-new"  <?php if($data->values['good_select_type_id'] == 3723){echo 'checked';}?> value="1" href="/supplier/shopgood/save?id=<?php echo $data->id; ?>" type="checkbox" class="minimal"></td>
    <td><?php echo $data->values['id']; ?></td>
    <td class="tr-header-photo">
        <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 60); ?>" class="logo img-responsive" alt="">
    </td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo Controller_SMMarket_Func::getGoodPriceStr(0, $siteData->currency, $data, $price, $priceOld); ?></td>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', ''); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="/supplier/shopgood/edit?id=<?php echo $data->id; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-blue text-sm"><i class="fa fa-edit"></i>изменить</a></li>
            <li><a href="/supplier/shopgood/clone?id=<?php echo $data->id; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-black text-sm"><i class="fa fa-clone"></i>дублировать</a></li>
            <li class="tr-remove"><a href="/supplier/shopgood/del?id=<?php echo $data->id; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-red text-sm"><i class="fa fa-remove"></i>удалить</a></li>
            <li class="tr-un-remove"><a href="/supplier/shopgood/del?id=<?php echo $data->id; ?>&is_undel=1&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i>восстановить</a></li>
        </ul>
    </td>
</tr>
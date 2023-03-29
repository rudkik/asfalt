<tr>
    <td><input name="set-is-public" <?php if($data->values['is_public'] == 1){echo 'checked';}?> value="1" checked href="/sadmin/shopgood/save?id=<?php echo $data->id; ?>" type="checkbox" class="minimal"></td>
    <td><input name="set-is-new"  <?php if($data->values['good_select_type_id'] == 3723){echo 'checked';}?> value="1" checked href="/sadmin/shopgood/save?id=<?php echo $data->id; ?>" type="checkbox" class="minimal"></td>
    <td><?php echo $data->values['id']; ?></td>
    <td class="tr-header-photo">
        <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 60); ?>" class="logo img-responsive" alt="">
    </td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['price']); ?></td>
    <?php if($siteData->branchID == 0){ ?>
        <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.name', ''); ?></td>
    <?php } ?>
    <td><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', ''); ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="" class="link-blue text-sm"><i class="fa fa-plus"></i>выбрать</a></li>
        </ul>
    </td>
</tr>
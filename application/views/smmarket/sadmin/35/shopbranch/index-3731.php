<tr>
    <td>#index#</td>
    <td><input name="set-is-active" <?php if($data->values['is_active'] == 1){echo 'checked';}?> value="1" href="/sadmin/shopbranch/save?id=<?php echo $data->id; ?>" type="checkbox" class="minimal"></td>
    <td><input name="set-is-public" <?php if($data->values['is_public'] == 1){echo 'checked';}?> value="1" href="/sadmin/shopbranch/save?id=<?php echo $data->id; ?>" type="checkbox" class="minimal"></td>
    <td><?php echo $data->id; ?></td>
    <td class="tr-header-photo">
        <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 60); ?>" class="logo img-responsive" alt="">
    </td>
    <td><a href=""><?php echo $data->values['name']; ?></a></td>
    <td><a href=""><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_branch_catalog.name', ''); ?></a></td>
    <td><a href=""><?php echo Arr::path($data->values, 'options.manager_company_name', ''); ?></a></td>
    <td>
        <ul class="list-inline tr-button  <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="/sadmin/shopbranch/edit?id=<?php echo $data->id; ?>" class="link-blue text-sm"><i class="fa fa-edit"></i>изменить</a></li>
            <li><a href="/sadmin/shopbranch/clone?id=<?php echo $data->id; ?>" class="link-black text-sm"><i class="fa fa-clone"></i>дублировать</a></li>
            <li class="tr-remove"><a href="/sadmin/shopbranch/del?id=<?php echo $data->id; ?>" class="link-red text-sm"><i class="fa fa-remove"></i>удалить</a></li>
            <li class="tr-un-remove"><a href="/sadmin/shopbranch/del?id=<?php echo $data->id; ?>&is_undel=1" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i>восстановить</a></li>
        </ul>
    </td>
</tr>

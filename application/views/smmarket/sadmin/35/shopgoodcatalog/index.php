<tr>
    <td><input name="set-is-public" <?php if($data->values['is_public'] == 1){echo 'checked';}?> value="1" checked href="/sadmin/shopgoodcatalog/save?id=<?php echo $data->id; ?>" type="checkbox" class="minimal"></td>
    <td><?php echo $data->values['id']; ?></td>
    <td class="tr-header-photo">
        <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 60); ?>" class="logo img-responsive" alt="">
    </td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php $s = Arr::path($data->values, '$elements$.root_id.name', ''); if(empty($s)){echo 'Каталог верхнего уровня';}else{echo $s;}  ?></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="/sadmin/shopgoodcatalog/edit?id=<?php echo $data->id; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-blue text-sm"><i class="fa fa-edit"></i>изменить</a></li>
            <li><a href="/sadmin/shopgoodcatalog/clone?id=<?php echo $data->id; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-black text-sm"><i class="fa fa-clone"></i>дублировать</a></li>
            <li class="tr-remove"><a href="/sadmin/shopgoodcatalog/del?id=<?php echo $data->id; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-red text-sm"><i class="fa fa-remove"></i>удалить</a></li>
            <li class="tr-un-remove"><a href="/sadmin/shopgoodcatalog/del?id=<?php echo $data->id; ?>&is_undel=1&shop_branch_id=<?php echo $data->values['shop_id']; ?>" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i>восстановить</a></li>
        </ul>
    </td>
</tr>
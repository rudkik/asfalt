<tr>
    <td><?php echo $data->id; ?></td>
    <td class="tr-header-photo">
        <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 60); ?>" class="logo img-responsive" alt="">
    </td>
    <td><a href=""><?php echo $data->values['name']; ?></a></td>
    <td>
        <ul class="list-inline tr-button <?php if ($data->values['is_delete'] == 1) { echo ' un-'; } ?>delete">
            <li><a href="/supplier/shopportfel/edit?id=<?php echo $data->id; ?>&shop_branch_id=<?php echo $data->id; ?>" class="link-blue text-sm"><i class="fa fa-edit"></i>изменить</a></li>
            <li><a href="/supplier/shopportfel/clone?id=<?php echo $data->id; ?>" class="link-black text-sm"><i class="fa fa-clone"></i>дублировать</a></li>
            <li class="tr-remove"><a href="/supplier/shopportfel/del?id=<?php echo $data->id; ?>" class="link-red text-sm"><i class="fa fa-remove"></i>удалить</a></li>
            <li class="tr-un-remove"><a href="/supplier/shopportfel/del?id=<?php echo $data->id; ?>&is_undel=1" class="link-red text-sm"><i class="fa fa-reply margin-r-5"></i>восстановить</a></li>
        </ul>
    </td>
</tr>
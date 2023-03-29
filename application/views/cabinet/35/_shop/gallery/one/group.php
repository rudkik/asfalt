<tr>
    <?php if (Func::isShopMenu('shopgallery/image?type='.$data->values['shop_table_catalog_id'], $siteData)){ ?>
        <td>
            <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>">
        </td>
    <?php }?>
    <td><?php echo $data->values['name']; ?></td>
    <td>
        <ul class="list-inline tr-button delete">
            <input hidden="hidden" name="shop_table_groups[]" value="<?php echo $data->values['id']; ?>">
            <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
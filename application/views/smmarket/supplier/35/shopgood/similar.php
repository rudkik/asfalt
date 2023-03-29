<tr>
    <td>
        <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>">
    </td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['price']); ?></td>
    <td>
        <ul class="list-inline tr-button delete">
            <input hidden="hidden" name="shop_good_similar_ids[]" value="<?php echo $data->values['id']; ?>">
            <li class="tr-remove"><a delete="tr" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
        </ul>
    </td>
</tr>
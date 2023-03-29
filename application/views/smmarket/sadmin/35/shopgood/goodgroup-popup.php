<tr>
    <td>
        <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>">
    </td>
    <td><?php echo $data->values['name']; ?></td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['price']); ?></td>
    <td>
        <ul class="list-inline tr-button delete">
            <input hidden="hidden" name="shopgood_ids[]" value="<?php echo $data->values['id']; ?>">
            <li class="tr-remove"><a href="javascript:actionAddGoodGroup(<?php echo $data->id; ?>, <?php echo $data->values['shop_id']; ?>)" class="text-sm"><i class="fa fa-plus margin-r-5"></i> Выбрать</a></li>
        </ul>
    </td>
</tr>
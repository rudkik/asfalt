<tr>
    <td><?php echo $data->id; ?></td>
    <td><img data-action="modal-image" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 68, 52); ?>"></td>
    <td><?php echo $data->values['name']; ?></td>
    <td>
        <input type="text" class="form-control" name="shop_goods[<?php echo $data->values['id']; ?>]" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->additionDatas, 'price', $data->values['price'])); ?>">
    </td>
</tr>
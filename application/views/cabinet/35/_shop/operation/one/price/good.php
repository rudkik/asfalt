<tr>
    <td><?php echo $data->id; ?></td>
    <td><?php echo $data->values['name']; ?></td>
    <td>
        <input type="text" class="form-control" name="shop_goods[<?php echo $data->values['id']; ?>]" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->additionDatas, 'price', '')); ?>">
    </td>
</tr>
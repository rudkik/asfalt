<tr>
    <td><?php echo $data->values['shop_good_id']; ?></td>
    <td style="width: 120px">
        <a href="">
            <img src="<?php echo Helpers_Image::getPhotoPath(Arr::path($data->values, '$elements$.shop_good.image_path', ''), 120, 80); ?>" class="logo img-responsive" alt="">
        </a>
    </td>
    <td>
        <a href="">
        <?php echo Arr::path($data->values, '$elements$.shop_good.name', ''); ?>
            </a>
    </td>
    <td><?php echo $data->values['count_first']; ?></td>
    <td>
        <div class="block-count">
            <a class="btn btn-default" data-action="down" href="#">-</a>
            <input name="shop_bill_items[<?php echo $data->values['id']; ?>][count]" data-action="count-edit" size="3" data-min-value="0" autocomplete="off" min="0" value="<?php echo Func::getNumberStr($data->values['count'], FALSE); ?>" data-price="<?php echo $data->values['price']; ?>" data-id="<?php echo $data->values['id']; ?>" class="form-control">
            <a class="btn btn-default" data-action="up" href="#">+</a>
        </div>
    </td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['price']);?></td>
    <td id="goods-<?php echo $data->values['id']; ?>"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></td>
    <td>
        <input name="shop_bill_items[<?php echo $data->values['id']; ?>][id]" value="<?php echo $data->values['id']; ?>" hidden>
        <a href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a>
    </td>
</tr>
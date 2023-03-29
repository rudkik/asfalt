<tr>
    <td>
        <a href="?<?php echo $data->values['shop_good_id']; ?>">
            <img src="<?php echo Helpers_Image::getPhotoPath(Arr::path($data->values, '$elements$.shop_good.image_path', ''), 68, 52); ?>" class="logo img-responsive">
            <?php echo Arr::path($data->values, '$elements$.shop_good.name', ''); ?>
        </a>
    </td>
    <td><?php echo Func::getNumberStr($data->values['count_first']); ?></td>
    <td>
        <div class="div-no-edit"><?php echo Func::getNumberStr($data->values['count']); ?></div>

        <div class="block-count div-yes-edit">
            <a class="btn btn-default" data-action="down" href="#">-</a>
            <input name="shop_bill_items[<?php echo $data->values['id']; ?>][count]" data-action="count-edit" size="3" data-min-value="0" autocomplete="off" min="0" value="<?php echo Func::getNumberStr($data->values['count'], FALSE); ?>" data-price="<?php echo $data->values['price']; ?>" data-id="<?php echo $data->values['id']; ?>" class="form-control">
            <a class="btn btn-default" data-action="up" href="#">+</a>
        </div>
    </td>
    <td>
        <div class="div-no-edit"><?php echo Func::getPriceStr($siteData->currency, $data->values['price']); ?></div>
        <div class="div-yes-edit">
            <input name="shop_bill_items[<?php echo $data->values['id']; ?>][price]" data-action="price-edit" autocomplete="off" value="<?php echo Func::getNumberStr($data->values['price'], FALSE); ?>" data-id="<?php echo $data->values['id']; ?>" class="form-control">
        </div>
    </td>
    <td data-name="goods-amount" id="goods-<?php echo $data->values['id']; ?>"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></td>
    <td>
        <input name="shop_bill_items[<?php echo $data->values['id']; ?>][id]" value="<?php echo $data->values['id']; ?>" hidden>
        <a href="" data-action="goods-delete" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a>
    </td>
</tr>

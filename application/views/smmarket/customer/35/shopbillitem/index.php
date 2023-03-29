<tr>
    <td>
        <a href="/customer/shopgood/edit?id=<?php echo $data->values['shop_good_id']; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>">
            <img src="<?php echo Helpers_Image::getPhotoPath(Arr::path($data->values, '$elements$.shop_good.image_path', ''), 120, 80); ?>" class="logo img-responsive" >
            <?php echo Arr::path($data->values, '$elements$.shop_good.name', ''); ?>
        </a>
    </td>
    <td><?php echo Func::getNumberStr($data->values['count_first']); ?></td>
    <td><?php echo Func::getNumberStr($data->values['count']); ?></td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['price']);?></td>
    <td><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></td>
</tr>

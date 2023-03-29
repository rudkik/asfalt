<tr data-id="<?php echo $data->values['id']; ?>">
    <td>
        <a href="">
            <a href="/customer/shopgood/edit?id=<?php echo $data->values['id']; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>"><img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 120, 80); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>"></a>
            <a href="/customer/shopgood/edit?id=<?php echo $data->values['id']; ?>&shop_branch_id=<?php echo $data->values['shop_id']; ?>"><?php echo $data->values['name']; ?></a>
        </a>
    </td>
    <td>
        <div class="block-count">
            <a data-id="<?php echo $data->values['id']; ?>" data-shop="<?php echo $data->values['shop_id']; ?>" class="btn btn-default" data-action="down" data-template="cart" href="#">-</a>
            <input data-id="<?php echo $data->values['id']; ?>" data-shop="<?php echo $data->values['shop_id']; ?>" data-name="count" size="3" data-min-value="0" autocomplete="off" min="0" data-template="cart" value="<?php echo $data->additionDatas['count']; ?>" data-template="sale" class="form-control">
            <a data-id="<?php echo $data->values['id']; ?>" data-shop="<?php echo $data->values['shop_id']; ?>" class="btn btn-default" data-action="up" data-template="cart" href="#">+</a>
        </div>
    </td>
    <td><?php echo Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?></td>
    <td data-name="good-<?php echo $data->values['id']; ?>"><?php echo Func::getGoodAmountStr($siteData->currency, $data, $data->additionDatas['count']); ?></td>
    <td>
        <a href="#" data-action="del-cart" data-shop="<?php echo $data->values['shop_id']; ?>" data-id="<?php echo $data->values['id']; ?>" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a>
    </td>
</tr>
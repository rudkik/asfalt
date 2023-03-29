<li class="item">
    <div class="box-product">
        <div class="product-img">
            <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 79); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
        </div>
        <div class="product-info">
            <a class="product-title"><?php echo $data->values['name']; ?> <a class="text-red pull-right" href="tel:<?php echo Arr::path($data->values['options'], 'phone', '');?>"><?php echo Arr::path($data->values['options'], 'phone', '');?></a></a>
            <span class="product-description"> <?php echo Arr::path($data->values['options'], 'address', ''); ?></span>
            <div class="box-cart" style="margin-top: 15px;">
                <span>Баланс </span> <label class="text-red"><?php echo Func::getPriceStr($siteData->currency, $data->values['balance']); ?></label>
            </div>
            <a href="<?php echo Func::getFullURL($siteData, '/shopcart/set_shop_root_id', array(), array('shop_root_id'=>$data->id)); ?>" class="btn btn-danger btn-flat pull-right btn-cart">Заказ</a>
            <a href="<?php echo Func::getFullURL($siteData, '/shoppaid/new', array(), array('paid_shop_id'=>$data->id, 'type'=>51666)); ?>" class="btn btn-info btn-flat pull-right btn-cart">Оплата</a>
        </div>
    </div>
</li>

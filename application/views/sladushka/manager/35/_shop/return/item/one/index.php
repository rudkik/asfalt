<li class="item">
    <div class="box-product">
        <div class="product-img">
            <img src="<?php echo Helpers_Image::getPhotoPath(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.image_path', ''), 90, 79); ?>" alt="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.name', ''), ENT_QUOTES); ?>">
        </div>
        <div class="product-info">
            <a class="product-title"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.name', ''); ?> <span class="text-red pull-right"><?php echo Func::getPriceStr($siteData->currency, $data->values['price']);?></span></a>
            <span class="product-description"> <?php echo Func::getNumberStr($data->values['count']); ?> шт.</span>
            <input data-cart-count="<?php echo $data->values['shop_good_id']; ?>" data-action="amount" value="1" style="display: none;">
            <button data-id="<?php echo $data->values['shop_good_id']; ?>" data-cart-action="add-good" data-child="0" data-shop="0" class="btn btn-danger btn-flat pull-right btn-cart">В корзину</button>
        </div>
    </div>
    <div class="label-success box-amount"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></div>
</li>

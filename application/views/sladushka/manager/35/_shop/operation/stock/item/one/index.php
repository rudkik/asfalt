<li class="item">
    <div class="box-product">
        <div class="product-img">
            <img src="<?php echo Helpers_Image::getPhotoPath(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.image_path', ''), 90, 79); ?>" alt="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.name', ''), ENT_QUOTES); ?>">
        </div>
        <div class="product-info">
            <a class="product-title"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_good_id.name', ''); ?> <span class="text-red pull-right"><?php echo Func::getPriceStr($siteData->currency, $data->values['price']);?></span></a>
            <span class="product-description" style="margin-bottom: 10px;"> </span>
            <?php if ($data->values['count'] > 0){?>
            <div class="box-cart">
                <div class="input-group">
                    <div class="input-group-btn">
                        <button data-action="input-plus" data-value="-1" type="button" class="btn btn-primary btn-flat">-</button>
                    </div>
                    <input data-cart-count="<?php echo $data->values['shop_good_id']; ?>" data-action="amount" class="form-control" type="text" value="1">
                    <div class="input-group-btn">
                        <button data-action="input-plus" data-value="1" type="button" class="btn btn-primary btn-flat">+</button>
                    </div>
                </div>
            </div>
            <button data-id="<?php echo $data->values['shop_good_id']; ?>" data-cart-action="add-good" data-child="0" data-shop="0" class="btn btn-danger btn-flat pull-right btn-cart">В корзину</button>
            <?php } ?>
        </div>
    </div>
    <div class="label-success box-amount"><?php echo Func::getNumberStr($data->values['count']); ?> шт.</div>
</li>

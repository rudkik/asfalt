<li class="item">
    <div class="box-product">
        <div class="product-img">
            <img src="<?php echo Helpers_Image::getPhotoPath(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.paid_shop_id.image_path', ''), 90, 79); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
        </div>
        <div class="product-info">
            <a class="product-title"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.paid_shop_id.name', ''); ?> <span class="text-red pull-right"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']);?></span></a>
            <span class="product-description"> <?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></span>
        </div>
    </div>
</li>

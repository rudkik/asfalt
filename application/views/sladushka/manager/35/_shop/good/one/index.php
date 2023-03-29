<li class="item">
    <div class="box-product">
        <div class="product-img">
            <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 79); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
        </div>
        <div class="product-info">
            <a class="product-title"><?php echo $data->values['name']; ?> <span class="text-red pull-right"><?php echo Func::getPriceStr($siteData->currency, $data->additionDatas['price']);?>/<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_unit_id.name', '');?></span></a>
            <span class="product-description"> <?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', ''); ?></span>
            <div class="box-cart">
                <div class="input-group">
                    <div class="input-group-btn">
                        <button data-action="input-plus" data-value="-1" type="button" class="btn btn-primary btn-flat">-</button>
                    </div>
                    <input data-cart-count="<?php echo $data->id; ?>" data-action="amount" class="form-control" type="text" value="1">
                    <div class="input-group-btn">
                        <button data-action="input-plus" data-value="1" type="button" class="btn btn-primary btn-flat">+</button>
                    </div>
                </div>
            </div>
            <button data-id="<?php echo $data->id; ?>" data-cart-action="add-good" data-child="0" data-shop="0" class="btn btn-danger btn-flat pull-right btn-cart">В корзину</button>
        </div>
    </div>
</li>

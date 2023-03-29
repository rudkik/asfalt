<li class="item">
    <div class="box-product">
        <div class="product-img">
            <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 79); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
        </div>
        <div class="product-info">
            <a class="product-title"><?php echo $data->values['name']; ?> <span class="text-red pull-right"><?php echo Func::getPriceStr($siteData->currency, $data->values['price']);?></span></a>
            <span class="product-description"> <?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', ''); ?></span>
            <div class="box-cart">
                <div class="input-group">
                    <div class="input-group-btn">
                        <button data-action="input-plus" data-value="-1" type="button" class="btn btn-primary btn-flat">-</button>
                    </div>
                    <input data-cart-action="set-good-count" data-id="<?php echo $data->id; ?>"  data-child="0" data-shop="0"
                           data-action="amount" data-count-up="1" data-good-price="<?php echo Func::getPrice($siteData->currency, $data->values['price']); ?>"
                           data-good-amount="<?php echo Func::getGoodAmount($data, $data->additionDatas['count'], $siteData->currency->getIsRound()); ?>" class="form-control" type="text" value="<?php echo $data->additionDatas['count'];?>">
                    <div class="input-group-btn">
                        <button data-action="input-plus" data-value="1" type="button" class="btn btn-primary btn-flat">+</button>
                    </div>
                </div>
            </div>
            <button data-cart-action="del-good" data-id="<?php echo $data->id; ?>"  data-child="0" data-shop="0" class="btn btn-danger btn-flat pull-right btn-cart">Удалить</button>
        </div>
    </div>
    <div class="label-success box-amount" data-cart-amount="<?php echo $data->id; ?>"><?php echo Func::getGoodAmountStr($siteData->currency, $data, $data->additionDatas['count']); ?></div>
</li>

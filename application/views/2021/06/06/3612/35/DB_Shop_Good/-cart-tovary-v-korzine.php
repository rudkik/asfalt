<ul class="product row col-md-12 col-sm-6">
    <li class="imgPlace col-md-5 col-sm-12">
        <img class="imgPlace__pic" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 120, 107); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        <span class="name">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a> 
        </span>
    </li>
    <li class="product__price col-md-2 col-sm-6 col-6">
        <span class="priceNum"><?php echo Func::getNumberStr($data->values['price'], false); ?></span>
        <span>тг</span>
        <?php if(Arr::path($data->additionDatas, 'calc_is_coupon', 0) == 1){ ?><span class="coupon-discount">-<?php echo $data->additionDatas['calc_coupon_discount']; ?><?php if($data->additionDatas['calc_coupon_is_percent'] == 1){ echo '%'; }else{ echo 'тг'; } ?></span><?php } ?>
    </li>
    <li class="quantity col-md-2 col-sm-12">
        <input class="quantity__minus" type="button" value="-">
        <span class="quantity__number"><?php echo $data->additionDatas['count']; ?></span> <span class="quantity__number-text">шт</span>
        <input class="quantity__plus" type="button" value="+">
        <input class="quantity__number1" value="<?php echo $data->additionDatas['count']; ?>" style="display: none" data-cart-action="set-good-count" data-id="<?php echo $data->values['id']; ?>" data-shop="<?php echo $data->values['shop_id']; ?>" >
    </li>
    <li class="product__priceTotal col-md-2 col-sm-6 col-6">
        <span class="priceTotal"><?php echo Func::getGoodAmountStr($siteData->currency, $data, $data->additionDatas['count']); ?></span>
        <span>тг</span>
    </li>
    <li class="product__delete col-md-1 col-sm-12">
        <button class="product__delBtn" type="button">
            <svg class="close-big" data-cart-action="del-good" data-id="<?php echo $data->values['id']; ?>" data-shop="<?php echo $data->values['shop_id']; ?>">
                <use xlink:href="#close-big"></use>
            </svg>
        </button>
    </li>
</ul>
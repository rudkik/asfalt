<article class="plantPictures__item col-md-3 col-sm-6 col-6">
    <div class="imagePlace">
        <div class="icon__place">
            <svg class="like" data-favorite-action="<?php if(Api_Favorite::isFindGood($data->id, 0, $siteData)){ ?>del-good<?php }else{ ?>add-good<?php } ?>" data-id="<?php echo $data->id;?>" data-child="0" data-shop="0">
                <use xlink:href="#like"></use>
            </svg>
        </div>
        <a href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>"><img id="goods-img-<?php echo $data->values['id']; ?>" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 340, 300); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"></a>
    </div>
    <div class="item__details">
        <ul>
            <li class="details__title">
                <a class="product-name" href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a>
            </li>
            <li>
                <span class="price">цена:</span>
                <span class="sum"><?php echo Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?></span>
            </li>
            <li  <?php if (Func::_empty(Arr::path($data->values['options'], 'size', ''))){ ?>style="display: none"<?php } ?>>
                <span><b>объём горшка:</b> <?php echo Arr::path($data->values['options'], 'size', '');?></span>
            </li>
            <li>
                <?php if($data->values['is_public'] == 1){ ?>
                    <button type="button" class="btn" data-cart-action="add-good" data-id="<?php echo $data->values['id']; ?>" data-child="0" data-shop="<?php echo $data->values['shop_id']; ?>">в корзину</button>
                <?php }else{ ?>
                    <button type="button" class="btn" disabled>нет в наличии</button>
                <?php } ?>
            </li>
        </ul>
    </div>
</article>
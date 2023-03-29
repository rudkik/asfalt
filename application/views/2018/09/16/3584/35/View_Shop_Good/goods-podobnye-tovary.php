<?php if(Request_RequestParams::getParamInt('id') != $data->id){ ?>
<?php Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?>
<div class="product">
    <a href="<?php echo $siteData->urlBasic; ?>/catalogs<?php echo $data->values['name_url']; ?>" class="woocommerce-LoopProduct-link">
        <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 224, 197); ?>" width="224" height="197" class="wp-post-image" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        <span class="price">
			<?php if(!empty($priceOld)){ ?>
            <ins>
                <span class="amount"><?php echo $priceOld; ?></span>
            </ins>
			<?php } ?>
            <span class="amount"><?php echo $price; ?></span>
        </span>
        <h2 class="woocommerce-loop-product__title"><?php echo $data->values['name']; ?></h2>
    </a>
    <div class="hover-area">
        <a class="button add_to_cart_button" href="#" rel="nofollow">В корзину</a>
    </div>
</div>
<?php } ?>
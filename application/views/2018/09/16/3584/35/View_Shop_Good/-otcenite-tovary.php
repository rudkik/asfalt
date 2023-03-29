<div class="landscape-product-widget product">
    <a class="woocommerce-LoopProduct-link" href="<?php echo $siteData->urlBasic; ?>/catalogs<?php echo $data->values['name_url']; ?>">
        <div class="media">
            <img class="wp-post-image" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 84, 74); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
            <div class="media-body">
                <span class="price">
                    <ins>
                        <span class="amount"><?php echo Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?></span>
                    </ins>
					<?php if($priceOld){ ?>
                    <del>
                        <span class="amount"><?php echo $priceOld; ?></span>
                    </del>
					<?php } ?>
                </span>
                <h2 class="woocommerce-loop-product__title"><?php echo $data->values['name']; ?></h2>
            </div>
        </div>
    </a>
</div>
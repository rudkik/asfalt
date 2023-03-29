<?php if(Request_RequestParams::getParamInt('id') != $data->id){ ?>
<?php Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?>
    <div class="landscape-product product">
        <a class="woocommerce-LoopProduct-link" href="<?php echo $siteData->urlBasic; ?>/catalogs<?php echo $data->values['name_url']; ?>">
            <div class="media">
                <img class="wp-post-image" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 224, 197); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
                <div class="media-body">
                    <span class="price">
                        <?php if(!empty($priceOld)){ ?>
						<ins>
							<span class="amount"><?php echo $priceOld; ?></span>
						</ins>
						<?php } ?>
						<span class="amount"><?php echo $price; ?></span>
                    </span>
                    <h2 class="woocommerce-loop-product__title"><?php echo $data->values['name']; ?></h2>
                </div>
            </div>
        </a>
    </div>
<?php } ?>
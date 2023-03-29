<?php Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?>
<?php if(Request_RequestParams::getParamBoolean('is_list')){ ?>
    <div class="product list-view-large #class#">
        <div class="media">
            <img width="224" height="197" alt="" class="attachment-shop_catalog size-shop_catalog wp-post-image" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 224, 197); ?>">
            <div class="media-body">
                <div class="product-info">
                    <a class="woocommerce-LoopProduct-link woocommerce-loop-product__link" href="<?php echo $siteData->urlBasic; ?>/catalogs<?php echo $data->values['name_url']; ?>">
                        <h2 class="woocommerce-loop-product__title"><?php echo $data->values['name']; ?></h2>
                    </a>
                    <?php
                    $brandImage = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_brand_id.image_path', '');
                    if (!empty($brandImage)){?>
                    <div class="brand">
                        <a href="<?php echo $siteData->urlBasic; ?>/catalogs?brand_id=<?php echo $data->values['shop_table_brand_id']; ?>">
                            <img src="<?php echo Helpers_Image::getPhotoPath($brandImage, 145, 50); ?>" alt="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_brand_id.name', ''), ENT_QUOTES);?>">
                        </a>
                    </div>
                    <?php }?>
                    <span class="sku_wrapper">
                    Артикул:
                    <span class="sku">A<?php echo $data->values['id']; ?></span>
                </span>
                </div>
                <div class="product-actions">
                    <div class="availability">
                        <p class="stock in-stock">В наличие</p>
                    </div>
                    <span class="price">
                    <span class="woocommerce-Price-amount amount">
                        <?php echo $price; ?>
                    </span>
                </span>
                    <a data-action="in-cart"  class="button add_to_cart_button" href="#">В корзину</a>
                </div>
            </div>
        </div>
    </div>
<?php }else{ ?>
    <div class="product #class#">
        <a href="<?php echo $siteData->urlBasic; ?>/catalogs<?php echo $data->values['name_url']; ?>" class="woocommerce-LoopProduct-link">
            <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 224, 197); ?>" width="224" height="197" class="wp-post-image" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
            <span class="price">
            <ins>
                <span class="amount"><?php echo $price; ?></span>
            </ins>
                <?php if(!empty($priceOld)){ ?>
                    <del>
                <span class="amount"><?php echo $priceOld; ?></span>
            </del>
                <?php } ?>
        </span>
            <h2 class="woocommerce-loop-product__title"><?php echo $data->values['name']; ?></h2>
        </a>
        <div class="hover-area">
            <a data-action="in-cart" class="button add_to_cart_button" href="#" rel="nofollow">В корзину</a>
        </div>
    </div>
<?php } ?>
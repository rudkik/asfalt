<li class="woocommerce-mini-cart-item mini_cart_item">
    <a href="#" class="remove" aria-label="Удалить" data-product_id="<?php echo $data->values['id']; ?>" data-product_sku="">×</a>
    <a href="<?php echo $siteData->urlBasic; ?>/catalogs<?php echo $data->values['name_url']; ?>">
        <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 75, 75); ?>" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"><?php echo $data->values['name']; ?></a>
    <span class="quantity">1 ×
        <span class="woocommerce-Price-amount amount">
            <?php echo Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?>
        </span>
    </span>
</li>
<li class="item">
    <div class="box-product">
        <div class="product-img">
            <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 79); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
        </div>
        <div class="product-info">
            <a class="product-title"><?php echo $data->values['name']; ?></a>
            <span class="product-description">Начало ревизии: <?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></span>
            <a href="/stock_write/shoptablerevision/stock?id=<?php echo $data->values['id']; ?>&type=<?php echo $data->values['shop_table_catalog_id']; ?>&goods-type=<?php echo Request_RequestParams::getParamInt('goods-type'); ?>" class="btn btn-danger btn-flat pull-right btn-cart">Продолжить</a>
        </div>
    </div>
</li>

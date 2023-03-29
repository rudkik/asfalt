<li class="item">
    <div class="box-product">
        <div class="product-img">
            <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 79); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
        </div>
        <div class="product-info">
            <a class="product-title"><?php echo $data->values['name']; ?></a>
            <span class="product-description">Ревизия, проверка остатков на складе</span>
            <a href="<?php echo $siteData->urlBasic; ?>/stock_write/shoptablerevision/index?type=<?php echo Arr::path($data->values, 'child_shop_table_catalog_ids.revision.id', Arr::path($data->values, 'child_shop_table_catalog_ids.35.revision.id', 0)); ?>&goods-type=<?php echo $data->id; ?>" class="btn btn-danger btn-flat pull-right btn-cart">Начать</a>
        </div>
    </div>
</li>
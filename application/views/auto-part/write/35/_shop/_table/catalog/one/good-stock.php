<li class="item">
    <div class="box-product">
        <div class="product-img">
            <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 79); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
        </div>
        <div class="product-info">
            <a class="product-title"><?php echo $data->values['name']; ?></a>
            <span class="product-description">Разместить</span>
            <a href="<?php echo $siteData->urlBasic; ?>/stock_write/shopgood/stock?type=<?php echo $data->id; ?>" class="btn btn-danger btn-flat pull-right btn-cart">Начать</a>
        </div>
    </div>
</li>
<li class="item">
    <div class="box-product">
        <div class="product-img">
            <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 79); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
        </div>
        <div class="product-info">
            <a class="product-title"><?php echo $data->values['name']; ?></a>
            <span class="product-description"> Каталог </span>
            <a href="<?php echo $siteData->urlBasic; ?>/manager/shopgood/index?shop_table_rubric_id=<?php echo $data->id; ?>" class="btn btn-danger btn-flat pull-right btn-cart">Продукция</a>
        </div>
    </div>
</li>
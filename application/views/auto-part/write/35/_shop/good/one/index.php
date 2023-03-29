<li class="item">
    <div class="box-product">
        <div class="product-img">
            <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 90, 79); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
        </div>
        <div class="product-info">
            <a class="product-title"><?php echo $data->values['name']; ?> <span class="text-red pull-right"><?php echo Func::getPriceStr($siteData->currency, $data->values['price']);?></a>
            <span class="product-description"> <?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', 'Верхнего уровня'); ?></span>
            <a href="/stock_write/shopgood/edit?id=<?php echo $data->values['id']; ?>&type=<?php echo $data->values['shop_table_catalog_id']; ?>" class="btn btn-danger btn-flat pull-right btn-cart">Изменить</a>
        </div>
    </div>
</li>

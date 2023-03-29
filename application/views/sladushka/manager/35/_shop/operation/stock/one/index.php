<li class="item">
    <div class="box-product">
        <div class="product-img">
            <img src="<?php echo Helpers_Image::getPhotoPath('', 90, 79); ?>" alt="">
        </div>
        <div class="product-info">
            <a class="product-title">Заявка №<?php echo $data->id; ?> <span class="text-red pull-right"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']);?></span></a>
            <span class="product-description"> <?php echo $siteData->operation->getName(); ?></span>
            <div class="box-cart">
                <a class="text-red" href="tel:"></a>
            </div>
            <a href="<?php echo $siteData->urlBasic; ?>/manager/shopoperationstock/edit?id=<?php echo $data->id; ?>" class="btn btn-danger btn-flat pull-right btn-cart">Просмотр</a>
        </div>
    </div>
</li>
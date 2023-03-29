<div class="col-md-2-5 product" itemscope itemtype="http://schema.org/Product">
    <div class="box-product">
        <div class="body">
            <a itemprop="url" href="<?php echo $siteData->urlBasic; ?>/catalogs<?php echo $data->values['name_url']; ?>"><img id="goods-img-<?php echo $data->values['id']; ?>" itemprop="image" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 245, 245); ?>" width="245" height="245" class="img-responsive img-product preload-product" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"></a>
            <a href="<?php echo $siteData->urlBasic; ?>/catalogs<?php echo $data->values['name_url']; ?>" title="<?php echo htmlspecialchars('<p style="font-size: 14px; ">'.$data->values['name'].'</p>', ENT_QUOTES);?>" class="name" data-toggle="tooltip" itemprop="name"><?php echo $data->values['name']; ?></a>
            <?php if($data->values['price'] > 0){ ?>
                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" style="display: none;">
                    <span itemprop="price"><?php echo $data->values['price']; ?></span>
                    <span itemprop="priceCurrency"><?php echo $siteData->currency->getCode(); ?></span>
                </div>
            <?php } ?>
            <p class="info"><?php echo Func::trimTextNew($data->values['text'], 300); ?></p>
        </div>
    </div>
</div>
<div itemscope itemtype="http://schema.org/Product" class="col-md-4 box-goods">
    <div class="goods">
        <a itemprop="url" href="<?php echo $siteData->urlBasicLanguage; ?>/products<?php echo $data->values['name_url']; ?>">
            <img width="263" height="263" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 293, 293); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
        </a>
        <h3><a itemprop="name" href="<?php echo $siteData->urlBasicLanguage; ?>/products<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></h3>
        <a class="btn-more" href="<?php echo $siteData->urlBasicLanguage; ?>/products<?php echo $data->values['name_url']; ?>">Подробнее ></a>
    </div>
    <div style="display: none;">
        <div itemprop="description"><?php echo $data->values['text']; ?></div>
        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            <span itemprop="price"><?php echo $data->values['price']; ?></span>
            <span itemprop="priceCurrency"><?php echo $siteData->currency->getCode(); ?></span>
        </div>
    </div>
</div>

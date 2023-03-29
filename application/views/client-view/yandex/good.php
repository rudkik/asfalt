<div itemscope itemtype="http://schema.org/Product" style="display: none;">
    <h1 itemprop="name"><?php echo $data->values['name']; ?></h1>
    <div itemprop="description"><?php echo $data->values['text']; ?></div>
    <?php if(! empty($data->values['image_path'])){ ?>
    <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 900, 750); ?>" itemprop="image">
    <?php } ?>
    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
        <span itemprop="price"><?php echo $data->values['price']; ?></span>
        <span itemprop="priceCurrency"><?php echo $siteData->currency->getCode(); ?></span>
    </div>
    <div itemscope="" itemtype="http://schema.org/PostalAddress">
        <span itemprop="addressLocality" data-qaid="region">г. <?php $city = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_id.'.Model_Basic_BasicObject::FIELD_ELEMENTS.'.city_id.name', ''); if(empty($city)){$city = $siteData->city->getName();} echo $city; ?></span>
    </div>
</div>
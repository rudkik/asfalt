<div class="contentInside__text col-md-6 col-12">
    <h1><?php echo $data->values['name']; ?></h1>
    <p class="mainText">
        <?php echo Arr::path($data->values['options'], 'pre_phone', ''); ?>
        <br>
        <br>
        <?php echo trim($siteData->globalDatas['view::DB_Shop_AddressContacts\-contacts-telefony']); ?>
        <?php echo Arr::path($data->values['options'], 'post_phone', ''); ?>
    </p>
    <p class="mainText">
        <?php echo Arr::path($data->values['options'], 'pre_address', ''); ?>
        <br>
        <?php echo trim($siteData->globalDatas['view::DB_Shop_Address\-contacts-adres']); ?>
</div>
<div class="contentInside__picture col-md-6 col-12">
    <div class="picture__holder">
        <img class="bigImage" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 531, null); ?>" alt="">
    </div>
</div>


<div class="col-sm-4 box-atomy-element">
    <div class="box-goods-atomy">
		<a href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>"><img class="width-100" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 321, 193); ?>"></a>
        <div class="name">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a>
        </div>
        <?php Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?>
        <p class="price"><?php if(!empty($priceOld)){ ?><span class="old"><?php echo $priceOld; ?><?php }?> <span class="new"><?php echo $price; ?></span></p>
    </div>
</div>
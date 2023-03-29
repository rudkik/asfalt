<div class="col-md-3 box-col">
    <div class="box-goods">
        <div class="box-goods-body">
            <div class="img-goods" >
                <a href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>"><img title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 371, 250); ?>"></a>
            </div>
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>" class="title"><?php echo $data->values['name']; ?></a>
            <p class="subtitle"><?php echo Arr::path($data->values['options'], 'subtitle', ''); ?></p>
            <div class="price"><?php echo Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?>/<?php echo Arr::path($data->values['options'], 'unit', 'шт.'); ?></div>
        </div>
        <a data-href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>" href="#" data-toggle="modal" data-target="#show-send" class="btn btn-flat btn-black-red width-100">Купить</a>
    </div>
</div>
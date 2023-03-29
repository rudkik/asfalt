<div class="col-md-6">
    <div class="box-goods">
        <img data-id="img" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 300, NULL); ?>" style="width: 300px; display:none;">
        <div class="media-left box-img-goods" style="background-image: url('<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 450, NULL); ?>')">
            <a href="<?php echo $siteData->urlBasic;?>/catalogs<?php echo $data->values['name_url']; ?>"> </a>
        </div>
        <div class="media-body box-info">
            <p class="box-goods-name">
                <a href="<?php echo $siteData->urlBasic;?>/catalogs<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a>
            </p>
            <?php
            $text = trim(Arr::path($data->values['options'], 'additions', ''));
            if(!empty($text)){
            ?>
            <ul class="ul-check">
                <li><?php echo str_replace("\n", "\n".'</li><li>', $text); ?></li>
            </ul>
            <?php }?>
            <span class="box-goods-price"><?php echo Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?></span>
            <button data-id="<?php echo $data->values['id']; ?>" data-action="add-cart" class="btn btn-flat btn-grey">В корзину <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/arrow.png"></button>
        </div>
    </div>
</div>
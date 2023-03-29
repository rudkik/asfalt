<div class="col-md-12 box-goods">
    <div class="row">
        <div class="col-md-5">
            <img class="img-goods" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 100, 100); ?>">
            <p class="box-goods-name"><?php echo $data->values['name']; ?></p>
            <p class="info"><?php echo Func::trimTextNew(Arr::path($data->values['options'], 'info', ''), 150); ?></p>
        </div>
        <div class="col-md-2">
            <span class="box-goods-price pull-left"><?php echo Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?></span>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <select data-id="<?php echo $data->values['id']; ?>" data-cart-action="set-good-count" data-id="" class="form-control select2" style="width: 100%;">
                    <?php
                    $s = '';
                    for ($i = 1; $i < 21; $i++){
                        $s .= '<option value="'.$i.'" data-id="'.$i.'">'.$i.'</option>';
                    }
                    $tmp = '" data-id="'.$data->additionDatas['count'].'"';
                    echo str_replace($tmp, $tmp.' selected', $s);
                    ?>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <span class="box-goods-price"><?php echo Func::getGoodAmountStr($siteData->currency, $data, $data->additionDatas['count']); ?></span>
        </div>
        <div class="col-md-1">
            <a data-id="<?php echo $data->values['id']; ?>" data-cart-action="del-good" data-action="tr-delete" class="delete" href="#"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/delete.png"></a>
        </div>
    </div>
</div>
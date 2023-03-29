<table class="table table-basket-goods">
    <tbody>
    <tr>
        <td class="box-title">
            <img class="img-goods" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 61, 70); ?>">
            <div class="goods">
                <h3><?php echo $data->values['name']; ?></h3>
                <div class="rating">
                    <?php $random = rand(0, 9); ?>
                    <div class="rating-mini">
                        <span class="active"></span>
                        <span class="active"></span>
                        <span class="active"></span>
                        <span class="active"></span>
                        <span <?php if($random > 5){ ?>class="active"<?php } ?>></span>
                    </div>
                    <div class="title"><?php echo '4.'.$random; ?> звезды</div>
                </div>
            </div>
        </td>
        <td class="box-gift" style="display: none">
            <img class="img-goods" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/goods-basket.png">
            <div class="goods">
                <h3>Товар в подарок</h3>
                <h4>Наушники HyperX Cloud Core</h4>
            </div>
        </td>
        <td class="box-count">
            <div class="pull-right">
                <div class="stepper stepper--style-2 js-spinner">
                    <input data-cart-action="set-good-count" data-id="<?php echo $data->values['id']; ?>" data-shop="<?php echo $data->values['shop_id']; ?>" autofocus type="number" min="1" max="100" step="1" value="<?php echo $data->additionDatas['count']; ?>" class="stepper__input" data-stepper-debounce="400">
                    <div class="stepper__controls">
                        <button type="button" spinner-button="up"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/plus.png"></button>
                        <button type="button" spinner-button="down"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/minus.png"></button>
                    </div>
                </div>
                <div class="box-price">
                    <div class="price-old" style="text-decoration: none;"><?php echo Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?></div>
                    <div class="price"><?php echo Func::getGoodAmountStr($siteData->currency, $data, $data->additionDatas['count']); ?></div>
                </div>
                <a class="del" href="#" data-cart-action="del-good" data-id="<?php echo $data->values['id']; ?>" data-shop="<?php echo $data->values['shop_id']; ?>"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/delete.png"></a>
            </div>
        </td>
    </tr>
    </tbody>
</table>
<article class="contentInside__text col-md-6 col-12">
    <h1><?php echo $data->values['name']; ?></h1>
    <h4><?php echo Arr::path($data->values['options'], 'subject', ''); ?></h4>
    <div class="mainText">
        <?php echo $data->values['text']; ?>
    </div>
    <ul class="plantAttribute row">
        <?php echo trim($siteData->globalDatas['view::DB_Shop_Goods\-goods-kheshtegi-tovara']); ?>
    </ul>
</article>
<div class="contentInside__picture col-md-6 col-12">
    <div class="picture__holder">
        <img id="goods-img-<?php echo $data->values['id']; ?>" class="bigImage" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 700, null); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        <div class="icon__place">
            <svg class="like" data-id="<?php echo $data->id;?> ?>" data-child="0" data-shop="0">
                <use xlink:href="#like"></use>
            </svg>
        </div>
    </div>
    <div class="buyingBlock">
        <ul class="buyingBlock__inner row">
            <li class="col-3">
                <div class="sum__box">
                    <!-- <div class="price">цена:</div> -->
                    <span class="sum"><?php echo Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?></span>
                </div>
            </li>
            <li class="col" <?php if (Func::_empty(Arr::path($data->values['options'], 'size', ''))){ ?>style="display: none"<?php } ?>>
                <span><b>объём горшка:</b> <?php echo Arr::path($data->values['options'], 'size', '');?></span>
            </li>
            <li class="quantity col">
                <input class="quantity__minus" type="button" value="-">
                <span class="quantity__number">1</span> <span class="quantity__number-text">шт</span>
                <input class="quantity__plus" type="button" value="+">
            </li>
            <li class="col-3">
                <?php if($data->values['is_public'] == 1){ ?>
                <button type="button" class="btn"  data-cart-action="add-good" data-id="<?php echo $data->values['id']; ?>" data-child="0" data-shop="<?php echo $data->values['shop_id']; ?>">в корзину</button>
                <?php }else{ ?>
                    <button type="button" class="btn" disabled>нет в наличии</button>
                <?php } ?>
            </li>
        </ul>
    </div>
</div>
<div class="col-xs-3 box-goods" itemscope itemtype="http://schema.org/Product">
    <div class="img-goods" >
        <a itemprop="url" href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>"><img itemprop="image" id="goods-img-<?php echo $data->values['id']; ?>" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 309, 158); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"></a>
    </div>
    <a itemprop="name" href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>" class="title"><?php echo $data->values['name']; ?></a>
    <div class="rating-mini">
        <span class="active"></span>
        <span class="active"></span>
        <span class="active"></span>
        <span></span>
        <span></span>
    </div>
    <div class="box-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
		<?php Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?>
		<?php if(!empty($priceOld)){ ?>
        <div class="old"><?php echo $priceOld; ?></div>
		<?php } ?>
        <div class="new"><?php echo $price; ?></div>

        <span itemprop="price" style="display:none;"><?php echo $data->values['price']; ?></span>
        <span itemprop="priceCurrency" style="display:none;"><?php echo $siteData->currency->getCode(); ?></span>
    </div>
    <div class="row btn-buy">
        <div class="col-xs-6">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>" class="btn btn-flat btn-red btn-sale">Купить</a>
        </div>
        <div class="col-xs-6">
            <a href="#" class="btn btn-flat btn-white btn-basket" data-cart-action="add-good" data-id="<?php echo $data->values['id']; ?>" data-child="0" data-shop="<?php echo $data->values['shop_id']; ?>">В корзину</a>
        </div>
    </div>
</div>
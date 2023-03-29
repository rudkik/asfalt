<div class="col-md-3 product" itemscope itemtype="http://schema.org/Product">
    <div class="box-product">
        <div class="body">
            <a itemprop="url" href="<?php echo Func::getFullURL($siteData, '/catalog/product', array('id' => 'id'), array(), $data->values); ?>">
                <img id="goods-img-23842" itemprop="image" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 245, 245); ?>" width="245" height="245" class="img-responsive img-product preload-product" alt="<?php echo $data->values['name']; ?>" title="<?php echo $data->values['name']; ?>">

            </a>
            <a href="<?php echo Func::getFullURL($siteData, '/catalog/product', array('id' => 'id'), array(), $data->values); ?>" title="<?php echo $data->values['name']; ?>" class="name" data-toggle="tooltip" itemprop="name"><?php echo $data->values['name']; ?></a>
            <div class="box-price">
                <span class="price"><?php echo Func::getNumberStr($data->values['price'], true); ?></span><span>тг</span>
            </div>
            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" style="display: none;">
                <span itemprop="price"><?php echo Func::getNumberStr($data->values['price'], true); ?></span>
                <span itemprop="priceCurrency">KZT</span>
            </div>
            <div class="text-center">
                <a data-action="btn-buy" class="btn btn-buy" href="javascript:addCart(23842, 22125)" data-id="23842">Купить</a>
            </div>
        </div>
    </div>
</div>
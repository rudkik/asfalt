
<div class="header header-breakpoint" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
    <div class="container">
        <?php echo trim($siteData->globalDatas['view::_shop/rubric/list/breadcrumb']); ?>
        <span typeof="v:Breadcrumb" class="active"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/trade/catalog/product?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a></span>
    </div>
</div>
<div class="header header-product-info" itemscope itemtype="http://schema.org/Product">
    <div class="container">
        <div class="col-md-12">
            <div class="row box-product">
                <div class="col-md-5">
                    <a class="thumbnail-goods"><img id="goods-img-22691" itemprop="image" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 900, 800); ?>" class="img-responsive img-product" alt="Детская молочная смесь Similac 1 (Симилак) от 0 до 6 месяцев, 700 г" title="Детская молочная смесь Similac 1 (Симилак) от 0 до 6 месяцев, 700 г"></a>
                    <div itemscope itemtype="http://schema.org/ImageObject" style="display: none;">
                        <h2 itemprop="name"><?php echo $data->values['name']; ?></h2>
                        <h2 itemprop="caption"><?php echo $data->values['name']; ?></h2>
                        <img id="goods-img-23842" itemprop="image" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 900, 800); ?>">
                        <span itemprop="text"><?php echo $data->values['text']; ?></span>
                    </div>
                </div>
                <div class="col-md-7">
                    <h1 itemprop="name"><?php echo $data->values['name']; ?> <span class="city">в Алматы</span></h1>
                    <div class="params" style="max-width: 400px;">
                        <p class="param"><span class="name">Объем:</span><span>700 г</span></p>
                        <p class="param"><span class="name">Штрихкод:</span><span>5099864008531</span></p>
                    </div>
                    <div><span class="price"><?php echo Func::getNumberStr($data->values['price'], true); ?></span> <span>тг</span></div>
                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" style="display: none;">
                        <span itemprop="price"><?php echo Func::getNumberStr($data->values['price'], true); ?></span>
                        <span itemprop="priceCurrency">KZT</span>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <a data-action="btn-buy" data-id="<?php echo Func::getNumberStr($data->values['id'], true); ?>" class="btn btn-buy" href="javascript:addCart(22691, 20983)">Купить</a>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row box-product-info">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 line-right">
                            <p class="info-title">Описание</p>
                            <div class="description" itemprop="description">
                                <?php echo $data->values['text']; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="info-title">Технические характеристики</p>
                            <div class="params">
                                <?php foreach ($data->values['params'] as $key => $values){?>
                                    <?php foreach ($values as $key2 => $value){?>
                                    <p class="param">
                                        <span class="name"><?php echo $key2; ?>:</span>
                                        <span><?php echo $value;?> </span>
                                    </p>
                                <?php } } ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<?php
$_POST['_rubric_id_'] = $data->values['shop_table_rubric_id'];
Helpers_SEO::setSEOHeader(Model_Shop_Good::TABLE_NAME, $data, $siteData);
$siteData->siteImage = Helpers_Image::getPhotoPath($data->values['image_path'], 420, 350);
?>
<?php
$shopGoodIDs = MySession::getSession($siteData->shopID, 'view_shop_good_ids');
if((empty($shopGoodIDs)) || (! is_array($shopGoodIDs))) {
    $shopGoodIDs = array($data->id => $data->id);
}else {
    if(key_exists($data->id, $shopGoodIDs)){
        unset($shopGoodIDs[$data->id]);
    }
    $shopGoodIDs = array($data->id => $data->id) + $shopGoodIDs;

    if(count($shopGoodIDs) > 100) {
        $new = array();
        $i = 0;
        foreach ($shopGoodIDs as $shopGoodID) {
            $new[$shopGoodID] = $shopGoodID;
            $i++;
            if($i > 100){
               break;
            }
        }
        $shopGoodIDs = $new;
    }
}
MySession::setSession($siteData->shopID, 'view_shop_good_ids', $shopGoodIDs);
?>
<div class="header header-breakpoint" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
    <div class="container">
		<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/">Главная</a></span> /
        <?php echo trim($siteData->globalDatas['view::View_Shop_Table_Rubrics\-catalog-khlebnye-kroshki']); ?>
		<span class="active" typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/catalogs<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></span>
    </div>
</div>
<div class="header header-product-info" itemscope itemtype="http://schema.org/Product">
    <div class="container">
        <div class="col-md-12">
            <div class="row box-product">
                <div class="col-md-9 line-right">
                    <div class="row line-bottom">
                        <div class="col-md-5">
                            <a class="thumbnail-goods"><img id="goods-img-<?php echo $data->values['id']; ?>" itemprop="image" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 420, 350); ?>" class="img-responsive img-product" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"></a>
                            <div itemscope itemtype="http://schema.org/ImageObject" style="display: none;">
                                <h2 itemprop="name"><?php echo $data->values['name']; ?></h2>
                                <h2 itemprop="caption"><?php echo $data->values['name']; ?></h2>
                                <img src=​"<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 900, 800); ?>" itemprop="contentUrl" />
                                <span itemprop="description"><?php echo Arr::path($data->values, 'text', Arr::path($data->values, 'info', '')); ?></span>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h1 itemprop="name"><?php echo $data->values['name']; ?> <span class="city">в <?php echo Func::getStringCaseRus($siteData->city->getName(), 5); ?></span></h1>
                            <div class="params">
                                <?php if(!empty($data->values['article'])){ ?>
                                <p class="param"><span class="name">Артикул:</span><span><?php echo $data->values['article']; ?></span></p>
                                <?php } ?>
                            </div>
                            <?php if (Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld, FALSE) > 0){ ?>
                            <div><span class="price"><?php echo Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?></span> <span class="weight">/ от 1 <?php echo $data->getElementValue('shop_table_unit_id', 'name', 'шт.'); ?></span></div>
                            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" style="display: none;">
                                <span itemprop="price"><?php echo $data->values['price']; ?></span>
                                <span itemprop="priceCurrency"><?php echo $siteData->currency->getCode(); ?></span>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <p class="title">Контакты</p>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\-goods-kontakty']); ?>
                    <p class="title" style="margin-top: 20px;">Адрес</p>
                    <p class="company-info">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_Address\-goods-adres']); ?>
                    </p>
                </div>
            </div>
            <div class="row box-product-info">
                <div class="col-md-12">
                    <div class="row">
                        <?php if(!empty($data->values['text'])){ ?>
                            <div class="col-md-6 line-right">
                                <p class="info-title">Описание</p>
                                <div itemprop="description">
                                    <?php echo $data->values['text']; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                        <?php }else{ ?>
                            <div class="col-md-12">
                        <?php } ?>

                            <p class="info-title">Параметры</p>
                            <div class="params">
                                <?php
                                $options = $data->values['options'];
                                ksort($options);
                                foreach($options as $optionKey => $optionValue) {
                                    if (!empty($optionValue)) {
                                        ?>
                                        <p class="param"><span class="name"><?php echo $optionKey; ?>
                                                :</span><span><?php echo $optionValue; ?></span></p>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="image-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" style="margin-top: 60px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <div class="modal-title">Просмотр изображения</div>
            </div>
            <div class="modal-body">
                <img class="img-responsive center-block" src="" alt="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('a.thumbnail-goods').click(function(e) {
            e.preventDefault();

            src = $(this).find('img').attr('src');
            var arr = src.split('/');
            file = arr[arr.length-1];
            var arr = file.split('.');
            file1 = arr[0];
            arr2 = file1.split('-');
            file2 = arr2[0] + '-950x700.' + arr[1];
            src = src.replace(file, file2);

            $('#image-modal .modal-body img').attr('src', src);
            $("#image-modal").modal('show');
        });
        $('#image-modal .modal-body img').on('click', function() {
            $("#image-modal").modal('hide')
        });
    });
</script>
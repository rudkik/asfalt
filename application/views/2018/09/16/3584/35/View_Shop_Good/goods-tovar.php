<?php
$_GET['rubric_id'] = $data->values['shop_table_rubric_id'];
$_GET['brand_id'] = $data->values['shop_table_brand_id'];

Helpers_SEO::setSEOHeader(Model_Shop_Good::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<nav class="woocommerce-breadcrumb">
    <a href="<?php echo $siteData->urlBasic; ?>">Главная</a>
    <span class="delimiter">
        <i class="tm tm-breadcrumbs-arrow-right"></i>
    </span>
    ...
    <span class="delimiter">
        <i class="tm tm-breadcrumbs-arrow-right"></i>
    </span>
    <a href="<?php echo $siteData->urlBasic; ?>/catalogs<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name_url', ''); ?>"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', ''); ?></a>
    <span class="delimiter">
        <i class="tm tm-breadcrumbs-arrow-right"></i>
    </span>
    <?php echo $data->values['name']; ?>
</nav>
<?php Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld, FALSE); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="product product-type-simple">
            <div class="single-product-wrapper">
                <div class="product-images-wrapper thumb-count-4">
                    <?php if(!empty($priceOld)){ ?>
                    <span class="onsale">-
                        <span class="woocommerce-Price-amount amount">
                            <?php echo Func::getPriceStr($siteData->currency, $price - $priceOld); ?>
                        </span>
                    </span>
                    <?php } ?>
                    <div id="techmarket-single-product-gallery" class="techmarket-single-product-gallery techmarket-single-product-gallery--with-images techmarket-single-product-gallery--columns-4 images" data-columns="4">
                        <div class="techmarket-single-product-gallery-images" data-ride="tm-slick-carousel" data-wrap=".woocommerce-product-gallery__wrapper" data-slick="{&quot;infinite&quot;:false,&quot;slidesToShow&quot;:1,&quot;slidesToScroll&quot;:1,&quot;dots&quot;:false,&quot;arrows&quot;:false,&quot;asNavFor&quot;:&quot;#techmarket-single-product-gallery .techmarket-single-product-gallery-thumbnails__wrapper&quot;}">
                            <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images" data-columns="4">
                                <a href="#" class="woocommerce-product-gallery__trigger">🔍</a>
                                <figure class="woocommerce-product-gallery__wrapper ">
                                    <?php
                                    if(is_array($data->values['files'])) {
                                        foreach ($data->values['files'] as $file) {
                                            if (($file['type'] == Model_ImageType::IMAGE_TYPE_IMAGE) || (intval($file['type']) == 0)) {
                                                ?>
                                                <div data-thumb="<?php echo Helpers_Image::getPhotoPath($file['file'], 180, 180); ?>" class="woocommerce-product-gallery__image">
                                                    <a href="<?php echo Helpers_Image::getPhotoPath($file['file'], 600, 600); ?>" tabindex="0">
                                                        <img width="600" height="600" src="<?php echo Helpers_Image::getPhotoPath($file['file'], 600, 600); ?>" class="attachment-shop_single size-shop_single wp-post-image" alt="<?php echo htmlspecialchars($file['title'], ENT_QUOTES);?>">
                                                    </a>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </figure>
                            </div>
                        </div>
                        <div class="techmarket-single-product-gallery-thumbnails" data-ride="tm-slick-carousel" data-wrap=".techmarket-single-product-gallery-thumbnails__wrapper" data-slick="{&quot;infinite&quot;:false,&quot;slidesToShow&quot;:4,&quot;slidesToScroll&quot;:1,&quot;dots&quot;:false,&quot;arrows&quot;:true,&quot;vertical&quot;:true,&quot;verticalSwiping&quot;:true,&quot;focusOnSelect&quot;:true,&quot;touchMove&quot;:true,&quot;prevArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-up\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;nextArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-down\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;asNavFor&quot;:&quot;#techmarket-single-product-gallery .woocommerce-product-gallery__wrapper&quot;,&quot;responsive&quot;:[{&quot;breakpoint&quot;:765,&quot;settings&quot;:{&quot;vertical&quot;:false,&quot;horizontal&quot;:true,&quot;verticalSwiping&quot;:false,&quot;slidesToShow&quot;:4}}]}">
                            <figure class="techmarket-single-product-gallery-thumbnails__wrapper">
                                <?php
                                if(is_array($data->values['files'])) {
                                    foreach ($data->values['files'] as $file) {
                                        if (($file['type'] == Model_ImageType::IMAGE_TYPE_IMAGE) || (intval($file['type']) == 0)) {
                                            ?>
                                            <figure data-thumb="<?php echo Helpers_Image::getPhotoPath($file['file'], 180, 180); ?>" class="techmarket-wc-product-gallery__image">
                                                <img width="180" height="180" src="<?php echo Helpers_Image::getPhotoPath($file['file'], 180, 180); ?>" class="attachment-shop_thumbnail size-shop_thumbnail wp-post-image" alt="<?php echo htmlspecialchars($file['title'], ENT_QUOTES);?>">
                                            </figure>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </figure>
                        </div>
                    </div>
                </div>
                <div class="summary entry-summary">
                    <div class="single-product-header">
                        <h1 class="product_title entry-title"><?php echo $data->values['name']; ?></h1>
                    </div>
                    <div class="single-product-meta">
                        <?php
                        $brandImage = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_brand_id.image_path', '');
                        if (!empty($brandImage)){?>
                        <div class="brand">
                            <a href="<?php echo $siteData->urlBasic; ?>/catalogs?brand_id=<?php echo $data->values['shop_table_brand_id']; ?>">
                                <img src="<?php echo Helpers_Image::getPhotoPath($brandImage, 145, 50); ?>" alt="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_brand_id.name', ''), ENT_QUOTES);?>">
                            </a>
                        </div>
                        <?php }?>
                        <div class="cat-and-sku">
                            <span class="posted_in categories">
                                <a rel="tag" href="<?php echo $siteData->urlBasic; ?>/catalogs<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name_url', ''); ?>"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', ''); ?></a>
                            </span>
                            <span class="sku_wrapper">
                                Артикул: <span class="sku">A<?php echo $data->id; ?></span>
                            </span>
                        </div>
                        <div class="product-label"></div>
                    </div>
                    <div class="woocommerce-product-details__short-description">
                        <?php echo $data->values['text']; ?>
                    </div>
                    <div class="product-actions-wrapper">
                        <div class="product-actions">
                            <p class="price">
								<?php if(!empty($priceOld)){ ?>
                                <del>
                                    <span class="woocommerce-Price-amount amount">
                                        <?php echo Func::getPriceStr($siteData->currency, $priceOld); ?>
                                    </span>
                                </del>
								<?php } ?>
                                <ins>
                                    <span class="woocommerce-Price-amount amount">
                                        <?php echo Func::getPriceStr($siteData->currency, $price); ?>
                                    </span>
                                </ins>
                            </p>
                            <form enctype="multipart/form-data" method="post" class="cart">
                                <div class="quantity">
                                    <label for="quantity-input">Кол-во</label>
                                    <input type="number" size="4" class="input-text qty text" title="Qty" value="1" name="quantity" id="quantity-input">
                                </div>
                                <button class="single_add_to_cart_button button alt" value="185" name="add-to-cart" type="submit">В корзину</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\goods-podobnye-tovary']); ?>
            <div class="woocommerce-tabs wc-tabs-wrapper">
                <ul role="tablist" class="nav tabs wc-tabs">
                    <li class="nav-item description_tab">
                        <a class="nav-link" data-toggle="tab" role="tab" aria-controls="tab-description" href="#tab-description">Описание</a>
                    </li>
                    <li class="nav-item specification_tab">
                        <a class="nav-link" data-toggle="tab" role="tab" aria-controls="tab-specification" href="#tab-specification">Характеристики</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane panel wc-tab" id="tab-description" role="tabpanel">
                        <h2>Описание</h2>
						<?php echo $data->values['text']; ?>
                    </div>
                    <div class="tab-pane" id="tab-specification" role="tabpanel">
                        <div class="tm-shop-attributes-detail like-column columns-3">
                            <h3 class="tm-attributes-title">Характеристики</h3>
                            <table class="shop_attributes">
                                <tbody>
                                <?php
                                $fields = Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_catalog_id.fields_options.shop_good', '');
                                foreach ($fields as $field){
                                    $value = Arr::path($data->values['options'], $field['field'], NULL);
                                    if($value !== NULL){?>
                                <tr>
                                    <th><?php echo $field['title']; ?></th>
                                    <td><?php echo $value; ?></td>
                                </tr>
                                <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\goods-tovary-kategorii']); ?>
        </div>
    </main>
</div>


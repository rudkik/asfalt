<?php
Helpers_SEO::setSEOHeader(Model_Shop_Good::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<?php $_GET['_root_id_'] = $data->values['shop_table_rubric_id']; ?>
    <header class="header-breadcrumb">
        <div class="container">
            <h1><?php echo $data->values['name']; ?></h1>
            <div class="breadcrumbs">
                <a href="<?php echo $siteData->urlBasic;?>; ?>">Главная</a> |
                <?php echo trim($siteData->globalDatas['view::View_Shop_Table_Rubrics\-catalogs-khlebnye-kroshki']); ?>
                <a class="active" href="<?php echo $siteData->urlBasic;?>/catalogs<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a>
            </div>
        </div>
    </header>
</header>
<header class="header-goods">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?php
                $files = Arr::path($data->values, 'files', array());
                if (count($files) > 0){
                    ?>
                    <div class="photo-list" id="sliders">
                        <?php
                        $i = 0;
                        $files = Arr::path($data->values, 'files', array());
                        foreach($files as $index => $file) {
                            $type = intval(Arr::path($file, 'type', 0));
                            if(($type == Model_ImageType::IMAGE_TYPE_IMAGE) || (($type == 0))){
                                $i++;
                                ?>
                                <div class="item<?php if($i == 1){echo ' active';} ?>">
                                    <a data-fancybox="gallery" href="<?php echo Helpers_Image::getPhotoPath(Arr::path($file, 'file', ''), NULL, 700);?>" data-width="<?php echo Arr::path($file, 'w', '');?>" data-height="<?php echo Arr::path($file, 'h', '');?>">
                                        <img class="img-fluid" src="<?php echo Helpers_Image::getPhotoPath($file['file'], 571, 379);?>" alt="<?php echo Arr::path($file, 'title', '');?>" style="margin: 0 auto;">
                                    </a>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#sliders').slick({
                                arrows:         true,
                                dots:           false,
                                infinite:       true,
                                slidesToShow:   1,
                                slidesToScroll: 1,
                                adaptiveHeight: true,
                                autoplay: true,
                                autoplaySpeed: 20000,
                                initialSlide: 0,
                            });
                        });
                        $('[data-fancybox="gallery"]').fancybox();
                    </script>
                <?php } ?>
            </div>
            <div class="col-md-6">
                <p class="box-goods-name"><?php echo $data->values['name']; ?></p>
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
            <div class="col-md-12">
                <div class="box-text">
                    <?php echo $data->values['text']; ?>
                </div>
            </div>
        </div>
    </div>
</header>
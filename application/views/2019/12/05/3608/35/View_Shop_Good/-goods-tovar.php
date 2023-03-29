<?php
$_GET['root_rubric'] = $data->values['shop_table_rubric_id'];
Helpers_SEO::setSEOHeader(Model_Shop_Good::TABLE_NAME, $data, $siteData);
$siteData->siteImage = Helpers_Image::getPhotoPath($data->values['image_path'], 420, 350);
?>
<header class="header-bread-crumbs">
    <div class="container">
        <div class="box-bread-crumbs" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
            <a typeof="v:Breadcrumb" rel="v:url" property="v:title" href="<?php echo $siteData->urlBasicLanguage; ?>/">Главная</a> /
            <?php echo trim($siteData->globalDatas['view::View_Shop_Table_Rubrics\-catalogs-khlebnye-kroshki']); ?>
            <span typeof="v:Breadcrumb" property="v:title" ><?php echo $data->values['name']; ?></span>
        </div>
    </div>
</header>
<header class="header-goods-info">
    <div class="container" itemscope itemtype="http://schema.org/Product">
        <div class="row">
            <div class="col-sm-5">
                <div class="box-images">
                    <div class="previews">
                        <?php
                        $i = 0;
                        $files = Arr::path($data->values, 'files', array());
                        foreach($files as $index => $file) {
                            $type = intval(Arr::path($file, 'type', 0));
                            if(($type == Model_ImageType::IMAGE_TYPE_IMAGE) || (($type == 0))){
                                $i++;
                                ?>
                                <img data-action="show-big-img" href="<?php echo Helpers_Image::getPhotoPath($file['file'], 443, 361); ?>" src="<?php echo Helpers_Image::getPhotoPath($file['file'], 50, 57);?>" alt="<?php echo Arr::path($file, 'title', '');?>">
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="box-image">
                        <img class="width-100" id="big-goods" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 443, 361); ?>" itemprop="image">
                    </div>

                    <div style="display: none">
                        <?php
                        $i = 0;
                        $files = Arr::path($data->values, 'files', array());
                        foreach($files as $index => $file) {
                            $type = intval(Arr::path($file, 'type', 0));
                            if(($type == Model_ImageType::IMAGE_TYPE_IMAGE) || (($type == 0))){
                                $i++;
                                ?>
                                <img data-fancybox="gallery" href="<?php echo $file['file'];?>" src="<?php echo Helpers_Image::getPhotoPath($file['file'], 50, 57);?>" alt="<?php echo Arr::path($file, 'title', '');?>">
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="box-title">
                    <h1 itemprop="name" itemprop="headline"><?php echo $data->values['name']; ?></h1>
                    <div class="availability"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/check.png"> В наличии</div>
                </div>
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
                <div class="line"></div>
                <div class="box_text">
                    <?php echo Arr::path($data->values['options'], 'info', ''); ?>
                </div>
                <div class="line"></div>
                <div class="box-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <?php Func::getGoodPriceStr($siteData->currency, $data, $price, $priceOld); ?>
                    <?php if(!empty($priceOld)){ ?>
                    <div class="price-old"><?php echo $priceOld; ?></div>
                    <?php } ?>
                    <div class="price"><?php echo $price; ?></div>

                    <span itemprop="price" style="display: none"><?php echo $data->values['price']; ?></span>
                    <span itemprop="priceCurrency" style="display: none"><?php echo $siteData->currency->getCode(); ?></span>
                </div>
                <div class="row btn-buy">
                    <div class="col-xs-6">
                        <a href="" class="btn btn-flat btn-white btn-img btn-basket">В корзину</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-gift" style="display: none">
            <div class="col-md-6 box-info">
                <img class="img-gift" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/gift.png">
                <div class="info">
                    <p>При покупке товара - <b>комплект бесплатно</b></p>
                    <p>Купить комплект с подарком можно ниже. </p>
                </div>
            </div>
            <div class="col-md-6 box-sale">
                <div class="time">
                    до конца акции<br> осталось
                </div>
                <div class="clock"></div>
            </div>
        </div>
        <div class="box-addition">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#info">Oписание</a></li>
               <!-- <li><a data-toggle="tab" href="#comment">Отзывы (0)</a></li> -->
            </ul>
            <div class="tab-content">
                <div id="info" class="tab-pane fade in active" itemprop="description">
                    <div class="box_text info">
                        <?php echo $data->values['text']; ?>
                    </div>
                    <?php
                    $table = Arr::path($data->values['options'], 'params', array());
                    if (!empty($table)){?>
                        <table class="table table-params">
                            <tbody>
                            <?php
                            foreach ($table as $child){
                                if(Arr::path($child, 'is_public', TRUE)){
                                    ?>
                                    <tr>
                                        <td><?php echo Arr::path($child, 'name', ''); ?></td>
                                        <td><?php echo Arr::path($child, 'title', ''); ?></td>
                                    </tr>
                                    <?php
                                }
                            } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
                <div id="comment" class="tab-pane fade">
                    <h3>Панель 2</h3>
                    <p>Содержимое 2 панели...</p>
                </div>
            </div>
        </div>
        <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-goods-tovary-dlya-sravneniya']); ?>
    </div>
</header>
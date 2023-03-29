<?php
Helpers_SEO::setSEOHeader(Model_Shop_Good::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<?php
$_POST['_root_id_'] = $data->values['shop_table_rubric_id'];
?>
<header class="header-bread-crumbs">
    <div class="container">
        <h1><?php echo $data->values['name']; ?></h1>
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>">Главная</a> /
			<?php echo trim($siteData->globalDatas['view::View_Shop_Table_Rubrics\-truck-khlebnye-kroshki']); ?>
            <span><?php echo $data->values['name']; ?></span>
        </div>
    </div>
</header>
<header class="header-goods">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php echo $data->values['name']; ?> <span class="yellow"><?php echo $data->getElementValue('shop_mark_id', 'name'); ?> <?php echo $data->getElementValue('shop_model_id', 'name'); ?></span></h2>
                <div class="box-chosen">
                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/heart.png"> <a href="">Отслеживать этого дилера</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="box-imgs">
                    <?php if(count($data->values['files']) > 1) { ?>
                    <a class="slider-left" href="#" data-action="left"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/s-left.png"></a>
                    <?php } ?>
                    <div id="images" class="box-img">
                        <?php
                        if(is_array($data->values['files'])) {
                            foreach ($data->values['files'] as $file) {
                                if (($file['type'] == Model_ImageType::IMAGE_TYPE_IMAGE) || (intval($file['type']) == 0)) {
                                    ?>
                                    <a data-fancybox="gallery" href="<?php echo Arr::path($file, 'file', '');?>" data-width="<?php echo Arr::path($file, 'w', '');?>" data-height="<?php echo Arr::path($file, 'h', '');?>">
                                        <img class="img-fluid" src="<?php echo Helpers_Image::getPhotoPath($file['file'], 610, 406);?>" alt="<?php echo Arr::path($file, 'title', '');?>" title="<?php echo htmlspecialchars($file['title'], ENT_QUOTES);?>" style="margin: 0 auto;">
                                    </a>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                    <?php if(count($data->values['files']) > 1) { ?>
                    <a class="slider-right"  href="#" data-action="right"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/s-right.png"></a>
                    <?php } ?>
                    <?php if(count($data->values['files']) > 1) { ?>
                        <script>
                        $(document).ready(function() {
                            $('#images').slick({
                                arrows:         false,
                                dots:           false,
                                infinite:       true,
                                slidesToShow:   1,
                                slidesToScroll: 1,
                                adaptiveHeight: true,
                                autoplay: true,
                                autoplaySpeed: 20000,
                                initialSlide: 0,
                            });
                            $('[data-action="right"]').on('click', function() {
                                $('#images').slick('slickNext');
                                return false;
                            });
                            $('[data-action="left"]').on('click', function() {
                                $('#images').slick('slickPrev');
                                return false;
                            });
                            $('[data-fancybox="gallery"]').fancybox();
                        });
                    </script>
                    <?php } ?>
                </div>
                <?php if(count($data->values['files']) > 1) { ?>
                <div class="list-img">
                    <div class="row">
                        <?php
                        if(is_array($data->values['files'])) {
                            $i = -1;
                            foreach ($data->values['files'] as $file) {
                                $i++;
                                if (($file['type'] == Model_ImageType::IMAGE_TYPE_IMAGE) || (intval($file['type']) == 0)) {
                                    ?>
                                    <div class="col-xs-2">
                                        <div class="b-img">
                                            <img data-action="slider-click" data-index="<?php echo $i; ?>" src="<?php echo Helpers_Image::getPhotoPath($file['file'], 162, 88);?>" alt="<?php echo Arr::path($file, 'title', '');?>" title="<?php echo htmlspecialchars($file['title'], ENT_QUOTES);?>">
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
                    <script>
                        $(document).ready(function() {
                            $('[data-action="slider-click"]').click(function () {
                                $('#images').slick('slickGoTo', $(this).data('index'), true);
                            });
                        });
                    </script>
                <?php } ?>
            </div>
            <div class="col-sm-6 box-good-info">
                <h3>Основная информация</h3>
                <table class="params">
                    <tr>
                        <td>Категория</td>
                        <td><a href="<?php echo $siteData->urlBasicLanguage; ?>/trucks<?php echo $data->getElementValue('shop_table_rubric_id', 'name_url'); ?>"><?php echo $data->getElementValue('shop_table_rubric_id', 'name'); ?></a></td>
                    </tr>
                    <tr>
                        <td>Марка / модель</td>
                        <td><?php echo $data->getElementValue('shop_mark_id', 'name'); ?> <?php echo $data->getElementValue('shop_model_id', 'name'); ?></td>
                    </tr>
                    <tr>
                        <td>Год выпуска</td>
                        <td><?php echo $data->values['param_1_int']; ?></td>
                    </tr>
                    <tr>
                        <td>Месторасположение</td>
                        <td><?php echo $data->getElementValue('location_land_id', 'name'); ?></td>
                    </tr>
                    <tr>
                        <td>Номер объявления</td>
                        <td><?php echo $data->values['id']; ?></td>
                    </tr>
                </table>
                <h3>Информация по продажи</h3>
                <table class="params">
                    <tr>
                        <td>Цена</td>
                        <td class="price"><?php
                            $price = Func::getCarPriceStr($siteData->currency, $data, $price, $priceOld, FALSE);
                            if($price > 0){
                                echo Func::getCarPriceStr($siteData->currency, $data, $price, $priceOld);
                            }else {
                                echo 'по запросу';
                            }
                            ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 box-good-info margin-b-50">
                <h3>ПОДРОБНОСТИ</h3>
                <?php
                $table = Arr::path($data->values['options'], 'table', array());
                if (!empty($table)){?>
                <table class="params">
                    <?php
                    foreach ($table as $child){
                        if(Arr::path($child, 'is_public', FALSE)){
                        ?>
                            <tr>
                                <td><?php echo Arr::path($child, 'name', ''); ?></td>
                                <td><?php echo Arr::path($child, 'title', ''); ?></td>
                            </tr>
                    <?php
                        }
                    } ?>
                </table>
                <?php } ?>
            </div>
            <div class="col-md-6">
                <div class="box-sales-form margin-b-50">
                    <?php if($data->values['shop_table_param_4_id'] > 0){ ?>
                        <div class="row box-title">
                        <div class="col-xs-6">
                            <p class="title"><?php echo $data->getElementValue('shop_table_param_4_id', 'name'); ?></p>
                            <p class="info"><?php echo $data->getElementValue('shop_table_param_4_id', 'options.position'); ?></p>
                            <?php $phone = $data->getElementValue('shop_table_param_4_id', 'options.phone2'); ?>
                            <?php if(!empty($phone)){?>
                                <p class="info" style="margin: 0px">Телефон: <a itemprop="telephone" href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></p>
                            <?php }?>
                            <?php $email = $data->getElementValue('shop_table_param_4_id', 'options.email'); ?>
                            <?php if(!empty($email)){?>
                                <p class="info">E-mail: <a itemprop="email" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
                            <?php }?>
                        </div>
                        <div class="col-xs-6">
                            <div class="btn-yellow btn-oblique">
                                <span>
                                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
                                    <?php $phone = $data->getElementValue('shop_table_param_4_id', 'options.phone1'); ?>
                                    <a itemprop="telephone" href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
                                </span>
                            </button>
                        </div>
                    </div>
                    <?php }else{?>
                        <?php echo trim($siteData->globalDatas['view::View_Shop_Table_Params\-truck-kontakty-menedzhera']); ?>
                    <?php }?>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="subtitle">Отправить запрос</p>
                        </div>
                        <div class="col-xs-6">
                            <input type="text" class="input-caeq form-control" placeholder="Дата начала аренды">
                        </div>
                        <div class="col-xs-6">
                            <input type="text" class="input-caeq form-control" placeholder="Дата начала аренды">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <input type="text" class="input-caeq form-control" placeholder="Ваше имя *">
                        </div>
                        <div class="col-xs-6">
                            <input type="text" class="input-caeq form-control" placeholder="E-mail * ">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <textarea class="input-caeq form-control" rows="4" placeholder="Текст запроса * "></textarea>
                        </div>
                        <div class="col-xs-6">
                            <input type="text" class="input-caeq form-control" placeholder="Телефон *">
                            <button type="button" class="btn btn-block btn-yellow btn-oblique margin-t-30">
                                <span>Отправить</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box_text"><?php echo $data->values['text']; ?></div>
    </div>
</header>
<?php  $siteData->replaceDatas['view::title_page'] = $data->values['name']; ?>
<header class="header-main">
    <div class="container">
        <h2><?php echo $data->values['name']; ?></h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <div class="row kitchen" style="margin-top: 30px">
            <div class="col-sm-12">
                <div class="line">
                    <p>Наши повара готовят блюда восточной и европейской кухни по-домашнему, с душой. В меню вы найдете каши, супы, вторые блюда, салаты, напитки.  Вы можете заказать лагман, плов, манты, сырне, бешбармак, куырдак, пельмени и многое другое.</p>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="line">
                            <p><b>Заказы принимаются заранее по телефонам:<br> <a href="tel:+7 702 431 21 35">+7 702 431 21 35</a> <br> <a href="tel:+7 707 910 80 79">+7 707 910 80 79</a></b></p>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Время работы:</h4>
                            </div>
                        </div>
                        <div class="row menu">
                            <div class="col-sm-12" style="margin-bottom: 15px">
                                <div class="row">
                                    <div class="col-sm-6 bold">
                                        Завтрак:
                                    </div>
                                    <div class="col-sm-6">
                                        8.30 - 10.30
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 bold">
                                        Обед:
                                    </div>
                                    <div class="col-sm-6">
                                        12.00 - 15.00
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 bold">
                                        Ужин:
                                    </div>
                                    <div class="col-sm-6">
                                        18.00 - 21.00
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="line">
                            <h4 style="margin-top: 0px;">Мангал зона</h4>
                            <p>Для любителей шашлыка и коктала, у нас есть мангал зона с мангалами, печкой-казаном и коктальницей. Для удобства гостей в мангал зоне есть столы и рукомойник. Вы можете самостоятельно приготовить шашлык или коктал, или другое блюдо в казане совершенно бесплатно.</p>
                        </div>
                        <div class="row">
                            <div class="box-btn">
                                <a href="<?php echo Arr::path($data->values['options'], 'price_list.file', '') ?>" class="btn btn-flat btn-blue">Скачать меню</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<link href="<?php echo $siteData->urlBasic;?>/css/_component/fancybox/dist/jquery.fancybox.min.css" rel="stylesheet">
<header class="header-gallery">
    <div class="container">
        <h2>Наши фотографии</h2>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <div class="row box-imgs">
            <div class="col-6 col-lg-4">
            <?php
            $files = Arr::path($data->values, 'files', array());
            $n = count($files);
            $rows = floor($n / 3);
            if($rows < ceil($n / 3)){
                $rows++;
            }

            $i = 0;
            foreach($files as $index => $file) {
                if((! is_array($file)) || (!key_exists('type', $file))){
                    continue;
                }
                $tуpe = intval(Arr::path($file, 'type', 0));
                if(($tуpe == Model_ImageType::IMAGE_TYPE_IMAGE) || (($tуpe == 0))){
                    $i++;
                    if($i == $rows + 1){
                        echo '</div><div class="col-6 col-lg-4">';
                        $i = 1;
                    }
                    ?>
                    <a class="d-block mb-4" data-fancybox="images" href="<?php echo Arr::path($file, 'file', '');?>" data-width="<?php echo Arr::path($file, 'w', '');?>" data-height="<?php echo Arr::path($file, 'h', '');?>">
                        <img class="img-fluid" src="<?php echo Helpers_Image::getPhotoPath($file['file'], 440, 0);?>" alt="<?php echo Arr::path($file, 'title', '');?>">
                    </a>
                    <?php
                }
            }
            ?>
            </div>
        </div>
    </div>
</header>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/fancybox/dist/jquery.fancybox.min.js"></script>
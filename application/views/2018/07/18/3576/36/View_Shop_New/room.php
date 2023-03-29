<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<?php  $siteData->replaceDatas['view::title_page'] = $data->values['name']; ?>
<h2><?php echo $data->values['name']; ?></h2>
<img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
<div class="row margin-t-40">
    <div class="col-sm-6 pool">
        <img class="img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 675, 432); ?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        <div class="title">
            <div class="row box-list-size">
                <div class="col-sm-3 box-price">
                    <?php echo Arr::path($data->values['options'], 'price', ''); ?>
                </div>
                <div class="col-sm-9 box-name" style="border-right: none;">
                    <?php echo Arr::path($data->values['options'], 'name', ''); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <p class="name"><?php echo $data->values['name']; ?></p>
        <div class="info"><?php echo $data->values['text']; ?></div>
    </div>
</div>
<link href="<?php echo $siteData->urlBasic;?>/css/_component/fancybox/dist/jquery.fancybox.min.css" rel="stylesheet">
<header class="header-gallery">
    <div class="container">
        <h2>Our Photo</h2>
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
                    $tуpe = intval(Arr::path($file, 'type', 0) );
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
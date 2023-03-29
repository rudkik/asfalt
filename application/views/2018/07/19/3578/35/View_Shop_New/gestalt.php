<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<div class="row">
    <div class="col-md-8">
        <h1><?php echo $data->values['name']; ?></h1>
    </div>
    <div class="col-md-4 box-a" style="font-size: 20px;">
        <a class="a-green" href="<?php echo $siteData->urlBasic;?>/teams" style="margin-right: 20px">Наша команда</a>
        <a class="a-green" href="<?php echo $siteData->urlBasic;?>/about">О центре</a>
    </div>
</div>
<div class="box-text-article">
	<?php echo $data->values['text']; ?>
</div>
<link href="<?php echo $siteData->urlBasic;?>/css/_component/fancybox/dist/jquery.fancybox.min.css" rel="stylesheet">
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
<script src="<?php echo $siteData->urlBasic;?>/css/_component/fancybox/dist/jquery.fancybox.min.js"></script>
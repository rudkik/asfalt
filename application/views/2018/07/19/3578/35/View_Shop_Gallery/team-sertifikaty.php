<link href="<?php echo $siteData->urlBasic;?>/css/_component/fancybox/dist/jquery.fancybox.min.css" rel="stylesheet">
<div class="row box-imgs">
    <div class="col-6 col-lg-3">
        <?php
        $files = Arr::path($data->values, 'files', array());
        $n = count($files);
        $rows = floor($n / 4);
        if($rows < ceil($n / 4)){
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
                    echo '</div><div class="col-6 col-lg-3">';
                    $i = 1;
                }
                ?>
                <a class="d-block mb-4" data-fancybox="images" href="<?php echo Arr::path($file, 'file', '');?>" data-width="<?php echo Arr::path($file, 'w', '');?>" data-height="<?php echo Arr::path($file, 'h', '');?>">
                    <img class="img-fluid" src="<?php echo Helpers_Image::getPhotoPath($file['file'], 322, 0);?>" alt="<?php echo Arr::path($file, 'title', '');?>">
                </a>
                <?php
            }
        }
        ?>
    </div>
</div>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/fancybox/dist/jquery.fancybox.min.js"></script>
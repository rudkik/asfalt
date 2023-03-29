<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<header class="header-bread-crumbs">
    <div class="container">
        <h2><?php echo $data->values['name']; ?></h2>
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>">Main</a> |
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us">About us</a> |
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/news">News</a> |
            <span><?php echo $data->values['name']; ?></span>
        </div>
    </div>
</header>
<header class="header-article">
    <div class="container">
        <h1 itemprop="name"><?php echo $data->values['name']; ?></h1>
        <div class="line-red"></div>
        <div class="box_text margin-b-40">
            <?php echo $data->values['text']; ?>
        </div>

        <?php
        $files = Arr::path($data->values, 'files', array());
        if (count($files) > 1){
            ?>
            <div class="photo-list margin-b-40" id="sliders">
                <?php
                $i = 0;
                $files = Arr::path($data->values, 'files', array());
                foreach($files as $index => $file) {
                    $type = intval(Arr::path($file, 'type', 0));
                    if(($type == Model_ImageType::IMAGE_TYPE_IMAGE) || (($type == 0))){
                        $i++;
                        if($i == 1){
                            continue;
                        }
                        ?>
                        <div class="item<?php if($i == 2){echo ' active';} ?>">
                            <a data-fancybox="gallery" href="<?php echo Arr::path($file, 'file', '');?>" data-width="<?php echo Arr::path($file, 'w', '');?>" data-height="<?php echo Arr::path($file, 'h', '');?>">
                                <img class="img-fluid" src="<?php echo Helpers_Image::getPhotoPath($file['file'], 1190, 793);?>" alt="<?php $s = Arr::path($file, 'title', ''); if(empty($s)){$s = $data->values['name'];} echo $s;?>" style="margin: 0 auto;">
                            </a>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        <?php } ?>
        <ul class="box-pagination">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\-about-us-news-show-predydushchaya-statya']); ?>
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\-about-us-news-show-sledushchaya-statya']); ?>
        </ul>
    </div>
</header>
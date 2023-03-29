<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
    <header class="header-breadcrumb">
        <div class="container">
            <h1><?php echo $data->values['name']; ?></h1>
            <div class="breadcrumbs">
                <a href="<?php echo $siteData->urlBasicLanguage; ?>/">Главная</a> |
                <a class="active" href="<?php echo $siteData->urlBasicLanguage; ?>/about"><?php echo $data->values['name']; ?></a>
            </div>
        </div>
    </header>
</header>
<header class="header-text">
    <div class="container">
        <div class="box-text">
            <?php echo $data->values['text']; ?>
            <?php if(count($data->values['files']) > 0){ ?>
                <br><br><br>
                <div class="row">
                    <?php
                    foreach(Arr::path($data->values, 'files', array()) as $index => $file) {
                        if((! is_array($file)) || (!key_exists('type', $file))){
                            continue;
                        }
                        $tуpe = intval(Arr::path($file, 'type', 0));
                        if(($tуpe == Model_ImageType::IMAGE_TYPE_IMAGE) || (($tуpe == 0))){
                        ?>
                        <div class="col-md-4">
                            <img src="<?php echo Helpers_Image::getPhotoPath($file['file'], 430, 286); ?>" alt="<?php echo htmlspecialchars($file['title'], ENT_QUOTES); ?>">
                        </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</header>
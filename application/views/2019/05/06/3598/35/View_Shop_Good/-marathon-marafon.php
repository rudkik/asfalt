<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<header class="header-breadcrumb">
    <div class="container">
        <h1><?php echo $data->values['name']; ?></h1>
        <div class="breadcrumbs">
            <a href="<?php echo $siteData->urlBasic;?>/">Главная</a> /
            <a class="active" href="<?php echo $siteData->urlBasic;?>/articles<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a>
        </div>
    </div>
</header>
<header class="header-text">
    <div class="container">
        <div class="line-green"></div>
        <div class="box-text">
            <?php echo $data->values['text']; ?>
        </div>
    </div>
</header>
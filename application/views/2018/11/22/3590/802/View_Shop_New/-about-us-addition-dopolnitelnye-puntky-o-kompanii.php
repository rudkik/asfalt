<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<header class="header-bread-crumbs">
    <div class="container">
        <h2><?php echo $data->values['name']; ?></h2>
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>">Main</a> |
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us">عن الشركة</a> |
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
    </div>
</header>
<div class="background-4">
    <div class="header-advantages box-pay">
        <h2><?php echo $data->values['name']; ?></h2>
        <div class="h2-line"></div>
        <div class="info"><?php echo $data->values['text']; ?></div>
        <a href="<?php echo $siteData->urlBasic; ?>/catalogs" class="btn btn-flat btn-background">ПЕРЕЙТИ В КАТАЛОГ</a>
        <div class="row advantages">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\usloviya-dostavki-i-oplata-spisok']); ?>
        </div>
    </div>
</div>
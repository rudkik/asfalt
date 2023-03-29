<div class="header"></div>
<div class="promo_link_section">
    <?php echo trim($siteData->globalDatas['view::View_Shops\-saity']); ?>
</div>
<div class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col logo_cont">
                <img src="<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getPhotoPathByImageType($siteData->shop->getFilesArray(), 'logo'), 110, 110);?>" alt="<?php echo htmlspecialchars($siteData->shop->getName(), ENT_QUOTES);?>" class="logo">
            </div>
            <div class="col copyright">© UNI-TECH 2018 WSZELKIE PRAWA ZASTRZEŻONE</div>
        </div>
    </div>
</div>
<header class="header-body">
    <div class="col-md-12">
        <div class="box-menu">
            <a href="<?php echo $siteData->urlBasicLanguage;?>"><img class="logo" src="<?php echo $siteData->shop->getImagePath();?>"></a>
            <div class="menus">
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasicLanguage;?>/about">О компании</a>
                </div>
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasicLanguage;?>/sectors">Направления</a>
                </div>
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasicLanguage;?>/sector-articles">Статьи</a>
                </div>
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasicLanguage;?>/contacts">Контакты</a>
                </div>
            </div>
            <div class="contact">
                <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefony-sverkhu']); ?>
            </div>
        </div>
        <div class="box-body">
            <?php echo trim($siteData->globalDatas['view::View_Shop_New\sector-acticle-statya']); ?>
        </div>
    </div>
</header>
<header class="header-body">
    <div class="col-md-12">
        <div class="box-menu">
            <a href="<?php echo $siteData->urlBasic;?>"><img class="logo" src="<?php echo $siteData->shop->getImagePath();?>"></a>
            <div class="menus">
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasic;?>/about">О компании</a>
                </div>
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasic;?>/sectors">Направления</a>
                </div>
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasic;?>/articles">Статьи</a>
                </div>
                <div class="menu">
                    <a href="<?php echo $siteData->urlBasic;?>/contacts">Контакты</a>
                </div>
            </div>
            <div class="contact">
                <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefony-sverkhu']); ?>
            </div>
        </div>
        <div class="box-body">
            <?php echo trim($siteData->globalDatas['view::View_Shop_New\acticle-statya']); ?>
        </div>
    </div>
</header>
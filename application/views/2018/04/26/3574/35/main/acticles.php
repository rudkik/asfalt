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
            <h1>Новости и статьи</h1>
            <div class="list-news">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\acticles-poslednyaya-statya']); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\acticles-stati']); ?>
                    </div>
                </div>
            </div>
            <div class="bg-grey">
                <div class="row">
                    <div class="col-md-12 socials-title" style="text-align: center;">
                        <a href="<?php echo $siteData->urlBasic;?>/articles">Больше статей</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
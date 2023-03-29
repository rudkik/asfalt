<header class="header-bread-crumbs">
    <div class="container">
        <div class="box-bread-crumbs" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
            <a typeof="v:Breadcrumb" rel="v:url" property="v:title"  href="<?php echo $siteData->urlBasicLanguage; ?>/">Главная</a> /
            <span typeof="v:Breadcrumb" property="v:title">История заказов</span>
        </div>
    </div>
</header>
<header class="header-goods-list">
    <div class="container">
        <h1 itemprop="headline">История заказов</h1>
        <div class="row">
            <div class="col-md-3">
                <ul class="my-account-menu">
                    <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/my/bills">История заказов</a></li>
                    <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/my/info">Данные</a></li>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sistemnye-stati']); ?>
                </ul>
            </div>
            <div class="col-md-9">

            </div>
        </div>
    </div>
</header>
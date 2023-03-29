<header class="header-bread-crumbs">
    <div class="container">
        <div class="box-bread-crumbs" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
            <a typeof="v:Breadcrumb" rel="v:url" property="v:title"  href="<?php echo $siteData->urlBasicLanguage; ?>/">Главная</a> /
            <span typeof="v:Breadcrumb" property="v:title" >Поиск "<b><?php echo Request_RequestParams::getParamStr('name_lexicon'); ?></b>"</span>
        </div>
    </div>
</header>
<header class="header-goods-list">
    <div class="container">
        <h1 itemprop="headline">Поиск "<b><?php echo Request_RequestParams::getParamStr('name_lexicon'); ?></b>"</h1>
        <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-catalogs-produktciya']); ?>
    </div>
</header>
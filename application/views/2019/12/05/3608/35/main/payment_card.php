<header class="header-bread-crumbs">
    <div class="container">
        <div class="box-bread-crumbs" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
            <a typeof="v:Breadcrumb" rel="v:url" property="v:title"  href="<?php echo $siteData->urlBasicLanguage; ?>/">Главная</a> /
            <span typeof="v:Breadcrumb" property="v:title" >Оплата банковской карточкой</span>
        </div>
    </div>
</header>
<header class="header-goods-list">
    <div class="container">
        <h1 itemprop="headline">Оплата банковской картой</h1>
        <div class="box_text text-center">
            <a href="/bank/in_bank?bill_id=<?php echo Request_RequestParams::getParamInt('bill_id'); ?>&bank=alfabank" class="btn btn-flat btn-red btn-img btn-sale bth-finish">Перейти к оплате</a>
        </div>
    </div>
</header>
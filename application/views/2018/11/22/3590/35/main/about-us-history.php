<header class="header-bread-crumbs">
    <div class="container">
        <h2>История компании</h2>
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>">Главная</a> |
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us">О компании</a> |
            <span>История компании</span>
        </div>
    </div>
</header>
<header class="header-history">
    <div class="container">
        <h1 itemprop="headline" class="objectTitle2">История компании</h1>
        <div class="line-red"></div>
        <div id="history" class="row">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\-about-us-history-istoriya-kompanii']); ?>
        </div>
    </div>
</header>
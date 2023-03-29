<header class="header-bread-crumbs">
    <div class="container">
        <h2>Nowości</h2>
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>">Main</a> |
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us">O nas</a> |
            <span>Nowości</span>
        </div>
    </div>
</header>
<header class="header-events">
    <div class="container">
        <h1 itemprop="headline" class="objectTitle2">Nowości</h1>
        <div class="line-red"></div>
        <div class="row">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\-about-us-news-novosti']); ?>
        </div>
    </div>
</header>
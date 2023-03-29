<header class="header-bread-crumbs">
    <div class="container">
        <h1>Новости</h1>
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>">Главная</a> /
            <span>Новости</span>
        </div>
    </div>
</header>
<header class="header-articles">
    <div class="container">
        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-articles-stati']); ?>
    </div>
</header>
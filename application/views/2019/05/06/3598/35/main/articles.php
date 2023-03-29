<header class="header-breadcrumb">
    <div class="container">
        <h1>Статьи</h1>
        <div class="breadcrumbs">
            <a href="<?php echo $siteData->urlBasic;?>/">Главная</a> /
            <a class="active" href="<?php echo $siteData->urlBasic;?>/articles">Статьи</a>
        </div>
    </div>
</header>
<header class="header-articles">
    <div class="container">
        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-articles-stati']); ?>
    </div>
</header>
    <header class="header-breadcrumbs">
        <div class="container">
            <h1>Статьи</h1>
            <div class="box-bread-crumbs">
                <a href="<?php echo $siteData->urlBasic;?>/">Главная</a> <span>/</span>
                <span class="current">Статьи</span>
            </div>
        </div>
    </header>
    <header class="header-list-articles">
        <div class="container">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News/-articles-stati']); ?>
        </div>
    </header>
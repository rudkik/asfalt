<header class="header-blog-slider"></header>
<header class="header-blogs">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Блог</h1>
                <?php echo trim($siteData->globalDatas['view::View_Shop_News\blogs-blog']); ?>
            </div>
            <div class="col-md-4">
                <div class="box-catalogs">
                    <div class="name">Категории</div>
                    <ul class="catalog">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\blogs-rubriki']); ?>
                    </ul>
                </div>
                <div class="box-catalogs">
                    <div class="name">Архив</div>
                    <ul class="catalog">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\blogs-mesyatca-i-goda']); ?>
                    </ul>
                </div>
                <div class="box-catalogs">
                    <div class="name">Поиск по тегам</div>
                    <div class="hashtags">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\blogs-kheshtegi']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
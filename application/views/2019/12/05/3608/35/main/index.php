<header class="header-slider">
    <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="10000">
        <div class="carousel-inner">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\-slaider-na-glavnoi']); ?>
        </div>
        <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Предыдущий</span>
        </a>
        <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Следующий</span>
        </a>
    </div>
</header>
<header class="header-company">
    <div class="container">
        <header class="header-about">
            <div class="container">
                <div class="box-info-atomy">
                    <h2>О компании</h2>
                    <div class="text">
                        Atomy - Южно-Корейская компания, прославившаяся натуральными и безопасными продуктами для здоровья!
                    </div>
                    <a href="<?php echo $siteData->urlBasic;?>/about" class="btn btn-flat btn-purple">Подробнее</a>
                </div>
            </div>
        </header>
        <header class="header-list-goods">
            <div class="container">
                <div class="box-info-atomy">
                    <h2>Наши товары</h2>
                    <div class="text">
                        Предоставляем Эко-продукцию абсолютного качества по абсолютной цене каждой семье!
                    </div>
                    <a href="<?php echo $siteData->urlBasic;?>/catalogs" class="btn btn-flat btn-purple">Подробнее</a>
                </div>
            </div>
        </header>
    </div>
</header>
<header class="header-catalogs">
    <div class="container">
        <h2>Каталог продукции</h2>
        <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-katalog-produktcii']); ?>
    </div>
</header>
<header class="header-company-text">
    <div class="container">
        <header class="header-about-text">
            <div class="container">
                <div class="box-info-atomy">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_News\-o-kompanii']); ?>
                </div>
            </div>
        </header>
        <header class="header-certificate">
            <div class="container">
                <div id="certificate" class="carousel slide" data-ride="carousel" data-interval="10000">
                    <div class="carousel-inner">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-sertifikaty']); ?>
                    </div>
                    <a class="left carousel-control" href="#certificate" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Предыдущий</span>
                    </a>
                    <a class="right carousel-control" href="#certificate" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Следующий</span>
                    </a>
                </div>
            </div>
        </header>
    </div>
</header>
<header class="header-goods">
    <div class="container">
        <h2>ТОП продукции</h2>
        <div class="row">
            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-top-produktcii']); ?>
        </div>
    </div>
</header>
<header class="header-company">
    <div class="container">
        <header class="header-women">
            <div class="container">
            </div>
        </header>
        <header class="header-comments">
            <div class="container">
                <div class="box-title">
                    <h2>Истории успеха</h2>
                    <div class="box-slider-btn">
                        <a class="slider-left" href="#comments" role="button" data-slide="prev"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/left.png"></a>
                        <a class="slider-right" href="#comments" role="button" data-slide="next"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/right.png"></a>
                    </div>
                </div>
                <?php echo trim($siteData->globalDatas['view::View_Shop_Comments\-otzyvy']); ?>
            </div>
        </header>
    </div>
</header>
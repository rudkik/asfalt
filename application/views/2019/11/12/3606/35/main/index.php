<header class="header-slider">
    <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="10000">
        <div class="carousel-inner">
           <?php echo trim($siteData->globalDatas['view::View_Shop_News\slaider-na-glavnoi']); ?>
        </div>
        <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
            <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/left-w.png">
            <span class="sr-only">Предыдущий</span>
        </a>
        <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
            <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/right-w.png">
            <span class="sr-only">Следующий</span>
        </a>
    </div>
</header>
<header class="header-categories">
    <div class="container">
        <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\gruppy-tovarov']); ?>
    </div>
</header>
<header class="header-goods">
    <div class="container">
        <h2>Хиты продаж</h2>
        <div class="row box-works" data-action="slider-goods">
            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\khity-prodazh']); ?>
        </div>
        <div class="line margin-b-50"></div>
        <h2>Распродажа</h2>
        <div class="row box-works" data-action="slider-goods">
            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\rasprodazha']); ?>
        </div>
    </div>
</header>
<header class="header-about">
    <div class="container">
        <h2>О нашем магазине</h2>
        <div class="row">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\o-kompanii']); ?>
        </div>
    </div>
</header>
<header class="header-comments">
    <div class="container">
        <h2>Отзывы наших клиентов</h2>
        <div id="carousel-comments" class="carousel slide" data-ride="carousel" data-interval="10000">
            <div class="carousel-inner">
                <?php echo trim($siteData->globalDatas['view::View_Shop_Comments\otzyvy']); ?>
            </div>
            <a class="left carousel-control" href="#carousel-comments" role="button" data-slide="prev">
                <div class="glyphicon glyphicon-chevron-left">
                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/left.png">
                </div>
                <span class="sr-only">Предыдущий</span>
            </a>
            <a class="right carousel-control" href="#carousel-comments" role="button" data-slide="next">
                <div class="glyphicon glyphicon-chevron-right">
                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/right.png">
                </div>
                <span class="sr-only">Следующий</span>
            </a>
        </div>
    </div>
</header>
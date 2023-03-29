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
</header>
<header class="header-background-2 header-background">
    <header class="header-direction">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-napravleniya']); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box-direction-info">
                        <h2>Наши направления</h2>
                        <h4>гарантия качества производимой продукции</h4>
                        <div class="info">
                            <p>С 2014 года Home-Mebel представляет на рынке Казахстана Российскую продукцию для производства корпусной мебели, интерьерных панелей, узорчатых зеркал выпускаемых под торговыми марками «Albico», «Eleros» и «Brinolli».</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</header>
<header class="header-background-3 header-background">
    <header class="header-workers">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="box-worker-info">
                        <h2>Наши направления</h2>
                        <h4>гарантия качества производимой продукции</h4>
                        <div class="info">
                            <p>С 2014 года Home-Mebel представляет на рынке Казахстана Российскую продукцию для производства корпусной мебели, интерьерных панелей, узорчатых зеркал выпускаемых под торговыми марками «Albico», «Eleros» и «Brinolli».</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-worker">
                                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/FlexiCAM.jpg">
                                <a>FlexiCAM!</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box-worker">
                                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/shop.jpg">
                                <a>Наш магазин</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-worker">
                                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/vys.jpg">
                                <a>Выставка</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box-worker">
                                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/vys2.jpg">
                                <a href="">Выставка</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
</header>
<header class="header-background-4 header-background">
    <header class="index header-contact">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="box-map">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_Address\-karta']); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box-worker-info">
                        <h2>Контакты</h2>
                        <?php echo trim($siteData->globalDatas['view::View_Shop_Addresss\-filialy']); ?>
                        <button class="btn btn-flat btn-grey">Оставить заявку <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/arrow.png"></button>
                    </div>
                </div>
            </div>
        </div>
    </header>
</header>
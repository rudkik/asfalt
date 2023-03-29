<header class="header-slider">
    <div class="slider">
        <div class="container">
            <div class="col-md-12">
                <div class="box-left">
                    <h1>ПСИХОЛОГИЧЕСКИЙ ЦЕНТР</h1>
                    <p>Наш центр работает для того, чтоб <label class="green">ТЫ нашел свой источник</label> внутри себя, потому что только этот источник для тебя станет неисчерпаемым!</p>
                    <div class="row box-groups">
                        <div class="col-md-4">
                            <a href="">
                                <img class="img-responsive" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/slider/g1.png">
                                <span>Личная терапия</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="">
                                <img class="img-responsive" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/slider/g2.png">
                                <span>Тематические группы</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="">
                                <img class="img-responsive" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/slider/g3.png">
                                <span>Групповая терапия</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<header class="header-event">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Ближайшие события</h2>
            </div>
            <div class="col-md-4 box-a">
                <a class="a-green" href="<?php echo $siteData->urlBasic;?>/schedule">Перейти в раздел</a>
            </div>
        </div>
        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-blizhaishie-meropriyatiya']); ?>
    </div>
</header>
<?php echo trim($siteData->globalDatas['view::View_Shop_News\-o-tcentre']); ?>
<header class="header-team">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Наша команда</h2>
            </div>
            <div class="col-md-4 box-a">
                <a class="a-green" href="<?php echo $siteData->urlBasic;?>/teams">Перейти в раздел</a>
            </div>
        </div>
        <div class="row">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\-nasha-komanda']); ?>
        </div>
    </div>
</header>
<header class="header-comment">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Отзывы наших клиентов</h2>
            </div>
            <div class="col-md-4 box-a">
                <a class="a-green" href="<?php echo $siteData->urlBasic;?>/comments">Перейти в раздел</a>
            </div>
        </div>
		<?php echo trim($siteData->globalDatas['view::View_Shop_Comments\-otzyvy']); ?>
    </div>
</header>
<header class="header-blog">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2>Блог</h2>
            </div>
            <div class="col-md-4 box-a">
                <a class="a-green" href="<?php echo $siteData->urlBasic;?>/blog">Перейти в раздел</a>
            </div>
        </div>
        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-blog']); ?>
    </div>
</header>
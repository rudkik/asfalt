<header class="header-slider">
    <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="10000">
        <div class="carousel-inner">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\-slaider']); ?>
        </div>
        <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
            <img class="glyphicon glyphicon-chevron-left" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/arrow-l-w.png">
            <span class="sr-only">Предыдущий</span>
        </a>
        <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
            <img class="glyphicon glyphicon-chevron-right" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/arrow-r-w.png">
            <span class="sr-only">Следующий</span>
        </a>
    </div>
</header>
<header class="header-list-goods">
    <div class="container">
        <h1 class="text-center">Эксперт и поставщик<br> электрохирургических систем</h1>
        <p class="box-subtitle">BOWA разрабатывает и представляет высокотехнологичные решения в области производства медицинского оборудования. С момента основания в 1977 году компания постоянно развивается и сегодня по праву занимает свое место среди ведущих производителей электрохирургических систем</p>
        <div class="row">
			<?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-produktciya']); ?>
		</div>
        <div class="text-center">
            <a href="<?php echo $siteData->urlBasic;?>/catalogs" class="btn btn-flat btn-red btn-big">В каталог</a>
        </div>
    </div>
</header>
<header class="header-list-news">
    <div class="container">
        <h1 class="text-center">Новости</h1>
        <div class="row">
			<?php echo trim($siteData->globalDatas['view::View_Shop_News\-novosti']); ?>
        </div>
        <div class="text-center">
            <a href="<?php echo $siteData->urlBasic;?>/news" class="btn btn-flat btn-red btn-big">Все новости</a>
        </div>
    </div>
</header>
<header class="header-slider">
    <div id="slider" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\-slaider-na-glavnoi']); ?>
        </div>
    </div>
</header>
<div class="box-bg-dom">
    <header class="header-department">
        <div class="container">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\-napravleniya']); ?>
            <div class="col-md-2-5 department">
                <div class="media-left">
                    <img class="active" src="http://okdmcs.kz/img/2/2018/12/23/3960/3960.png">
                    <img class="no-active" src="http://okdmcs.kz/img/2/2018/12/23/3960/3960_1.png">
                </div>
                <div class="media-body">
                    <div class="box-text"><a href="http://www.sadykhan.kz/">Интернет-аптека "Садыхан"</a></div>
                </div>
            </div>
        </div>
    </header>
    <header class="header-why">
        <div class="container">
            <h2>Почему именно мы</h2>
            <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
            <div class="row">
                <?php echo trim($siteData->globalDatas['view::View_Shop_News\-pochemu-my']); ?>
            </div>
        </div>
    </header>
</div>
<header class="header-services box-services">
    <div class="container">
        <h2>Наши услуги</h2>
        <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-nashi-uslugi']); ?>
    </div>
</header>
<header class="header-comments">
    <div class="container">
        <h2>Отзывы наших клиентов</h2>
        <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <div class="box-comments">
            <div id="comments" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Comments\-otzyvy']); ?>
                </div>
            </div>
        </div>
    </div>
</header>
<header class="header-certificates">
    <div class="container">
        <h2>Сертификаты</h2>
        <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-sertifikaty']); ?>
    </div>
</header>
<header class="header-send">
    <div class="container">
        <div class="box-left">
            <h2>Запись на прием</h2>
            <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
            <p>Оставьте заявку и мы свяжемся с Вами в ближайщее время</p>
        </div>
        <div class="box-right">
            <a class="btn btn-default btn-yellow" href="#modal-send" data-toggle="modal">Записаться</a>
        </div>
    </div>
</header>
<header class="header-sales box-sales">
    <div class="container">
        <h2>Акции и cкидки</h2>
        <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-skidki-i-aktcii']); ?>
    </div>
</header>
<header class="header-benefit">
    <div class="container">
        <h2>Полезная информация</h2>
        <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">

        <div class="text-center">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#panel1">Статьи</a></li>
                <li><a data-toggle="tab" href="#panel2">Рекомендации</a></li>
            </ul>
        </div>
        <div class="tab-content box-articles">
            <div id="panel1" class="tab-pane fade in active">
                <?php echo trim($siteData->globalDatas['view::View_Shop_News\-novosti']); ?>
            </div>
            <div id="panel2" class="tab-pane fade">
                <?php echo trim($siteData->globalDatas['view::View_Shop_News\-rekomendatcii']); ?>
            </div>
        </div>
    </div>
</header>
<header class="header-workers">
    <div class="container">
        <h2>Наши сотрудники</h2>
        <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-spetcialisty']); ?>
    </div>
</header>
<header class="header-video">
    <div class="container">
        <h2>Видеоблог</h2>
        <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <div class="box-video" style="background: url('<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/video.png') no-repeat scroll center top transparent;">
            <div class="box-mac">
                <div id="video" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-video-blog']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
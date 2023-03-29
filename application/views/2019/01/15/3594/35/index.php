<!doctype html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="<?php if($siteData->isIndexRobots){echo 'index';}else{echo 'noindex';} ?>">
    <meta name="description" content="<?php echo htmlspecialchars($siteData->siteDescription, ENT_QUOTES); ?>" />
    <meta name="keywords" content="<?php echo htmlspecialchars($siteData->siteKeywords, ENT_QUOTES); ?>" />

    <title><?php echo trim($siteData->siteTitle); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo trim($siteData->meta); ?>
    <meta property="og:locale" content="ru_RU" />
    <meta property="og:site_name" content="<?php echo htmlspecialchars($siteData->shop->getName(), ENT_QUOTES); ?> на русском" />
    <meta property="og:url" content="<?php echo trim($siteData->urlCanonical); ?>" >
    <meta itemprop="name" content="<?php echo htmlspecialchars($siteData->siteTitle, ENT_QUOTES); ?>">
    <meta itemprop="description" content="<?php echo htmlspecialchars($siteData->siteDescription, ENT_QUOTES); ?>">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($siteData->siteTitle, ENT_QUOTES); ?> ">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($siteData->siteDescription, ENT_QUOTES); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($siteData->siteTitle, ENT_QUOTES); ?>" />
    <meta property="og:description" content="<?php echo htmlspecialchars($siteData->siteDescription, ENT_QUOTES); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="<?php if (empty($siteData->siteImage)){echo Func::addSiteNameInFilePath($siteData->shop->getImagePath(), $siteData);}else{echo Func::addSiteNameInFilePath($siteData->siteImage, $siteData);} ?>" />

    <?php if(!empty($siteData->favicon)){ ?>
        <?php if(is_array($siteData->favicon)){ ?>
            <?php foreach($siteData->favicon as $key => $value){ ?>
                <link rel="apple-touch-icon-precomposed" sizes="<?php echo $key; ?>" href="<?php echo Func::addSiteNameInFilePath($value, $siteData); ?>" />
                <link rel="icon" type="image/png" href="<?php echo Func::addSiteNameInFilePath($value, $siteData); ?>" sizes="<?php echo $key; ?>" />
            <?php } ?>
        <?php }else{ ?>
            <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo Helpers_Image::getPhotoPath($siteData->favicon, 57, 57) ?>" />
            <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Helpers_Image::getPhotoPath($siteData->favicon, 72, 72) ?>" />
            <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Helpers_Image::getPhotoPath($siteData->favicon, 144, 144) ?>" />
            <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo Helpers_Image::getPhotoPath($siteData->favicon, 120, 120) ?>" />
            <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo Helpers_Image::getPhotoPath($siteData->favicon, 152, 152) ?>" />
            <link rel="icon" type="image/png" href="<?php echo Helpers_Image::getPhotoPath($siteData->favicon, 32, 32) ?>" sizes="32x32" />
            <link rel="icon" type="image/png" href="<?php echo Helpers_Image::getPhotoPath($siteData->favicon, 16, 16) ?>" sizes="16x16" />
        <?php } ?>
    <?php } ?>

    <?php if(!empty($siteData->siteImage)){ ?>
        <meta itemprop="image" content="<?php echo htmlspecialchars(Func::addSiteNameInFilePath($siteData->siteImage), ENT_QUOTES); ?>" />
        <meta property="og:image" content="<?php echo htmlspecialchars(Func::addSiteNameInFilePath($siteData->siteImage), ENT_QUOTES); ?>" />
        <meta name="twitter:image:src" content="<?php echo htmlspecialchars(Func::addSiteNameInFilePath($siteData->siteImage), ENT_QUOTES); ?>" />
    <?php } ?>

    <?php
    if ($siteData->pages > 1){
        if ($siteData->page > 1){
            $urlParams = $siteData->urlParams ;
            $urlParams['page'] = $siteData->page - 1;
            echo '<link rel="prev" href="'.$siteData->urlBasic.$siteData->url.URL::query($urlParams, FALSE).'">'."\r\n";
        }

        if ($siteData->pages > $siteData->page){
            $urlParams = $siteData->urlParams ;
            $urlParams['page'] = $siteData->page + 1;
            echo '		<link rel="next" href="'.$siteData->urlBasic.$siteData->url.URL::query($urlParams, FALSE).'">';
        }
    }
    ?>
    <?php
    if ($siteData->favicon != ''){
        echo '<link href="'.$siteData->urlBasic.trim($siteData->favicon).'" rel="shortcut icon" />';
    }
    ?>
    <link rel="canonical" href="<?php echo trim($siteData->urlCanonical); ?>" />
	
	<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">
    <link href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/style.css">
</head>
<body itemscope="itemscope" itemtype="http://schema.org/WebPage"><!-- !@@&body&@@! -->
<div class="body">
    <header class="header-menu">
        <div class="container">
            <div class="box-logo">
                <a href="<?php echo $siteData->urlBasic;?>/"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png"></a>
            </div>
            <div class="pull-right">
                <nav class="navbar navbar-default pull-left">
                    <div class="container-fluid">
                        <nav class="navbar navbar-default">
                            <div class="container-fluid">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                    <ul class="nav navbar-nav">
                                        <li>
                                            <a class="nav-link" href="<?php echo $siteData->urlBasic;?>/automation">Автоматизация</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="<?php echo $siteData->urlBasic;?>/sites">Сайты и приложения</a>
                                        </li>
                                        <li class="active">
                                            <a class="nav-link" href="<?php echo $siteData->urlBasic;?>/portfolio">Портфолио</a>
                                        </li>
                                        <li>
                                            <a class="nav-link" href="<?php echo $siteData->urlBasic;?>/contacts">Контакты</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </nav>
                <div class="box-phone">
                    <div class="media-left">
                        <img class="box-img" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
                    </div>
                    <div class="media-body">
                        <div class="phone"><?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefon']); ?></div>
                        <div class="title"><a href="">Заказать звонок</a></div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <?php echo trim($data['view::body']);?>
    <header class="header-send">
        <div class="container">
            <div class="box-left">
                <h2>Хотите сайт?</h2>
                <p class="info">Закажите сейчас и получите скидку <span class="blue-circle">30%</span> на услугу</p>
            </div>
            <div class="box-send ">
                <input type="text" class="form-control" placeholder="Телефон">
                <button type="button" class="btn btn-default btn-white">Заказать</button>
            </div>
        </div>
    </header>
</div>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <ul class="menu">
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/o-nas">О нас</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/komanda">Команда</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/articles">Статьи</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/sertifikaty">Сертификаты</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/nagrady">Награды</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/na-chem-my-pishem">На чем мы пишем</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="menu">
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/sait-vizitka">Сайт-визитка</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/">Сертификаты</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/landing-page">Landing page</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/internet-magazin">Интернет-магазин</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/korporativnyi-portal">Корпоративный портал</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="menu">
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/dizain">Дизайн</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/logotipy">Логотипы</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/firmennyi-stil">Фирменный стиль</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/mobilnye-prilozheniya">Мобильные приложения</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/razrabotka-programmnogo-obespecheniya">Разработка программного обеспечения</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="menu">
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/kontekstnaya-reklama">Контекстная реклама</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/bannernaya-reklama">Баннерная реклама</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/smm">SMM</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/seo-prodvizhenie">SEO продвижение</a></li>
                </ul>
            </div>
        </div>
        <div class="row margin-t-40">
            <div class="col-md-3">
                <ul class="menu">
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/avtomatizatciya-predpriyatii">Автоматизация предприятий</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/vnedrenie-biznes-protcessov">Внедрение бизнес-процессов</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/podderzhka-i-obsluzhivanie-saitov">Поддержка и обслуживание сайтов</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/data/vnedrenie-i-obsluzhivanie-1s">Внедрение и обслуживание 1С</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="menu">
                    <li><a href="">Обратная связь</a></li>
                    <li><a href="<?php echo $siteData->urlBasic;?>/contacts">Контакты</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
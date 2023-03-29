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
    <script>
        window.loadCSS = function(hf) {
            var ms=document.createElement("link");ms.rel="stylesheet";
            ms.href=hf;document.getElementsByTagName("head")[0].appendChild(ms);
        }
    </script>
    <style>
        <?php
        echo file_get_contents($siteData->urlBasic.'/css/'.$siteData->shopShablonPath.'/css/bootstrap-grid.css');
        echo file_get_contents($siteData->urlBasic.'/css/'.$siteData->shopShablonPath.'/base/header.css');
        echo file_get_contents($siteData->urlBasic.'/css/'.$siteData->shopShablonPath.'/base/main.css');
        echo file_get_contents($siteData->urlBasic.'/css/'.$siteData->shopShablonPath.'/base/footer.css');
        ?>
    </style>
</head>
<body itemscope="itemscope" itemtype="http://schema.org/WebPage"><!-- !@@&body&@@! --><header class="page__header">
    <div class="container p-none">
        <div class="row justify-content-between no-gutters">
            <div class="col-sm-auto col-6 align-self-center">
                <div class="page__header__logo">
                    <a href="<?php echo $siteData->urlBasic;?>/">
                        <figure><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/logo.png" alt="Logo"></figure>
                    </a>
                </div>
            </div>
            <div class="col-sm-auto col-6 align-self-center" style="z-index: 99;">
                <div class="page__header__links">
                    <div class="page__header__hamburger" onclick="
							this.classList.toggle('active');
							this.nextElementSibling.classList.toggle('active');
							document.body.classList.toggle('noScroll');
						">
                        <div class="page__header__hamburger__item"></div>
                        <div class="page__header__hamburger__item"></div>
                        <div class="page__header__hamburger__item"></div>
                    </div>
                    <div class="page__header__links__list__wrap">
                        <ul class="page__header__links__list ">
                            <li class="page__header__links__list__item<?php if(($siteData->url == '/catalog') || ($siteData->url == '/goods')){echo ' active';} ?>">
                                <a href="<?php echo $siteData->urlBasic;?>/catalog">Каталог</a>
                            </li>
                            <li class="page__header__links__list__item<?php if($siteData->url == '/lease'){echo ' active';} ?>">
                                <a href="<?php echo $siteData->urlBasic;?>/lease">Аренда</a>
                            </li>
                            <li class="page__header__links__list__item<?php if($siteData->url == '/about'){echo ' active';} ?>">
                                <a href="<?php echo $siteData->urlBasic;?>/about">О компании</a>
                            </li>
                            <li class="page__header__links__list__item<?php if(($siteData->url == '/news') || ($siteData->url == '/article')){echo ' active';} ?>">
                                <a href="<?php echo $siteData->urlBasic;?>/news">Новости</a>
                            </li>
                            <li class="page__header__links__list__item<?php if($siteData->url == '/contacts'){echo ' active';} ?>">
                                <a href="<?php echo $siteData->urlBasic;?>/contacts">Контакты</a>
                            </li>
                        </ul>
                    </div>
                    <div class="page__header__links__tel">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefony-sverkhu']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header><?php echo trim($data['view::body']);?><footer class="page__footer">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="page__footer__site__map page__footer__list__wrap">
                    <header class="page__footer__list__title">
                        Карта сайта
                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/site_map.png" alt="Site map icon">
                    </header>
                    <div class="page__footer__list__body">
                        <ul class="page__footer__list__body__list">
                            <li class="page__footer__list__body__list__item">
                                <a href="<?php echo $siteData->urlBasic;?>/">Главная</a>
                            </li>
                            <li class="page__footer__list__body__list__item">
                                <a href="<?php echo $siteData->urlBasic;?>/catalog">Каталог</a>
                            </li>
                            <li class="page__footer__list__body__list__item">
                                <a href="<?php echo $siteData->urlBasic;?>/lease">Аренда</a>
                            </li>
                        </ul>
                        <ul class="page__footer__list__body__list">
                            <li class="page__footer__list__body__list__item">
                                <a href="<?php echo $siteData->urlBasic;?>/about">О компании</a>
                            </li>
                            <li class="page__footer__list__body__list__item">
                                <a href="<?php echo $siteData->urlBasic;?>/news">Новости</a>
                            </li>
                            <li class="page__footer__list__body__list__item">
                                <a href="<?php echo $siteData->urlBasic;?>/contacts">Контакты</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="page__footer__site__services page__footer__list__wrap">
                    <header class="page__footer__list__title">
                        Дополнительные услуги
                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/services.png" alt="Services icon">
                    </header>
                    <div class="page__footer__list__body">
                        <ul class="page__footer__list__body__list">
                            <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\dopolnitelnye-uslugi']); ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 align-self-strech page__footer__atmos__wrap flex-column box-left">
                <div class="page__footer__atmos box-left" style="margin-bottom: 10px;">
                    <figure style="max-width: 80px;">
                        <a href="http://www.vostkomer.kz/">
                            <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/logo.png" alt="VK icon" style="max-width: 100%;">
                        </a>
                    </figure>
                    <p>
                        Прямые поставки товаров<br> и оборудования из Европы
                    </p>
                </div>
                <div class="page__footer__atmos box-left">
                    <figure>
                        <a href="http://www.atmos-chrast.cz/">
                            <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/page/atmos.png" alt="ATMOS icon">
                        </a>
                    </figure>
                    <p>
                        Свыше 50 лет<br>
                        опыта производства<br>
                        компрессоров<br>

                    </p>
                </div>
            </div>
            <style>
                .box-left{
                    -webkit-box-align: start !important;
                    -ms-flex-align: flex-start !important;
                    align-items: flex-start  !important;
                    -webkit-box-pack: start  !important;
                    -ms-flex-pack: flex-start !important;
                }
            </style>
        </div>
    </div>
    <div class="container page__footer__footer">
        <div class="row justify-content-between no-gutters">
            <div class="col-12 col-sm-6">
                <div class="page__footer__copyright">
                    Copyright © Vostochnaya Kommercheskaya 2018
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="page__footer__autors">
<!--                     <a href="//gnezdo.kz" class="main_color">Support</a> -->
                </div>
            </div>
        </div>
    </div>
</footer>

<!--[if lt IE 9]>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/libs/html5shiv/es5-shim.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/libs/html5shiv/html5shiv.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/libs/respond/respond.min.js"></script>
<![endif]-->

<!-- Load Scripts -->
<script>var scr = {"scripts":[
        {"src" : "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js", "async" : false},
        {"src" : "https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js", "async" : false},
        {"src" : "<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/common.js", "async" : false}
    ]};!function(t,n,r){"use strict";var c=function(t){if("[object Array]"!==Object.prototype.toString.call(t))return!1;for(var r=0;r<t.length;r++){var c=n.createElement("script"),e=t[r];c.src=e.src,c.async=e.async,n.body.appendChild(c)}return!0};t.addEventListener?t.addEventListener("load",function(){c(r.scripts);},!1):t.attachEvent?t.attachEvent("onload",function(){c(r.scripts)}):t.onload=function(){c(r.scripts)}}(window,document,scr);
</script>

</body>
</html>
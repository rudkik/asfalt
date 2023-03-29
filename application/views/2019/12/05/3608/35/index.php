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
    <link rel="icon" type="image/png" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon.png" />

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
    <link href="<?php echo $siteData->urlBasic;?>/css/_component/fonts/font-awesome/v4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/fancybox/dist/jquery.fancybox.css" type="text/css" media="screen" />

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/slider/slick.css" media="screen, projection">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/slider/slick-theme.css" media="screen, projection">


    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/style.css">
</head>
<body itemscope="itemscope" itemtype="http://schema.org/WebPage">
<div class="wrapper">
    <div class="content">
        <!-- !@@&body&@@! -->
        <header class="header-top">
            <div class="container">
                <div class="contacts">
                    <div class="logo">
                        <a href="<?php echo $siteData->urlBasic;?>/"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png"></a>
                    </div>
                    <div class="logo-title">
                        Интернет-магазин продукции HyperX
                    </div>
                    <div class="phone">
                        <div class="media-left">
                            <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
                        </div>
                        <div class="media-body">
                            <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefon']); ?>
                            <p class="info">Звонок бесплатный</p>
                        </div>
                    </div>
                    <div class="phone work">
                        <div class="media-left">
                            <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/clock.png">
                        </div>
                        <div class="media-body">
                            <span class="name">График работы: </span>
                            <p>Пн-Пт: 9.00-18.00</p>
                        </div>
                    </div>
                    <div class="phone email">
                        <div class="media-left">
                            <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/email.png">
                        </div>
                        <div class="media-body">
                            <span class="name">Напишите нам</span>
                            <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\e-mail']); ?>
                        </div>
                    </div>
                </div>
                <div class="box-basket">
                    <a class="" href="<?php echo $siteData->urlBasic;?>/basket" ><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/basket.png"> <span class="count" id="basket-count"><?php echo trim($siteData->globalDatas['view::View_Shop_Carts\basic\kolichestvo-tovarov-v-korzine']); ?></span></a>
                </div>
            </div>
        </header>
        <header class="header-menu">
            <div class="container">
                <div class="box-find-menu">
                    <a href="#find-menu-modal" data-toggle="modal" class="btn btn-find"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/search.png"></a>
                    <div id="find-menu-modal" class="modal fade modal-find">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Поиск</h4>
                                </div>
                                <div class="modal-body">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <form action="<?php echo $siteData->urlBasic;?>/find" method="GET" class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="name_lexicon">
                                            <span class="input-group-btn">
                                                <button class="btn btn-info btn-flat btn-red" type="submit">Поиск</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <nav class="navbar navbar-default">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-left">
                            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\basic\rubriki']); ?>
                        </ul>
                        <div class="navbar-right box-find">
                            <a href="#find-modal" data-toggle="modal" class="btn btn-find"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/search.png"></a>
                            <div id="find-modal" class="modal fade modal-find">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Поиск</h4>
                                        </div>
                                        <div class="modal-body">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <form action="<?php echo $siteData->urlBasic;?>/find" method="GET" class="form-group">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="name_lexicon">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-info btn-flat btn-red" type="submit">Поиск</button>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <?php echo trim($data['view::body']);?>
    </div>
    <footer>
            <div class="container">
                <div class="box-logo">
                    <div class="logo">
                        <a href="<?php echo $siteData->urlBasic;?>/"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo-grey.png"></a>
                    </div>
                    <div class="logo-title">
                        Интернет-магазин продукции HyperX
                    </div>
                </div>
                <ul class="system-aticle">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sistemnye-stati']); ?>
                </ul>
                <div class="contacts">
                    <div class="phone">
                        <div class="media-left">
                            <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
                        </div>
                        <div class="media-body">
                            <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefon']); ?>
                            <p class="info">Звонок бесплатный</p>
                        </div>
                    </div>
                    <div class="phone">
                        <div class="media-left">
                            <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/clock.png">
                        </div>
                        <div class="media-body">
                            <span class="name">График работы: </span>
                            <p>Пн-Пт: 9.00-18.00</p>
                        </div>
                    </div>
                    <div class="phone">
                        <div class="media-left">
                            <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/email.png">
                        </div>
                        <div class="media-body">
                            <span class="name">Напишите нам</span>
                            <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\e-mail']); ?>
                        </div>
                    </div>
                </div>
            </div>
    </footer>
</div>

<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/main.js"></script>

<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/stepper/js/stepper.min.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/_component/fancybox/dist/jquery.fancybox.min.js"></script>
<script>
    $(document).ready(function() {
       /* $('[data-fancybox="gallery"]').fancybox({
            loop: true
        });*/

    });
</script>

<?php if($siteData->url == '' || $siteData->url == '/'){?>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/slider/slick.js"></script>
<script type="text/javascript">
    $(document).on('ready', function() {
        $('[data-action="slider-goods"]').slick({
            arrows:         true,
            dots:           false,
            infinite:       true,
            slidesToShow:   4,
            slidesToScroll: 1,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 10000,
            initialSlide: 0, // с какого слайдера начать показ
            responsive: [
                {
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: 3,
                    }
                },
                {
                    breakpoint: 899,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 450,
                    settings: {
                        slidesToShow: 1,
                    }
                }
            ]
        });
    });
</script>
<?php } ?>


<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $(".select2").select2();
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    });
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-75908218-6"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-75908218-6');
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(56690683, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/56690683" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
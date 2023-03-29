<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="<?php if($siteData->isIndexRobots){echo 'index';}else{echo 'noindex';} ?>">
    <meta name="description" content="<?php echo htmlspecialchars($siteData->siteDescription, ENT_QUOTES); ?>" />
    <meta name="keywords" content="<?php echo htmlspecialchars($siteData->siteKeywords, ENT_QUOTES); ?>" />

    <title><?php echo trim($siteData->siteTitle); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo trim($siteData->meta); ?>
    <meta property="og:locale" content="en_US" />
    <meta property="og:site_name" content="<?php echo htmlspecialchars($siteData->shop->getName(), ENT_QUOTES); ?> english" />
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

    <link href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon.ico" rel="shortcut icon" />

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">
    <link href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/iCheck/all.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/fonts/font-awesome/v4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/_component/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/_component/slick/slick-theme.css"/>

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/fancybox/dist/jquery.fancybox.css" type="text/css" media="screen" />

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/style.css?cache=43">

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/jquery-3.3.1.min.js"></script>
</head>
<body class="arab" itemscope="itemscope" itemtype="http://schema.org/WebPage">
<!-- !@@&body&@@! -->
<div class="body">
    <header class="header-contacts">
        <div class="container">
            <div class="box-address">
                <div class="media-left">
                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/location.png">
                </div>
                <div class="media-body">
                    <a href="<?php echo $siteData->urlBasicLanguage; ?>/contact-us"><?php echo trim($siteData->globalDatas['view::View_Shop_Addresss\basic\adres-po-ip']); ?></a>
                </div>
            </div>
            <div class="box-phone">
                <div class="media-left">
                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
                </div>
                <div class="media-body">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefony-sverkhu']); ?>
                </div>
            </div>
            <div class="pull-right">
                <div class="box-about">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\punkty-menyu-o-kompanii']); ?>
                    <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/news"> أخبار الشركة</a>
                </div>
                <div class="box-find">
                    <a href="#find-modal" data-toggle="modal" class="btn btn-find"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/find-red.png"></a>
                    <div id="find-modal" class="modal fade modal-find">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Find</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="<?php echo $siteData->urlBasicLanguage; ?>/find" method="GET" class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="name_lexicon">
                                            <span class="input-group-btn">
                                        <button class="btn btn-info btn-flat btn-red" type="submit">Find</button>
                                    </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-language">
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown messages-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="language-active"><?php echo $siteData->language->getName();?></span><i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu menu-red">
                                    <?php echo trim($siteData->globalDatas['view::View_Languages\basic\yazyki']); ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <header class="header-menu">
        <div class="container">
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
                        <ul class="nav navbar-nav box-main-menu">
                            <li class="box-home">
                                <a href="#" data-toggle="modal" data-target="#show-menu"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/home.png"></a>
                            </li>
                            <li class="box-logo">
                                <a href="<?php echo $siteData->urlBasicLanguage; ?>"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png"></a>
                            </li>
                            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\basic\menyu']); ?>
                            <li class="one-line"><a href="<?php echo $siteData->urlBasicLanguage; ?>/contact-us">الإتصال بنا</a></li>
                            <li class="pull-right" style="display: none">
                                <div class="input-group box-find one-line">
                                    <div class="input-group-btn">
                                        <a href="#myModal1" data-toggle="modal" class="btn btn-find"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/find.png"></a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <?php echo trim($data['view::body']);?>
</div>
<footer>
    <div class="footer-menu">
        <div class="container">
            <div class="row group-menu">
                <div class="col-md-3">
                    <ul class="box-menu">
                        <li>
                            <h3><a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us">عن الشركة</a></h3>
                        </li>
                        <li>
                            <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/history">تاريخ الشركة </a>
                        </li>
                        <li>
                            <a href="<?php echo $siteData->urlBasicLanguage; ?>/events/events-and-exhibitions"> المعارض</a>
                        </li>
                        <li>
                            <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/news"> أخبار الشركة</a>
                        </li>
                        <li>
                            <a href="<?php echo $siteData->urlBasicLanguage; ?>/brands">شركاؤنا</a>
                        </li>
                        <li>
                            <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/job-positions"> التوظيف </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-main-v-futore-rubriki']); ?>
                </div>
            </div>
            <div class="row box-addresses">
                <div class="col-md-9">
                    <div class="row">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_Addresss/-adresa']); ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <ul class="socials pull-right">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sotcialnye-seti-footer']); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="box-logo">
                <a href="<?php echo $siteData->urlBasicLanguage; ?>"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo3.png"></a>
            </div>
            <div class="copyright">
                UNI-TECH 2004 - <?php echo date('Y');?> © ALL RIGHTS RESERVED
            </div>
        </div>
    </div>
</footer>

<div id="show-menu" class="dialog-menu modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="box-close">
                <button class="close" type="button" data-dismiss="modal"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/f-close.png" class="img-responsive"></button>
            </div>
            <div class="modal-body">
                <div class="modal-fields">
                    <div class="background-7">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-rubriki-dlya-vslyvayushchego-okna']); ?>
                    </div>
                    <div class="background-body">
                        <div class="row my-menu">
                            <a href="<?php echo $siteData->urlBasicLanguage; ?>/brands">شركاؤنا</a>
                            <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/news"> أخبار الشركة</a>
                            <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/job-positions"> التوظيف </a>
                            <a href="<?php echo $siteData->urlBasicLanguage; ?>/contact-us">الإتصال بنا</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<a target="_blank" href="https://t.me/uni_tech_group_en_bot" class="telegram-bot"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/telegram.png"></a>
<?php if(!key_exists('CookieApply', $_COOKIE)){?>
    <div class="cookie-bar">
        <div class="cookie-bar__left">
            UNI-TECH GROUP uses cookies to personalise your browsing experience. Please read our Cookie Statement for more information about cookies, how we use them and how you can remove them. By continuing to use this website, you agree to our use of cookies.
        </div>
        <div class="cookie-bar__right">
            <a class="settings" href="#" onclick="showSettings()">Cookie settings</a>
            <a class="cookie__cta" href="#" onclick="setCookie('3')">Accept cookies </a>
            <a class="cookiebar-close" onclick="setCookie('1')">✕</a>
        </div>
    </div>
    <script>
        function setCookie(b){
            var a=new Date ,c=a.getTime();
            c += 31536E6;
            a.setTime(c);
            document.cookie="CookieApply\x3d"+b+"; expires\x3d"+a.toGMTString()+"; path\x3d/";
            location.reload()
        }
    </script>
<?php }?>

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v4.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
     attribution=install_email
     page_id="161842230570785"
     theme_color="#fa3c4c">
</div>

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic; ?>/css/_component/slick/slick.min.js"></script>

<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/_component/fancybox/dist/jquery.fancybox.min.js"></script>
<script>
    $(document).ready(function() {
        $('[data-action="select-panel"]').mouseenter(function() {
            $(this).parent().children('[data-action="select-panel"]').removeClass('active');
            $(this).addClass('active');

            $(this).parent().parent().parent().find('[data-action="find-panel"]').removeClass('active');
            $($(this).data('children')).addClass('active');
        });

        $('#sliders').slick({
            arrows:         true,
            dots:           false,
            infinite:       true,
            slidesToShow:   1,
            slidesToScroll: 1,
            adaptiveHeight: true,
            autoplay: true,
            autoplaySpeed: 10000,
            initialSlide: 0,
        });
        $('[data-fancybox="gallery"]').fancybox();
    });
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });
</script>

<?php if(strpos($siteData->urlBasic, 'uni-tech.kz')){ ?>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(46950831, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/46950831" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
<?php }elseif(strpos($siteData->urlBasic, 'ut-ec.com')){ ?>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(46950837, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/46950837" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
<?php } ?>
</body>
</html>
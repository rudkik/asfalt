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
    <meta property="og:locale" content="ru_RU" />
    <meta property="og:site_name" content="<?php echo htmlspecialchars($siteData->shop->getName(), ENT_QUOTES); ?> english" />
    <meta property="og:url" content="<?php echo $siteData->urlBasicLanguage.trim($siteData->urlCanonical); ?>" >
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
            echo '<link rel="prev" href="'.$siteData->urlBasicLanguage.$siteData->url.URL::query($urlParams, FALSE).'">'."\r\n";
        }

        if ($siteData->pages > $siteData->page){
            $urlParams = $siteData->urlParams ;
            $urlParams['page'] = $siteData->page + 1;
            echo '		<link rel="next" href="'.$siteData->urlBasicLanguage.$siteData->url.URL::query($urlParams, FALSE).'">';
        }
    }
    ?>
    <?php
    if ($siteData->favicon != ''){
        echo '<link href="'.$siteData->urlBasic.trim($siteData->favicon).'" rel="shortcut icon" />';
    }
    ?>
    <link rel="canonical" href="<?php echo $siteData->urlBasicLanguage.trim($siteData->urlCanonical); ?>" />

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">
    <link href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="<?php echo $siteData->urlBasic;?>/css/_component/fonts/font-awesome/v4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link type="text/css" rel="stylesheet" href="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/style.css?cache=2">

    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.min.css">
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>

    <script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/main.js"></script>
</head>
<body itemscope="itemscope" itemtype="http://schema.org/WebPage"><!-- !@@&body&@@! --><header class="header-menu">
    <header class="header-menu-first">
        <div class="container">
            <div class="col-sm-12">
                <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\e-mail-sverkhu']); ?>
                <div class="socials">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sotcialnye-seti-sverkhu']); ?>
                </div>
                <div class="price-list">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\price-list']); ?>
                </div>
                <div class="languages">
                    <?php echo trim($siteData->globalDatas['view::View_Languages\basic\yazyki']); ?>
                </div>
                <div class="box-phones">
                    <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
                    <div class="phones">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefony-sverkhu']); ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <header class="header-menu-two">
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
                            <ul class="nav navbar-nav">
                                <li>
                                    <a class="nav-link<?php if($siteData->url == '/reserv/check'){echo ' active';} ?>" href="<?php echo $siteData->urlBasicLanguage;?>/reserv/check">Check Your Booking</a>
                                </li>
                                <li>
                                    <a class="nav-link<?php if($siteData->url == '/about'){echo ' active';} ?>" href="<?php echo $siteData->urlBasicLanguage;?>/about">About us</a>
                                </li>
                                <li>
                                    <a class="nav-link<?php if($siteData->url == '/water'){echo ' active';} ?>" href="<?php echo $siteData->urlBasicLanguage;?>/water">Thermal Pools</a>
                                </li>
                                <li>
                                    <a class="nav-link<?php if($siteData->url == '/habitation'){echo ' active';} ?>" href="<?php echo $siteData->urlBasicLanguage;?>/habitation">Accommodation</a>
                                </li>
                                <li>
                                    <a class="nav-link<?php if($siteData->url == '/kitchen'){echo ' active';} ?>" href="<?php echo $siteData->urlBasicLanguage;?>/kitchen">Café</a>
                                </li>
                                <li>
                                    <a class="nav-link<?php if($siteData->url == '/faq'){echo ' active';} ?>" href="<?php echo $siteData->urlBasicLanguage;?>/faq">FAQ</a>
                                <li>
                                <li>
                                    <a class="nav-link<?php if($siteData->url == '/scheme'){echo ' active';} ?>" href="<?php echo $siteData->urlBasicLanguage;?>/scheme">Scheme</a>
                                <li>
                                <li>
                                    <a class="nav-link<?php if($siteData->url == '/contacts'){echo ' active';} ?>" href="<?php echo $siteData->urlBasicLanguage;?>/contacts">Contact us</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
        </div>
    </header>
</header>
<header class="header-slider">
    <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="10000">
        <div class="carousel-inner">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\-slaider-na-glavnoi']); ?>
        </div>
        <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</header>
<?php if (($siteData->url != '/reserv/check') && ($siteData->url != '/bill/pay/online') && ($siteData->url != '/bill/pay')
    && ($siteData->url != '/bill/client')&& ($siteData->url != '/bill/finish')&& ($siteData->url != '/send-message')){ ?>
<header class="header-reserve background">
    <div class="container">
        <h3>Book a Room</h3>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
        <form action="<?php echo $siteData->urlBasicLanguage;?>/free/room/types" method="get">
            <div class="row box-reserve">
                <div class="col-sm-1"></div>
                <div class="col-sm-2 box-date">
                    <div class="form-group">
                        <label>Check in Date</label>
                        <div class="input-group">
                            <input name="date_from" class="form-control" required type="datetime" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamStr('date_from')); ?>">
                            <span class="input-group-addon"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/calendar.png"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 box-date">
                    <div class="form-group">
                        <label>Check out Date</label>
                        <div class="input-group">
                            <input name="date_to" class="form-control" required type="datetime" value="<?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamStr('date_to')); ?>">
                            <span class="input-group-addon"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/calendar.png"></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Number of Guests: Adults</label>
                        <select name="adults" class="form-control select2" style="width: 100%;">
                            <?php
                            $select = Request_RequestParams::getParamInt('adults');
                            for ($i=1; $i <= 30; $i++){
                                if ($i == $select){
                                    echo '<option selected="selected">' . $i . '</option>';
                                }else {
                                    echo '<option>' . $i . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Number of Guests: Children 5-12 year olds</label>
                        <select name="childs" class="form-control select2" style="width: 100%;">
                            <?php
                            $select = Request_RequestParams::getParamInt('childs');
                            for ($i=0; $i <= 10; $i++){
                                if ($i == $select){
                                    echo '<option selected="selected">' . $i . '</option>';
                                }else {
                                    echo '<option>' . $i . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2 btn_box">
                    <div class="box-finish-reserve">
                        <button type="submit" class="btn btn-flat btn-blue-un" style="margin-top: 7px;" type="submit">
                            <?php  if(($siteData->url == '/free/room/types') || ($siteData->url == '/free/rooms')){ ?>Change Booking<?php }else{ ?>Book a Room<?php } ?></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</header>
<?php } ?>
<?php echo trim($data['view::body']);?>
<header class="header-maps">
    <?php echo trim($siteData->globalDatas['view::View_Shop_Address\basic\adres']); ?>
</header>
<footer>
    <div class="container">
        <div class="copyright">
            <?php echo date('Y'); ?> © Kara Dala
        </div>
        <div class="socials">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sotcialnye-seti-snizu']); ?>
        </div>
    </div>
</footer>
<a href="#" title="UP" class="topbutton">^ UP ^</a>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/_component/datetime/jquery.datetimepicker.js"></script>

<script>
    $(document).ready(function () {
        var date = $('input[type="datetime"][name="date_from"]');
        if(date.length > 0) {
            date.datetimepicker({
                dayOfWeekStart: 1,
                lang: 'ru',
                format: 'd.m.Y',
                timepicker: false,
                minDate: '<?php echo date('d.m.Y'); ?>',
            });

            date.parent().children('.input-group-addon').click(function() {
                $(this).parent().children('input[type="datetime"]').datetimepicker('show');
            });
        }

        var date = $('input[type="datetime"][name="date_to"]');
        if(date.length > 0) {
            date.datetimepicker({
                dayOfWeekStart: 1,
                lang: 'ru',
                format: 'd.m.Y',
                timepicker: false,
                minDate: '<?php echo date('d.m.Y', strtotime('+1 days')); ?>',
            });

            date.parent().children('.input-group-addon').click(function() {
                $(this).parent().children('input[type="datetime"]').datetimepicker('show');
            });
        }

        $('.select2').select2({
            "language": {
                "noResults": function(){
                    return "Room not found";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });
    });
    $(function(){
        $(window).scroll(function() {
            if ($(this).scrollTop() >= 81) {
                $('.header-menu').addClass('scroll');
            }
            else {
                $('.header-menu').removeClass('scroll');
            }
        });
        if ($(this).scrollTop() >= 81) {
            $('.header-menu').addClass('scroll');
        }
        else {
            $('.header-menu').removeClass('scroll');
        }
    });
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-75908218-2"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-75908218-2');
</script>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter50843251 = new Ya.Metrika2({
                    id:50843251,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/50843251" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
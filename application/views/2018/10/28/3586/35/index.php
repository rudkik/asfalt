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


    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/apple-touch-icon-57x57.png?v=M4mqxyE22j">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/apple-touch-icon-60x60.png?v=M4mqxyE22j">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/apple-touch-icon-72x72.png?v=M4mqxyE22j">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/apple-touch-icon-76x76.png?v=M4mqxyE22j">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/apple-touch-icon-114x114.png?v=M4mqxyE22j">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/apple-touch-icon-120x120.png?v=M4mqxyE22j">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/apple-touch-icon-144x144.png?v=M4mqxyE22j">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/apple-touch-icon-152x152.png?v=M4mqxyE22j">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/apple-touch-icon-180x180.png?v=M4mqxyE22j">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/favicon-32x32.png?v=M4mqxyE22j">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/android-chrome-192x192.png?v=M4mqxyE22j">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/favicon-16x16.png?v=M4mqxyE22j">
    <link rel="manifest" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/site.webmanifest?v=M4mqxyE22j">
    <link rel="mask-icon" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/safari-pinned-tab.svg?v=M4mqxyE22j" color="#008fc4">
    <link rel="shortcut icon" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/favicon.ico?v=M4mqxyE22j">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/favicons/mstile-144x144.png?v=M4mqxyE22j">
    <meta name="theme-color" content="#ffffff">
    <!-- <?php if(!empty($siteData->favicon)){ ?>
        <?php if(is_array($siteData->favicon)){ ?>
            <?php foreach($siteData->favicon as $key => $value){ ?>
                <link rel="apple-touch-icon-precomposed" sizes="<?php echo $key; ?>" href="<?php echo Func::addSiteNameInFilePath($value, $siteData); ?>" />
                <link rel="icon" type="image/png" href="<?php echo Func::addSiteNameInFilePath($value, $siteData); ?>" sizes="<?php echo $key; ?>" />
            <?php } ?>
        <?php }else{ ?>
            <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo Helper_Image::getPhotoPath($siteData->favicon, 57, 57) ?>" />
            <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Helper_Image::getPhotoPath($siteData->favicon, 72, 72) ?>" />
            <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Helper_Image::getPhotoPath($siteData->favicon, 144, 144) ?>" />
            <link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo Helper_Image::getPhotoPath($siteData->favicon, 120, 120) ?>" />
            <link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo Helper_Image::getPhotoPath($siteData->favicon, 152, 152) ?>" />
            <link rel="icon" type="image/png" href="<?php echo Helper_Image::getPhotoPath($siteData->favicon, 32, 32) ?>" sizes="32x32" />
            <link rel="icon" type="image/png" href="<?php echo Helper_Image::getPhotoPath($siteData->favicon, 16, 16) ?>" sizes="16x16" />
        <?php } ?>
    <?php } ?>

    <?php if(!empty($siteData->siteImage)){ ?>
        <meta itemprop="image" content="<?php echo htmlspecialchars(Func::addSiteNameInFilePath($siteData->siteImage), ENT_QUOTES); ?>" />
        <meta property="og:image" content="<?php echo htmlspecialchars(Func::addSiteNameInFilePath($siteData->siteImage), ENT_QUOTES); ?>" />
        <meta name="twitter:image:src" content="<?php echo htmlspecialchars(Func::addSiteNameInFilePath($siteData->siteImage), ENT_QUOTES); ?>" />
    <?php } ?> -->

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
	
	<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/libs/bootstrap/css/bootstrap-grid.min.css">
	<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/css/main.css">

    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/jquery-2.1.4.min.js"></script>
</head>
<body itemscope="itemscope" itemtype="http://schema.org/WebPage" style="overflow-y: scroll;"><!-- !@@&body&@@! --><div id="pagewrap" style="min-height: 100vh;" class="d-flex flex-column"><header class="header">
    <div class="container">
        <div class="row justify-content-end">
<!--
            <div class="langs">
                <?php echo trim($siteData->globalDatas['view::View_Languages\basic\yazyki']); ?>
            </div>
-->
        </div>
        <div class="row no-gutters align-items-center justify-content-between">
            <div class="col-3 col-md-2">
                <a href="<?php echo $siteData->urlBasic;?>/">
                    <figure class="logo">
                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/logo.svg" alt="">
                    </figure>
                </a>
            </div>
            <?php echo trim($siteData->globalDatas['view::View_User\basic\polzovatel']); ?>
        </div>
    </div>
    <?php if($siteData->userID > 0){ ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <nav class="nav--extra">
                <ul class="nav__list nav__list--horscroll">
                    <?php echo trim($siteData->globalDatas['view::View_Ads_Shop_Parcels\user-menu']); ?>
                    <li class="nav__item" style="display: none">
                        <a href="<?php echo $siteData->urlBasic;?>/account/invoice" class="nav__link<?php if ($siteData->url == '/account/invoice'){echo ' current';}?>">Счета</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <?php } ?>
</header>
<script>
    var menu = document.getElementById('menu');
    var links = menu.querySelectorAll('a');
    for (var i = 0; i < links.length; i++) {
        links[i].addEventListener('click', function() {
            if (document.body.offsetWidth < 1200) {
                menuToggle();
            }
        });
    }
    function disableScroll() {
        document.querySelector('html').style.overflow = 'hidden';
        document.querySelector('body').style.overflow = 'hidden';
    }
    function enagleScroll() {
        document.querySelector('html').style.overflow = 'auto';
        document.querySelector('body').style.overflow = 'auto';
    }
    function menuToggle() {
        if (menu.classList.contains('open')) {
            enagleScroll();
        } else {
            disableScroll();
        }
        menu.classList.toggle('open');
    }
</script><?php echo trim($data['view::body']);?><footer class="footer">
    <div class="container">
        <div class="row no-gutters align-items-center justify-content-between footer__block">
            <div class="col-3 col-md-2">
                <figure class="logo logo--min">
                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/img/logo-black.svg" alt="" class="logo--invert">
                </figure>
            </div>
            <div class="col-auto d-none d-xl-none">
                <nav class="nav nav--footer">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="<?php echo $siteData->urlBasic;?>/#how-it-works" class="nav__link">Как это работает?</a>
                        </li>
                        <li class="nav__item">
                            <a href="<?php echo $siteData->urlBasic;?>/#price" class="nav__link">Сколько стоит</a>
                        </li>
                        <li class="nav__item">
                            <a href="<?php echo $siteData->urlBasic;?>/#form_new_address" class="nav__link">Регистрация</a>
                        </li>
                        <li class="nav__item">
                            <a href="<?php echo $siteData->urlBasic;?>/#delivery" class="nav__link">Доставка</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row no-gutters align-items-center justify-content-between footer__block">
            <div class="col-auto">
			  <span class="footer__text" style="line-height: 25px;">
				Республика Казахстан,<br/>
				г. Алматы, ул. Чайкиной 1/1<br/>
			  </span>
			  <a href="tel:+77273557788" style="margin-top: 25px; display: inherit;">+7 (727) 355 77 88</a>			  
            </div>
            <div class="col-auto">
			  <span class="footer__text">
				Мы в соцсетях:
				<?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sotcialnye-seti']); ?>
			  </span>
            </div>
        </div>
    </div>
</footer></div>
<!--[if lt IE 9]>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/libs/html5shiv/es5-shim.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/libs/html5shiv/html5shiv.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/libs/html5shiv/html5shiv-printshiv.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/libs/respond/respond.min.js"></script>
<![endif]-->
<script>
    var elems = document.querySelectorAll('[href="' + document.location.href + '"]');
    if (elems.length > 0) {
        for (var i = 0; i < elems.length; i++) {
            elems[i].classList.add('current');
        }
    } else {
        var allLinks = document.getElementsByTagName('a');
        var linkWithoutHTTP;
        for (var j = 0; j < allLinks.length; j++) {
            linkWithoutHTTP = allLinks[j].href.split('//').splice(1)[0].split('/').splice(1).join('/');
            if (~document.location.href.indexOf(linkWithoutHTTP)) {
                allLinks[j].classList.add('current');
            }
        }
    }
</script>
<script>
    function changeDownloadInputsLabel(e) {
        var el = e.target;
        var fileName = el.value.split('\\')[el.value.split('\\').length - 1];
        document.querySelector('[for="'+ el.id + '"]').innerText = fileName;
    }
    var downloadInputs = document.querySelectorAll('input[type="file"]');
    for (var i = 0; i < downloadInputs.length; i++) {
        downloadInputs[i].addEventListener('change', changeDownloadInputsLabel);
    }
</script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/libs/bodyScrollLock/bodyScrollLock.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/js/popup.js"></script>
<script>
    window.popup = new Popup();
</script>

<!-- Load Scripts -->
<script>var scr = {"scripts":[
        {"src" : "<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/js/common.js", "async" : false}
    ]};!function(t,n,r){"use strict";var c=function(t){if("[object Array]"!==Object.prototype.toString.call(t))return!1;for(var r=0;r<t.length;r++){var c=n.createElement("script"),e=t[r];c.src=e.src,c.async=e.async,n.body.appendChild(c)}return!0};t.addEventListener?t.addEventListener("load",function(){c(r.scripts);},!1):t.attachEvent?t.attachEvent("onload",function(){c(r.scripts)}):t.onload=function(){c(r.scripts)}}(window,document,scr);
</script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/main.js"></script>
<script>
    window.__forceSmoothScrollPolyfill__ = true;
</script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/libs/scroll/scrollPolyfill.js"></script>
<script>
    var scroll = new SmoothScroll('a[href*="#"]', {
        speed: 500
    });
</script>
</body>
</html>
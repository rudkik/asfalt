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

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/bootstrap.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/font-awesome.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/bootstrap-grid.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/bootstrap-reboot.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/font-techmarket.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/slick.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/techmarket-font-awesome.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/slick-style.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/animate.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/style.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/colors/red.css" media="all" />
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,900" rel="stylesheet">
</head>
<body class="woocommerce-active left-sidebar" itemscope="itemscope" itemtype="http://schema.org/WebPage">
<!-- !@@&body&@@! -->
<div id="page" class="hfeed site">
    <div class="top-bar top-bar-v1">
        <div class="col-full">
            <ul id="menu-top-bar-left" class="nav justify-content-center">
                <li class="menu-item animate-dropdown">
                    <a title="Доставка" href="<?php echo $siteData->urlBasic;?>/delivery">Доставка</a>
                </li>
                <li class="menu-item animate-dropdown">
                    <a title="Гарантия качества продукции" href="<?php echo $siteData->urlBasic;?>/guarantee">Гарантия качества</a>
                </li>
                <li class="menu-item animate-dropdown">
                    <a title="Контакты" href="<?php echo $siteData->urlBasic;?>/contacts">Контакты</a>
                </li>
            </ul>
        </div>
    </div>
    <header id="masthead" class="site-header header-v1" style="background-image: none; ">
        <div class="col-full desktop-only">
            <div class="techmarket-sticky-wrap">
                <div class="row">
                    <div class="site-branding">
                        <a href="<?php echo $siteData->urlBasic;?>" class="custom-logo-link" rel="home">
                            <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png">
                        </a>
                    </div>
                    <nav id="primary-navigation" class="primary-navigation" aria-label="Primary Navigation" data-nav="flex-menu">
                        <ul id="menu-primary-menu" class="nav yamm">
                            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\basic\rubrikatciya-sverkhu']); ?>
                            <li class="techmarket-flex-more-menu-item dropdown">
                                <a title="..." href="#" data-toggle="dropdown" class="dropdown-toggle">...</a>
                                <ul class="overflow-items dropdown-menu"></ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="row align-items-center">
                <div id="departments-menu" class="dropdown departments-menu">
                    <button class="btn dropdown-toggle btn-block" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="tm tm-departments-thin"></i>
                        <span>Категории</span>
                    </button>
                    <ul id="menu-departments-menu" class="dropdown-menu yamm departments-menu-dropdown">
                        <li class="highlight menu-item animate-dropdown">
                            <a title="Value of the Day" href="home-v2.html">Value of the Day</a>
                        </li>
                        <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\basic\rubrikatciya-s-detvoroi']); ?>
                    </ul>
                </div>
                <form class="navbar-search" method="get" action="<?php echo $siteData->urlBasic;?>/catalogs">
                    <label class="sr-only screen-reader-text" for="search">Поиск</label>
                    <div class="input-group">
                        <input type="text" id="search" class="form-control search-field product-search-field" dir="ltr" value="<?php echo Request_RequestParams::getParamStr('name_lexicon'); ?>" name="name_lexicon" placeholder="Название товара" />
                        <div class="input-group-addon search-categories popover-header">
                            <select name='rubric_id' id='product_cat' class='postform resizeselect'>
                                <option value="-1" selected='selected'>Все категории </option>
                                <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\basic\rubrika-tovarov-dlya-poiska']); ?>
                            </select>
                        </div>
                        <div class="input-group-btn input-group-append">
                            <input type="hidden" id="search-param" name="post_type" value="product" />
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                                <span class="search-btn">Поиск</span>
                            </button>
                        </div>
                    </div>
                </form>
                <?php echo trim($siteData->globalDatas['view::View_Shop_Carts\basic\korzina']); ?>
            </div>
        </div>
        <div class="col-full handheld-only">
            <div class="handheld-header">
                <div class="row">
                    <div class="site-branding">
                        <a href="home-v1.html" class="custom-logo-link" rel="home">
                            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 176 28">
                                <defs>
                                    <style>
                                        .cls-1,
                                        .cls-2 {
                                            fill: #333e48;
                                        }

                                        .cls-1 {
                                            fill-rule: evenodd;
                                        }

                                        .cls-3 {
                                            fill: #3265b0;
                                        }
                                    </style>
                                </defs>
                                <polygon class="cls-1" points="171.63 0.91 171.63 11 170.63 11 170.63 0.91 170.63 0.84 170.63 0.06 176 0.06 176 0.91 171.63 0.91" />
                                <rect class="cls-2" x="166.19" y="0.06" width="3.47" height="0.84" />
                                <rect class="cls-2" x="159.65" y="4.81" width="3.51" height="0.84" />
                                <polygon class="cls-1" points="158.29 11 157.4 11 157.4 0.06 158.26 0.06 158.36 0.06 164.89 0.06 164.89 0.87 158.36 0.87 158.36 10.19 164.99 10.19 164.99 11 158.36 11 158.29 11" />
                                <polygon class="cls-1" points="149.54 6.61 150.25 5.95 155.72 10.98 154.34 10.98 149.54 6.61" />
                                <polygon class="cls-1" points="147.62 10.98 146.65 10.98 146.65 0.05 147.62 0.05 147.62 5.77 153.6 0.33 154.91 0.33 147.62 7.05 147.62 10.98" />
                                <path class="cls-1" d="M156.39,24h-1.25s-0.49-.39-0.71-0.59l-1.35-1.25c-0.25-.23-0.68-0.66-0.68-0.66s0-.46,0-0.72a3.56,3.56,0,0,0,3.54-2.87,3.36,3.36,0,0,0-3.22-4H148.8V24h-1V13.06h5c2.34,0.28,4,1.72,4.12,4a4.26,4.26,0,0,1-3.38,4.34C154.48,22.24,156.39,24,156.39,24Z" transform="translate(-12 -13)" />
                                <polygon class="cls-1" points="132.04 2.09 127.09 7.88 130.78 7.88 130.78 8.69 126.4 8.69 124.42 11 123.29 11 132.65 0 133.04 0 133.04 11 132.04 11 132.04 2.09" />
                                <polygon class="cls-1" points="120.97 2.04 116.98 6.15 116.98 6.19 116.97 6.17 116.95 6.19 116.95 6.15 112.97 2.04 112.97 11 112 11 112 0 112.32 0 116.97 4.8 121.62 0 121.94 0 121.94 11 120.97 11 120.97 2.04" />
                                <ellipse class="cls-3" cx="116.3" cy="22.81" rx="5.15" ry="5.18" />
                                <rect class="cls-2" x="99.13" y="0.44" width="5.87" height="27.12" />
                                <polygon class="cls-1" points="85.94 27.56 79.92 27.56 79.92 0.44 85.94 0.44 85.94 16.86 96.35 16.86 96.35 21.84 85.94 21.84 85.94 27.56" />
                                <path class="cls-1" d="M77.74,36.07a9,9,0,0,0,6.41-2.68L88,37c-2.6,2.74-6.71,4-10.89,4A13.94,13.94,0,0,1,62.89,27.15,14.19,14.19,0,0,1,77.11,13c4.38,0,8.28,1.17,10.89,4,0,0-3.89,3.82-3.91,3.8A9,9,0,1,0,77.74,36.07Z" transform="translate(-12 -13)" />
                                <rect class="cls-2" x="37.4" y="11.14" width="7.63" height="4.98" />
                                <polygon class="cls-1" points="32.85 27.56 28.6 27.56 28.6 5.42 28.6 3.96 28.6 0.44 47.95 0.44 47.95 5.42 34.46 5.42 34.46 22.72 48.25 22.72 48.25 27.56 34.46 27.56 32.85 27.56" />
                                <polygon class="cls-1" points="15.4 27.56 9.53 27.56 9.53 5.57 9.53 0.59 9.53 0.44 24.93 0.44 24.93 5.57 15.4 5.57 15.4 27.56" />
                                <rect class="cls-2" y="0.44" width="7.19" height="5.13" />
                            </svg>
                        </a>
                        <!-- /.custom-logo-link -->
                    </div>
                    <!-- /.site-branding -->
                    <!-- ============================================================= End Header Logo ============================================================= -->
                    <div class="handheld-header-links">
                        <ul class="columns-3">
                            <li class="my-account">
                                <a href="login-and-register.html" class="has-icon">
                                    <i class="tm tm-login-register"></i>
                                </a>
                            </li>
                            <li class="wishlist">
                                <a href="wishlist.html" class="has-icon">
                                    <i class="tm tm-favorites"></i>
                                    <span class="count">3</span>
                                </a>
                            </li>
                            <li class="compare">
                                <a href="compare.html" class="has-icon">
                                    <i class="tm tm-compare"></i>
                                    <span class="count">3</span>
                                </a>
                            </li>
                        </ul>
                        <!-- .columns-3 -->
                    </div>
                    <!-- .handheld-header-links -->
                </div>
                
                <div class="techmarket-sticky-wrap">
                    <div class="row">
                        <nav id="handheld-navigation" class="handheld-navigation" aria-label="Handheld Navigation">
                            <button class="btn navbar-toggler" type="button">
                                <i class="tm tm-departments-thin"></i>
                                <span>Menu</span>
                            </button>
                            <div class="handheld-navigation-menu">
                                <span class="tmhm-close">Close</span>
                                <ul id="menu-departments-menu-1" class="nav">
                                    <li class="highlight menu-item animate-dropdown">
                                        <a title="Value of the Day" href="shop.html">Value of the Day</a>
                                    </li>
                                    <li class="highlight menu-item animate-dropdown">
                                        <a title="Top 100 Offers" href="shop.html">Top 100 Offers</a>
                                    </li>
                                    <li class="highlight menu-item animate-dropdown">
                                        <a title="New Arrivals" href="shop.html">New Arrivals</a>
                                    </li>
                                    <li class="yamm-tfw menu-item menu-item-has-children animate-dropdown dropdown-submenu">
                                        <a title="Computers &amp; Laptops" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" href="#">Computers &#038; Laptops <span class="caret"></span></a>
                                        <ul role="menu" class=" dropdown-menu">
                                            <li class="menu-item menu-item-object-static_block animate-dropdown">
                                                <div class="yamm-content">
                                                    <div class="bg-yamm-content bg-yamm-content-bottom bg-yamm-content-right">
                                                        <div class="kc-col-container">
                                                            <div class="kc_single_image">
                                                                <img src="assets/images/megamenu.jpg" class="" alt="" />
                                                            </div>
                                                            <!-- .kc_single_image -->
                                                        </div>
                                                        <!-- .kc-col-container -->
                                                    </div>
                                                    <!-- .bg-yamm-content -->
                                                    <div class="row yamm-content-row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="kc-col-container">
                                                                <div class="kc_text_block">
                                                                    <ul>
                                                                        <li class="nav-title">Computers &amp; Accessories</li>
                                                                        <li><a href="shop.html">All Computers &amp; Accessories</a></li>
                                                                        <li><a href="shop.html">Laptops, Desktops &amp; Monitors</a></li>
                                                                        <li><a href="shop.html">Pen Drives, Hard Drives &amp; Memory Cards</a></li>
                                                                        <li><a href="shop.html">Printers &amp; Ink</a></li>
                                                                        <li><a href="shop.html">Networking &amp; Internet Devices</a></li>
                                                                        <li><a href="shop.html">Computer Accessories</a></li>
                                                                        <li><a href="shop.html">Software</a></li>
                                                                        <li class="nav-divider"></li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <span class="nav-text">All Electronics</span>
                                                                                <span class="nav-subtext">Discover more products</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .kc_text_block -->
                                                            </div>
                                                            <!-- .kc-col-container -->
                                                        </div>
                                                        <!-- .kc_column -->
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="kc-col-container">
                                                                <div class="kc_text_block">
                                                                    <ul>
                                                                        <li class="nav-title">Office &amp; Stationery</li>
                                                                        <li><a href="shop.html">All Office &amp; Stationery</a></li>
                                                                        <li><a href="shop.html">Pens &amp; Writing</a></li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .kc_text_block -->
                                                            </div>
                                                            <!-- .kc-col-container -->
                                                        </div>
                                                        <!-- .kc_column -->
                                                    </div>
                                                    <!-- .kc_row -->
                                                </div>
                                                <!-- .yamm-content -->
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="yamm-tfw menu-item menu-item-has-children animate-dropdown dropdown-submenu">
                                        <a title="Cameras &amp; Photo" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" href="#">Cameras &#038; Photo <span class="caret"></span></a>
                                        <ul role="menu" class=" dropdown-menu">
                                            <li class="menu-item menu-item-object-static_block animate-dropdown">
                                                <div class="yamm-content">
                                                    <div class="bg-yamm-content bg-yamm-content-bottom bg-yamm-content-right">
                                                        <div class="kc-col-container">
                                                            <div class="kc_single_image">
                                                                <img src="assets/images/megamenu-1.jpg" class="" alt="" />
                                                            </div>
                                                            <!-- .kc_single_image -->
                                                        </div>
                                                        <!-- .kc-col-container -->
                                                    </div>
                                                    <!-- .bg-yamm-content -->
                                                    <div class="row yamm-content-row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="kc-col-container">
                                                                <div class="kc_text_block">
                                                                    <ul>
                                                                        <li class="nav-title">Cameras & Photography</li>
                                                                        <li><a href="shop.html">All Cameras & Photography</a></li>
                                                                        <li><a href="shop.html">Point & Shoot Cameras</a></li>
                                                                        <li><a href="shop.html">Lenses</a></li>
                                                                        <li><a href="shop.html">Camera Accessories</a></li>
                                                                        <li><a href="shop.html">Security & Surveillance</a></li>
                                                                        <li><a href="shop.html">Binoculars & Telescopes</a></li>
                                                                        <li><a href="shop.html">Camcorders</a></li>
                                                                        <li class="nav-divider"></li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <span class="nav-text">All Electronics</span>
                                                                                <span class="nav-subtext">Discover more products</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .kc_text_block -->
                                                            </div>
                                                            <!-- .kc-col-container -->
                                                        </div>
                                                        <!-- .kc_column -->
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="kc-col-container">
                                                                <div class="kc_text_block">
                                                                    <ul>
                                                                        <li class="nav-title">Audio & Video</li>
                                                                        <li><a href="shop.html">All Audio & Video</a></li>
                                                                        <li><a href="shop.html">Headphones & Speakers</a></li>
                                                                        <li><a href="shop.html">Home Entertainment Systems</a></li>
                                                                        <li><a href="shop.html">MP3 & Media Players</a></li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .kc_text_block -->
                                                            </div>
                                                            <!-- .kc-col-container -->
                                                        </div>
                                                        <!-- .kc_column -->
                                                    </div>
                                                    <!-- .kc_row -->
                                                </div>
                                                <!-- .yamm-content -->
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="yamm-tfw menu-item menu-item-has-children animate-dropdown dropdown-submenu">
                                        <a title="Smart Phones &amp; Tablets" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" href="#">Smart Phones &#038; Tablets 	<span class="caret"></span></a>
                                        <ul role="menu" class=" dropdown-menu">
                                            <li class="menu-item menu-item-object-static_block animate-dropdown">
                                                <div class="yamm-content">
                                                    <div class="bg-yamm-content bg-yamm-content-bottom bg-yamm-content-right">
                                                        <div class="kc-col-container">
                                                            <div class="kc_single_image">
                                                                <img src="assets/images/megamenu.jpg" class="" alt="" />
                                                            </div>
                                                            <!-- .kc_single_image -->
                                                        </div>
                                                        <!-- .kc-col-container -->
                                                    </div>
                                                    <!-- .bg-yamm-content -->
                                                    <div class="row yamm-content-row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="kc-col-container">
                                                                <div class="kc_text_block">
                                                                    <ul>
                                                                        <li class="nav-title">Computers &amp; Accessories</li>
                                                                        <li><a href="shop.html">All Computers &amp; Accessories</a></li>
                                                                        <li><a href="shop.html">Laptops, Desktops &amp; Monitors</a></li>
                                                                        <li><a href="shop.html">Pen Drives, Hard Drives &amp; Memory Cards</a></li>
                                                                        <li><a href="shop.html">Printers &amp; Ink</a></li>
                                                                        <li><a href="shop.html">Networking &amp; Internet Devices</a></li>
                                                                        <li><a href="shop.html">Computer Accessories</a></li>
                                                                        <li><a href="shop.html">Software</a></li>
                                                                        <li class="nav-divider"></li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <span class="nav-text">All Electronics</span>
                                                                                <span class="nav-subtext">Discover more products</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .kc_text_block -->
                                                            </div>
                                                            <!-- .kc-col-container -->
                                                        </div>
                                                        <!-- .kc_column -->
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="kc-col-container">
                                                                <div class="kc_text_block">
                                                                    <ul>
                                                                        <li class="nav-title">Office &amp; Stationery</li>
                                                                        <li><a href="shop.html">All Office &amp; Stationery</a></li>
                                                                        <li><a href="shop.html">Pens &amp; Writing</a></li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .kc_text_block -->
                                                            </div>
                                                            <!-- .kc-col-container -->
                                                        </div>
                                                        <!-- .kc_column -->
                                                    </div>
                                                    <!-- .kc_row -->
                                                </div>
                                                <!-- .yamm-content -->
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="yamm-tfw menu-item menu-item-has-children animate-dropdown dropdown-submenu">
                                        <a title="Video Games &amp; Consoles" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" href="#">Video Games &#038; Consoles <span class="caret"></span></a>
                                        <ul role="menu" class=" dropdown-menu">
                                            <li class="menu-item menu-item-object-static_block animate-dropdown">
                                                <div class="yamm-content">
                                                    <div class="bg-yamm-content bg-yamm-content-bottom bg-yamm-content-right">
                                                        <div class="kc-col-container">
                                                            <div class="kc_single_image">
                                                                <img src="assets/images/megamenu-1.jpg" class="" alt="" />
                                                            </div>
                                                            <!-- .kc_single_image -->
                                                        </div>
                                                        <!-- .kc-col-container -->
                                                    </div>
                                                    <!-- .bg-yamm-content -->
                                                    <div class="row yamm-content-row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="kc-col-container">
                                                                <div class="kc_text_block">
                                                                    <ul>
                                                                        <li class="nav-title">Cameras & Photography</li>
                                                                        <li><a href="shop.html">All Cameras & Photography</a></li>
                                                                        <li><a href="shop.html">Point & Shoot Cameras</a></li>
                                                                        <li><a href="shop.html">Lenses</a></li>
                                                                        <li><a href="shop.html">Camera Accessories</a></li>
                                                                        <li><a href="shop.html">Security & Surveillance</a></li>
                                                                        <li><a href="shop.html">Binoculars & Telescopes</a></li>
                                                                        <li><a href="shop.html">Camcorders</a></li>
                                                                        <li class="nav-divider"></li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <span class="nav-text">All Electronics</span>
                                                                                <span class="nav-subtext">Discover more products</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .kc_text_block -->
                                                            </div>
                                                            <!-- .kc-col-container -->
                                                        </div>
                                                        <!-- .kc_column -->
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="kc-col-container">
                                                                <div class="kc_text_block">
                                                                    <ul>
                                                                        <li class="nav-title">Audio & Video</li>
                                                                        <li><a href="shop.html">All Audio & Video</a></li>
                                                                        <li><a href="shop.html">Headphones & Speakers</a></li>
                                                                        <li><a href="shop.html">Home Entertainment Systems</a></li>
                                                                        <li><a href="shop.html">MP3 & Media Players</a></li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .kc_text_block -->
                                                            </div>
                                                            <!-- .kc-col-container -->
                                                        </div>
                                                        <!-- .kc_column -->
                                                    </div>
                                                    <!-- .kc_row -->
                                                </div>
                                                <!-- .yamm-content -->
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="yamm-tfw menu-item menu-item-has-children animate-dropdown dropdown-submenu">
                                        <a title="TV &amp; Audio" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" href="#">TV &#038; Audio <span class="caret"></span></a>
                                        <ul role="menu" class=" dropdown-menu">
                                            <li class="menu-item menu-item-object-static_block animate-dropdown">
                                                <div class="yamm-content">
                                                    <div class="bg-yamm-content bg-yamm-content-bottom bg-yamm-content-right">
                                                        <div class="kc-col-container">
                                                            <div class="kc_single_image">
                                                                <img src="assets/images/megamenu.jpg" class="" alt="" />
                                                            </div>
                                                            <!-- .kc_single_image -->
                                                        </div>
                                                        <!-- .kc-col-container -->
                                                    </div>
                                                    <!-- .bg-yamm-content -->
                                                    <div class="row yamm-content-row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="kc-col-container">
                                                                <div class="kc_text_block">
                                                                    <ul>
                                                                        <li class="nav-title">Computers &amp; Accessories</li>
                                                                        <li><a href="shop.html">All Computers &amp; Accessories</a></li>
                                                                        <li><a href="shop.html">Laptops, Desktops &amp; Monitors</a></li>
                                                                        <li><a href="shop.html">Pen Drives, Hard Drives &amp; Memory Cards</a></li>
                                                                        <li><a href="shop.html">Printers &amp; Ink</a></li>
                                                                        <li><a href="shop.html">Networking &amp; Internet Devices</a></li>
                                                                        <li><a href="shop.html">Computer Accessories</a></li>
                                                                        <li><a href="shop.html">Software</a></li>
                                                                        <li class="nav-divider"></li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <span class="nav-text">All Electronics</span>
                                                                                <span class="nav-subtext">Discover more products</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .kc_text_block -->
                                                            </div>
                                                            <!-- .kc-col-container -->
                                                        </div>
                                                        <!-- .kc_column -->
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="kc-col-container">
                                                                <div class="kc_text_block">
                                                                    <ul>
                                                                        <li class="nav-title">Office &amp; Stationery</li>
                                                                        <li><a href="shop.html">All Office &amp; Stationery</a></li>
                                                                        <li><a href="shop.html">Pens &amp; Writing</a></li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .kc_text_block -->
                                                            </div>
                                                            <!-- .kc-col-container -->
                                                        </div>
                                                        <!-- .kc_column -->
                                                    </div>
                                                    <!-- .kc_row -->
                                                </div>
                                                <!-- .yamm-content -->
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="yamm-tfw menu-item menu-item-has-children animate-dropdown dropdown-submenu">
                                        <a title="Car Electronic &amp; GPS" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" href="#">Car Electronic &#038; GPS <span class="caret"></span></a>
                                        <ul role="menu" class=" dropdown-menu">
                                            <li class="menu-item menu-item-object-static_block animate-dropdown">
                                                <div class="yamm-content">
                                                    <div class="bg-yamm-content bg-yamm-content-bottom bg-yamm-content-right">
                                                        <div class="kc-col-container">
                                                            <div class="kc_single_image">
                                                                <img src="assets/images/megamenu-1.jpg" class="" alt="" />
                                                            </div>
                                                            <!-- .kc_single_image -->
                                                        </div>
                                                        <!-- .kc-col-container -->
                                                    </div>
                                                    <!-- .bg-yamm-content -->
                                                    <div class="row yamm-content-row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="kc-col-container">
                                                                <div class="kc_text_block">
                                                                    <ul>
                                                                        <li class="nav-title">Cameras & Photography</li>
                                                                        <li><a href="shop.html">All Cameras & Photography</a></li>
                                                                        <li><a href="shop.html">Point & Shoot Cameras</a></li>
                                                                        <li><a href="shop.html">Lenses</a></li>
                                                                        <li><a href="shop.html">Camera Accessories</a></li>
                                                                        <li><a href="shop.html">Security & Surveillance</a></li>
                                                                        <li><a href="shop.html">Binoculars & Telescopes</a></li>
                                                                        <li><a href="shop.html">Camcorders</a></li>
                                                                        <li class="nav-divider"></li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <span class="nav-text">All Electronics</span>
                                                                                <span class="nav-subtext">Discover more products</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .kc_text_block -->
                                                            </div>
                                                            <!-- .kc-col-container -->
                                                        </div>
                                                        <!-- .kc_column -->
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="kc-col-container">
                                                                <div class="kc_text_block">
                                                                    <ul>
                                                                        <li class="nav-title">Audio & Video</li>
                                                                        <li><a href="shop.html">All Audio & Video</a></li>
                                                                        <li><a href="shop.html">Headphones & Speakers</a></li>
                                                                        <li><a href="shop.html">Home Entertainment Systems</a></li>
                                                                        <li><a href="shop.html">MP3 & Media Players</a></li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .kc_text_block -->
                                                            </div>
                                                            <!-- .kc-col-container -->
                                                        </div>
                                                        <!-- .kc_column -->
                                                    </div>
                                                    <!-- .kc_row -->
                                                </div>
                                                <!-- .yamm-content -->
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="yamm-tfw menu-item menu-item-has-children animate-dropdown dropdown-submenu">
                                        <a title="Accesories" data-toggle="dropdown" class="dropdown-toggle" aria-haspopup="true" href="#">Accesories <span class="caret"></span></a>
                                        <ul role="menu" class=" dropdown-menu">
                                            <li class="menu-item menu-item-object-static_block animate-dropdown">
                                                <div class="yamm-content">
                                                    <div class="bg-yamm-content bg-yamm-content-bottom bg-yamm-content-right">
                                                        <div class="kc-col-container">
                                                            <div class="kc_single_image">
                                                                <img src="assets/images/megamenu.jpg" class="" alt="" />
                                                            </div>
                                                            <!-- .kc_single_image -->
                                                        </div>
                                                        <!-- .kc-col-container -->
                                                    </div>
                                                    <!-- .bg-yamm-content -->
                                                    <div class="row yamm-content-row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="kc-col-container">
                                                                <div class="kc_text_block">
                                                                    <ul>
                                                                        <li class="nav-title">Computers &amp; Accessories</li>
                                                                        <li><a href="shop.html">All Computers &amp; Accessories</a></li>
                                                                        <li><a href="shop.html">Laptops, Desktops &amp; Monitors</a></li>
                                                                        <li><a href="shop.html">Pen Drives, Hard Drives &amp; Memory Cards</a></li>
                                                                        <li><a href="shop.html">Printers &amp; Ink</a></li>
                                                                        <li><a href="shop.html">Networking &amp; Internet Devices</a></li>
                                                                        <li><a href="shop.html">Computer Accessories</a></li>
                                                                        <li><a href="shop.html">Software</a></li>
                                                                        <li class="nav-divider"></li>
                                                                        <li>
                                                                            <a href="#">
                                                                                <span class="nav-text">All Electronics</span>
                                                                                <span class="nav-subtext">Discover more products</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .kc_text_block -->
                                                            </div>
                                                            <!-- .kc-col-container -->
                                                        </div>
                                                        <!-- .kc_column -->
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="kc-col-container">
                                                                <div class="kc_text_block">
                                                                    <ul>
                                                                        <li class="nav-title">Office &amp; Stationery</li>
                                                                        <li><a href="shop.html">All Office &amp; Stationery</a></li>
                                                                        <li><a href="shop.html">Pens &amp; Writing</a></li>
                                                                    </ul>
                                                                </div>
                                                                <!-- .kc_text_block -->
                                                            </div>
                                                            <!-- .kc-col-container -->
                                                        </div>
                                                        <!-- .kc_column -->
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item animate-dropdown">
                                        <a title="Gadgets" href="shop.html">Gadgets</a>
                                    </li>
                                    <li class="menu-item animate-dropdown">
                                        <a title="Virtual Reality" href="shop.html">Virtual Reality</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                        <div class="site-search">
                            <div class="widget woocommerce widget_product_search">
                                <form role="search" method="get" class="woocommerce-product-search" action="home-v1.html">
                                    <label class="screen-reader-text" for="woocommerce-product-search-field-0">Search for:</label>
                                    <input type="search" id="woocommerce-product-search-field-0" class="search-field" placeholder="Search products&hellip;" value="" name="s" />
                                    <input type="submit" value="Search" />
                                    <input type="hidden" name="post_type" value="product" />
                                </form>
                            </div>
                            <!-- .widget -->
                        </div>
                        <!-- .site-search -->
                        <a class="handheld-header-cart-link has-icon" href="cart.html" title="View your shopping cart">
                            <i class="tm tm-shopping-bag"></i>
                            <span class="count">2</span>
                        </a>
                    </div>                    
                </div>
            </div>
        </div>
    </header>
	<div id="content" class="site-content" tabindex="-1">
        <?php echo trim($data['view::body']);?>
    </div>
    <div class="col-full">
        <section class="section-landscape-products-carousel recently-viewed" id="recently-viewed">
            <header class="section-header">
                <h2 class="section-title">Recently viewed products</h2>
                <nav class="custom-slick-nav"></nav>
            </header>
            <div class="products-carousel" data-ride="tm-slick-carousel" data-wrap=".products" data-slick="{&quot;slidesToShow&quot;:5,&quot;slidesToScroll&quot;:2,&quot;dots&quot;:true,&quot;arrows&quot;:true,&quot;prevArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-left\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;nextArrow&quot;:&quot;&lt;a href=\&quot;#\&quot;&gt;&lt;i class=\&quot;tm tm-arrow-right\&quot;&gt;&lt;\/i&gt;&lt;\/a&gt;&quot;,&quot;appendArrows&quot;:&quot;#recently-viewed .custom-slick-nav&quot;,&quot;responsive&quot;:[{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesToScroll&quot;:2}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesToScroll&quot;:3}},{&quot;breakpoint&quot;:1400,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesToScroll&quot;:3}},{&quot;breakpoint&quot;:1700,&quot;settings&quot;:{&quot;slidesToShow&quot;:4,&quot;slidesToScroll&quot;:4}}]}">
                <div class="container-fluid">
                    <div class="woocommerce columns-5">
                        <div class="products">
                            <div class="landscape-product product">
                                <a class="woocommerce-LoopProduct-link" href="single-product-fullwidth.html">
                                    <div class="media">
                                        <img class="wp-post-image" src="assets/images/products/card-1.jpg" alt="">
                                        <div class="media-body">
                                                    <span class="price">
                                                        <ins>
                                                            <span class="amount"> $3,788.00</span>
                                                        </ins>
                                                        <del>
                                                            <span class="amount">$4,780.00</span>
                                                        </del>
                                                        <span class="amount"> </span>
                                                    </span>
                                            <!-- .price -->
                                            <h2 class="woocommerce-loop-product__title">Unlocked Android 6″ Inch 4.4.2 Dual Core</h2>
                                            <div class="techmarket-product-rating">
                                                <div title="Rated 0 out of 5" class="star-rating">
                                                            <span style="width:0%">
                                                                <strong class="rating">0</strong> out of 5</span>
                                                </div>
                                                <span class="review-count">(0)</span>
                                            </div>
                                            <!-- .techmarket-product-rating -->
                                        </div>
                                        <!-- .media-body -->
                                    </div>
                                    <!-- .media -->
                                </a>
                                <!-- .woocommerce-LoopProduct-link -->
                            </div>
                            <!-- .landscape-product -->
                            <div class="landscape-product product">
                                <a class="woocommerce-LoopProduct-link" href="single-product-fullwidth.html">
                                    <div class="media">
                                        <img class="wp-post-image" src="assets/images/products/card-2.jpg" alt="">
                                        <div class="media-body">
                                                    <span class="price">
                                                        <ins>
                                                            <span class="amount"> </span>
                                                        </ins>
                                                        <span class="amount"> $500</span>
                                                    </span>
                                            <!-- .price -->
                                            <h2 class="woocommerce-loop-product__title">Headset 3D Glasses VR for Android</h2>
                                            <div class="techmarket-product-rating">
                                                <div title="Rated 0 out of 5" class="star-rating">
                                                            <span style="width:0%">
                                                                <strong class="rating">0</strong> out of 5</span>
                                                </div>
                                                <span class="review-count">(0)</span>
                                            </div>
                                            <!-- .techmarket-product-rating -->
                                        </div>
                                        <!-- .media-body -->
                                    </div>
                                    <!-- .media -->
                                </a>
                                <!-- .woocommerce-LoopProduct-link -->
                            </div>
                            <!-- .landscape-product -->
                            <div class="landscape-product product">
                                <a class="woocommerce-LoopProduct-link" href="single-product-fullwidth.html">
                                    <div class="media">
                                        <img class="wp-post-image" src="assets/images/products/card-3.jpg" alt="">
                                        <div class="media-body">
                                                    <span class="price">
                                                        <ins>
                                                            <span class="amount"> $3,788.00</span>
                                                        </ins>
                                                        <del>
                                                            <span class="amount">$4,780.00</span>
                                                        </del>
                                                        <span class="amount"> </span>
                                                    </span>
                                            <!-- .price -->
                                            <h2 class="woocommerce-loop-product__title">PowerBank 4400</h2>
                                            <div class="techmarket-product-rating">
                                                <div title="Rated 0 out of 5" class="star-rating">
                                                            <span style="width:0%">
                                                                <strong class="rating">0</strong> out of 5</span>
                                                </div>
                                                <span class="review-count">(0)</span>
                                            </div>
                                            <!-- .techmarket-product-rating -->
                                        </div>
                                        <!-- .media-body -->
                                    </div>
                                    <!-- .media -->
                                </a>
                                <!-- .woocommerce-LoopProduct-link -->
                            </div>
                            <!-- .landscape-product -->
                            <div class="landscape-product product">
                                <a class="woocommerce-LoopProduct-link" href="single-product-fullwidth.html">
                                    <div class="media">
                                        <img class="wp-post-image" src="assets/images/products/card-6.jpg" alt="">
                                        <div class="media-body">
                                                    <span class="price">
                                                        <ins>
                                                            <span class="amount"> </span>
                                                        </ins>
                                                        <span class="amount"> $600</span>
                                                    </span>
                                            <!-- .price -->
                                            <h2 class="woocommerce-loop-product__title">ZenBook 3 Ultrabook 8GB 512SSD W10</h2>
                                            <div class="techmarket-product-rating">
                                                <div title="Rated 0 out of 5" class="star-rating">
                                                            <span style="width:0%">
                                                                <strong class="rating">0</strong> out of 5</span>
                                                </div>
                                                <span class="review-count">(0)</span>
                                            </div>
                                            <!-- .techmarket-product-rating -->
                                        </div>
                                        <!-- .media-body -->
                                    </div>
                                    <!-- .media -->
                                </a>
                                <!-- .woocommerce-LoopProduct-link -->
                            </div>
                            <!-- .landscape-product -->
                            <div class="landscape-product product">
                                <a class="woocommerce-LoopProduct-link" href="single-product-fullwidth.html">
                                    <div class="media">
                                        <img class="wp-post-image" src="assets/images/products/card-4.jpg" alt="">
                                        <div class="media-body">
                                                    <span class="price">
                                                        <ins>
                                                            <span class="amount"> </span>
                                                        </ins>
                                                        <span class="amount"> $800</span>
                                                    </span>
                                            <!-- .price -->
                                            <h2 class="woocommerce-loop-product__title">Snap White Instant Digital Camera in White</h2>
                                            <div class="techmarket-product-rating">
                                                <div title="Rated 0 out of 5" class="star-rating">
                                                            <span style="width:0%">
                                                                <strong class="rating">0</strong> out of 5</span>
                                                </div>
                                                <span class="review-count">(0)</span>
                                            </div>
                                            <!-- .techmarket-product-rating -->
                                        </div>
                                        <!-- .media-body -->
                                    </div>
                                    <!-- .media -->
                                </a>
                                <!-- .woocommerce-LoopProduct-link -->
                            </div>
                            <!-- .landscape-product -->
                            <div class="landscape-product product">
                                <a class="woocommerce-LoopProduct-link" href="single-product-fullwidth.html">
                                    <div class="media">
                                        <img class="wp-post-image" src="assets/images/products/card-4.jpg" alt="">
                                        <div class="media-body">
                                                    <span class="price">
                                                        <ins>
                                                            <span class="amount"> </span>
                                                        </ins>
                                                        <span class="amount"> $800</span>
                                                    </span>
                                            <!-- .price -->
                                            <h2 class="woocommerce-loop-product__title">Snap White Instant Digital Camera in White</h2>
                                            <div class="techmarket-product-rating">
                                                <div title="Rated 0 out of 5" class="star-rating">
                                                            <span style="width:0%">
                                                                <strong class="rating">0</strong> out of 5</span>
                                                </div>
                                                <span class="review-count">(0)</span>
                                            </div>
                                            <!-- .techmarket-product-rating -->
                                        </div>
                                        <!-- .media-body -->
                                    </div>
                                    <!-- .media -->
                                </a>
                                <!-- .woocommerce-LoopProduct-link -->
                            </div>
                            <!-- .landscape-product -->
                            <div class="landscape-product product">
                                <a class="woocommerce-LoopProduct-link" href="single-product-fullwidth.html">
                                    <div class="media">
                                        <img class="wp-post-image" src="assets/images/products/card-3.jpg" alt="">
                                        <div class="media-body">
                                                    <span class="price">
                                                        <ins>
                                                            <span class="amount"> $3,788.00</span>
                                                        </ins>
                                                        <del>
                                                            <span class="amount">$4,780.00</span>
                                                        </del>
                                                        <span class="amount"> </span>
                                                    </span>
                                            <!-- .price -->
                                            <h2 class="woocommerce-loop-product__title">PowerBank 4400</h2>
                                            <div class="techmarket-product-rating">
                                                <div title="Rated 0 out of 5" class="star-rating">
                                                            <span style="width:0%">
                                                                <strong class="rating">0</strong> out of 5</span>
                                                </div>
                                                <span class="review-count">(0)</span>
                                            </div>
                                            <!-- .techmarket-product-rating -->
                                        </div>
                                        <!-- .media-body -->
                                    </div>
                                    <!-- .media -->
                                </a>
                                <!-- .woocommerce-LoopProduct-link -->
                            </div>
                            <!-- .landscape-product -->
                            <div class="landscape-product product">
                                <a class="woocommerce-LoopProduct-link" href="single-product-fullwidth.html">
                                    <div class="media">
                                        <img class="wp-post-image" src="assets/images/products/card-5.jpg" alt="">
                                        <div class="media-body">
                                                    <span class="price">
                                                        <ins>
                                                            <span class="amount"> $3,788.00</span>
                                                        </ins>
                                                        <del>
                                                            <span class="amount">$4,780.00</span>
                                                        </del>
                                                        <span class="amount"> </span>
                                                    </span>
                                            <!-- .price -->
                                            <h2 class="woocommerce-loop-product__title">Smart Watches 3 SWR50</h2>
                                            <div class="techmarket-product-rating">
                                                <div title="Rated 0 out of 5" class="star-rating">
                                                            <span style="width:0%">
                                                                <strong class="rating">0</strong> out of 5</span>
                                                </div>
                                                <span class="review-count">(0)</span>
                                            </div>
                                            <!-- .techmarket-product-rating -->
                                        </div>
                                        <!-- .media-body -->
                                    </div>
                                    <!-- .media -->
                                </a>
                                <!-- .woocommerce-LoopProduct-link -->
                            </div>
                            <!-- .landscape-product -->
                        </div>
                    </div>
                    <!-- .woocommerce -->
                </div>
                <!-- .container-fluid -->
            </div>
            <!-- .products-carousel -->
        </section>
        <!-- .section-landscape-products-carousel -->
        <section class="brands-carousel">
            <h2 class="sr-only">Brands Carousel</h2>
            <div class="col-full" data-ride="tm-slick-carousel" data-wrap=".brands" data-slick="{&quot;slidesToShow&quot;:6,&quot;slidesToScroll&quot;:1,&quot;dots&quot;:false,&quot;arrows&quot;:true,&quot;responsive&quot;:[{&quot;breakpoint&quot;:400,&quot;settings&quot;:{&quot;slidesToShow&quot;:1,&quot;slidesToScroll&quot;:1}},{&quot;breakpoint&quot;:800,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesToScroll&quot;:3}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesToScroll&quot;:3}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:4,&quot;slidesToScroll&quot;:4}},{&quot;breakpoint&quot;:1400,&quot;settings&quot;:{&quot;slidesToShow&quot;:5,&quot;slidesToScroll&quot;:5}}]}">
                <div class="brands">
                    <div class="item">
                        <a href="shop.html">
                            <figure>
                                <figcaption class="text-overlay">
                                    <div class="info">
                                        <h4>apple</h4>
                                    </div>
                                    <!-- /.info -->
                                </figcaption>
                                <img width="145" height="50" class="img-responsive desaturate" alt="apple" src="assets/images/brands/1.png">
                            </figure>
                        </a>
                    </div>
                    <!-- .item -->
                    <div class="item">
                        <a href="shop.html">
                            <figure>
                                <figcaption class="text-overlay">
                                    <div class="info">
                                        <h4>bosch</h4>
                                    </div>
                                    <!-- /.info -->
                                </figcaption>
                                <img width="145" height="50" class="img-responsive desaturate" alt="bosch" src="assets/images/brands/2.png">
                            </figure>
                        </a>
                    </div>
                    <!-- .item -->
                    <div class="item">
                        <a href="shop.html">
                            <figure>
                                <figcaption class="text-overlay">
                                    <div class="info">
                                        <h4>cannon</h4>
                                    </div>
                                    <!-- /.info -->
                                </figcaption>
                                <img width="145" height="50" class="img-responsive desaturate" alt="cannon" src="assets/images/brands/3.png">
                            </figure>
                        </a>
                    </div>
                    <!-- .item -->
                    <div class="item">
                        <a href="shop.html">
                            <figure>
                                <figcaption class="text-overlay">
                                    <div class="info">
                                        <h4>connect</h4>
                                    </div>
                                    <!-- /.info -->
                                </figcaption>
                                <img width="145" height="50" class="img-responsive desaturate" alt="connect" src="assets/images/brands/4.png">
                            </figure>
                        </a>
                    </div>
                    <!-- .item -->
                    <div class="item">
                        <a href="shop.html">
                            <figure>
                                <figcaption class="text-overlay">
                                    <div class="info">
                                        <h4>galaxy</h4>
                                    </div>
                                    <!-- /.info -->
                                </figcaption>
                                <img width="145" height="50" class="img-responsive desaturate" alt="galaxy" src="assets/images/brands/5.png">
                            </figure>
                        </a>
                    </div>
                    <!-- .item -->
                    <div class="item">
                        <a href="shop.html">
                            <figure>
                                <figcaption class="text-overlay">
                                    <div class="info">
                                        <h4>gopro</h4>
                                    </div>
                                    <!-- /.info -->
                                </figcaption>
                                <img width="145" height="50" class="img-responsive desaturate" alt="gopro" src="assets/images/brands/6.png">
                            </figure>
                        </a>
                    </div>
                    <!-- .item -->
                    <div class="item">
                        <a href="shop.html">
                            <figure>
                                <figcaption class="text-overlay">
                                    <div class="info">
                                        <h4>handspot</h4>
                                    </div>
                                    <!-- /.info -->
                                </figcaption>
                                <img width="145" height="50" class="img-responsive desaturate" alt="handspot" src="assets/images/brands/7.png">
                            </figure>
                        </a>
                    </div>
                    <!-- .item -->
                    <div class="item">
                        <a href="shop.html">
                            <figure>
                                <figcaption class="text-overlay">
                                    <div class="info">
                                        <h4>kinova</h4>
                                    </div>
                                    <!-- /.info -->
                                </figcaption>
                                <img width="145" height="50" class="img-responsive desaturate" alt="kinova" src="assets/images/brands/8.png">
                            </figure>
                        </a>
                    </div>
                    <!-- .item -->
                    <div class="item">
                        <a href="shop.html">
                            <figure>
                                <figcaption class="text-overlay">
                                    <div class="info">
                                        <h4>nespresso</h4>
                                    </div>
                                    <!-- /.info -->
                                </figcaption>
                                <img width="145" height="50" class="img-responsive desaturate" alt="nespresso" src="assets/images/brands/9.png">
                            </figure>
                        </a>
                    </div>
                    <!-- .item -->
                    <div class="item">
                        <a href="shop.html">
                            <figure>
                                <figcaption class="text-overlay">
                                    <div class="info">
                                        <h4>samsung</h4>
                                    </div>
                                    <!-- /.info -->
                                </figcaption>
                                <img width="145" height="50" class="img-responsive desaturate" alt="samsung" src="assets/images/brands/10.png">
                            </figure>
                        </a>
                    </div>
                    <!-- .item -->
                    <div class="item">
                        <a href="shop.html">
                            <figure>
                                <figcaption class="text-overlay">
                                    <div class="info">
                                        <h4>speedway</h4>
                                    </div>
                                    <!-- /.info -->
                                </figcaption>
                                <img width="145" height="50" class="img-responsive desaturate" alt="speedway" src="assets/images/brands/11.png">
                            </figure>
                        </a>
                    </div>
                    <!-- .item -->
                    <div class="item">
                        <a href="shop.html">
                            <figure>
                                <figcaption class="text-overlay">
                                    <div class="info">
                                        <h4>yoko</h4>
                                    </div>
                                    <!-- /.info -->
                                </figcaption>
                                <img width="145" height="50" class="img-responsive desaturate" alt="yoko" src="assets/images/brands/12.png">
                            </figure>
                        </a>
                    </div>
                    <!-- .item -->
                </div>
            </div>
            <!-- .col-full -->
        </section>
    <footer class="site-footer footer-v1">
        <div class="col-full">
            <div class="before-footer-wrap">
                <div class="col-full">
                    <div class="footer-newsletter">
                        <div class="media">
                            <i class="footer-newsletter-icon tm tm-newsletter"></i>
                            <div class="media-body">
                                <div class="clearfix">
                                    <div class="newsletter-header">
                                        <h5 class="newsletter-title">Получить скидку</h5>
                                        <span class="newsletter-marketing-text">
                                            <strong>на первую покупку</strong>
                                        </span>
                                    </div>
                                    <div class="newsletter-body">
                                        <form class="newsletter-form">
                                            <input name="email" type="text" placeholder="Введите e-mail адрес">
                                            <button class="button" type="button">Запросить</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sotcialnye-seti']); ?>
                </div>
            </div>
            <div class="footer-widgets-block">
                <div class="row">
                    <div class="footer-contact">
                        <div class="footer-logo">
                            <a href="<?php echo $siteData->urlBasic;?>" class="custom-logo-link" rel="home">
                                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png">
                            </a>
                        </div>
                        <div class="contact-payment-wrap">
                            <div class="footer-contact-info">
                                <div class="media">
                                    <span class="media-left icon media-middle">
                                        <i class="tm tm-call-us-footer"></i>
                                    </span>
                                    <div class="media-body">
                                        <span class="call-us-title">Позвонить</span>
                                        <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefon-snizu']); ?>
                                        <address class="footer-contact-address">Режим работы: <b>09:00 - 18:00</b></address>
                                    </div>
                                </div>
                            </div>
                            <div class="footer-payment-info">
                                <div class="media">
                                    <span class="media-left icon media-middle">
                                        <i class="footer-newsletter-icon tm tm-newsletter"></i>
                                    </span>
                                    <div class="media-body">
                                        <span class="call-us-title">Написать</span>
                                        <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\e-mail-snizu']); ?>
                                        <address class="footer-contact-address">Режим работы: <b>09:00 - 18:00</b></address>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- .footer-contact -->
                    <div class="footer-widgets">
                        <div class="columns">
                            <aside class="widget clearfix">
                                <div class="body">
                                    <h4 class="widget-title">Find it Fast</h4>
                                    <div class="menu-footer-menu-1-container">
                                        <ul id="menu-footer-menu-1" class="menu">
                                            <li class="menu-item">
                                                <a href="shop.html">Computers &#038; Laptops</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="shop.html">Cameras &#038; Photography</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="shop.html">Smart Phones &#038; Tablets</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="shop.html">Video Games &#038; Consoles</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="shop.html">TV</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="shop.html">Car Electronic &#038; GPS</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- .menu-footer-menu-1-container -->
                                </div>
                                <!-- .body -->
                            </aside>
                            <!-- .widget -->
                        </div>
                        <!-- .columns -->
                        <div class="columns">
                            <aside class="widget clearfix">
                                <div class="body">
                                    <h4 class="widget-title">&nbsp;</h4>
                                    <div class="menu-footer-menu-2-container">
                                        <ul id="menu-footer-menu-2" class="menu">
                                            <li class="menu-item">
                                                <a href="shop.html">Printers &#038; Ink</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="shop.html">Audio &amp; Music</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="shop.html">Home Theaters</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="shop.html">PC Components</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="shop.html">Ultrabooks</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="shop.html">Smartwatches</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- .menu-footer-menu-2-container -->
                                </div>
                                <!-- .body -->
                            </aside>
                            <!-- .widget -->
                        </div>
                        <!-- .columns -->
                        <div class="columns">
                            <aside class="widget clearfix">
                                <div class="body">
                                    <h4 class="widget-title">Customer Care</h4>
                                    <div class="menu-footer-menu-3-container">
                                        <ul id="menu-footer-menu-3" class="menu">
                                            <li class="menu-item">
                                                <a href="login-and-register.html">My Account</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="track-your-order.html">Track Order</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="shop.html">Shop</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="wishlist.html">Wishlist</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="about.html">About Us</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="terms-and-conditions.html">Returns/Exchange</a>
                                            </li>
                                            <li class="menu-item">
                                                <a href="faq.html">FAQs</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- .menu-footer-menu-3-container -->
                                </div>
                                <!-- .body -->
                            </aside>
                            <!-- .widget -->
                        </div>
                        <!-- .columns -->
                    </div>
                    <!-- .footer-widgets -->
                </div>
                <!-- .row -->
            </div>
            <!-- .footer-widgets-block -->
            <div class="site-info">
                <div class="col-full">
                    <div class="copyright">Copyright &copy; 2017 <a href="home-v1.html">Techmarket</a> Theme. All rights reserved.</div>
                    <!-- .copyright -->
                    <div class="credit">Made with
                        <i class="fa fa-heart"></i> by bcube.</div>
                    <!-- .credit -->
                </div>
                <!-- .col-full -->
            </div>
            <!-- .site-info -->
        </div>
    </footer>
</div>
</div>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/tether.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/jquery-migrate.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/hidemaxlistitem.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/hidemaxlistitem.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/jquery.easing.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/scrollup.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/jquery.waypoints.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/waypoints-sticky.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/pace.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/slick.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/scripts.js"></script>
</body>
</html>
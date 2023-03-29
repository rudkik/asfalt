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
<body class="<?php
switch ($siteData->url){
    case '':
    case '/':
        echo 'woocommerce-active left-sidebar';
        break;
    case '/contacts':
        echo 'page home page-template-default  pace-done';
        break;
    case '/catalogs':
        echo 'woocommerce-active left-sidebar  pace-done';
        break;
    case '/goods':
        echo 'woocommerce-active single-product full-width normal  pace-done';
        break;
    default:
        echo 'right-sidebar single single-post';
}?>" itemscope="itemscope" itemtype="http://schema.org/WebPage">
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
                        <a href="<?php echo $siteData->urlBasic;?>" class="custom-logo-link" rel="home">
                            <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png">
                        </a>
                    </div>
                    <div class="handheld-header-links">
                        <ul class="columns-3">
                            <li class="my-account">
                                <a href="<?php echo $siteData->urlBasic;?>/users/registr" class="has-icon">
                                    <i class="tm tm-login-register"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="techmarket-sticky-wrap">
                    <div class="row">
                        <nav id="handheld-navigation" class="handheld-navigation" aria-label="Handheld Navigation">
                            <button class="btn navbar-toggler" type="button">
                                <i class="tm tm-departments-thin"></i>
                                <span>Меню</span>
                            </button>
                            <div class="handheld-navigation-menu">
                                <span class="tmhm-close">Закрыть</span>
                                <ul id="menu-departments-menu-1" class="nav">
                                    <li class="highlight menu-item animate-dropdown">
                                        <a title="Value of the Day" href="shop.html">Value of the Day</a>
                                    </li>
                                    <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\basic\rubrikatciya-s-detvoroi']); ?>
                                </ul>
                            </div>
                        </nav>
                        <div class="site-search">
                            <div class="widget woocommerce widget_product_search">
                                <form role="search" method="get" class="woocommerce-product-search" action="<?php echo $siteData->urlBasic;?>/catalogs">
                                    <label class="screen-reader-text" for="woocommerce-product-search-field-0">Поиск</label>
                                    <input type="search" id="woocommerce-product-search-field-0" class="search-field" value="<?php echo Request_RequestParams::getParamStr('name_lexicon'); ?>" name="name_lexicon" placeholder="Название товара" />
                                    <input type="submit" value="Поиск" />
                                    <input type="hidden" name="post_type" value="product" />
                                </form>
                            </div>
                        </div>
                        <a class="handheld-header-cart-link has-icon" href="<?php echo $siteData->urlBasic;?>/cart" title="View your shopping cart">
                            <i class="tm tm-shopping-bag"></i>
                            <span class="count"><?php echo trim($siteData->globalDatas['view::shopcart_count']); ?></span>
                        </a>
                    </div>                    
                </div>
            </div>
        </div>
    </header>
	<div id="content" class="site-content" tabindex="-1">
        <div class="col-full">
            <div class="row">
                <?php echo trim($data['view::body']);?>
            </div>
        </div>
    </div>
    <div class="col-full">
        <section class="brands-carousel">
            <h2 class="sr-only">Популярные бренды</h2>
            <div class="col-full" data-ride="tm-slick-carousel" data-wrap=".brands" data-slick="{&quot;slidesToShow&quot;:6,&quot;slidesToScroll&quot;:1,&quot;dots&quot;:false,&quot;arrows&quot;:true,&quot;responsive&quot;:[{&quot;breakpoint&quot;:400,&quot;settings&quot;:{&quot;slidesToShow&quot;:1,&quot;slidesToScroll&quot;:1}},{&quot;breakpoint&quot;:800,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesToScroll&quot;:3}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesToScroll&quot;:3}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:4,&quot;slidesToScroll&quot;:4}},{&quot;breakpoint&quot;:1400,&quot;settings&quot;:{&quot;slidesToShow&quot;:5,&quot;slidesToScroll&quot;:5}}]}">
                <div class="brands">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\basic\brendy']); ?>
                </div>
            </div>
        </section>
    </div>
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
                                        <span class="footer-payment-info-title">Написать</span>
                                        <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\e-mail-snizu']); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer-widgets">
                        <div class="columns">
                            <aside class="widget clearfix">
                                <div class="body">
                                    <h4 class="widget-title">Категории</h4>
                                    <div class="menu-footer-menu-1-container">
                                        <ul id="menu-footer-menu-1" class="menu">
                                            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\basic\rubrikatciya-snizu']); ?>
                                        </ul>
                                    </div>
                                </div>
                            </aside>
                        </div>
                        <div class="columns">
                            <aside class="widget clearfix">
                                <div class="body">
                                    <h4 class="widget-title">&nbsp;</h4>
                                    <div class="menu-footer-menu-2-container">
                                        <ul id="menu-footer-menu-2" class="menu">
                                            <li class="menu-item">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </aside>
                        </div>
                        <div class="columns">
                            <aside class="widget clearfix">
                                <div class="body">
                                    <h4 class="widget-title">Информация</h4>
                                    <div class="menu-footer-menu-3-container">
                                        <ul id="menu-footer-menu-3" class="menu">
                                            <li class="menu-item">
                                                <a title="Доставка" href="<?php echo $siteData->urlBasic;?>/delivery">Доставка</a>
                                            </li>
                                            <li class="menu-item">
                                                <a title="Гарантия качества продукции" href="<?php echo $siteData->urlBasic;?>/guarantee">Гарантия качества</a>
                                            </li>
                                            <li class="menu-item">
                                                <a title="Контакты" href="<?php echo $siteData->urlBasic;?>/contacts">Контакты</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
            <div class="site-info">
                <div class="col-full">
                    <div class="copyright">Copyright &copy; <?php echo date('Y');?> <a href="home-v1.html">iCartridge</a> Все права защищены.</div>
                </div>
            </div>
        </div>
    </footer>
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
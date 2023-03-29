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

    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/favicon-16x16.png">
	
	<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/style.min.css">
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;1,400&family=Podkova:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>

</head>
<body itemscope="itemscope" itemtype="http://schema.org/WebPage"><!-- !@@&body&@@! --><svg style="display: none;">
    <symbol id="like" viewBox="0 0 23.031 20">
        <g>
            <path d="M178.047,35a6.027,6.027,0,0,0-4.3,1.8,6.173,6.173,0,0,0,0,8.668l9.172,9.293a0.783,0.783,0,0,0,1.111,0l0,0q4.593-4.64,9.188-9.276a6.18,6.18,0,0,0,0-8.676,6.044,6.044,0,0,0-8.6,0L183.5,37.963,182.35,36.8a6.043,6.043,0,0,0-4.3-1.8h0Zm0,1.563a4.485,4.485,0,0,1,3.191,1.349l1.7,1.719a0.783,0.783,0,0,0,1.111,0l0,0,1.686-1.71a4.447,4.447,0,0,1,6.374,0,4.567,4.567,0,0,1,0,6.447q-4.315,4.359-8.632,8.726l-8.616-8.734a4.568,4.568,0,0,1,0-6.447,4.465,4.465,0,0,1,3.183-1.349h0Z" transform="translate(-171.969 -35)"/>
        </g>
    </symbol>
    <symbol id="basket" viewBox="0 0 27 20">
        <g>
            <path d="M260.166,41.527h-2.827l-5.1-6.213a0.867,0.867,0,0,0-1.185-.134,0.79,0.79,0,0,0-.139,1.139h0l4.271,5.208H240.153l4.26-5.208a0.79,0.79,0,0,0-.139-1.139,0.866,0.866,0,0,0-1.184.134h0l-5.1,6.213h-3.149a0.811,0.811,0,1,0,0,1.621H236.1l1.57,9.15a3.337,3.337,0,0,0,3.319,2.7H254.02a3.337,3.337,0,0,0,3.319-2.7l1.562-9.136h1.256a0.811,0.811,0,1,0,0-1.621Zm-4.482,10.5a1.669,1.669,0,0,1-1.664,1.351H240.988a1.67,1.67,0,0,1-1.664-1.351l-1.517-8.874H257.2Z" transform="translate(-234 -35)"/>
        </g>
    </symbol>
    <symbol id="search" viewBox="0 0 20.01 20.02">
        <g>
            <path d="M8.17.28a7.9,7.9,0,1,0,5.2,13.83l5.48,5.49a.51.51,0,0,0,.74,0h0a.53.53,0,0,0,0-.75l-5.48-5.48A7.89,7.89,0,0,0,8.17.28Z"/><path d="M8.17,1.33A6.84,6.84,0,1,1,1.32,8.17,6.84,6.84,0,0,1,8.17,1.33Z"/><path d="M19.22,20a.83.83,0,0,1-.56-.23l-5.31-5.32a8.17,8.17,0,1,1,1.11-1.11l5.32,5.31a.78.78,0,0,1,0,1.11A.8.8,0,0,1,19.22,20Z"/><path d="M8.17,15.28a7.1,7.1,0,1,1,7.1-7.1,7.12,7.12,0,0,1-7.1,7.1Z"/><path class="icon-color" d="M8.17,1.6a6.58,6.58,0,1,0,6.58,6.57A6.57,6.57,0,0,0,8.17,1.6Z"/>
        </g>
    </symbol>
    <symbol id="contacts" viewBox="0 0 427.69 427.69">
        <g>
            <path d="M407.65,304.54l-76.37-50.91a45.12,45.12,0,0,0-56.78,5.63l-20.1,20.09c-11.79-1.71-39.82-8.73-68.58-37.48s-35.77-56.79-37.48-68.59l20.09-20.09a45.11,45.11,0,0,0,5.62-56.78L123.14,20a45,45,0,0,0-69.26-6.86L22.05,45A74.42,74.42,0,0,0,.12,101.84c2.4,40.8,20.08,122.89,111.46,214.27S285.05,425.16,325.85,427.56a74.41,74.41,0,0,0,56.83-21.93l31.82-31.82a45,45,0,0,0-6.85-69.27Zm-14.36,48-31.83,31.83a44.39,44.39,0,0,1-33.85,13.19c-36.55-2.15-110.46-18.35-194.82-102.71S32.22,136.63,30.07,100.08A44.43,44.43,0,0,1,43.26,66.22L75.09,34.4a15,15,0,0,1,23.09,2.28l50.91,76.37A15,15,0,0,1,147.22,132l-25,25a15,15,0,0,0-4.39,10.61c0,2,.53,49.17,46.82,95.46s93.47,46.82,95.46,46.82a15,15,0,0,0,10.6-4.4l25-25a15,15,0,0,1,18.93-1.88L391,329.5a15,15,0,0,1,2.29,23.09Z"/>
        </g>
    </symbol>
    <symbol id="more" viewBox="0 0 44 44">
        <g>
            <path d="M25.612,43.756 C25.238,43.820 24.871,43.918 24.499,44.000 C22.820,44.000 21.140,44.000 19.460,44.000 C18.933,43.882 18.409,43.747 17.878,43.648 C8.730,41.931 1.611,34.555 0.237,25.362 C-1.567,13.308 6.603,2.167 18.634,0.274 C30.505,-1.594 41.833,6.618 43.718,18.457 C45.639,30.523 37.663,41.666 25.612,43.756 ZM21.956,2.772 C11.323,2.784 2.711,11.446 2.743,22.099 C2.775,32.718 11.369,41.287 21.988,41.287 C32.646,41.286 41.278,32.658 41.263,22.019 C41.248,11.372 32.610,2.760 21.956,2.772 ZM33.380,19.851 C30.117,23.115 26.818,26.345 23.607,29.661 C22.738,30.558 21.288,30.590 20.387,29.660 C17.176,26.345 13.877,23.114 10.614,19.849 C10.432,19.668 10.239,19.487 10.096,19.276 C9.730,18.734 9.792,18.043 10.223,17.583 C10.685,17.090 11.407,16.997 11.984,17.395 C12.247,17.576 12.469,17.819 12.697,18.047 C15.531,20.874 18.361,23.704 21.194,26.532 C21.439,26.777 21.700,27.008 22.000,27.291 C22.298,27.009 22.556,26.775 22.802,26.531 C25.635,23.703 28.466,20.872 31.299,18.044 C31.527,17.817 31.749,17.575 32.012,17.393 C32.562,17.012 33.227,17.078 33.702,17.519 C34.202,17.984 34.291,18.688 33.897,19.277 C33.755,19.489 33.563,19.669 33.380,19.851 Z"/>
        </g>
    </symbol>
    <symbol id="insta" viewBox="0 0 26 26">
        <g>
            <path d="M20.315,25.828 L5.681,25.828 C2.544,25.828 -0.008,23.294 -0.008,20.178 L-0.008,5.646 C-0.008,2.531 2.544,-0.003 5.681,-0.003 L20.315,-0.003 C23.452,-0.003 26.004,2.531 26.004,5.646 L26.004,20.178 C26.004,23.294 23.452,25.828 20.315,25.828 ZM24.318,5.646 C24.318,3.454 22.522,1.671 20.315,1.671 L5.681,1.671 C3.474,1.671 1.678,3.454 1.678,5.646 L1.678,20.178 C1.678,22.370 3.474,24.153 5.681,24.153 L20.315,24.153 C22.522,24.153 24.318,22.370 24.318,20.178 L24.318,5.646 ZM20.249,6.344 C19.438,6.344 18.778,5.689 18.778,4.884 C18.778,4.079 19.438,3.424 20.249,3.424 C21.060,3.424 21.719,4.079 21.719,4.884 C21.719,5.689 21.060,6.344 20.249,6.344 ZM19.029,14.261 C18.668,15.860 17.700,17.224 16.304,18.100 C15.311,18.724 14.172,19.053 13.010,19.053 C12.552,19.053 12.092,19.002 11.641,18.902 C8.317,18.158 6.219,14.867 6.967,11.566 C7.330,9.966 8.299,8.602 9.694,7.725 C11.092,6.846 12.750,6.562 14.356,6.924 C17.680,7.668 19.776,10.959 19.029,14.261 ZM14.008,8.463 C13.674,8.387 13.332,8.349 12.990,8.349 C12.126,8.349 11.280,8.594 10.543,9.057 C9.504,9.710 8.784,10.723 8.517,11.911 C7.961,14.366 9.519,16.811 11.989,17.363 C13.187,17.632 14.417,17.420 15.455,16.769 C16.492,16.117 17.211,15.104 17.479,13.915 C18.036,11.461 16.478,9.015 14.008,8.463 Z"/>
        </g>
    </symbol>
    <symbol id="close-big" viewBox="0 0 27 27">
        <g>
            <path d="M1197.6,208.508l10.97-10.97a1.5,1.5,0,0,0,0-2.1,1.476,1.476,0,0,0-2.1,0l-10.96,10.97-10.97-10.97a1.5,1.5,0,0,0-2.1,0,1.473,1.473,0,0,0,0,2.1l10.97,10.97-10.97,10.971a1.5,1.5,0,0,0,0,2.1,1.427,1.427,0,0,0,1.05.419,1.557,1.557,0,0,0,1.05-.419l10.97-10.971,10.96,10.971a1.427,1.427,0,0,0,1.05.419,1.557,1.557,0,0,0,1.05-.419,1.5,1.5,0,0,0,0-2.1Z" transform="translate(-1182.03 -195.031)"/>
        </g>
    </symbol>
    <symbol id="plant-size" viewBox="0 0 16 16">
        <g>
            <path d="M15.42,16V14.32H10.09V11.85a7.46,7.46,0,0,0,4.17-1.67A7.8,7.8,0,0,0,16,5a.81.81,0,0,0-.81-.84H15A6.88,6.88,0,0,0,10.2,6a7.1,7.1,0,0,0-.69,1c-.35-.83-.81-2.75-1.39-3.35A14.34,14.34,0,0,0,1,0H.81A1,1,0,0,0,0,.84C0,1.2-.11,7.3,2.09,9.58c1.5,1.56,5,2,6.26,2.15V14.2H2.67V16ZM11.48,7.06a4.77,4.77,0,0,1,2.78-1.19A5.09,5.09,0,0,1,13.1,8.74a4.73,4.73,0,0,1-2.78,1.2A4.64,4.64,0,0,1,11.48,7.06ZM3.36,8.38C2.2,7.18,1.86,3,1.74,1.8A13.4,13.4,0,0,1,7,4.67c1.16,1.2,1.5,4.19,1.62,5.39C7.42,9.94,4.52,9.58,3.36,8.38Z"/>
        </g>
    </symbol>
</svg>
<header class="header mainContainer">
    <nav class="nav">
        <div class="nav__functions col">
            <button class="burger" type="menu" id="navToggle">
                <span class="burger__item">Menu</span>
            </button>
            <div class="funcIcons">
                <a class="funcIcons__item" href="<?php echo $siteData->urlBasic;?>/favorite">
                    <div class="status__like" data-id="favorite-count" id="favorite-count"><?php echo trim($siteData->globalDatas['view::DB_Shop_Good\basic\kolichestvo-tovarov-v-igbrannom']); ?></div>
                    <svg class="funcIcons__icon">
                        <use xlink:href="#like"></use>
                    </svg>
                </a>
                <a class="funcIcons__item" href="<?php echo $siteData->urlBasic;?>/cart">
                    <div class="status__basket" data-id="basket-count" id="basket-count"><?php echo trim($siteData->globalDatas['view::View_Shop_Carts\basic\kolichestvo-tovarov-v-korzine']); ?></div>
                    <svg class="funcIcons__icon">
                        <use xlink:href="#basket"></use>
                    </svg>
                </a>
                <a class="funcIcons__item" href="#" id="search__btn">
                    <svg class="funcIcons__icon">
                        <use xlink:href="#search"></use>
                    </svg>
                </a>
            </div>
        </div>
        <div class="logoCont"><a href="<?php echo $siteData->urlBasic;?>/"><img class="logo" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/images/logo.svg" alt=""></a></div>
        <div class="phoneNumber col"><?php echo trim($siteData->globalDatas['view::DB_Shop_AddressContacts\basic\telefon-sverkhu']); ?></div>
        <div class="searchField col">
            <a class="funcIcons__item" href="#" id="search__sm__btn">
                <svg class="funcIcons__icon">
                    <use xlink:href="#search"></use>
                </svg>
            </a>
        </div>
        <div class="searchBlock" id="searchPlace">
            <form action="<?php echo $siteData->urlBasic;?>/catalogs" class="searchForm">
                <input class="searchInput" type="search" name="name_lexicon" placeholder="поиск по сайту">
                <button class="submit" type="submit"></button>
            </form>
        </div>
    </nav>
    <div class="listMenu" id="listMenu">
        <nav class="listMenu__main col-md-4 col-12">
            <ul class="listMenu__list">
                <?php echo trim($siteData->globalDatas['view::DB_Shop_Goods\basic\derevo-rubrik']); ?>
				<?php echo trim($siteData->globalDatas['view::DB_Shop_News\basic\uslugi-menyu']); ?>
				<?php echo trim($siteData->globalDatas['view::DB_Shop_News\basic\sistemnye-stranitcy']); ?>
                <li>
                    <a class="list__icons" href="<?php echo $siteData->urlBasic;?>/favorite">
                        <div class="status__like" data-id="favorite-count"><?php echo trim($siteData->globalDatas['view::DB_Shop_Good\basic\kolichestvo-tovarov-v-igbrannom']); ?></div>
                        <svg class="funcIcons__icon">
                            <use xlink:href="#like"></use>
                        </svg>
                        Избранное
                    </a>
                </li>
                <li>
                    <a class="list__icons" href="<?php echo $siteData->urlBasic;?>/cart">
                        <div class="status__basket" data-id="basket-count"><?php echo trim($siteData->globalDatas['view::View_Shop_Carts\basic\kolichestvo-tovarov-v-korzine']); ?></div>
                        <svg class="funcIcons__icon">
                            <use xlink:href="#basket"></use>
                        </svg>
                        Корзина
                    </a>
                </li>
                <li>
                    <a href="<?php echo $siteData->urlBasic;?>/contacts">
                        <svg class="funcIcons__icon">
                            <use xlink:href="#contacts"></use>
                        </svg>
                        Контакты
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
<div class="social">
    <div class="social__text">следите за нами</div>
    <div class="social__line"></div>
    <div class="social__items">
        <a target="_blank" href="https://www.instagram.com/dzungla.kz/">
            <svg class="social__icon">
                <use xlink:href="#insta"></use>
            </svg>
        </a>
    </div>
</div>
<div class="mainContainer">
    <div class="content">
        <?php echo trim($data['view::body']);?>
    </div>
</div>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/app.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/main.js"></script>

<style>
    .product-name {
        margin-bottom: 10px;
        min-height: 40.2px;
        max-height: 40.2px;
        text-overflow: clip;
        overflow: hidden;
        display: block;
    }
</style>
</body>
</html>
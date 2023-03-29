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

    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

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

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/bootstrap-slider.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/normalize.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/icomoon.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/chosen.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/prettyPhoto.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/scrollbar.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/morris.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/YouTubePopUp.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/auto-complete.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/jquery.navhideshow.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/transitions.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/style.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/colorv4.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/color.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/responsive.css">
    <script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>

    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
</head>

<?php if(FALSE && (($siteData->url == '') || ($siteData->url == '/')) && (!Request_RequestParams::getParamBoolean('is_load'))){ ?>
<body itemscope="itemscope" itemtype="http://schema.org/WebPage" style="text-align: center;">
<img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/start.jpg" style="max-width: 100%">
<?php }else{ ?>
<body class="listar-home listar-hometwo" itemscope="itemscope" itemtype="http://schema.org/WebPage">
<!-- !@@&body&@@! -->

<div id="listar-wrapper" class="listar-wrapper listar-haslayout">
    <header id="listar-header" class="listar-header cd-auto-hide-header listar-headervfour listar-haslayout">
        <div class="container<?php if(($siteData->url != '/') && ($siteData->url != '')){echo '-fluid';} ?>">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <strong class="listar-logo"><a href="<?php echo $siteData->urlBasic;?>"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo-header-alt.png" alt="Бухгалтерия нового поколения"></a></strong>
                    <nav class="listar-addnav">
                        <ul>
                            <li>
                                <a id="listar-btnsignin" class="listar-btn listar-btngreen" href="#listar-loginsingup">
                                    <i class="icon-smiling-face"></i>
                                    <span>Войти / Зарегистрироваться</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <nav id="listar-nav" class="listar-nav">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#listar-navigation" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div id="listar-navigation" class="collapse navbar-collapse listar-navigation">
                            <ul>
                                <li><a href="<?php echo $siteData->urlBasic;?>/about">О нас</a></li>
                                <li><a href="<?php echo $siteData->urlBasic;?>/what-offer">Что мы предлагаем</a></li>
                                <li><a href="<?php echo $siteData->urlBasic;?>/comments">Отзывы</a></li>
                                <li><a href="<?php echo $siteData->urlBasic;?>/articles">Статьи</a></li>
                                <li><a href="<?php echo $siteData->urlBasic;?>/packages">Цены</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <?php echo trim($data['view::body']);?>
    <footer id="listar-footer" class="listar-footer listar-haslayout">
        <div class="listar-footeraboutarea">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="listar-upperbox">
                            <strong class="listar-logo"><a href="<?php echo $siteData->urlBasic;?>"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo-header-alt.png" alt="Бухгалтерия нового поколения"></a></strong>
                            <ul class="listar-socialicons">
                                <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sotcialnye-seti']); ?>
                            </ul>
                            <nav class="listar-navfooter">
                                <ul>
                                    <li><a href="<?php echo $siteData->urlBasic;?>">Главная</a></li>
                                    <li><a href="<?php echo $siteData->urlBasic;?>/about">О нас</a></li>
                                    <li><a href="<?php echo $siteData->urlBasic;?>/what-offer">Что мы предлагаем</a></li>
                                    <li><a href="<?php echo $siteData->urlBasic;?>/comments">Отзывы</a></li>
                                    <li><a href="<?php echo $siteData->urlBasic;?>/articles">Статьи</a></li>
                                    <li><a href="<?php echo $siteData->urlBasic;?>/partners">Партнерам</a></li>
                                    <li><a href="<?php echo $siteData->urlBasic;?>/packages">Цены</a></li>
                                </ul>
                            </nav>
                        </div>
                        <div class="listar-lowerbox">
                            <div class="listar-description">
                                <p>Онлайн сервис по ведению бухгалтерского учета для всех видов предпринимателей на территории Казахстана. </p>
                            </div>
                            <address><strong>Телефон:</strong> <a href="tel::+7 708 104 11 12">+7 708 104 11 12</a></span>
                                <br><strong>E-mail:</strong> <a href="mailto::info@bigbuh.kz">info@bigbuh.kz</a></span>
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="listar-footerbar">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <span class="listar-copyright"><?php echo date('Y'); ?> © Bigbuh. Все права защищены.</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<div id="listar-loginsingup" class="listar-loginsingup">
    <button type="button" class="listar-btnclose">x</button>
    <figure class="listar-loginsingupimg" data-vide-bg="poster: <?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/images/bgjoin.jpg" data-vide-options="position: 50% 50%"></figure>
    <div class="listar-contentarea">
        <div class="listar-themescrollbar">
            <div class="listar-logincontent">
                <div class="listar-themetabs">
                    <ul class="listar-tabnavloginregistered" role="tablist">
                        <li role="presentation" class="active"><a href="#listar-loging" data-toggle="tab">Авторизация</a></li>
                        <li role="presentation"><a href="#listar-register" data-toggle="tab">Регистрация</a></li>
                        <li role="presentation"><a href="#listar-reset" data-toggle="tab">Забыли пароль?</a></li>
                    </ul>
                    <div class="tab-content listar-tabcontentloginregistered">
                        <div role="tabpanel" class="tab-pane active fade in" id="listar-loging">
                            <form class="listar-formtheme listar-formlogin" action="<?php echo $siteData->urlBasic;?>/tax/shopuser/login" method="post">
                                <fieldset>
                                    <div class="form-group listar-inputwithicon">
                                        <i class="icon-profile-male"></i>
                                        <input name="email" class="form-control" placeholder="E-mail" type="text">
                                    </div>
                                    <div class="form-group listar-inputwithicon">
                                        <i class="icon-icons208"></i>
                                        <input name="password" class="form-control" placeholder="Пароль" type="password">
                                    </div>
                                    <div class="form-group">
                                        <div class="listar-checkbox">
                                            <input type="checkbox" name="remember" id="rememberpass2">
                                            <label for="rememberpass2">Запомнить меня</label>
                                        </div>
                                        <span style="display: none"><a href="#">Восстановить пароль</a></span>
                                    </div>
                                    <button class="listar-btn listar-btngreen" type="submit">Войти</button>
                                </fieldset>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="listar-register">
                            <form class="listar-formtheme listar-formlogin" action="<?php echo $siteData->urlBasic;?>/command/shopcreate" method="post">
                                <fieldset>
                                    <div class="form-group listar-inputwithicon">
                                        <i class="icon-profile-male"></i>
                                        <input class="form-control" name="shop[name]" placeholder="Юридическое название компании" type="text" required>
                                    </div>
                                    <div class="form-group listar-inputwithicon">
                                        <i class="icon-icons208"></i>
                                        <input class="form-control" name="user[email]" placeholder="E-mail" type="email" required>
                                    </div>
                                    <div class="form-group listar-inputwithicon">
                                        <i class="icon-phone"></i>
                                        <input class="form-control" name="shop[options][phone]" placeholder="Телефон" type="phone" required>
                                    </div>
                                    <div class="form-group listar-inputwithicon">
                                        <i class="icon-lock-stripes"></i>
                                        <input class="form-control" name="user[password]" placeholder="Пароль" type="password" required>
                                    </div>
                                    <div class="form-group">
                                        <div class="listar-checkbox">
                                            <input class="form-control offers" checked name="is_agreement" type="checkbox" value="1">
                                            <label for="rememberpass">Принимаю <a target="_blank" href="<?php echo $siteData->urlBasic;?>/offers">договор оферты</a></label>

                                            <script>
                                                $('[name="is_agreement"]').change(function () {
                                                    if($(this).prop('checked')){
                                                        $('#button-registration').removeAttr('disabled');
                                                    }else{
                                                        $('#button-registration').attr('disabled', '');
                                                    }
                                                });
                                            </script>
                                        </div>
                                    </div>
                                    <input name="shop[shop_branch_type_id]" value="3827" hidden="">
                                    <input name="url" value="<?php echo $siteData->urlBasic;?>/client/register" hidden="">
                                    <input name="redirect_url" value="<?php echo $siteData->urlBasic;?>/tax" hidden="">
                                    <button id="button-registration" class="listar-btn listar-btngreen" type="submit">Зарегистрироваться</button>
                                </fieldset>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in" id="listar-reset">
                            <form class="listar-formtheme listar-formlogin" action="<?php echo $siteData->urlBasic;?>/client-tax/forgot" method="post">
                                <fieldset>
                                    <div class="form-group listar-inputwithicon">
                                        <i class="icon-profile-male"></i>
                                        <input name="email" class="form-control" placeholder="E-mail" type="text">
                                    </div>
                                    <input name="error_url" value="<?php echo $siteData->urlBasic;?>/client/reset" style="display: none">
                                    <input name="url" value="<?php echo $siteData->urlBasic;?>/client/reset/finish" style="display: none">
                                    <button class="listar-btn listar-btngreen" type="submit">Сброс пароля</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/vendor/jquery-library.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/mapclustering/data.json"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/tinymce/tinymce.min4bb5.js?apiKey=4cuu2crphif3fuls3yb1pe4qrun9pkq99vltezv2lv6sogci"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/mapclustering/markerclusterer.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/mapclustering/infobox.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/mapclustering/map.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/ResizeSensor.js.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/jquery.sticky-sidebar.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/YouTubePopUp.jquery.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/jquery.navhideshow.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/backgroundstretch.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/jquery.sticky-kit.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/bootstrap-slider.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/owl.carousel.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/jquery.vide.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/auto-complete.html"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/chosen.jquery.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/scrollbar.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/isotope.pkgd.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/jquery.steps.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/prettyPhoto.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/raphael-min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/parallax.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/sortable.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/countTo.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/appear.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/gmap3.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/dev_themefunction.js"></script>
<?php } ?>

<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter50174806 = new Ya.Metrika2({ id:50174806, clickmap:true, trackLinks:true, accurateTrackBounce:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/tag.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks2"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/50174806" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-125016655-1"></script>

<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
<script>
    $(document).ready(function() {
        $('input[type="phone"]').inputmask({
            mask: "+7 (999) 999 99 99"
        });
    });

    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-125016655-1');
</script>

</body>
</html>
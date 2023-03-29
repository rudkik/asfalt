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
    <link href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/favicon.png" rel="shortcut icon" />
	
    <link rel="canonical" href="<?php echo trim($siteData->urlCanonical); ?>" />
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">
    <link href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="<?php echo $siteData->urlBasic;?>/css/_component/fonts/font-awesome/v4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/style.css?cache=2">

</head>
<body itemscope="itemscope" itemtype="http://schema.org/WebPage"><!-- !@@&body&@@! --><header class="header-top">
    <div class="container">
        <div class="contacts">
            <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefon-sverkhu']); ?>
            <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\e-mail-sverkhu']); ?>
        </div>
        <div class="box-social">
            <span class="title">Мы в соцсетях</span>
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sotcialnye-seti']); ?>
        </div>
    </div>
</header>
<header class="header-menu">
    <div class="container">
        <div class="logo-mini">
            <a href="<?php echo $siteData->urlBasic;?>/"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png"></a>
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
                <div class="logo">
                    <a href="<?php echo $siteData->urlBasic;?>/"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png"></a>
                </div>
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a class="nav-link" href="<?php echo $siteData->urlBasic;?>/about">Компания</a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?php echo $siteData->urlBasic;?>/catalogs">Продукты</a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?php echo $siteData->urlBasic;?>/applying">Применение</a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?php echo $siteData->urlBasic;?>/careers">Карьера</a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?php echo $siteData->urlBasic;?>/contacts">Контакты</a>
                    </li>
                </ul>
                <div class="box-find navbar-right">
                    <form action="/catalogs" class="input-group">
                        <input type="text" class="form-control" name="name_lexicon" placeholder="Поиск">
                        <span class="input-group-btn">
                            <button class="btn btn-info btn-flat btn-find" type="submit"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/search-w.png"></button>
                        </span>
                    </form>
                </div>
            </div>
        </nav>
    </div>
</header><?php echo trim($data['view::body']);?><header class="header-message">
    <div class="container">
        <h1>Хотите связаться с нами?</h1>
        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line-slider.png">
        <p class="subtitle">Оставьте ваши данные</p>
        <p class="subtitle2">Мы позвоним и проконсультируем вас</p>
        <form class="row" id="form-send" method="post" action="/command/message_add" enctype="multipart/form-data">
            <div class="col-xs-4 box-col-message">
                <div class="form-group">
                    <div class="input-group med-input">
                        <div class="input-group-addon"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/user-g.png"></div>
                        <input id="name" name="name" type="text" class="form-control user-success" placeholder="Имя" required="">
                    </div>
                </div>
            </div>
            <div class="col-xs-4 box-col-message">
                <div class="form-group">
                    <div class="input-group med-input">
                        <div class="input-group-addon"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone-g.png"></div>
                        <input id="phone" type="phone" name="options[phone]" class="form-control user-success" placeholder="Телефон" required="">
                    </div>
                </div>
            </div>
            <div class="col-xs-4 box-col-message">
                <input name="type" value="4115" hidden="">
                <input name="captcha_hash" value="<?php echo Helpers_Captcha::getCaptchaMathematical(); ?>" hidden>
                <button id="button-send" type="submit" class="btn btn-flat btn-red width-100">Отправить</button>
            </div>
        </form>
    </div>
</header>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-xs-4 box-col-footer">
                <div class="logo">
                    <a href="<?php echo $siteData->urlBasic;?>/"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo-w.png"></a>
                </div>
                <p class="logo-title">
                    Товарищество с ограниченной ответственностью «Медсервис Азия»
                </p>
                <?php echo trim($siteData->globalDatas['view::View_Shop_Address\basic\adres']); ?>
                <p class="copyright"><?php echo date('Y');?> © “Медсервис Азия”</p>
            </div>
            <div class="col-xs-8 box-col-footer">
                <div class="row">
                    <div class="col-xs-4 box-col-menu">
                        <h4>Навигатор</h4>
                        <ul class="box-menu">
                            <li><a href="<?php echo $siteData->urlBasic;?>/about">Компания</a></li>
                            <li><a href="<?php echo $siteData->urlBasic;?>/catalogs">Продукты</a></li>
                            <li><a href="<?php echo $siteData->urlBasic;?>/applying">Применение</a></li>
                            <li><a href="<?php echo $siteData->urlBasic;?>/careers">Карьера</a></li>
                            <li><a href="<?php echo $siteData->urlBasic;?>/contacts">Контакты</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-4 box-col-menu">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefony-snizu']); ?>
                        <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\faks-snizu']); ?>
                    </div>
                    <div class="col-xs-4 box-col-menu">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\e-mail-snizu']); ?>
                        <p class="address-title margin-b-20">
                            Мы в соцсетях
                        </p>
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sotcialnye-seti']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div id="show-send" class="dialog-youtube modal fade">
    <div class="modal-dialog" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h3 class="modal-title">Оставить заявку</h3>
            </div>
            <div class="modal-body">
                <div style="display: inline-block; width: 100%;">
                    <form id="form-send" method="post" action="/command/message_add" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Имя</label>
                            <input type="text" name="name" class="form-control" placeholder="Имя">
                        </div>
                        <div class="form-group">
                            <label>Телефон</label>
                            <input type="phone" name="options[phone]"  class="form-control" placeholder="Телефон">
                        </div>
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="email" name="options[email]" class="form-control" placeholder="E-mail">
                        </div>
                        <div class="form-group">
                            <label>Примечание</label>
                            <textarea class="form-control" name="text" rows="3" placeholder="Примечание" style="max-width: 100%;"></textarea>
                        </div>
                        <div class="form-group">
                            <input id="url" name="options[url]" hidden value="<?php echo  ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>">
                            <input name="type" value="4115" hidden>
                            <input name="captcha_hash" value="<?php echo Helpers_Captcha::getCaptchaMathematical(); ?>" hidden>
                            <button id="button-send" class="btn btn-block btn-lg btn-red" type="submit">Отправить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>

<script>
    $('[data-target="#show-send"]').click(function () {
        $('#url').val($(this).data('href')).attr('value', $(this).data('href'));
    });
</script>
</body>
</html>
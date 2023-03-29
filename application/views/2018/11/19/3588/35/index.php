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

        <?php if(!empty($siteData->siteImage)){ ?>
        <meta itemprop="image" content="<?php echo htmlspecialchars($siteData->siteImage, ENT_QUOTES); ?>" />
        <meta property="og:image" content="<?php echo htmlspecialchars($siteData->siteImage, ENT_QUOTES); ?>" />
        <meta name="twitter:image:src" content="<?php echo htmlspecialchars($siteData->siteImage, ENT_QUOTES); ?>" />
        <?php } ?>

        <?php if(!empty($siteData->favicon)){ ?>
            <?php if(is_array($siteData->favicon)){ ?>
                <?php foreach($siteData->favicon as $key => $value){ ?>
                    <link rel="apple-touch-icon-precomposed" sizes="<?php echo $key; ?>" href="<?php echo Func::addSiteNameInFilePath($value); ?>" />
                    <link rel="icon" type="image/png" href="<?php echo Func::addSiteNameInFilePath($value); ?>" sizes="<?php echo $key; ?>" />
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
			echo '<link href="'.trim($siteData->urlBasic).trim($siteData->favicon).'" rel="shortcut icon" />';
		}
		?>
		<link rel="canonical" href="<?php echo trim($siteData->urlBasic).trim($siteData->urlCanonical); ?>" />
		
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/css/skins/_all-skins.min.css">

    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/bootstrap/css/font-awesome.min.css">


    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/plugins/iCheck/all.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/css/AdminLTE.min.css">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,600i,700,700i" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/dist/style.css?cash=1">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
</head>
<body itemscope="itemscope" itemtype="http://schema.org/WebPage"><!-- !@@&body&@@! --><div class="header header-top">
    <div class="container">
        <form action="<?php echo $siteData->urlBasic;?>/catalogs" method="get" target="_top">
            <div class="box-top">
                <div class="box-logo">
                    <div class="logo-block">
                        <a href="<?php echo $siteData->urlBasic;?>/">
                            <img  class="logo img-responsive" alt="<?php echo $siteData->shop->getName();?>" src="<?php echo $siteData->shop->getImagePath();?>" width="233" height="54"/>
                        </a>
                    </div>
                </div>
                <div class="box-right">
                    <div class="my">
                        <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefon']); ?>
                    </div>
                </div>
                <div class="box-find">
                    <div class="find">
                        <div class="input-group">
                            <input class="form-control" type="text" name="name" placeholder="Мне нужно..." value="<?php echo Request_RequestParams::getParamStr('name'); ?>">
                            <span class="input-group-addon"><button type="submit" class="btn"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/find.png" class="img-responsive" alt=""></button></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="line"></div>
</div>
<div class="header header-shift"></div>
<div class="header header-menu">
    <div class="container">
        <nav class="navbar navbar-default navbar-static" role="navigation" id="menu-top">
            <div class="navbar-header">
                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#menu-top .bs-example-js-navbar-collapse">
                    <span class="sr-only">Переключить навигацию</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse bs-example-js-navbar-collapse collapse padding-0px" aria-expanded="false">
                <ul class="nav navbar-nav">
                    <?php echo trim($siteData->globalDatas['view::View_ShopGoodCatalogs\basic_rubriki']); ?>
                </ul>
            </div>
        </nav>
    </div>
</div><div class="main"><?php echo trim($data['view::body']);?></div><footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="menu">
                    <li>
                        <a href="<?php echo $siteData->urlBasic;?>/about" title="О нас">О нас</a>
                    </li>
                    <li class="message">
                        <a href="" data-toggle="modal" data-target="#send-message">
                            <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/send-message.png" class="img-responsive" alt="">
                            <span>Написать нам</span>
                        </a>
                    </li>
                </ul>
                <ul class="menu groups pull-right">
                    <?php echo trim($siteData->globalDatas['view::View_ShopNews\basic_sotcialnye-seti']); ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="copyright">© <?php echo date('Y'); ?> “Opto”.  Все права защищены.</p>
            </div>
        </div>
    </div>
</footer>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
            html: true,
        });
    });
</script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/main.js"></script>
<div id="send-message" class="modal fade">
    <div class="modal-dialog" style="max-width: 701px; margin-top: 60px;">
        <div class="modal-content">
            <div class="modal-body">
                <div class="pull-right">
                    <button class="close" type="button" data-dismiss="modal"><i class="fa fa-fw fa-close"></i></button>
                </div>
                <div class="modal-fields">
                    <h2>Написать нам</h2>
                    <form action="/command/message_add" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Ваше имя:</label>
                                    <input name="name" class="form-control" type="text" placeholder="Иван Федорович Крузенштерн" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Телефон:</label>
                                    <input name="phone" class="form-control" type="text" placeholder="+7 777 777 77 77" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>E-mail:</label>
                                    <input name="email" class="form-control" type="email" placeholder="E-mail" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Сообщение</label>
                                    <textarea name="text" id="text" cols="30" rows="6" class="form-control" placeholder="Сообщение"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <input name="type" value="32008" hidden>
                                <input name="url" value="/send-message" hidden>
                                <input name="is_not_captcha_hash" value="1" hidden>
                                <button type="submit" class="btn btn-primary pull-right">Отправить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(52722658, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/52722658" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-75908218-3"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-75908218-3');
</script>

</body>
</html>
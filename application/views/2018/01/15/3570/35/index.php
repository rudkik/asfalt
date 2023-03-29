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

    <link rel="icon" type="image/png" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/favicon.png" sizes="32x32" />

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
    <link rel="canonical" href="<?php echo Func::addSiteNameInFilePath($siteData->urlCanonical); ?>" />
	
	<link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/style.css">

    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>
</head>
<body class="<?php if(($siteData->url == '/catalogs') || ($siteData->url == '/spare-part')){echo 'catalog';}else{echo 'index';}?>" itemscope="itemscope" itemtype="http://schema.org/WebPage"><!-- !@@&body&@@! --><div class="container">
    <header class="header-left">        
        <a href="#" data-toggle="modal" data-target="#show-menu">
            <div class="box-top-modal">
                <div class="line1"></div>
                <div class="line2"></div>
            </div>
        </a>
		<?php if(($siteData->url == '') || ($siteData->url == '/')){?>
        <div class="ovals">
			<div class="oval active" data-id="1"></div>
			<div class="oval" data-id="2"></div>
			<div class="oval" data-id="3"></div>
			<div class="oval" data-id="4"></div>
			<div class="oval" data-id="5"></div>
        </div>
        <?php }elseif(($siteData->url == '/contacts')){?>
            <div class="ovals">
                <div class="oval active" data-id="1"></div>
                <div class="oval" data-id="5"></div>
            </div>
        <?php }elseif(($siteData->url == '/delivery')){?>
            <div class="ovals">
                <div class="oval active" data-id="1"></div>
                <div class="oval" data-id="4"></div>
                <div class="oval" data-id="5"></div>
            </div>
        <?php }?>
    </header>
    <div class="scroll">
		<?php if(($siteData->url != '/catalogs') && ($siteData->url != '/spare-part')){?>
		<div data-action="scroll-line" data-id="1"  class="background-1">			
		<?php }?>
            <div class="header-menu">
                <div class="media-body">
                    <div class="box-menu-center">
                        <div class="box-menu">
                            <div class="menu"><a href="<?php echo $siteData->urlBasic;?>/catalogs">КАТАЛОГ ЗАПЧАСТЕЙ</a></div>
                            <div class="menu"><a href="<?php echo $siteData->urlBasic;?>/delivery">УСЛОВИЯ ДОСТАВКИ</a></div>
                        </div>
                        <div class="box-phones">
                            <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefon-sverkhu']); ?>
                        </div>
                    </div>
                </div>
                <div class="media-right">
                    <a class="btn btn-flat" href="#" data-toggle="modal" data-target="#send-message">НАПИСАТЬ НАМ</a>
                </div>
            </div><?php echo trim($data['view::body']);?></div>
</div>
<div id="send-message" class="dialog-message modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="box-close">
                <button class="close" type="button" data-dismiss="modal"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/close.png" class="img-responsive"></button>
            </div>
            <div class="modal-body">
                <div class="modal-fields">
                    <div class="box-fields">
                        <h2>Написать нам <br>сообщение</h2>
                        <div class="line"></div>
                        <p class="info">В случае, если Вы не можете связаться с нами по телефону,
                            пожалуйста, напишите нам и мы ответим вам в ближайшее время.</p>

                        <form class="form-send-message">
                            <div class="input-group">
                                <input class="form-control" name="name" value="" placeholder="Ваше имя">
                            </div>
                            <div class="input-group">
                                <input class="form-control" name="name" value="" placeholder="Номер телефона">
                            </div>
                            <div class="input-group">
                                <textarea class="form-control" name="text" value="" placeholder="Сообщение"></textarea>
                            </div>
                            <button class="btn btn-flat btn-background">Отправить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="show-menu" class="dialog-menu modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="box-close">
                <button class="close" type="button" data-dismiss="modal"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/f-close.png" class="img-responsive"></button>
            </div>
            <div class="modal-body">
                <div class="modal-fields">
                    <div class="background-7">
                        <h2>Разборка автомобилей <br>в Москве</h2>
                    </div>
                    <div class="background-body">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="header-maps">
                                    <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefony-v-menyu']); ?>
                                    <div class="phone">
                                        <div class="media-left">
                                            <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/contact/w-point.png">
                                        </div>
                                        <div class="media-body">
                                            г. Москва, Егорьевский проезд, 22 Б
                                        </div>
                                    </div>
                                    <div class="phone">
                                        <div class="media-left">
                                            <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/contact/w-time.png">
                                        </div>
                                        <div class="media-body">
                                            Пн-Пт с 9:00 до 20:00, Сб-Вс с 10:00 до 18:00
                                        </div>
                                    </div>
                                    <div class="box-btn">
                                        <a href="<?php echo $siteData->urlBasic;?>/catalogs" class="btn btn-flat btn-background">ПОИСК ЗАПЧАСТЕЙ</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <ul class="my-menu">
                                    <li><a href="<?php echo $siteData->urlBasic;?>/">Главная</a></li>
                                    <li><a href="<?php echo $siteData->urlBasic;?>/catalogs">Каталог запчастей</a></li>
                                    <li><a href="<?php echo $siteData->urlBasic;?>/delivery">Условия доставки и оплата</a></li>
                                    <li><a href="<?php echo $siteData->urlBasic;?>/contacts">Контакты</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/main.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-116149166-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-116149166-1');
    </script>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript" >
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter48152630 = new Ya.Metrika({
                        id:48152630,
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
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/48152630" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</body>
</html>
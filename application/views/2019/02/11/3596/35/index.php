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
	
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">
    <link href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/iCheck/all.css">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/fonts/font-awesome/v4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/select2/select2.min.css">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/slick/slick.css" media="screen, projection">
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/slick/slick-theme.css" media="screen, projection">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/style.css?cache=2">

    <?php if(($siteData->url == '/truck')){ ?>
        <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/fancybox/dist/jquery.fancybox.css" type="text/css" media="screen" />
    <?php } ?>

    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="<?php echo $siteData->urlBasic; ?>/css/_component/bootstrap/v3.3/plugins/select2/select2.full.min.js"></script>
</head>
<body itemscope="itemscope" itemtype="http://schema.org/WebPage"><!-- !@@&body&@@! --><div class="body">
    <header class="header-menu">
        <div class="container">
            <div class="box-logo">
                <a href="<?php echo $siteData->urlBasicLanguage;?>"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png"></a>
            </div>
            <div class="box-rubrics">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-logo-min">
                                    <a href="<?php echo $siteData->urlBasicLanguage;?>"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png"></a>
                                </div>
                                <div class="box_count">
                                    <div class="media-left">
                                        <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/ds.png">
                                    </div>
                                    <div class="media-body">
                                        <?php echo trim($siteData->globalDatas['view::View_Shop_Cars\-kolichestvo-mashin']); ?>
                                    </div>
                                </div>
                                <div class="box-currencies">
                                    <?php echo trim($siteData->globalDatas['view::View_Currencys\basic\kursy-valyut']); ?>
                                </div>
                                <div class="box-phone">
                                    <i class="fa fa-fw fa-phone"></i>
                                    <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefony-v-samom-verkhu']); ?>
                                </div>
                                <div class="box-language">
                                    <div class="navbar-custom-menu pull-right">
                                        <ul class="nav">
                                            <li class="dropdown messages-menu">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    <img class="land" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/<?php echo strtolower($siteData->language->getCode()); ?>_f.png">
                                                    <span class="language-active"><?php echo Func::mb_ucfirst($siteData->language->getName()); ?></span><i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <?php echo trim($siteData->globalDatas['view::View_Languages\basic\yazyki']); ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="navbar-yellow">
                            <ul class="nav navbar-nav pull-left">
                                <li class="menu-root-about"><a href="<?php echo $siteData->urlBasicLanguage;?>/about">О нас</a></li>
                                <li class="menu-root-trucks"><a href="<?php echo $siteData->urlBasicLanguage;?>/trucks">Спецтехника</a></li>
                                <li class="menu-root-spares"><a href="<?php echo $siteData->urlBasicLanguage;?>/spares">Запчасти</a></li>
                                <li class="menu-root-articles"><a href="<?php echo $siteData->urlBasicLanguage;?>/articles">Статьи</a></li>
                                <li class="menu-root-all dropdown messages-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                        . . .
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="menu-child-about"><a href="<?php echo $siteData->urlBasicLanguage;?>/about">О нас</a></li>
                                        <li class="menu-child-trucks"><a href="<?php echo $siteData->urlBasicLanguage;?>/trucks">Спецтехника</a></li>
                                        <li class="menu-child-spares"><a href="<?php echo $siteData->urlBasicLanguage;?>/spares">Запчасти</a></li>
                                        <li class="menu-child-articles"><a href="<?php echo $siteData->urlBasicLanguage;?>/articles">Статьи</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="box-message">
                                <a href="<?php echo $siteData->urlBasicLanguage;?>/truck-add" class="btn btn-primary btn-grey">
                                    <span>Добавить объявление</span>
                                </a>
                            </div>
                        </div>
                        <div data-action="line" class="line-yellow"></div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <?php echo trim($data['view::body']);?>
    <header class="header-message <?php if(($siteData->url == '') || ($siteData->url == '/')){ echo 'main'; }?>">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <h2>Оставайся на связи</h2>
                    <p class="info">Подпишитесь на нашу рассылку, и мы вышлем вам информацию и списки, чтобы сделать ваш поиск еще проще.</p>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-6">
                    <form id="form-send-data" action="/command/add_contact_client" method="post" class="box-message">
                        <div class="corner-white"></div>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                            <input name="contact[name]" type="email" class="form-control" required>
                            <div style="display: none">
                                <input name="client[type]" value="4050">
                                <input name="contact[client_contact_type_id]" value="<?php echo Model_ClientContactType::CONTACT_TYPE_EMAIL; ?>">
                            </div>
                            <span class="input-group-btn">
                                <button id="button-send-data" class="btn btn-block btn-yellow btn-oblique" type="submit"><span>Подписаться</span></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>
</div>
<footer class="header-menu">
    <div class="container">
        <div class="box-logo">
            <a href="<?php echo $siteData->urlBasicLanguage;?>"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png"></a>
        </div>
        <div class="box-rubrics">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-logo-min">
                                <a href="<?php echo $siteData->urlBasicLanguage;?>"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png"></a>
                            </div>
                            <div class="box_count">
                                <div class="media-left">
                                    <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/ds.png">
                                </div>
                                <div class="media-body">
                                    <?php echo trim($siteData->globalDatas['view::View_Shop_Cars\-kolichestvo-mashin']); ?>
                                </div>
                            </div>
                            <div class="box-currencies">
                                <?php echo trim($siteData->globalDatas['view::View_Currencys\basic\kursy-valyut']); ?>
                            </div>
                            <div class="box-phone">
                                <i class="fa fa-fw fa-phone"></i>
                                <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\basic\telefony-v-samom-verkhu']); ?>
                            </div>
                            <div class="box-language">
                                <div class="navbar-custom-menu pull-right">
                                    <ul class="nav">
                                        <li class="dropdown messages-menu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                <img class="land" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/<?php echo strtolower($siteData->language->getCode()); ?>_f.png">
                                                <span class="language-active"><?php echo Func::mb_ucfirst($siteData->language->getName()); ?></span><i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <?php echo trim($siteData->globalDatas['view::View_Languages\basic\yazyki']); ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="navbar-yellow">
                        <ul class="nav navbar-nav pull-left">
                            <li class="menu-root-about"><a href="<?php echo $siteData->urlBasicLanguage;?>/about">О нас</a></li>
                            <li class="menu-root-trucks"><a href="<?php echo $siteData->urlBasicLanguage;?>/trucks">Спецтехника</a></li>
                            <li class="menu-root-spares"><a href="<?php echo $siteData->urlBasicLanguage;?>/spares">Запчасти</a></li>
                            <li class="menu-root-articles"><a href="<?php echo $siteData->urlBasicLanguage;?>/articles">Статьи</a></li>
                            <li class="menu-root-all dropdown messages-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    . . .
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="menu-child-about"><a href="<?php echo $siteData->urlBasicLanguage;?>/about">О нас</a></li>
                                    <li class="menu-child-trucks"><a href="<?php echo $siteData->urlBasicLanguage;?>/trucks">Спецтехника</a></li>
                                    <li class="menu-child-spares"><a href="<?php echo $siteData->urlBasicLanguage;?>/spares">Запчасти</a></li>
                                    <li class="menu-child-articles"><a href="<?php echo $siteData->urlBasicLanguage;?>/articles">Статьи</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="box-message">
                            <a href="<?php echo $siteData->urlBasicLanguage;?>/truck-add" class="btn btn-primary btn-grey">
                                <span>Добавить объявление</span>
                            </a>
                        </div>
                    </div>
                    <div data-action="line" class="line-yellow"></div>
                </div>
            </div>
        </div>
        <div class="box-social">
            <p class="copyrighted">© <?php echo date('Y');?> Central Asia Equipment</p>
            <ul class="social">
                <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sotcialnye-seti']); ?>
            </ul>
        </div>
    </div>
</footer>
<div id="modal-send-data-finish" class="modal my-modal">
    <div class="modal-dialog" style="max-width: 400px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Поздравляем</h4>
            </div>
            <div class="modal-body">
                <p class="text-body">Вы успешно подписались на рассылку</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-yellow" data-dismiss="modal">Закрыть</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/_component/slick/slick.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/iCheck/icheck.min.js"></script>

<?php if(($siteData->url == '/truck')){ ?>
    <script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/_component/fancybox/dist/jquery.fancybox.min.js"></script>
<?php } ?>
<script>
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });

    var size = ($(window).width() - 1300) / 2;
    if (size < 0){
        size = 0;
    }
    size = size + 15;
    $('[data-action="line"]').css('width', size);
    $(window).resize(function(){
        var size = ($(window).width() - 1300) / 2;
        if (size < 0){
            size = 0;
        }
        size = size + 15;
        $('[data-action="line"]').css('width', size);
    });

    $('#button-send-data').click(function (e) {
        e.preventDefault();

        var form = $('#form-send-data');

        var el = form.find('[type="email"]');
        var s = el.val();
        if ((s == '') || (!(/^[\.a-zA-Z0-9_-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,6}$/i.test(s)))){
            el.addClass('error');
            return false;
        }
        el.removeClass('error');

        var url = form.attr('action');

        var params = form.serializeArray();

        jQuery.ajax({
            url: url,
            data: params,
            type: "POST",
            success: function (data) {
                $('#modal-send-data-finish').modal('show');
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });
    });
</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(54407650, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/54407650" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-75908218-5"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-75908218-5');
</script>


</body>
</html>


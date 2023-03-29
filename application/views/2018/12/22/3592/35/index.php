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

    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/_component/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $siteData->urlBasic;?>/css/_component/slick/slick-theme.css"/>
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/style.css?cache=33">
    <script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
</head>
<?php $font = Request_RequestParams::getParamStr('font'); ?>
<body <?php if (!empty($font)){echo 'class="font-'.$font.' impaired"';} ?> itemscope="itemscope" itemtype="http://schema.org/WebPage"><!-- !@@&body&@@! --><div class="body">
    <header class="header-top">
        <div class="container box-main-top <?php if (!empty($font)){echo 'font';} ?>">
            <a href="<?php echo $siteData->urlBasicLanguage.$siteData->url.URL::query(array('font' => 'huge'));?>" class="vision"><span class="glyphicon glyphicon-eye-close"></span> Версия для слабовидящих</a>
            <a href="<?php $arr = $_GET; unset($arr['font']); echo $siteData->urlBasicLanguage.$siteData->url.URL::query($arr, FALSE);?>" class="not-vision"><span class="glyphicon glyphicon-eye-close"></span> Обычная версия сайта</a>
            <div class="box-font">
                размер шрифта:
                <a href="<?php echo $siteData->urlBasicLanguage.$siteData->url.URL::query(array('font' => 'norm'));?>" class="btn btn-default btn-sm <?php if ($font == 'norm'){echo 'active';} ?>">A</a>
                <a href="<?php echo $siteData->urlBasicLanguage.$siteData->url.URL::query(array('font' => 'big'));?>" class="btn btn-default btn-md <?php if ($font == 'big'){echo 'active';} ?>">A</a>
                <a href="<?php echo $siteData->urlBasicLanguage.$siteData->url.URL::query(array('font' => 'huge'));?>" class="btn btn-default btn-lg <?php if ($font == 'huge'){echo 'active';} ?>">A</a>
            </div>
            <div class="pull-right">
                <div class="box-socials">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_News/-sotcialnye-seti']); ?>
                </div>
                <a href="<?php echo $siteData->urlBasic.'/kk'. $siteData->url . $siteData->urlSEO . URL::query($arr, FALSE);?>" class="blog-main" style="font-weight: 700;">Қазақ</a>
                <a href="http://www.sadykhan.kz/" class="blog-main" style="margin-right: 20px; color: #b00e23; font-weight: 500">Интернет-аптека "Садыхан"</a>
                <a href="<?php echo $siteData->urlBasicLanguage;?>/blog-head-doctor" class="blog-main" style="margin-right: 20px;">Блог главного врача</a>
            </div>
        </div>
        <div class="container">
            <div class="box-logo">
                <a href="<?php echo $siteData->urlBasicLanguage;?>"><img itemprop="associatedMedia" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png"></a>
            </div>
            <div class="box-right">
                <div class="row" itemscope itemtype="http://schema.org/LocalBusiness">
                    <div class="col-sm-4 location">
                        <div class="media-left">
                            <img class="box-img" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/location.png">
                        </div>
                        <div class="media-body">
                            <div class="box-text" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                                <div class="title">Мы находимся</div>
                                <div class="text" itemprop="streetAddress"><?php echo trim($siteData->globalDatas['view::View_Shop_Address\-adres']); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 clock">
                        <div class="media-left">
                            <img class="box-img" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/clock.png">
                        </div>
                        <div class="media-body">
                            <div class="box-text">
                                <div class="title">Режим работы</div>
                                <div class="text">08:00 - 20:00</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 phone">
                        <div class="media-left">
                            <img class="box-img" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
                        </div>
                        <div class="media-body">
                            <div class="box-text">
                                <div class="title">Наш телефон</div>
                                <div class="text"><?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\-telefony-sverkhu']); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <header class="header-menu">
        <div class="container">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
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
                                    <li <?php if ($siteData->url == '/about'){echo 'class="active"';}?>>
                                        <a class="nav-link" href="<?php echo $siteData->urlBasicLanguage;?>/about">О центре</a>
                                    </li>
                                    <li <?php if (($siteData->url == '/departments') || ($siteData->url == '/department')){echo 'class="active"';}?>>
                                        <a class="nav-link" href="<?php echo $siteData->urlBasicLanguage;?>/departments">Отделения</a>
                                    </li>
                                    <li <?php if (($siteData->url == '/doctors') || ($siteData->url == '/doctor')){echo 'class="active"';}?>>
                                        <a class="nav-link" href="<?php echo $siteData->urlBasicLanguage;?>/doctors">Специалисты</a>
                                    </li>
                                    <li <?php if ($siteData->url == '/fo-patients'){echo 'class="active"';}?>>
                                        <a class="nav-link" href="<?php echo $siteData->urlBasicLanguage;?>/fo-patients">Пациентам</a>
                                    </li>
                                    <li <?php if ($siteData->url == '/documents'){echo 'class="active"';}?>>
                                        <a class="nav-link" href="<?php echo $siteData->urlBasicLanguage;?>/documents">Документы</a>
                                    </li>
                                    <li <?php if ($siteData->url == '/contacts'){echo 'class="active"';}?>>
                                        <a class="nav-link" href="<?php echo $siteData->urlBasicLanguage;?>/contacts">Контакты</a>
                                    </li>
                                </ul>
                                <form action="<?php echo $siteData->urlBasicLanguage;?>/find" class="navbar-form navbar-right box-find">
                                    <div class="form-group">
                                        <input name="name_lexicon" type="text" class="form-control" placeholder="Поиск" value="<?php echo Request_RequestParams::getParamStr('name_lexicon'); ?>">
                                    </div>
                                    <button type="submit" class="btn btn-default"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/search.png"></button>
                                </form>
                            </div>
                        </div>
                    </nav>
                </div>
            </nav>
        </div>
    </header><?php echo trim($data['view::body']);?></div>
<footer class="header-top">
    <div class="container">
        <div class="box-logo">
            <a href="<?php echo $siteData->urlBasicLanguage;?>"><img itemprop="associatedMedia" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png"></a>
        </div>
        <div class="box-right">
            <div class="row">
                <div class="col-sm-4 location">
                    <div class="media-left">
                        <img class="box-img" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/location.png">
                    </div>
                    <div class="media-body">
                        <div class="box-text">
                            <div class="title">Мы находимся</div>
                            <div class="text"><?php echo trim($siteData->globalDatas['view::View_Shop_Address\-adres']); ?></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 clock">
                    <div class="media-left">
                        <img class="box-img" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/clock.png">
                    </div>
                    <div class="media-body">
                        <div class="box-text">
                            <div class="title">Режим работы</div>
                            <div class="text">08:00 - 20:00</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 phone">
                    <div class="media-left">
                        <img class="box-img" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
                    </div>
                    <div class="media-body">
                        <div class="box-text">
                            <div class="title">Наш телефон</div>
                            <div class="text"><?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\-telefony-sverkhu']); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<div id="modal-send" class="modal fade my-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Записаться на прием</h2>
                <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
            </div>
            <div class="modal-body">
                <h4>
                    <a href="https://egov.kz/cms/ru/services/health_care/496pass_mz">Вызов врача надом</a>
                </h4>
                <h4>
                    <a href="https://egov.kz/cms/ru/services/health_care/495pass_mz">Записать на прием к врачу</a>
                </h4>
                <h4>
                    <a href="https://egov.kz/cms/ru/services/health_care/494pass_mz">Прикрепление к медицинской организации, оказывающей первичную медико-санитарную помощь</a>
                </h4>

                <form action="<?php echo $siteData->urlBasic;?>/command/add_contact_client" method="post" style="display: none">
                    <div class="input-group">
                        <span class="input-group-addon">Ваше ФИО</span>
                        <input name="client[name]" type="text" class="form-control input-lg" placeholder="Ваше ФИО" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">Ваш ИИН</span>
                        <input name="client[options][ИИН]" type="iin" class="form-control input-lg" placeholder="Ваш ИИН" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">Телефон</span>
                        <input name="contact[name]" type="phone" class="form-control input-lg" placeholder="Телефон" required>
                        <input name="contact[client_contact_type_id]" value="<?php echo Model_ClientContactType::CONTACT_TYPE_PHONE; ?>" style="display: none">
                    </div>
                    <div class="input-group">
                        <div class="g-recaptcha" data-sitekey="<?php echo Helpers_Captcha::getPublicReCaptchaGoogle($siteData); ?>"></div>
                        <script src="https://www.google.com/recaptcha/api.js?hl=ru" async defer></script>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <input name="client[type]" value="1" style="display: none">
                            <button id="modal-send-button" type="submit" class="btn btn-default btn-yellow">Отправить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/input-mask/jquery.inputmask.js"></script>
<script>
    $(document).ready(function() {
        $('input[type="phone"]').inputmask({
            mask: "+7 (999) 999 99 99"
        });
        $('input[type="iin"]').inputmask({
            mask: "999999999999"
        });
    });

    $('#modal-send-button').click(function (e) {
        e.preventDefault();

        var form = $(this).parent().parent().parent();
        var $that = form;
        var url = form.attr('action');

        var params = form.serializeArray();

        var isOK = true;

        var el = $that.find('[id="g-recaptcha-response"]');
        var s = el.val();
        $that.find('[data="'+el.attr('id')+'"]').remove();
        if (s == ''){
            $that.find('div[class="g-recaptcha"]').after('<span data="'+el.attr('id')+'" class="text--title alert--error">Установите галочку "Я не робот"</span>');
            isOK = false;
        }

        if(isOK) {
            jQuery.ajax({
                url: url,
                data: params,
                type: "POST",
                success: function (data) {
                    $('#modal-send').modal('hide');
                    $('#modal-send-finish').modal('show');
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });
        }
    });
</script>
<div id="modal-send-finish" class="modal fade my-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h2 class="modal-title">Спасибо за заявку</h2>
                <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p class="info">Наш менеджер свяжется с Вами в ближайшее время</p>
                        <button type="button" class="btn btn-default btn-yellow" data-dismiss="modal">Вернуться на главную</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $siteData->urlBasic;?>/css/_component/slick/slick.min.js"></script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(53250850, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/53250850" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-138218760-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-138218760-1');
</script>


</body>
</html>
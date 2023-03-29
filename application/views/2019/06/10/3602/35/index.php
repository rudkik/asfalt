<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="ru"> <!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="<?php if($siteData->isIndexRobots){echo 'index';}else{echo 'noindex';} ?>">
    <meta name="description" content="<?php echo htmlspecialchars($siteData->siteDescription, ENT_QUOTES); ?>" />
    <meta name="keywords" content="<?php echo htmlspecialchars($siteData->siteKeywords, ENT_QUOTES); ?>" />

    <title><?php echo trim($siteData->siteTitle); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">
    <link href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="<?php echo $siteData->urlBasic;?>/css/_component/fonts/font-awesome/v4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/style.css?cache=2">
</head>
<body itemscope="itemscope" itemtype="http://schema.org/WebPage">
<header class="header-top">
    <div class="container">
        <div class="logo">
            <a href="<?php echo $siteData->urlBasic;?>"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png"></a>
        </div>
        <div class="title"> Компания «SKY-TRANS ASIA» грузоперевозки по Казахстану и СНГ</div>
        <div class="contacts">
            <div class="phone">
                <div class="media-left">
                    <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
                </div>
                <div class="media-body">
                    <a href="tel:+77011105909">+7 (701) 110 59 09</a><br />
                    <a href="tel:+77272256263">+7 (727) 225-62-63</a>
                </div>
            </div>
        </div>
    </div>
</header>
<header class="header-menu">
    <div class="container">
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
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a class="nav-link" href="<?php echo $siteData->urlBasic;?>#about">О нас</a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?php echo $siteData->urlBasic;?>#uslugi">Услуги</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#message" data-toggle="modal">Цены</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#comments">Отзывы</a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?php echo $siteData->urlBasic;?>/pages.html">Статьи</a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?php echo $siteData->urlBasic;?>/incoterms.html">Инкотермс</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#message" data-toggle="modal">Заявка</a>
                    </li>
                    <li>
                        <a class="nav-link" href="<?php echo $siteData->urlBasic;?>/contact.html">Контакты</a>
                    </li>
                </ul>
                <div class="navbar-right">
                    <a href="#message" data-toggle="modal" class="btn btn-flat btn-orange"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/call.png"> Оставить заявку </a>
                </div>
            </div>
        </nav>
    </div>
</header>

<!-- !@@&body&@@! -->
<?php echo trim($data['view::body']);?>

<header class="header-comment">
    <div class="container">
        <h2 id="comments">Отзывы клиентов <span>SKY-TRANS ASIA</span></h2>
        <div class="text-center margin-b-30">
            <img class="line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line-two.png">
        </div>
        <div id="comments-slider" class="carousel slide" data-ride="carousel" data-interval="10000">
            <div class="carousel-inner">
                <?php echo trim($siteData->globalDatas['view::View_Shop_News/basic/otzyvy']); ?>
            </div>
            <a class="left carousel-control" href="#comments-slider" role="button" data-slide="prev">
                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/left.png">
                <span class="sr-only">Предыдущий</span>
            </a>
            <a class="right carousel-control" href="#comments-slider" role="button" data-slide="next">
                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/right.png">
                <span class="sr-only">Следующий</span>
            </a>
        </div>
    </div>
</header>
<footer class="header-top">
    <div class="container">
        <div class="logo">
            <a href=""><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/logo.png"></a>
        </div>
        <div class="title"> Компания «SKY-TRANS ASIA» грузоперевозки по Казахстану и СНГ</div>
        <div class="contacts">
            <div class="phone">
                <div class="media-left">
                    <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
                </div>
                <div class="media-body">
                    <a href="tel:+77751105909">+7 (775) 110-59-09</a><br />
                </div>
            </div>
            <div class="phone">
                <div class="media-left">
                    <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
                </div>
                <div class="media-body">
                    <a href="tel:+77750004959">+7 (775) 000-49-59</a><br />
                    <a href="tel:+77272256263">+7 (727) 225-62-63</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<footer class="footer-bottom">
    <div class="container">
        <p class="copyright">2019 © SKY-TRANS ASIA</p>
        <div class="social">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sotcialnye-seti']); ?>
        </div>
    </div>
</footer>

<div id="message" class="modal fade">
    <div class="modal-dialog">
        <form action="/command/message_add" method="post" class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Заявка</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="name" class="form-control" placeholder="Ваше имя">
                        <div class="input-group-addon">
                            <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/user.png">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="phone" name="options[phone]" class="form-control" placeholder="Телефон">
                        <div class="input-group-addon">
                            <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone-1.png">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group" style="width: 100%;">
                    <input type="email" name="options[email]" class="form-control" placeholder="E-mail">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group" style="width: 100%;">
                        <textarea row="5" name="text" class="form-control" placeholder="Сообщение"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="<?php echo Helpers_Captcha::getPublicReCaptchaGoogle($siteData); ?>"></div>
                    <script src="https://www.google.com/recaptcha/api.js?hl=ru" async defer></script>
                    <span class="error_g-recaptcha-response error"></span>
                </div>
            </div>
            <div class="modal-footer">
                <input name="text" value="Клиент хочет, чтобы к нему позвонили" hidden="">
                <input name="type" value="4169" hidden="">
                <button type="button" class="btn btn-flat btn-white" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-flat btn-orange">Отправить</button>
            </div>
        </form>
    </div>
</div>

<div class="col-sm-4">
    <input name="text" value="Клиент хочет, чтобы к нему позвонили" hidden="">
    <input name="type" value="5308" hidden="">
    <input name="url" value="<?php echo $siteData->urlBasicLanguage; ?>/send-message" hidden="">
    <button type="submit" class="btn btn-flat btn-blue active">Send</button>
</div>


<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>

<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/vendors/owlcarousel/owl.carousel.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/theme.js"></script>


<!--LiveInternet counter-->
<script type="text/javascript">
    document.write("<a href='//www.liveinternet.ru/click' "+
        "target=_blank><img src='//counter.yadro.ru/hit?t44.1;r"+
        escape(document.referrer)+((typeof(screen)=="undefined")?"":
            ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
            screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
        ";"+Math.random()+
        "' alt='' title='LiveInternet' "+
        "border='0' width='31' height='31'><\/a>")
</script>
<!--/LiveInternet-->

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
    (function(){ var widget_id = 'Z08WLFsKyI';var d=document;var w=window;function l(){
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;
        s.src = '//code.jivosite.com/script/widget/'+widget_id
        ; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}
        if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}
        else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(53718433, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/53718433" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- Rating@Mail.ru counter -->
<script type="text/javascript">var _tmr = window._tmr || (window._tmr = []);_tmr.push({id: "2837472", type: "pageView", start: (new Date()).getTime()});(function (d, w, id) {  if (d.getElementById(id)) return;  var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;  ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";  var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};  if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }})(document, window, "topmailru-code");</script><noscript><div style="position:absolute;left:-10000px;"><img src="//top-fwz1.mail.ru/counter?id=2837472;js=na" style="border:0;" height="1" width="1" alt="Рейтинг@Mail.ru" /></div></noscript>
<!-- //Rating@Mail.ru counter -->

<!--Поделиться в соц сетях-->
<script type="text/javascript">(function(w,doc) {if (!w.__utlWdgt ) {    w.__utlWdgt = true;    var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;    s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';    var h=d[g]('body')[0];    h.appendChild(s);}})(window,document);</script>
<div data-background-alpha="0.0" data-buttons-color="#FFFFFF" data-counter-background-color="#ffffff" data-share-counter-size="12" data-top-button="false" data-share-counter-type="common" data-share-style="1" data-mode="share" data-like-text-enable="false" data-hover-effect="rotate-cw" data-mobile-view="true" data-icon-color="#ffffff" data-orientation="fixed-left" data-text-color="#000000" data-share-shape="round-rectangle" data-sn-ids="fb.vk.tw.ok.gp." data-share-size="30" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.vb." data-pid="1537522" data-counter-background-alpha="1.0" data-following-enable="false" data-exclude-show-more="false" data-selection-enable="true" class="uptolike-buttons" ></div>
</body>
</html>
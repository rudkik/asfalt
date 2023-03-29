<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="<?php if($siteData->isIndexRobots){echo 'index';}else{echo 'noindex';} ?>">
    <meta name="description" content="<?php echo htmlspecialchars($siteData->siteDescription, ENT_QUOTES); ?>" />
    <meta name="keywords" content="<?php echo htmlspecialchars($siteData->siteKeywords, ENT_QUOTES); ?>" />

    <title><?php echo trim($siteData->siteTitle); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo trim($siteData->meta); ?>
    <meta property="og:locale" content="en_EN" />
    <meta property="og:site_name" content="<?php echo htmlspecialchars($siteData->shop->getName(), ENT_QUOTES); ?> english" />
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
    <link rel="canonical" href="<?php echo $siteData->urlBasicLanguage.trim($siteData->urlCanonical); ?>" />

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/css/bootstrap.min.css">
    <link href="<?php echo $siteData->urlBasic;?>/css/_component/fonts/font-awesome/v4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/css/style.css">
</head>
<body<?php if($siteData->url == '/sector'){echo ' class="global-direct"';} ?> itemscope="itemscope" itemtype="http://schema.org/WebPage"><!-- !@@&body&@@! --><div class="container">
    <header class="header-left">
        <div class="box-find"><a href=""><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/search.png"></a></div>
        <div class="box-languages">
            <?php echo trim($siteData->globalDatas['view::View_Languages\basic\yazyki']); ?>
        </div>
        <div class="box-socials">
            <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\sotcialnye-seti']); ?>
        </div>
    </header>
    <header class="header-direction">
        <div class="box-directions">
            <div class="body-directions">
                <h3>Направления компании</h3>
                <div class="row">
                    <?php echo trim($siteData->globalDatas['view::View_Shops\basic\napravleniya']); ?>
                </div>
            </div>
        </div>
        <div class="list-direction-info" id="list-direction">
            <?php echo trim($siteData->globalDatas['view::View_Shops\basic\napravleniya-tekst']); ?>
        </div>
        <?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\stati-o-komande']); ?>
		<?php echo trim($siteData->globalDatas['view::View_Shop_News\basic\partnery']); ?>        
        <?php echo trim($siteData->globalDatas['view::View_Shop_Comments\basic\otzyvy']); ?>
    </header>
    <?php echo trim($data['view::body']);?>
</div>
<footer>
    <div class="container">
        <div class="col-md-12">
            <div class="line">
                <div class="lines">
                    <div class="blue"></div>
                    <div class="yellow"></div>
                </div>

                <div class="copyright"> © <b><?php echo date('Y'); ?> ALLKemia LLP</b> </div>
                <div class="address"><?php echo trim($siteData->globalDatas['view::View_Shop_Address\basic\adres-snizu']); ?></div>
            </div>
        </div>
    </div>
</footer>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter49856143 = new Ya.Metrika2({
                    id:49856143,
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
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/49856143" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/_component/bootstrap/v3.3/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/js/main.js"></script>
<script>
    $(function () {
        $('#carousel-sector').carousel({
            interval: 10000000,
            keyboard: false,
            pause: 'hover',
        });
        $('#carousel-sector').carousel('pause');
    });
</script>

</body>
</html>
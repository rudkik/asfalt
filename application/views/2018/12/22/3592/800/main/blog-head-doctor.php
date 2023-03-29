<header class="header-bread-crumbs">
    <div class="container">
        <h2>Блог главного врача</h2>
        <ul itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs" class="bread-crumbs">
            <li>
                <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasicLanguage; ?>/">Алғашқы бет</a></span> /
            </li>
            <li>
                <span typeof="v:Breadcrumb">Блог главного врача</span>
            </li>
        </ul>
    </div>
</header>
<header class="header-body box-bg-dom">
    <div class="container">
        <div class="col-sm-3">
            <div class="row">
                <div class="box-menu">
                    <ul>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/documents">Құжаттар</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/services">Біздің ұсынатын қызметтеріміз</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/departments">Құрылымдық бөлімшелер</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/about">Орталық туралы мәлімет</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/fo-patients">Емделушіге</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/recommendations">Ұсыныстар</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/sales">Скидки и акции</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/articles">Мақалалар</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/doctors">Мамандар</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <h1 itemprop="headline">Блог главного врача</h1>
            <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png" >
            <form class="add-question" role="form" action="<?php echo $siteData->urlBasicLanguage; ?>/command/question_add" method="post">
                <div class="form-group">
                    <label>ФИО</label>
                    <input name="name" type="text" class="form-control" placeholder="ФИО">
                </div>
                <div class="form-group">
                    <label>Вопрос</label>
                    <textarea name="text" class="form-control" rows="5" placeholder="Вопрос ..."></textarea>
                </div>
                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="<?php echo Helpers_Captcha::getPublicReCaptchaGoogle($siteData); ?>"></div>
                    <script src="https://www.google.com/recaptcha/api.js?hl=ru" async defer></script>
                </div>
                <div class="box-footer">
                    <input name="type" value="4142" style="display: none">
                    <input name="url" value="<?php echo $siteData->urlBasicLanguage; ?>/blog-head-doctor" style="display: none">
                    <button type="submit" class="btn btn-primary btn-yellow">Задать</button>
                </div>
            </form>
            <div class="box_text">
                <?php echo trim($siteData->globalDatas['view::View_Shop_Questions\-blog-head-doctor-voprosy']); ?>
            </div>
        </div>
    </div>
</header>
<header class="header-send">
    <div class="container">
        <div class="box-left">
            <h2>Қабылдауға жазылу</h2>
            <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png" >
            <p>Сұрау қалдырыңыз, біз сізбен жақын арада хабарласамыз</p>
        </div>
        <div class="box-right">
            <a href="#modal-send" data-toggle="modal" class="btn btn-default btn-yellow">Записаться</a>
        </div>
    </div>
</header>
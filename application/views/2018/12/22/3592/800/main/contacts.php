<header class="header-bread-crumbs">
    <div class="container">
        <h2>Байланыс</h2>
        <ul itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs" class="bread-crumbs">
            <li>
                <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasicLanguage; ?>/">Алғашқы бет</a></span> /
            </li>
            <li>
                <span typeof="v:Breadcrumb">Байланыс</span>
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
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/departments">Бөлімдер</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/about">Орталық туралы</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/fo-patients">Пациенттерге арналған</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/recommendations">Ұсыныстар</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/sales">Скидки и акции</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/articles">Мақалалар</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/doctors">Мамандар</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <h1 itemprop="headline">Байланыс</h1>
            <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png" >
            <p class="box-info">Областной консультационно-диагностический медицинский центр Садыхан расположен по адресу:</p>
            <div class="map"><?php echo trim($siteData->globalDatas['view::View_Shop_Address\-contacts-karta']); ?></div>
            <div class="box-contacts">
                <div class="row" itemscope itemtype="http://schema.org/LocalBusiness">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Address\-contacts-adres']); ?>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\-contacts-telefony']); ?>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_AddressContacts\-contacts-e-mail']); ?>
                </div>
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
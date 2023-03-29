<header class="header-bread-crumbs">
    <div class="container">
        <h2>Блог главного врача</h2>
        <ul itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs" class="bread-crumbs">
            <li>
                <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasicLanguage; ?>/">Главная</a></span> /
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
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/documents">Документы</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/services">Наши услуги</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/departments">Отделения</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/about">О центре</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/fo-patients">Пациентам</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/recommendations">Рекомендации</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/sales">Скидки и акции</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/articles">Статьи</a></li>
                        <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/doctors">Специалисты</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <h1 itemprop="headline">Блог главного врача</h1>
            <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png" >
            <div class="box_text">
                <?php echo trim($siteData->globalDatas['view::View_Shop_Questions\-blog-head-doctor-voprosy']); ?>
            </div>
        </div>
    </div>
</header>
<header class="header-send">
    <div class="container">
        <div class="box-left">
            <h2>Запись на прием</h2>
            <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png" >
            <p>Оставьте заявку и мы свяжемся с Вами в ближайщее время</p>
        </div>
        <div class="box-right">
            <a href="#modal-send" data-toggle="modal" class="btn btn-default btn-yellow">Записаться</a>
        </div>
    </div>
</header>
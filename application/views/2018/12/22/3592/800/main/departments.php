<header class="header-bread-crumbs">
    <div class="container">
        <h2>Бөлімдер</h2>
        <ul itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs" class="bread-crumbs">
            <li>
                <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasicLanguage; ?>/">Алғашқы бет</a></span> /
            </li>
            <li>
                <span typeof="v:Breadcrumb">Бөлімдер</span>
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
                        <?php echo trim($siteData->globalDatas['view::View_Shop_News\-departments-rubrikatciya']); ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <h1 itemprop="headline">Бөлімдер</h1>
            <img class="img-line" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/line.png" >
            <p class="box-info">На сегодняшний день в ОКДМЦС функционируют следующие отделения:</p>
            <div class="box-departments">
                <img itemprop="associatedMedia" class="img-responsive" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/department.png">
                <div class="departments">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_News\-departments-otdeleniya']); ?>
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
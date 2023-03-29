	<header class="header-breadcrumb">
        <div class="container">
            <h1>Контакты</h1>
            <div class="breadcrumbs">
                <a href="<?php echo $siteData->urlBasic;?>/">Главная</a> |
                <a class="active" href="<?php echo $siteData->urlBasic;?>/contacts">Контакты</a>
            </div>
        </div>
    </header>
</header>
<header class="header-contact">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="box-map">
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Address\-karta']); ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box-worker-info">
                    <h2>Контакты</h2>
                    <?php echo trim($siteData->globalDatas['view::View_Shop_Addresss\-filialy']); ?>
                    <button class="btn btn-flat btn-grey">Оставить заявку <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/arrow.png"></button>
                </div>
            </div>
        </div>
    </div>
</header>
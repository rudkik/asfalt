<header class="header-breadcrumbs">
    <div class="container">
        <h1>Контакты</h1>
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasic;?>/">Главная</a> <span>/</span>
            <span class="current">Контакты</span>
        </div>
    </div>
</header>
<header class="header-contacts">
    <div class="container">
		<div class="map"><?php echo trim($siteData->globalDatas['view::View_Shop_Address/-contacts-karta']); ?></div>
    </div>
</header>
<header class="header-breadcrumb">
    <div class="container">
        <h1>Список программ</h1>
        <div class="breadcrumbs">
            <a href="<?php echo $siteData->urlBasic;?>/">Главная</a> /
            <a class="active" href="<?php echo $siteData->urlBasic;?>/programs">Список программ</a>
        </div>
    </div>
</header>
<header class="header-programs">
    <div class="container">
        <div class="row">
			<?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-programs-marafony']); ?>
            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-programs-programmy']); ?>
        </div>
    </div>
</header>
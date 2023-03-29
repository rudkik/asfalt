<header class="header-breadcrumb">
    <div class="container">
        <h1>Отзывы</h1>
        <div class="breadcrumbs">
            <a href="<?php echo $siteData->urlBasic;?>/">Главная</a> /
            <a class="active" href="<?php echo $siteData->urlBasic;?>/comments">Отзывы</a>
        </div>
    </div>
</header>
<header class="header-comment">
    <div class="container">
        <?php echo trim($siteData->globalDatas['view::View_Shop_Comments\-comments-otzyvy']); ?>
    </div>
</header>
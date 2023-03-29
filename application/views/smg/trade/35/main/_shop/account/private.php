<div class="header header-breakpoint" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
    <div class="container">
        <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/trade/general/index">Главная</a></span> /
        <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/trade/account/index">Личный кабинет</a></span> /
        <span typeof="v:Breadcrumb" class="active"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/trade/account/private">Личные данные</a></span>
    </div>
</div>
<div class="header header-rubrics">
    <div class="container">
        <div class="row">
                <?php echo trim($data['view::_shop/account/list/private']); ?>
        </div>
    </div>
</div>


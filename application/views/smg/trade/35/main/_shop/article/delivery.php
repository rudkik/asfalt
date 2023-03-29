<div class="header header-breakpoint" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
    <div class="container">
        <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/trade/general/index">Главная</a></span> /
        <span typeof="v:Breadcrumb" class="active"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/trade/delivery">Доставка</a></span>
    </div>
</div>
<div class="header header-info">
    <div class="container">
        <h1 itemprop="headline"></h1>
        <div class="row">
            <div class="col-md-12 box-text">
                <?php echo trim($data['view::_shop/article/delivery/list/index']); ?>
            </div>
        </div>
    </div>
</div>

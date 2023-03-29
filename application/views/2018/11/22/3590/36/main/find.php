<header class="header-bread-crumbs">
    <div class="container">
        <h2>Find</h2>
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>">Main</a> |
            <?php $name = Request_RequestParams::getParamStr('name_lexicon'); ?>
            <span>Find <?php if (!empty($name)){echo '«'.$name.'»';} ?></span>
        </div>
    </div>
</header>
<header class="header-catalogs">
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-products-brendy']); ?>
            </div>
            <div class="col-xs-9">
                <h1 itemprop="headline" class="objectTitle2">Find <?php if (!empty($name)){echo ' «'.$name.'»';} ?></h1>
                <div class="line-red"></div>
                <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-brands-rubriki-brendov']); ?>
                <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-products-produktciya']); ?>
            </div>
        </div>
    </div>
</header>
<header class="header-groups">
    <div class="container">
        <div class="row">
            <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-main-gruppy-s-rubrikami']); ?>
        </div>
    </div>
</header>
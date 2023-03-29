<?php echo trim($siteData->globalDatas['view::View_ShopNews\main_slaider']); ?>
<?php echo trim($siteData->globalDatas['view::View_ShopNews\main_nashi-preimushchstva-sverkhu']); ?>

<div class="header header-products padding-top-25">
    <div class="container">
        <?php echo trim($siteData->globalDatas['view::View_ShopGoods\main_vi_interesovalis']); ?>
        <?php echo trim($siteData->globalDatas['view::View_ShopGoods\main_mi_rekomenduem']); ?>
    </div>
</div>
<div class="header header-products header-blue padding-top-25">
    <div class="container">
        <?php echo trim($siteData->globalDatas['view::View_ShopGoods\main_aktualno']); ?>
        <?php echo trim($siteData->globalDatas['view::View_ShopGoods\main_luchshie_ceni']); ?>
    </div>
</div>
<div class="header header-find-rubrics">
    <div class="container">
        <h2>Сейчас ищут в <?php echo Func::getStringCaseRus($siteData->city->getName(), 5); ?></h2>
        <div class="row rubrics">
            <?php echo trim($siteData->globalDatas['view::View_ShopGoodCatalogs\main_seichas-ishchut']); ?>
        </div>
    </div>
</div>
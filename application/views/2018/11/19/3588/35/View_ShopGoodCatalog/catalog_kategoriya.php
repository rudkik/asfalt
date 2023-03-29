<?php if ($data->id > 0){ ?>
    <?php
    $_POST['_rubric_id_'] = $data->values['root_id'];
    Helpers_SEO::setSEOHeader(Model_Shop_Table_Rubric::TABLE_NAME, $data, $siteData);
    ?>
    <div class="header header-breakpoint" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
        <div class="container">
            <span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/">Главная</a></span> /
            <?php echo trim($siteData->globalDatas['view::View_Shop_Table_Rubrics\-catalog-khlebnye-kroshki']); ?>
            <span typeof="v:Breadcrumb" class="active"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/catalogs<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></span>
        </div>
    </div>
    <div class="header header-rubrics">
        <div class="container">
            <h1 itemprop="headline"><?php echo $data->values['name']; ?> в <?php echo Func::getStringCaseRus($siteData->city->getName(), 5); ?></h1>
            <div class="row">
                <?php echo trim($siteData->globalDatas['view::View_ShopGoodCatalogs\catalog_podkategorii']); ?>
            </div>
        </div>
    </div>
<?php } ?>
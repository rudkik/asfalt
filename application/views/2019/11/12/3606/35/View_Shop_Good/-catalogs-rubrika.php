<?php
$_GET['root_rubric'] = $data->values['root_id'];
Helpers_SEO::setSEOHeader(Model_Shop_Table_Rubric::TABLE_NAME, $data, $siteData);
?>
<header class="header-bread-crumbs">
    <div class="container">
        <div class="box-bread-crumbs" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" data-qaid="breadcrumbs">
            <a typeof="v:Breadcrumb" rel="v:url" property="v:title"  href="<?php echo $siteData->urlBasicLanguage; ?>/">Главная</a> /
            <?php echo trim($siteData->globalDatas['view::View_Shop_Table_Rubrics\-catalogs-khlebnye-kroshki']); ?>
            <span typeof="v:Breadcrumb" property="v:title" ><?php echo $data->values['name']; ?></span>
        </div>
    </div>
</header>
<header class="header-goods-list">
    <div class="container">
        <h1 itemprop="headline"><?php echo $data->values['name']; ?></h1>
        <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-catalogs-produktciya']); ?>
    </div>
</header>
<header class="header-text padding-t-0">
    <div class="container">
        <div class="box_text"><?php echo $data->values['text']; ?></div>
    </div>
</header>
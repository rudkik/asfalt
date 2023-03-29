<?php
Helpers_SEO::setSEOHeader(Model_Shop_Table_Rubric::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
$_GET['hashtag'] = Arr::path($data->values['options'], 'type', -1);
?>
<header class="header-bread-crumbs">
    <div class="container">
        <h2><?php echo $data->values['name']; ?></h2>
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>">Главная</a> |
            <?php echo trim($siteData->globalDatas['view::View_Shop_Table_Rubrics\-products-khlebnye-kroshki']); ?>
            <span><?php echo $data->values['name']; ?></span>
        </div>
    </div>
</header>
<header class="header-catalogs">
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <?php echo trim($siteData->globalDatas['view::View_Shop_News\-products-detvora']); ?>
                <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-products-brendy']); ?>
            </div>
            <div class="col-xs-9">
                <h1 itemprop="headline" class="objectTitle2"><?php echo $data->values['name']; ?></h1>
                <div class="line-red"></div>
                <div class="box_text">
                    <?php echo $data->values['text']; ?>
                </div>
                <?php echo trim($siteData->globalDatas['view::View_Shop_Goods\-products-produktciya']); ?>
            </div>
        </div>
    </div>
</header>
<?php if($data->id > 0){?>
    <?php
    Helpers_SEO::setSEOHeader(Model_Shop_Table_Rubric::TABLE_NAME, $data, $siteData);
    $siteData->siteImage = $data->values['image_path'];
    ?>
    <header class="header-breadcrumb">
        <div class="container">
            <h1><?php echo $data->values['name']; ?></h1>
            <div class="breadcrumbs">
                <a href="<?php echo $siteData->urlBasicLanguage; ?>/">Главная</a> |
                <?php echo trim($siteData->globalDatas['view::View_Shop_Table_Rubrics\-catalogs-khlebnye-kroshki']); ?>
                <a class="active" href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a>
            </div>
        </div>
    </header>
<?php }else{?>
    <header class="header-breadcrumb">
        <div class="container">
            <h1>Каталог продукции</h1>
            <div class="breadcrumbs">
                <a href="<?php echo $siteData->urlBasicLanguage; ?>/">Главная</a> |
                <a class="active" href="<?php echo $siteData->urlBasicLanguage; ?>/catalogs">Каталог продукции</a>
            </div>
        </div>
    </header>
<?php }?>
</header>
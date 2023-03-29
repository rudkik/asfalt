<?php
if($data->id > 0){
    $_POST['_root_id_'] = $data->values['root_id'];
    ?>
    <?php
    Helpers_SEO::setSEOHeader(Model_Shop_Table_Rubric::TABLE_NAME, $data, $siteData);
    $siteData->siteImage = $data->values['image_path'];
    ?>
    <header class="header-bread-crumbs">
        <div class="container">
            <h1><?php echo $data->values['name']; ?></h1>
            <div class="box-bread-crumbs">
                <a href="<?php echo $siteData->urlBasicLanguage; ?>/">Главная</a> /
                <?php echo trim($siteData->globalDatas['view::View_Shop_Table_Rubrics\-trucks-khlebnye-kroshki']); ?>
                <span><?php echo $data->values['name']; ?></span>
            </div>
        </div>
    </header>
<?php }else{ ?>
    <header class="header-bread-crumbs">
        <div class="container">
            <h1>Поиск</h1>
            <div class="box-bread-crumbs">
                <a href="<?php echo $siteData->urlBasicLanguage; ?>/">Главная</a> /
                <span>Поиск</span>
            </div>
        </div>
    </header>
<?php } ?>


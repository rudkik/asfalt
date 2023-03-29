<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<?php
$_POST['_root_id_'] = $data->values['shop_table_rubric_id'];
?>
<header class="header-bread-crumbs">
    <div class="container">
        <h1><?php echo $data->values['name']; ?></h1>
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>">Главная</a> /
			<?php echo trim($siteData->globalDatas['view::View_Shop_Table_Rubrics\-article-khlebnye-kroshki']); ?>
            <span><?php echo $data->values['name']; ?></span>
        </div>
    </div>
</header>
<header class="header-article">
    <div class="container">
        <h2><?php echo $data->values['name']; ?></h2>
        <div class="box_text">
			<?php echo $data->values['text']; ?>
		</div>
    </div>
</header>
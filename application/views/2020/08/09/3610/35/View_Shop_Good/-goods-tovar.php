<?php
Helpers_SEO::setSEOHeader(Model_Shop_Good::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];

if ($data->values['shop_table_rubric_id'] == 0){
    $_GET['rubric_root_id'] = Arr::path($_GET, '_current_rubric_', 999);
}else{
    $_GET['rubric_root_id'] = Arr::path($_GET, '_current_rubric_', $data->values['shop_table_rubric_id']);
}
?>
<header class="header-bread-crumbs">
    <div class="container">
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasic;?>/">Главная</a> /
            <a href="<?php echo $siteData->urlBasic;?>/catalogs">Продукты</a> /
            <?php echo trim($siteData->globalDatas['view::View_Shop_Table_Rubrics\-catalogs-khlebnye-kroshki']); ?>
            <span><?php echo $data->values['name']; ?></span>
        </div>
    </div>
</header>
<header class="header-good">
    <div class="container">
		<h1><?php echo $data->values['name']; ?></h1>		
		<div class="box_text">
			<img class="box-img-med" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" src="<?php echo Func::addSiteNameInFilePath($data->values['image_path']); ?>">
			<?php echo $data->values['text']; ?>
		</div>
	</div>
</header>
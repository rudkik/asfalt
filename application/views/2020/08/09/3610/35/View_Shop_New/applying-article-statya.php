<header class="header-bread-crumbs">
    <div class="container">
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasic;?>/">Главная</a> /
            <a href="<?php echo $siteData->urlBasic;?>/applying">Применение</a> /
            <span><?php echo $data->values['name']; ?></span>
        </div>
    </div>
</header>
<header class="header-article">
    <div class="container">
		<h1><?php echo $data->values['name']; ?></h1>		
		<div class="box_text">
			<img class="box-img-med" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" src="<?php echo Func::addSiteNameInFilePath($data->values['image_path']); ?>">
			<?php echo $data->values['text']; ?>
		</div>
	</div>
</header>
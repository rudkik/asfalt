<header class="header-breadcrumbs">
    <div class="container">
        <h1><?php echo $data->values['name']; ?></h1>
        <div class="box-bread-crumbs">
            <a href="<?php echo $siteData->urlBasicLanguage; ?>/">Главная</a> <span>/</span>
            <span class="current"><?php echo $data->values['name']; ?></span>
        </div>
    </div>
</header>
<header class="header-box-article">
    <div class="container">
        <?php if(FALSE && !empty($data->values['image_path'])){ ?>
            <div class="box-img">
                <img src="<?php echo $data->values['image_path']; ?>">
                <div class="date"><span><?php echo Helpers_DateTime::getDateFormatRus($data->values['created_at']); ?></span></div>
            </div>
        <?php } ?>
		<div class="box_text">
			<?php echo $data->values['text']; ?>
		</div>
    </div>
</header>
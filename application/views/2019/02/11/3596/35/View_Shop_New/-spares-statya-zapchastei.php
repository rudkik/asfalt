<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<header class="header-article">
    <div class="container">
        <h2><?php echo $data->values['name']; ?></h2>
        <div class="box_text">
			<?php echo $data->values['text']; ?>
		</div>
    </div>
</header>
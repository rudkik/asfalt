<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<h1><?php echo $data->values['name']; ?></h1>
<div>
    <?php if(!empty($data->values['image_path'])){ ?>
    <img class="img-right img-border" src="<?php echo $data->values['image_path']; ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    <?php } ?>
    <div class="box-text-article"><?php echo $data->values['text']; ?></div>
</div>
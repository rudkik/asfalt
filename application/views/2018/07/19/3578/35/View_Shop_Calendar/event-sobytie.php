<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<h1><?php echo $data->values['name']; ?></h1>
<?php 
$quote = Arr::path($data->values['options'], 'quote', '');
if(!empty($quote)){
?>
<div class="quote-text">
    <img class="quote-l" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/quotes-l-g.png">
    <div class="text">
        <?php echo $quote; ?>
    </div>
    <img class="quote-r" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/quotes-r-g.png">
</div>
<?php } ?>
<div>
    <?php if(!empty($data->values['image_path'])){ ?>
        <img class="img-right img-border" src="<?php echo $data->values['image_path']; ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    <?php } ?>
	<div class="box-text-article"><?php echo $data->values['text']; ?></div>
</div>
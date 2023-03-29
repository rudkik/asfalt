<div class="service">
	<p class="name"><a href="<?php echo $siteData->urlBasic; ?>/service?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a></p>
    <div class="line-green"></div>
    <div class="text box-text-article">
        <?php echo Arr::path($data->values['options'], 'info', ''); ?>
    </div>
    <a href="<?php echo $siteData->urlBasic; ?>/service?id=<?php echo $data->values['id']; ?>" class="btn btn-green">ПОДРОБНЕЕ</a>
</div>
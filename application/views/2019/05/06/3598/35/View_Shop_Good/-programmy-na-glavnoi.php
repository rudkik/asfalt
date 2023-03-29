<div class="col-md-4 box-meditation">
    <div class="box-title">
        <h3><?php echo Arr::path($data->values['options'], 'price', ''); ?></h3>
        <h4><?php echo $data->values['name']; ?></h4>
    </div>
    <div class="box-body">
        <p><?php echo Arr::path($data->values['options'], 'info', ''); ?></p>
        <a href="<?php echo $siteData->urlBasicLanguage; ?>/programs<?php echo $data->values['name_url']; ?>" class="btn btn-flat btn-green">Подробнее</a>
    </div>
</div>
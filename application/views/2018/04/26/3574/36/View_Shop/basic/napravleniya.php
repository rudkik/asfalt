<div class="col-md-3 sector" data-id="<?php echo $data->id; ?>" data-parent="#list-direction" data-action="direction">
    <a href="<?php echo $siteData->urlBasicLanguage;?>/sector?id=<?php echo $data->id; ?>">
        <img class="current" src="<?php echo Arr::path($data->values['files'], '0.file', ''); ?>">
        <img class="select" src="<?php echo Arr::path($data->values['files'], '1.file', ''); ?>">
    </a>
</div>
<div class="col-sm-6 sale">
    <div class="bg-gradient" style="background: url('<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 635, 386); ?>') no-repeat scroll center top transparent;">
        <?php if(!Func::_empty(Arr::path($data->values['options'], 'percent', ''))){ ?>
            <div class="img-circle"><?php echo Arr::path($data->values['options'], 'percent', ''); ?>%</div>
        <?php } ?>
        <p class="title"><a href="<?php echo $siteData->urlBasicLanguage; ?>/sales<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></p>
    </div>
</div>
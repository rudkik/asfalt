<div class="col-3 tv">
    <div class="tv__block">
        <?php if(Func::_empty(Arr::path($data->values['options'], 'youtube', ''))){ ?>
            <img src="<?php echo Func::getPhotoPath($data->values['image_path'], 192, 100); ?>">
        <?php }else{ ?>
            <iframe width="300" height="200" src="<?php echo Arr::path($data->values['options'], 'youtube', ''); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <?php } ?>
    </div>
</div>

<div class="item">
    <div class="slider" style="background-image: url(<?php echo $data->values['image_path']; ?>);">
        <div class="container">
            <h1><span><?php echo Arr::path($data->values['options'], 'title_1', ''); ?></span><br> <?php echo Arr::path($data->values['options'], 'title_2', ''); ?></h1>
            <h4><?php echo Arr::path($data->values['options'], 'title_3', ''); ?></h4>
            <div class="line-green"></div>
            <p><?php echo $data->values['text']; ?></p>
            <a href="<?php echo Arr::path($data->values['options'], 'url', ''); ?>" class="btn btn-flat btn-green"><?php echo Arr::path($data->values['options'], 'button', ''); ?></a>
        </div>
    </div>
</div>
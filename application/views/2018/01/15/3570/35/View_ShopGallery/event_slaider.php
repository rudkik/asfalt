<div class="tz-items">
    <div class="tz-slider-images">
        <img src="<?php echo Func::getPhotoPath($data->values['image_path'], 1920, 800); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </div>
    <div class="tz-banner-content">
        <div class="container">
            <small><?php echo $data->values['name']; ?> </small>
            <h4><?php echo Arr::path($data->values['options'], 'title', ''); ?></h4>
            <span class="tz-under-line"></span>
            <h6><?php echo Arr::path($data->values['options'], 'title1', ''); ?></h6>
            <a class="tz-item-more-details" href="<?php echo Arr::path($data->values['options'], 'button_url', ''); ?>">
                <span><i class="fa fa-arrows-alt"></i><?php echo Arr::path($data->values['options'], 'button', ''); ?></span>
            </a>
        </div>
    </div>
    <button class="tz-button-left">
        <i class="fa fa-angle-left"></i>
    </button>
    <button class="tz-button-right">
        <i class="fa fa-angle-right"></i>
    </button>
</div>
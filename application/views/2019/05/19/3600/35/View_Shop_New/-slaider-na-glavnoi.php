<div class="item">
    <div class="slider">
        <div class="container">
            <div class="box-left">
                <h1><?php echo Arr::path($data->values['options'], 'title_1', ''); ?></h1>
                <h4><?php echo Arr::path($data->values['options'], 'title_2', ''); ?></h4>
                <div class="info">
                    <p><?php echo $data->values['text']; ?></p>
                </div>
                <a href="<?php echo Arr::path($data->values['options'], 'url', ''); ?>" class="btn btn-flat btn-grey"><?php echo Arr::path($data->values['options'], 'button', ''); ?></a>
            </div>
        </div>
    </div>
</div>
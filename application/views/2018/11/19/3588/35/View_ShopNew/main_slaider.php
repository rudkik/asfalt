<div class="item">
    <div class="row">
        <div class="col-md-12">
            <div class="box_text">
                <?php echo Arr::path($data->values['options'], 'html', ''); ?>
            </div>
            <img src="<?php echo $data->values['image_path']; ?>" class="img-responsive width-100" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        </div>
    </div>
</div>
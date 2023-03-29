<div class="col-md-4">
    <img src="<?php echo $data->values['image_path']; ?>" class="img-responsive icon" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    <div class="box_text">
        <div class="title"><?php echo $data->values['name']; ?></div>
        <div class="text"><?php echo Arr::path($data->values['options'], 'title', ''); ?></div>
    </div>
    <div class="line"></div>
</div>
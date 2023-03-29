<div class="content__item <?php echo Arr::path($data->values['options'], 'class', ''); ?> col-lg-<?php echo  3 * intval(Arr::path($data->values['options'], 'column', 1)); ?> col-<?php echo  6 * intval(Arr::path($data->values['options'], 'column', 1)); ?>">
    <a href="<?php echo Arr::path($data->values['options'], 'url', ''); ?>">
        <div class="titleText"><?php echo $data->values['text']; ?></div>
        <img class="imagePlace" src="<?php echo $data->values['image_path']; ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </a>
</div>
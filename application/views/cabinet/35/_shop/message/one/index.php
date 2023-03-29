<div class="item">
    <img src="<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.image_path', ''); ?>" alt="<?php echo htmlspecialchars(Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.name', ''), ENT_QUOTES); ?>" class="online">
    <p class="message">
        <a href="#" class="name">
            <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds($data->values['created_at']); ?></small>
            <?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_client_id.name', ''); ?>
        </a>
        <?php echo $data->values['text']; ?>
    </p>
    <?php if (false){?>
    <div class="attachment">
        <h4>Attachments:</h4>
        <p class="filename">
            Theme-thumbnail-image.jpg
        </p>
        <div class="pull-right">
            <button class="btn btn-primary btn-sm btn-flat">Open</button>
        </div>
    </div>
    <?php }?>
</div>

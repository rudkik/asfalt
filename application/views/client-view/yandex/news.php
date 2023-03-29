<?php if(! empty($data->values['image_path'])){ ?>
    <img hidden src="<?php echo $data->values['image_path']; ?>" itemprop="associatedMedia" alt="<?php echo htmlspecialchars($data->values['name']); ?>" title="<?php echo htmlspecialchars($data->values['name']); ?>">
<?php } ?>
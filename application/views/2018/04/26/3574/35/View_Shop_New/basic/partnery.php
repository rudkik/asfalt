<div class="item">
    <div class="partner">
        <img src="<?php echo $data->values['image_path']; ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        <div class="info">
            <?php echo $data->values['text']; ?>
        </div>
    </div>
</div>
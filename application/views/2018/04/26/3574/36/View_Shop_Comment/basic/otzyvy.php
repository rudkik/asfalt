<div class="item">
    <div class="partner">
        <img src="<?php echo $data->values['image_path']; ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        <div class="info">
            <p><?php echo $data->values['text']; ?></p>
			<p class="men"><span>—</span> <?php echo $data->values['name']; ?> </p>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="advantage">
        <div class="advantage__inner">
            <figure class="advantage__icon icon">
                <img src="<?php echo $data->values['image_path']; ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
            </figure>
            <div class="text--title text--bold">
                <?php echo $data->values['name']; ?>
            </div>
            <div class="text"><?php echo $data->values['text']; ?></div>
        </div>
    </div>
</div>
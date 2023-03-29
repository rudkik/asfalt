<div class="col-12 col-lg-4">
    <div class="step">
        <div class="step__num">#index#</div>
        <div class="step__inner">
            <figure class="step__img icon">
                <img src="<?php echo $data->values['image_path']; ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
            </figure>
            <div class="text--title"><?php echo $data->values['name']; ?></div>
            <div class="text"><?php echo $data->values['text']; ?></div>
        </div>
    </div>
</div>
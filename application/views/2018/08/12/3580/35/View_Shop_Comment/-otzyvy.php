<div class="item listar-testimonial">
    <blockquote>
        <h5><?php echo Arr::path($data->values['options'], 'title', ''); ?></h5>
        <q><?php echo $data->values['text']; ?></q>
    </blockquote>
    <figure>
        <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 60, 60); ?>" alt="image description">
        <figcaption>
            <h3><?php echo $data->values['name']; ?></h3>
            <h4><?php echo Arr::path($data->values['options'], 'position', ''); ?></h4>
        </figcaption>
    </figure>
</div>
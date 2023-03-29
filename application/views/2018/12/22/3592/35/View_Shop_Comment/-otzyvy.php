<div class="item">
    <div class="media-left">
		<?php if(!empty($data->values['image_path'])){?>
        <img class="img-circle" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 103, 103); ?>">
		<?php }?>
    </div>
    <div class="media-body">
        <div itemscope="" itemtype="http://schema.org/UserComments" class="box-text">
            <p class="name"><?php echo $data->values['name']; ?></p>
            <div class="comment" itemtype="http://schema.org/Comment" itemscope="">
                <?php echo $data->values['text']; ?>
            </div>
        </div>
    </div>
</div>
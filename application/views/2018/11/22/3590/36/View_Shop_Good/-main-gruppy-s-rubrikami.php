<div class="col-md-4 div-group">
    <div class="box-group">
        <div class="box-img"><img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 403, 313); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"></div>
        <div class="box-group-body">
            <div class="box-child">
                <h3><?php echo $data->values['name']; ?></h3>
                <?php echo $data->additionDatas['view::View_Shop_Goods\group\-main-gruppy-s-rubrikami']; ?>
            </div>
        </div>
    </div>
</div>
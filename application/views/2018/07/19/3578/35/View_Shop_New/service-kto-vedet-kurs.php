<div class="col-md-6" style="margin-bottom: 40px;">
    <div class="row">
        <div class="col-md-4 text-center">
            <div class="box-img">
                <img class="img-circle img-responsive" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 322, 322); ?>">
            </div>
            <p class="name"><?php echo $data->values['name']; ?></p>
            <div class="phone">
                <div class="media-left">
                    <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
                </div>
                <div class="media-body">
                    <p>Наш телефон:</p>
                    <?php
                    $phone = Arr::path($data->values['options'], 'phone', '');
                    if(!empty($phone)){?>
                    <a href="tel:<?php echo $phone;  ?>"><?php echo $phone;  ?></a>
                    <?php }?>
                    <?php
                    $phone = Arr::path($data->values['options'], 'phone_2', '');
                    if(!empty($phone)){?>
                        <a href="tel:<?php echo $phone;  ?>"><?php echo $phone;  ?></a>
                    <?php }?>
                </div>
            </div>
            <div class="email">
                <div class="media-left">
                    <img class="" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/email.png">
                </div>
                <div class="media-body">
                    <p>Моя почта:</p>
                    <a href="mailto:<?php echo Arr::path($data->values['options'], 'email', '');  ?>"><?php echo Arr::path($data->values['options'], 'email', '');  ?></a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <?php echo $data->values['text']; ?>
            <a href="<?php echo Arr::path($data->values['options'], 'url', '');  ?>" class="btn btn-green">Обо мне</a>
        </div>
    </div>
</div>
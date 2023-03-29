<div class="row box-title">
    <div class="col-xs-6">
        <p class="title"><?php echo $data->values['name']; ?></p>
        <p class="info"><?php echo Arr::path($data->values['options'], 'position', ''); ?></p>
        <?php $phone = Arr::path($data->values['options'], 'phone2', ''); ?>
        <?php if(!empty($phone)){?>
        <p class="info" style="margin: 0px">Телефон: <a itemprop="telephone" href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a></p>
        <?php }?>
        <?php $email = Arr::path($data->values['options'], 'email', ''); ?>
        <?php if(!empty($email)){?>
            <p class="info">E-mail: <a itemprop="email" href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></p>
        <?php }?>
    </div>
    <div class="col-xs-6">
        <div class="btn-yellow btn-oblique">
            <span>
                <img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/phone.png">
                <?php $phone = Arr::path($data->values['options'], 'phone1', ''); ?>
                <a itemprop="telephone" href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
            </span>
        </div>
    </div>
</div>
<?php $percent = round($data->values['quantity'] / ($data->values['size_meter'] * $data->values['ton_in_meter']) * 100, 2); ?>
<style>
    img{cursor:default!important;}
</style>
<div class="box-barrel" id="storage-<?php echo $data->id; ?>">
    <div class="body-barrel">
        <p class="name"><?php echo $data->values['name']; ?></p>
        <p class="raw"><?php echo $data->getElementValue('shop_raw_id'); ?></p>
        <div class="progress-barrel">
            <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="<?php echo $percent; ?>" aria-valuemin="0" aria-valuemax="100" style="height: <?php echo $percent; ?>%;">
            </div>
            <img src="<?php echo $siteData->urlBasic; ?>/css/ab1/img/barrel.png">
            <div class="right <?php if($data->values['is_up']){ ?>up<?php }else{?>down<?php }?>">
                <img data-action="add-drain" data-id="<?php echo $data->id; ?>" data-is_upload="1" class="active" src="<?php echo $siteData->urlBasic; ?>/css/ab1/img/left.png">
                <img data-action="add-drain" data-id="<?php echo $data->id; ?>" data-is_upload="0" src="<?php echo $siteData->urlBasic; ?>/css/ab1/img/right.png">
                <img class="img-up" src="<?php echo $siteData->urlBasic; ?>/css/ab1/img/up-g.png" >
                <img class="img-down" src="<?php echo $siteData->urlBasic; ?>/css/ab1/img/down-r.png">
            </div>
        </div>
    </div>
    <p class="quantity"><span data-id="percent"><?php echo $percent; ?></span>% / <span data-id="quantity"><?php echo Func::getNumberStr($data->values['quantity'], true, 3, false); ?></span> т</p>
    <p class="meter"><span data-id="meter"><?php echo Func::getNumberStr($data->values['meter'], true, 3, false); ?></span> <span><?php echo $data->values['unit']; ?></span></p>
</div>

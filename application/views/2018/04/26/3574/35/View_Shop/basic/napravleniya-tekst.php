<div class="box-direction-info" data-id="<?php echo $data->values['id']; ?>">
    <div class="direction-info">
        <h2><?php echo $data->values['name']; ?></h2>
        <div class="info"><?php echo $data->values['text']; ?></div>
        <a href="<?php echo $siteData->urlBasic;?>/sector?id=<?php echo $data->id; ?>">Подробнее</a>
    </div>
</div>
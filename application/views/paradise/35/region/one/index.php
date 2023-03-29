<div class="col-md-4" style="width: <?php echo Arr::path($data->additionDatas, 'weight_width', 0); ?>%; height: <?php echo Arr::path($data->additionDatas, 'weight_height', 0); ?>%;">
    <?php if (intval($data->id) > 0){?>
        <a href="/region?id=<?php echo $data->values['id']; ?>"><img class="img-responsive" src="<?php echo $data->values['image_path']; ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"></a>
    <?php }else{?>
        <?php echo trim($siteData->globalDatas['view::people/list/index']); ?>
    <?php }?>
</div>
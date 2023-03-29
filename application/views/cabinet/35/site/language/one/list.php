<div class="row margin-b-10">
    <div class="col-md-2">
        <input class="minimal" name="languages[<?php echo $data->id;?>]" data-id="1" type="checkbox" <?php if($data->additionDatas['is_public']){echo ' value="1" checked';}else{echo ' value="0"';}?>>
        <?php if($data->additionDatas['is_public']){?>
            <label class="margin-l-5">
                <?php echo $data->values['name'];?>
            </label>
        <?php }else{?>
            <span class="margin-l-5">
                <?php echo $data->values['name'];?>
            </span>
        <?php }?>
    </div>
    <div class="col-md-10">
        <?php if($data->additionDatas['is_public']){?>
        <a href="<?php echo $siteData->urlBasic;?>/cabinet/site/views?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&url=<?php echo Request_RequestParams::getParamStr('url');?>&language=<?php echo $data->id;?>" class="btn btn-primary">Список вьюшек</a>
        <a href="<?php echo $siteData->urlBasic;?>/cabinet/site/url?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&url=<?php echo Request_RequestParams::getParamStr('url');?>&language=<?php echo $data->id;?>" class="btn btn-primary btn-success">Тело страницы</a>
        <a href="<?php echo $siteData->urlBasic;?>/cabinet/site/view_statics?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&language=<?php echo $data->id;?>" class="btn bg-purple">Вьюшки index-файла</a>
        <a href="<?php echo $siteData->urlBasic;?>/cabinet/site/html?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&language=<?php echo $data->id;?>" class="btn bg-orange">Тело index-файла</a>
        <a class="margin-l-5" href="<?php echo $siteData->urlBasic.'/'.Request_RequestParams::getParamStr('url');?>?language_id=<?php echo $data->id;?>">Ссылка на страницу</a>
        <?php }?>
    </div>
</div>
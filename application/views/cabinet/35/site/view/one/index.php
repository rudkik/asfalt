<div class="row margin-b-10">
    <div class="col-md-3">
        <input type="text" class="form-control" value="<?php echo Arr::path($data->values['index_title'], 'ru', '');?>" disabled>
    </div>
    <div class="col-md-3">
        <input name="views[<?php echo $data->values['index']; ?>][title]" type="text" class="form-control" placeholder="Название" value="<?php echo $data->values['title'];?>">
    </div>
    <div class="col-md-3">
        <a href="<?php echo $siteData->urlBasic;?>/cabinet/site/view?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&url=<?php echo Request_RequestParams::getParamStr('url'); ?>&language=<?php echo Request_RequestParams::getParamInt('language'); ?>&view=<?php echo $data->values['index'];?>" class="btn btn-primary btn-insert">Настройка</a>
        <a data-action="del-view" href="#" class="btn btn-danger btn-insert">Удалить</a>
    </div>
</div>
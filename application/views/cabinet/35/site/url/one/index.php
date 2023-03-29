<div class="row margin-b-10">
    <div class="col-md-2">
        <input name="urls[/<?php echo $data->values['url']; ?>][url]" type="text" class="form-control" placeholder="URL" value="<?php echo $data->values['url'];?>">
    </div>
    <div class="col-md-2">
        <input name="urls[/<?php echo $data->values['url']; ?>][title]" type="text" class="form-control" placeholder="Название" value="<?php echo $data->values['title'];?>">
    </div>
    <div class="col-md-8">
        <a href="<?php echo $siteData->urlBasic;?>/cabinet/site/languages?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&url=<?php echo $data->values['url'];?>" class="btn btn-primary btn-insert">Языки</a>
        <a data-action="del-view" href="#" class="btn btn-danger btn-insert">Удалить</a>
        <a href="<?php echo Func::getURL($siteData, $data->values['url']);?>">Ссылка на страницу</a>
    </div>
</div>
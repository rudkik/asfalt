<div id="index-list-item<?php echo $data->values['index']; ?>" class="index-list-item">
    <div class="row">
        <div class="col-md-4" id="child2" textarea="footer">
            <input type="hidden" name="names[]" value="<?php echo $data->values['name'];?>">
            <select class="form-control select" disabled>
                <?php echo trim($data->additionDatas['view::site/combobox-views']); ?>
            </select>
        </div>
        <input style="height: 29px;" type="text" class="btn-group" placeholder="Название" name="titles[]" value="<?php echo $data->values['title']; ?>"/>
        <input type="hidden" placeholder="Название" name="indexes[]" value="<?php echo $data->values['index']; ?>"/>
        <a href="<?php echo $siteData->urlBasic;?>/superadmin/site/view?id=<?php echo Request_RequestParams::getParamInt('id'); ?>&url=<?php echo Request_RequestParams::getParamStr('url'); ?>&language=<?php echo Request_RequestParams::getParamInt('language'); ?>&view=<?php echo $data->values['index'];?>" class="btn btn-primary btn-insert">Настройка</a>
        <a deldiv="1"  href="" class="btn btn-danger btn-insert">Удалить</a>
    </div>
</div>
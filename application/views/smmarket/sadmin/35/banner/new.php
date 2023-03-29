<section id="edit_panel" class="content top20" style="padding-top: 0px;">
    <input name="type" type="text" hidden="hidden" value="<?php echo Arr::path($siteData->urlParams, 'type', 0);?>">
    <div class="row top20">
        <div class="col-md-3">
            <div class="col-md-12" style="text-align: center;">
                <?php if (empty($data->values['name'])) { ?>
                    <img id="img_logo" name="filename" width="100%" height="100%" src="<?php echo $siteData->urlBasic; ?>/css/_component/admin-panel/img/default-magazin.jpg" alt="">
                <?php } else { ?>
                    <img id="img_logo" name="filename" width="100%" height="100%" src="<?php echo Helpers_Image::getPhotoPath($data->values['image'], 360, 240); ?>" alt="">
                <?php } ?>
                <a href="#" onclick="javascript:browse()">Добавить изображение</a>
                <div id="progress" class="progress" style="display: none">
                    <div id="progressbar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:100%; background: #00b9f2">0%
                    </div>
                </div>
                <div id="status"></div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="form-group">
                <input type="checkbox" class="flat-red" checked> Опубликовать
            </div>

            <div class="form-group">
                <label>Название</label>
                <input name="name" type="text" class="form-control" placeholder="Название статьи">
            </div>
            <div class="form-group">
                <label>Лимит кликов:</label>
                <input name="limit" type="text" class="form-control"  placeholder="Лимит">
            </div>
        </div>
        <div class="form-group">
            <label>Тип статьи </label>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Текст</label>
                <textarea name="text" placeholder="Текст..." rows="7" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <div class="row top20">
        <div class="col-md-3">
            <input type="submit" value="Сохранить" class="btn btn-primary btn-block" onclick="actionSaveObject('<?php echo $siteData->urlBasic.'/cabinet/banner/save'?>?', 0,'edit_panel', 'table_panel')">
        </div>
    </div>
</section>

<script src="<?php echo $siteData->urlBasic; ?>/css/_component/ckeditor/ckeditor.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $siteData->urlBasic; ?>/css/cabinet/js/main.js"></script>
<script>
    CKEDITOR.replace('info');
</script>
<script>
    var input = getElementById('logo_input');
    input.addEventListener('change', function (event) {
        uploadFile(event.target.id, '/cabinet/shop/upload');
    }, false);
</script>

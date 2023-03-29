<div class="row top20" id="edit_panel">
    <div class="col-md-4">
        <div class="dropzone">
            <div class="browser">
                <label style="margin-bottom: 0px;">
                    <span>Загрузить</span>
                    <input type="file" name="file"/>
                </label>
            </div>
            <div data-id="output"></div>

            <input data-id="file-name" id="file" hidden="hidden" name="image"/>
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <input type="checkbox" class="flat-red" checked> Опубликовать
        </div>
        <div class="form-group">
            <label>Название</label>
            <input name="name" type="text" class="form-control" rows="5" placeholder="Название">
        </div>
        <div class="form-group">
            <label>Официальное название</label>
            <input name="official_name" type="text" class="form-control" rows="5" placeholder="Официальное название">
        </div>

        <div class="form-group">
            <label>Домен</label>
            <input unique-current-id="<?php echo $data->id;?>" unique-error="Домен с таким именем уже существует"  unique="1" href="<?php echo $siteData->urlBasic; ?>/manager/shop/isunique" name="domain" type="text" class="form-control" rows="5" placeholder="Название">
        </div>

        <div class="form-group">
            <label>Поддомен (*.*.*)</label>
            <input unique-current-id="<?php echo $data->id;?>" unique-error="Поддомен с таким именем уже существует" unique="1" href="<?php echo $siteData->urlBasic; ?>/manager/shop/isunique" name="sub_domain" type="text" class="form-control" id="sub_name" placeholder="Поддомен">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Информация</label>
            <textarea name="info" placeholder="Текст..." rows="7" class="form-control"></textarea>
        </div>
    </div>
</div>
<div class="row top20">
    <div class="col-md-2">
        <input type="submit" value="Сохранить" class="btn btn-primary btn-block"
               onclick="actionSaveObject('<?php echo $siteData->urlBasic . '/manager/shop/save'; ?>', 0, 'edit_panel', true)">
    </div>
</div>
<script>
    CKEDITOR.replace('info');
</script>

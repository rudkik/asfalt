<section id="edit_panel" class="content top20" style="padding-top: 0;">
	<input name="type" type="text" hidden="hidden" value="<?php echo Arr::path($siteData->urlParams, 'type', 0);?>">
    <div class="row top20">
        <div class="col-md-3">
            <div class="add-image bottom20">
                <div><i class="fa fa-fw fa-plus-square-o"></i></div>
                добавить изображение
            </div>
        </div>
        <div class="col-md-9">
        	<div class="form-group">
                <input type="checkbox" class="flat-red"<?php if($data->values['is_public'] == 1){ echo ' checked';}?>> Опубликовать
            </div>

            <div class="form-group">
            	<label>Название</label>
                <input name="name" type="text" class="form-control" placeholder="Название статьи" value="<?php echo htmlspecialchars($data->values['name']);?>">
            </div>
            <div class="form-group">
                <label>Лимит кликов:</label>
                <input name="limit" type="text" class="form-control" placeholder="Лимит" value="<?php echo htmlspecialchars($data->values['limit']);?>">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Текст</label>
                <textarea name="text" placeholder="Текст..." rows="7" class="form-control"><?php echo htmlspecialchars($data->values['name']);?></textarea>
            </div>
        </div>
    </div>
    <div class="row top20">
        <div class="col-md-3">
            <input type="submit" value="Сохранить" class="btn btn-primary btn-block" onclick="actionSaveObject('<?php echo $siteData->urlBasic.'/cabinet/banner/save'?>?', <?php if($siteData->action == 'clone') {echo 0;}else{echo $data->id;} ?>,'edit_panel', 'table_panel')">
        </div>
    </div>
</section>

<script src="<?php echo $siteData->urlBasic; ?>/css/_component/ckeditor/ckeditor.js" type="text/javascript" charset="utf-8"></script>
<script>
	CKEDITOR.replace('text');
</script>

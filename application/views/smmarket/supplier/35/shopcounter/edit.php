<?php
/**
 * Created by PhpStorm.
 * User: abylkhasov
 * Date: 23.02.16
 * Time: 22:29
 */?>
<section id="edit_panel" class="content top20" style="padding-top: 0px;">
    <input name="type" type="text" hidden="hidden" value="<?= Arr::path($siteData->urlParams, 'type', 0);?>">
    <div class="row top20">
        <div class="col-md-9">

            <div class="form-group">
                <label>Название</label>
                <input name="title" type="text" class="form-control" placeholder="Название статьи" value="<?= $data->values['title'];?>">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Текст</label>
                <textarea name="data" placeholder="Текст..." rows="7" class="form-control"><?= $data->values['data'];?></textarea>
            </div>
        </div>
    </div>
    <div class="row top20">
        <div class="col-md-2">
            <input type="submit" value="Сохранить" class="btn btn-primary btn-block"
                   onclick="actionSaveObject('<?= $siteData->urlBasic.'/cabinet/shopcounter/save'?>',
                   <?php if($siteData->action == 'clone') {echo 0;}else{echo $data->id;} ?>, 'edit_panel', 'table_panel', false)">
        </div>
        <div class="col-md-3">
            <input type="submit" value="Сохранить и закрыть" class="btn btn-primary btn-block"
                   onclick="actionSaveObject('<?= $siteData->urlBasic.'/cabinet/shopcounter/save'?>',
                   <?php if($siteData->action == 'clone') {echo 0;}else{echo $data->id;} ?>, 'edit_panel', 'table_panel', true)">
        </div>
    </div>
</section>

<script src="<?php echo $siteData->urlBasic; ?>/css/_component/ckeditor/ckeditor.js" type="text/javascript" charset="utf-8"></script>


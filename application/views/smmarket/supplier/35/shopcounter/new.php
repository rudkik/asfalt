<?php
/**
 * Created by PhpStorm.
 * User: abylkhasov
 * Date: 23.02.16
 * Time: 22:30
 */?>
<section id="edit_panel" class="content top20" style="padding-top: 0px;">
    <input name="type" type="text" hidden="hidden" value="<?php echo Arr::path($siteData->urlParams, 'type', 0); ?>">
    <div class="row top20">
        <div class="col-md-9">

            <div class="form-group">
                <label>Название</label>
                <input name="title" type="text" class="form-control" placeholder="Название переменной">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Текст</label>
                <textarea name="data" placeholder="<script>......</script>" rows="7" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <div class="row top20">
        <div class="col-md-2">
            <input type="submit" value="Сохранить" class="btn btn-primary btn-block"
                   onclick="actionSaveObject('<?= $siteData->urlBasic . '/cabinet/shopcounter/save'?>', 0,'edit_panel', 'table_panel', false)">
        </div>
        <div class="col-md-3">
            <input type="submit" value="Сохранить и закрыть" class="btn btn-primary btn-block"
                   onclick="actionSaveObject('<?= $siteData->urlBasic . '/cabinet/shopcounter/save'?>', 0,'edit_panel', 'table_panel', true)">
        </div>
    </div>
</section>
<form enctype="multipart/form-data" method="POST">
    <input id="logo_input" type="file" accept="image/jpeg" style="display: none">
    <input type="hidden" name="file" id="filenamePath">
</form>

<script src="<?php echo $siteData->urlBasic; ?>/css/cabinet/js/main.js"></script>


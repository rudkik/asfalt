<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Название
    </label>
    <div class="col-md-10">
        <input name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo $data->values['name']; ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Описание
    </label>
    <div class="col-md-10">
        <textarea name="text" rows="5" placeholder="Описание" class="form-control"><?php echo htmlspecialchars($data->values['text'], ENT_QUOTES);?></textarea>
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

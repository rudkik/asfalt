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
        Код
    </label>
    <div class="col-md-10">
        <input name="code" type="text" class="form-control" placeholder="Код" required value="<?php echo $data->values['code']; ?>">
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

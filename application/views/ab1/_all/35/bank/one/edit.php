<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="Название банка" required value="<?php echo $data->values['name'] ?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Адрес
        </label>
    </div>
    <div class="col-md-9">
        <input name="address" type="text" class="form-control" placeholder="Адрес банка" value="<?php echo $data->values['address'] ?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            БИК
        </label>
    </div>
    <div class="col-md-3">
        <input name="bik" type="phone" class="form-control" placeholder="БИК" required value="<?php echo $data->values['bik'] ?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            БИН/ИИН
        </label>
    </div>
    <div class="col-md-3">
        <input name="bin" type="phone" class="form-control" placeholder="БИН/ИИН" required value="<?php echo $data->values['bin'] ?>">
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
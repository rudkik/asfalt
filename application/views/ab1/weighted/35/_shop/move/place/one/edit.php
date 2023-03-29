<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-9">
        <input data-unique="true" data-field="name_full" data-href="/weighted/shopmoveplace/json?id_not=<?php echo $data->id;?>" data-message="Данное название уже существует" name="name" type="text" class="form-control" placeholder="Название" required value="<?php echo htmlspecialchars(Arr::path($data->values, 'name', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название в 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_1c" type="text" class="form-control" placeholder="Название в 1С" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name_1c', ''), ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название на сайте
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_site" type="text" class="form-control" placeholder="Название на сайте" value="<?php echo htmlspecialchars(Arr::path($data->values, 'name_site', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            БИН/ИИН
        </label>
    </div>
    <div class="col-md-3">
        <input data-unique="true" data-field="bin_full" data-href="/weighted/shopmoveplace/json?id_not=<?php echo $data->id;?>" data-message="Данный БИН/ИИН уже существует"  name="bin" type="text" class="form-control" placeholder="БИН/ИИН" maxlength="12" value="<?php echo htmlspecialchars(Arr::path($data->values, 'bin', ''), ENT_QUOTES);?>">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Адрес
        </label>
    </div>
    <div class="col-md-3">
        <input name="address" type="text" class="form-control" placeholder="Адрес" value="<?php echo htmlspecialchars(Arr::path($data->values, 'address', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            № счета
        </label>
    </div>
    <div class="col-md-3">
        <input name="account" type="text" class="form-control" placeholder="№ счета" maxlength="20" value="<?php echo htmlspecialchars(Arr::path($data->values, 'account', ''), ENT_QUOTES);?>">
    </div>

    <div class="col-md-3 record-title">
        <label>
            Банк
        </label>
    </div>
    <div class="col-md-3">
        <input name="bank" type="text" class="form-control" placeholder="Банк" value="<?php echo htmlspecialchars(Arr::path($data->values, 'bank', ''), ENT_QUOTES);?>">
    </div>
</div>
<div class="row">
    <div hidden>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php } ?>
        <input id="is_close" name="is_close" value="1" style="display: none">
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn bg-green" data-action="form-apply">Применить</button>
        <button type="submit" class="btn btn-primary" data-action="form-save">Сохранить</button>
    </div>
</div>

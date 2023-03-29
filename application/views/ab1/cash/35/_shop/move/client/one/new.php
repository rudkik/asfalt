<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-9">
        <input data-unique="true" data-field="name_full" data-href="/cash/shopmoveclient/json" data-message="Такое название уже есть в базе данных" name="name" type="text" class="form-control" placeholder="Название" required>
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
        <input name="name_1c" type="text" class="form-control" placeholder="Название в 1С">
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название на сайте
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_site" type="text" class="form-control" placeholder="Название на сайте">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Тип организации
        </label>
    </div>
    <div class="col-md-9">
        <div class="input-group">
            <select id="organization_type_id" name="organization_type_id" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::organizationtype/list/list']; ?>
            </select>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            БИН/ИИН
        </label>
    </div>
    <div class="col-md-3">
        <input data-unique="true" data-field="bin_full" data-href="/cash/shopmoveclient/json" data-message="Такой БИН/ИИН уже есть в базе данных"  name="bin" type="text" class="form-control" placeholder="БИН/ИИН" maxlength="12">
    </div>
    <div class="col-md-3 record-title">
        <label>
            Адрес
        </label>
    </div>
    <div class="col-md-3">
        <input name="address" type="text" class="form-control" placeholder="Адрес">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            № счета
        </label>
    </div>
    <div class="col-md-3">
        <input name="account" type="text" class="form-control" placeholder="№ счета" maxlength="20">
    </div>

    <div class="col-md-3 record-title">
        <label>
            Банк
        </label>
    </div>
    <div class="col-md-3">
        <input name="bank" type="text" class="form-control" placeholder="Банк">
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

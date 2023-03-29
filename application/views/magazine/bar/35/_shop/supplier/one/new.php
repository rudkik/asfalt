<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
    <div class="col-md-3 record-title"></div>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_nds" value="1" checked type="checkbox" class="minimal">
            Является ли плательщиком НДС
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название
        </label>
    </div>
    <div class="col-md-3">
        <input name="name" type="text" class="form-control" placeholder="Название" required>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название в 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="name_1c" type="text" class="form-control" placeholder="Название в 1С">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            ID 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="old_id" type="text" class="form-control" placeholder="ID 1С">
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
            <select data-type="select2" id="organization_type_id" name="organization_type_id" class="form-control select2" required style="width: 100%;">
                <option value="0" data-id="0">Без значения</option>
                <?php echo $siteData->globalDatas['view::organizationtype/list/list']; ?>
            </select>
        </div>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            БИН
        </label>
    </div>
    <div class="col-md-3">
        <input name="bin" type="text" class="form-control" placeholder="БИН" maxlength="12">
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
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            БИК
        </label>
    </div>
    <div class="col-md-3">
        <input name="bik" type="text" class="form-control" placeholder="БИК" maxlength="20">
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
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Телефоны
        </label>
    </div>
    <div class="col-md-9">
        <input name="phones" type="text" class="form-control" placeholder="Телефоны">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            E-mail
        </label>
    </div>
    <div class="col-md-9">
        <input name="email" type="text" class="form-control" placeholder="E-mail">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Примечание
        </label>
    </div>
    <div class="col-md-9">
        <textarea rows="5" name="text" type="text" class="form-control" placeholder="Примечание"></textarea>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

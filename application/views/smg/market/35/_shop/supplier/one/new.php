<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
    <label class="col-md-2 control-label"></label>
    <div class="col-md-3">
        <label class="span-checkbox">
            <input name="is_disable_dumping" value="0" style="display: none">
            <input name="is_disable_dumping" value="1" type="checkbox" class="minimal">
            Отключить демпинг цен
        </label>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        БИН
    </label>
    <div class="col-md-4">
        <input name="bin" type="text" class="form-control" placeholder="БИН" required>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Поставщик
    </label>
    <div class="col-md-10">
        <input name="name" type="text" class="form-control" placeholder="Поставщик" required>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Минимальная наценка на товар
    </label>
    <div class="col-md-5">
        <input name="min_markup" type="phone" class="form-control" placeholder="Минимальная наценка на товар">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Организация
    </label>
    <div class="col-md-4">
        <input name="name_organization" type="text" class="form-control" placeholder="Организация">
    </div>
    <label class="col-md-2 control-label">
        Номер телефона
    </label>
    <div class="col-md-4">
        <input name="phone" type="text" class="form-control" placeholder="Номер телефона">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Банк
    </label>
    <div class="col-md-4">
        <input name="bank_name" type="text" class="form-control" placeholder="Банк">
    </div>
    <label class="col-md-2 control-label">
        Номер счета
    </label>
    <div class="col-md-4">
        <input name="bank_number" type="text" class="form-control" placeholder="Номер счета">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Должность
    </label>
    <div class="col-md-4">
        <input name="director_position" type="text" class="form-control" placeholder="Должность">
    </div>
    <label class="col-md-2 control-label">
        ФИО
    </label>
    <div class="col-md-4">
        <input name="director_name" type="text" class="form-control" placeholder="ФИО">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
       Адрес
    </label>
    <div class="col-md-5">
        Юридический
        <input name="legal_address" type="text" class="form-control" placeholder="Юридический">
    </div>
    <div class="col-md-5">
        Почтовый
        <input name="post_address" type="text" class="form-control" placeholder="Почтовый">
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

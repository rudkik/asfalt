<div class="form-group">
    <label class="col-md-2 control-label"></label>
    <div class="col-md-10">
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
        Название
    </label>
    <div class="col-md-10">
        <input name="name" type="text" class="form-control" placeholder="Название" required>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>

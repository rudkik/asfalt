<div class="form-group">
    <label class="col-md-2 control-label">Показать</label>
    <div class="col-md-4">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
        </label>
    </div>
    <label class="col-md-2 control-label">Считать расходом?</label>
    <div class="col-md-4">
        <label class="span-checkbox">
            <input name="is_expanse" value="0" style="display: none">
            <input name="is_expanse" value="1" checked type="checkbox" class="minimal">
        </label>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Название
    </label>
    <div class="col-md-10">
        <input name="name" type="text" class="form-control" placeholder="Название">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        КПН
    </label>
    <div class="col-md-4">
        <input name="kpn" type="text" class="form-control" placeholder="КПН">
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
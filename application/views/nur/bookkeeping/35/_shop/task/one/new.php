<div class="form-group">
    <label class="span-checkbox">
        <input name="is_public" value="1" checked type="checkbox" class="minimal">
        Активная задача
    </label>
</div>
<div class="form-group">
    <label for="name" class="block">Название</label>
    <input id="name" name="name" type="text" class="form-control" placeholder="Название" required>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="date_from" class="block">Срок действия от</label>
            <input name="date_from" id="date_from" type="datetime" data-type="date" class="form-control">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="date_to" class="block">Срок действия до</label>
            <input name="date_to" id="date_to" type="datetime" data-type="date" class="form-control">
        </div>
    </div>
</div>
<div class="text-center" style="width: 100%;">
    <button type="submit" class="btn btn-primary" style="margin-right: 10px;">Сохранить</button>
    <a href="/nur-bookkeeping/shoptask/index" class="btn btn-danger">Отменить</a>
</div>
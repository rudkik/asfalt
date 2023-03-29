<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Источник
    </label>
    <div class="col-md-4">
        <select data-type="select2" id="shop_source_id" name="shop_source_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/source/list/list']; ?>
        </select>
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Фамилия
    </label>
    <div class="col-md-10">
        <input name="lastName" type="text" class="form-control" placeholder="Фамилия">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        Имя
    </label>
    <div class="col-md-10">
        <input name="firstName" type="text" class="form-control" placeholder="Имя">
    </div>
</div>
<div class="form-group">
    <label class="col-md-2 control-label">
        <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
        Номер телефона
    </label>
    <div class="col-md-10">
        <input name="phone" type="phone" class="form-control" placeholder="Номер телефона">
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>